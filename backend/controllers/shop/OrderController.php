<?php

namespace backend\controllers\shop;

use store\forms\manage\order\OrderEditForm;
use store\useCases\manage\order\OrderManageService;
use Yii;
use store\entities\shop\order\Order;
use backend\forms\OrderSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        OrderManageService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'complete' => ['POST'],
                    'sent' => ['POST'],
                    'cancel' => ['POST'],
                    'pay' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'order' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $order = $this->findModel($id);
        $form = new OrderEditForm($order);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($order->id, $form);
                Yii::$app->session->setFlash('success', 'Заказ отредактирован.');
                return $this->redirect(['view', 'id' => $order->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'order' => $order,
        ]);
    }

    public function actionComplete($id)
    {
        $this->service->complete($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSent($id)
    {
        $this->service->sent($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionCancel($id)
    {
        $this->service->cancel($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionPay($id)
    {
        $this->service->pay($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try{
            $this->service->remove($id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
