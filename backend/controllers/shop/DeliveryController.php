<?php

namespace backend\controllers\shop;

use store\forms\manage\shop\DeliveryForm;
use store\services\manage\shop\DeliveryMethodManageService;
use Yii;
use store\entities\shop\DeliveryMethod;
use backend\forms\DeliverySearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeliveryController implements the CRUD actions for DeliveryMethod model.
 */
class DeliveryController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        DeliveryMethodManageService $service,
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
                ],
            ],
        ];
    }

    /**
     * Lists all DeliveryMethod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeliveryMethod model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'method' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DeliveryMethod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DeliveryForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $method = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Новый метод доставки успешно создан.');
                return $this->redirect(['view', 'id' => $method->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing DeliveryMethod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $method = $this->findModel($id);
        $form = new DeliveryForm($method);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($method->id, $form);
                Yii::$app->session->setFlash('success', 'Метод доставки успешно отредактирован.');
                return $this->redirect(['view', 'id' => $method->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'method' => $method,
        ]);
    }

    /**
     * Deletes an existing DeliveryMethod model.
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
     * Finds the DeliveryMethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeliveryMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeliveryMethod::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
