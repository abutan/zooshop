<?php

namespace frontend\controllers\shop;


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

    public function __construct(
        $id,
        Module $module,
        ProductReadRepository $products,
        CategoryReadRepository $categories,
        MakerReadRepository $makers,
        BrandReadRepository $brands,
        TagReadRepository $tags,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->categories = $categories;
        $this->makers = $makers;
        $this->brands = $brands;
        $this->tags = $tags;
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

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $category,
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
}