<?php

namespace backend\controllers\shop;

use store\entities\shop\product\Product;
use store\forms\manage\shop\product\ReviewEditForm;
use store\services\manage\shop\ProductManageService;
use Yii;
use store\entities\shop\product\Review;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends Controller
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
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/shop/product']);
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $product_id
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id,  $id)
    {
        $product = $this->findModel($product_id);
        $review = $product->getReview($id);
        $form = new ReviewEditForm($review);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->editReview($product->id, $review->id, $form);
                return $this->redirect(['/shop/product/view', 'id' => $product->id, '#' => 'reviews']);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'product' => $product,
            'review' => $review,
        ]);
    }

    /**
     * @param $id
     * @param $reviewId
     * @return \yii\web\Response
     */
    public function actionActivate($id, $reviewId)
    {
        $this->service->activateReview($id, $reviewId);
        return $this->redirect(['/shop/product/view', 'id' => $id, '#' => 'reviews']);
    }

    /**
     * @param $id
     * @param $reviewId
     * @return \yii\web\Response
     */
    public function actionDraft($id, $reviewId)
    {
        $this->service->draftReview($id, $reviewId);
        return $this->redirect(['/shop/product/view', 'id' => $id, '#' => 'reviews']);
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $product_id
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($product_id, $id)
    {
        $product = $this->findModel($product_id);
        try{
            $this->service->removeReview($product->id, $id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/shop/product/view', 'id' => $product->id, '#' => 'reviews']);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
