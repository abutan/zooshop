<?php

namespace frontend\controllers\cabinet;

use Yii;
use store\frontModels\shop\ProductReadRepository;
use store\services\cabinet\WhishlistService;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WhishlistController extends Controller
{
    public $layout = 'cabinet';

    private $service;
    private $products;

    public function __construct(
        string $id,
        Module $module,
        WhishlistService $service,
        ProductReadRepository $products,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = $this->products->getWhishlist(Yii::$app->user->id);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd($id)
    {
        try{
            $this->service->add(Yii::$app->user->id, $id);
            Yii::$app->session->setFlash('success', 'Товар добавлен в лист желаний (избранное).');
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionDelete($id)
    {
        try{
            $this->service->remove(Yii::$app->user->id, $id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
}