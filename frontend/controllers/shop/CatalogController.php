<?php

namespace frontend\controllers\shop;

use store\services\manage\shop\ProductManageService;
use Yii;
use store\forms\shop\AddToCartForm;
use store\forms\shop\ReviewForm;
use store\frontModels\shop\BrandReadRepository;
use store\frontModels\shop\CategoryReadRepository;
use store\frontModels\shop\MakerReadRepository;
use store\frontModels\shop\ProductReadRepository;
use store\frontModels\shop\TagReadRepository;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $products;
    private $categories;
    private $makers;
    private $brands;
    private $tags;
    private $service;

    public function __construct(
        $id,
        Module $module,
        ProductReadRepository $products,
        CategoryReadRepository $categories,
        MakerReadRepository $makers,
        BrandReadRepository $brands,
        TagReadRepository $tags,
        ProductManageService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->categories = $categories;
        $this->makers = $makers;
        $this->brands = $brands;
        $this->tags = $tags;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $dataProvider = $this->products->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }

    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена');
        }
        $dataProvider = $this->products->getAllByCategory($category);
        $brandData = $this->brands->getToSelect();
        $tagData = $this->tags->getToSelect();
        $makerData = $this->makers->getToSelect();

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $category,
            'brandData' => $brandData,
            'tagData' => $tagData,
            'makerData' => $makerData,
        ]);
    }

    public function actionMaker($slug)
    {
        if (!$maker = $this->makers->findBySlug($slug)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
        $dataProvider = $this->products->getAllByMaker($maker);

        return $this->render('maker', [
            'dataProvider' => $dataProvider,
            'maker' => $maker,
        ]);
    }

    public function actionBrand($slug)
    {
        if (!$brand = $this->brands->findBySlug($slug)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
        $dataProvider = $this->products->getAllByBrand($brand);

        return $this->render('brand', [
            'dataProvider' => $dataProvider,
            'brand' => $brand,
        ]);
    }

    public function actionTag($slug)
    {
        if (!$tag = $this->tags->findBySlug($slug)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
        $dataProvider = $this->products->getAllByTag($tag);

        return $this->render('tag', [
            'dataProvider' => $dataProvider,
            'tag' => $tag,
        ]);
    }

    public function actionProduct($id)
    {
        if (!$product = $this->products->find($id)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        $reviewForm = new ReviewForm();
        if ($reviewForm->load(Yii::$app->request->post()) && $reviewForm->validate()){
            try{
                $this->service->addReview($product->id, Yii::$app->user->id, $reviewForm);
                Yii::$app->session->setFlash('success', 'Спасибо! Ваш отзыв получен. После проверки модератором, он будет опубликован на сайте.');
                return $this->redirect(['/shop/catalog/product', 'id' => $product->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $addToCart = new AddToCartForm($product);

        return $this->render('product', [
            'product' => $product,
            'reviewForm' => $reviewForm,
            'addToCart' => $addToCart,
        ]);
    }

    public function actionFeatured()
    {
        return $this->render('featured');
    }

    public function actionAttention(){
        return $this->renderAjax('attention');
    }

    public function actionHit()
    {
        return $this->render('hit');
    }

    public function actionSale()
    {
        $dataProvider = $this->products->getSaleList();

        return $this->render('sale', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch($text)
    {
        if (!$text){
            return $this->redirect(Yii::$app->request->referrer);
        }
        $dataProvider = $this->products->searchByText($text);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'text' => $text,
        ]);
    }

    public function actionFast($maker, $brand, $tag)
    {
        if (!$maker && !$brand && !$tag){
            return $this->redirect(Yii::$app->request->referrer);
        }

        $dataProvider = $this->products->searchByWidget($maker, $brand, $tag);

        return $this->render('fast', [
            'dataProvider' => $dataProvider,
        ]);
    }
}