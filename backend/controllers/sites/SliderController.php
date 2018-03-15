<?php

namespace backend\controllers\sites;

use store\forms\manage\site\SliderCreateForm;
use store\forms\manage\site\SliderEditForm;
use store\forms\manage\site\SliderPhotosForm;
use store\services\manage\site\SliderManageService;
use Yii;
use store\entities\site\Slider;
use backend\forms\SliderSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        SliderManageService $service,
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
                    'move-slide-up' => ['POST'],
                    'move-slide-down' => ['POST'],
                    'remove-slide' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $slider = $this->findModel($id);
        $slideForm = new SliderPhotosForm();
        if ($slideForm->load(Yii::$app->request->post()) && $slideForm->validate()){
            try{
                $this->service->addSlides($slider->id, $slideForm);
                return $this->redirect(['view', 'id' => $slider->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'slider' => $slider,
            'slideForm' => $slideForm,
        ]);
    }

    /**
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new SliderCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $slider = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Новый слайдер создан.');
                return $this->redirect(['view', 'id' => $slider->id]);
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
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $slider = $this->findModel($id);
        $form = new SliderEditForm($slider);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($slider->id, $form);
                Yii::$app->session->setFlash('success', 'Слайдер отредактирован.');
                return $this->redirect(['view', 'id' => $slider->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'slider' => $slider,
        ]);
    }

    /**
     * @param $id
     * @param $slideId
     * @return \yii\web\Response
     */
    public function actionMoveSlideUp($id, $slideId)
    {
        $this->service->moveSlideUp($id, $slideId);
        return $this->redirect(['view', 'id' => $id, '#' => 'slides']);
    }

    /**
     * @param $id
     * @param $slideId
     * @return \yii\web\Response
     */
    public function actionMoveSlideDown($id, $slideId)
    {
        $this->service->moveSlideDown($id, $slideId);
        return $this->redirect(['view', 'id' => $id, '#' => 'slides']);
    }

    /**
     * @param $id
     * @param $slideId
     * @return \yii\web\Response
     */
    public function actionRemoveSlide($id, $slideId)
    {
        try{
            $this->service->removeSlide($id, $slideId);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'slides']);
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
     * Deletes an existing Slider model.
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
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
