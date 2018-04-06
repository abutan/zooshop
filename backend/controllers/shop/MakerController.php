<?php

namespace backend\controllers\shop;

use store\forms\manage\shop\MakerManageForm;
use store\useCases\manage\shop\MakerManageService;
use Yii;
use store\entities\shop\Maker;
use backend\forms\MakerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Module;

/**
 * MakerController implements the CRUD actions for Maker model.
 */
class MakerController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        MakerManageService $service,
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
     * Lists all Maker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MakerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Maker model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'maker' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Maker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new MakerManageForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $maker = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Новый производитель создан.');
                return $this->redirect(['view', 'id' => $maker->id]);
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
     * Updates an existing Maker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $maker = $this->findModel($id);
        $form = new MakerManageForm($maker);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($maker->id, $form);
                Yii::$app->session->setFlash('success', 'Производитель отредактирован.');
                return $this->redirect(['view', 'id' => $maker->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'maker' => $maker,
        ]);
    }

    /**
     * Deletes an existing Maker model.
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
     * Finds the Maker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Maker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Maker::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
