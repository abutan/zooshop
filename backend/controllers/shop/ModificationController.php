<?php

namespace backend\controllers\shop;

use store\entities\shop\product\Product;
use store\forms\manage\shop\product\ModificationCreateForm;
use store\forms\manage\shop\product\ModificationEditForm;
use store\useCases\manage\shop\ProductManageService;
use Yii;
use store\entities\shop\product\Modification;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModificationController implements the CRUD actions for Modification model.
 */
class ModificationController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        \store\useCases\manage\shop\ProductManageService $service,
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
     * Lists all Modification models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/shop/product']);
    }

    /**
     * Creates a new Modification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $product_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($product_id)
    {
        $product = $this->findModel($product_id);
        $form = new ModificationCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->addModification($product->id, $form);
                return $this->redirect(['/shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    /**
     * Updates an existing Modification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $product_id
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id, $id)
    {
        $product = $this->findModel($product_id);
        $modification = $product->getModification($id);
        $form = new ModificationEditForm($modification);


        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->editModification($product->id, $modification->id, $form);
                return $this->redirect(['/shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'product' => $product,
            'modification' => $modification,
        ]);
    }

    /**
     * Deletes an existing Modification model.
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
            $this->service->removeModification($product->id, $id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/shop/product/view', 'id' => $product->id, '#' => 'modifications']);
    }

    /**
     * Finds the Modification model based on its primary key value.
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
