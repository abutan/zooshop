<?php

namespace frontend\controllers\payment;


use robokassa\FailAction;
use robokassa\Merchant;
use robokassa\ResultAction;
use robokassa\SuccessAction;
use Yii;
use store\entities\shop\order\Order;
use store\frontModels\shop\OrderReadRepository;
use store\services\shop\OrderService;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RobocassaController extends Controller
{
    public $enableCsrfValidation = false;

    private $orders;
    private $service;

    public function __construct(
        string $id,
        Module $module,
        OrderReadRepository $orders,
        OrderService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->service = $service;
    }

    public function actionInvoice($id)
    {
        $order = $this->loadModel($id);
        /* @var Merchant $merchant */
        $merchant = Yii::$app->get('robokassa');
        return $merchant->payment($order->cost, $order->id, 'Оплата заказа №' . $order->id, null, $order->user->email);

    }

    public function actions()
    {
        return [
            'result' => [
                'class' => ResultAction::class,
                'callback' => [$this, 'resultCallback'],
            ],
            'success' => [
                'class' => SuccessAction::class,
                'callback' => [$this, 'successCallback'],
            ],
            'fail' => [
                'class' => FailAction::class,
                'callback' => [$this, 'failCallback'],
            ],
        ];
    }

    public function resultCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $order = $this->loadModel($nInvId);
        try{
            $this->service->pay($order->id);
            return 'OK'.$nInvId;
        }catch (\DomainException $e){
            return $e->getMessage();
        }
    }

    public function successCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        return $this->goBack();
    }

    public function failCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $order = $this->loadModel($nInvId);
        try{
            $this->service->fail($order->id);
            return 'Ok';
        }catch (\DomainException $e){
            return $e->getMessage();
        }
    }

    private function loadModel($id): Order
    {
        if (!$order = $this->orders->findOwn(Yii::$app->user->id, $id)){
            throw new NotFoundHttpException('Заказ не найден.');
        }
        return $order;
    }
}