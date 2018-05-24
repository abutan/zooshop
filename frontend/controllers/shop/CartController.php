<?php

namespace frontend\controllers\shop;


use store\forms\shop\AddToCartForm;
use Yii;
use store\frontModels\shop\ProductReadRepository;
use store\useCases\shop\CartService;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{
    public $layout = 'blank';

    private $products;
    private $service;

    public function __construct(
        string $id,
        Module $module,
        ProductReadRepository $products,
        CartService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'quantity' => ['POST'],
                    'remove' => ['POST'],
                    'clear' => ['POST'],
                    'add-from-button' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $cart = $this->service->getCart();

        return $this->render('index', [
            'cart' => $cart,
        ]);
    }

    public function actionAddFromButton($id)
    {
        if (!$product = $this->products->find($id)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        if (!$product->modifications){
            try{
                $this->service->add($product->id, null, 1);
                Yii::$app->session->setFlash('success', 'Товар успешно добавлен в корзину.');
                return $this->redirect(Yii::$app->request->referrer);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add', [
            'product' => $product,
            'model' => $form,
        ]);
    }

    public function actionAdd($id)
    {
        if (!$product = $this->products->find($id)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        /*if (!$product->modifications){
            try{
                $this->service->add($product->id, null, 1);
                Yii::$app->session->setFlash('success', 'Товар успешно добавлен в корзину.');
                return $this->redirect(Yii::$app->request->referrer);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }*/

        $this->layout = 'blank';

        $form = new AddToCartForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->add($product->id, $form->modification, $form->quantity);
                return $this->redirect(Yii::$app->request->referrer);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add', [
            'product' => $product,
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionQuantity($id)
    {
        try{
            $this->service->set($id, Yii::$app->request->post('quantity'));
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionRemove($id)
    {
        try{
            $this->service->remove($id);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionClear()
    {
        try{
            $this->service->clear();
            return $this->redirect(Yii::$app->homeUrl);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}