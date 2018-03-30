<?php
namespace frontend\controllers\shop;


use Yii;
use store\cart\Cart;
use store\forms\shop\order\OrderForm;
use store\services\shop\OrderService;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

class CheckoutController extends Controller
{
    public $layout = 'blank';

    private $cart;
    private $service;

    public function __construct(
        string $id,
        Module $module,
        Cart $cart,
        OrderService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->cart = $cart;
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $form = new OrderForm($this->cart->getCost()->getTotal(), $this->cart->getWeight());

        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $order = $this->service->checkout(Yii::$app->user->id, $form);
                return $this->redirect(['/cabinet/order/view', 'id' => $order->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'cart' => $this->cart,
            'model' => $form,
        ]);
    }
}