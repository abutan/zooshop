<?php

namespace backend\controllers\shop;

use store\entities\shop\product\Modification;
use store\entities\shop\product\Review;
use store\forms\manage\shop\product\PhotosForm;
use store\forms\manage\shop\product\PriceForm;
use store\forms\manage\shop\product\ProductCreateForm;
use store\forms\manage\shop\product\ProductEditForm;
use store\forms\manage\shop\product\ProductRelatesForm;
use store\forms\manage\shop\product\QuantityForm;
use store\useCases\manage\shop\ProductManageService;
use Yii;
use store\entities\shop\product\Product;
use backend\forms\ProductSearch;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        ProductManageService $service,
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
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                    'remove-photo' => ['POST'],
                    'sale' => ['POST'],
                    'un-sale' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $product = $this->findModel($id);
        $reviewProvider = new ActiveDataProvider([
            'query' => $product->getReviews(),
            'key' => function(Review $review) use($product){
                return [
                    'product_id' => $product->id,
                    'id' => $review->id,
                ];
            },
            'pagination' => false,
        ]);
        $modificationsProvider = new ActiveDataProvider([
            'query' => $product->getModifications()->orderBy('name'),
            'key' => function(Modification $modification) use($product)
            {
                return [
                    'product_id' => $product->id,
                    'id' => $modification->id,
                ];
            },
            'pagination' => false,
        ]);

        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()){
            try{
                $this->service->addPhotos($product->id, $photosForm);
                return $this->redirect(['view', 'id' => $product->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'product' => $product,
            'modificationsProvider' => $modificationsProvider,
            'reviewProvider' => $reviewProvider,
            'photosForm' => $photosForm,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ProductCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $product = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Новый товар создан.');
                return $this->redirect(['view', 'id' => $product->id]);
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
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionPrice($id)
    {
        $product = $this->findModel($id);
        $form = new PriceForm($product);

        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->changePrice($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('price', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionQuantity($id)
    {
        $product = $this->findModel($id);
        $form = new QuantityForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->changeQuantity($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('quantity', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDraft($id)
    {
        try{
            $this->service->draft($id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionActivate($id)
    {
        try{
            $this->service->activate($id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @param $photoId
     * @return \yii\web\Response
     */
    public function actionMovePhotoDown($id, $photoId)
    {
        $this->service->movePhotoDown($id, $photoId);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param $id
     * @param $photoId
     * @return \yii\web\Response
     */
    public function actionMovePhotoUp($id, $photoId)
    {
        $this->service->movePhotoUp($id, $photoId);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param $id
     * @param $photoId
     * @return \yii\web\Response
     */
    public function actionRemovePhoto($id, $photoId)
    {
        try{
            $this->service->removePhoto($id, $photoId);
        }catch (\DomainException $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $form = new ProductEditForm($product);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($product->id, $form);
                Yii::$app->session->setFlash('success', 'Товар отредактирован.');
                return $this->redirect(['view', 'id' => $product->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionSale($id)
    {
        try{
            $this->service->sale($id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionUnSale($id)
    {
        try{
            $this->service->unSale($id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelate($id)
    {
        $product = $this->findModel($id);
        $form = new ProductRelatesForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->editRelates($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('relate', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionRemoveRelatedProduct($id, $otherId)
    {
        $this->service->removeRelatedProduct($id, $otherId);
        return $this->redirect(['view', 'id' => $id, '#' => 'relates']);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
