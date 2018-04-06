<?php

namespace backend\controllers\sites;

use store\forms\site\BonusForm;
use store\useCases\manage\site\BonusService;
use Yii;
use store\entities\site\Bonus;
use backend\forms\BonusSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BonusController implements the CRUD actions for Bonus model.
 */
class BonusController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        BonusService $service,
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
                    'draft' => ['POST'],
                    'activate' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bonus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BonusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bonus model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'bonus' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bonus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new BonusForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $bonus = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Новый бонус создан.');
                return $this->redirect(['view', 'id' => $bonus->id]);
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
     * Updates an existing Bonus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $bonus = $this->findModel($id);
        $form = new BonusForm($bonus);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($bonus->id, $form);
                Yii::$app->session->setFlash('success', 'Бонус отредактирован.');
                return $this->redirect(['view', 'id' => $bonus->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'bonus' => $bonus,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDraft($id)
    {
        $this->service->draft($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionActivate($id)
    {
        $this->service->activate($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Bonus model.
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
     * Finds the Bonus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bonus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bonus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
