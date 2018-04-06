<?php

namespace frontend\controllers;


use store\entities\shop\Category;
use store\entities\shop\product\Product;
use store\entities\site\Article;
use store\entities\site\Bonus;
use store\entities\site\Stock;
use store\frontModels\shop\CategoryReadRepository;
use store\frontModels\shop\ProductReadRepository;
use store\frontModels\site\ArticleReadRepository;
use store\frontModels\site\BonusReadRepository;
use store\frontModels\site\StockReadRepository;
use store\services\sitemap\IndexItem;
use store\services\sitemap\MapItem;
use store\services\sitemap\Sitemap;
use yii\caching\Dependency;
use yii\caching\TagDependency;
use yii\base\Module;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;

class SitemapController extends Controller
{
    const ITEM_PER_PAGE = 100;

    private $sitemap;
    private $categories;
    private $products;
    private $articles;
    private $bonuses;
    private $stockes;

    public function __construct(
        string $id,
        Module $module,
        Sitemap $sitemap,
        CategoryReadRepository $categories,
        ProductReadRepository $products,
        ArticleReadRepository $articles,
        BonusReadRepository $bonuses,
        StockReadRepository $stockes,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->sitemap = $sitemap;
        $this->categories = $categories;
        $this->products = $products;
        $this->articles = $articles;
        $this->bonuses = $bonuses;
        $this->stockes = $stockes;
    }

    public function actionIndex(): Response
    {
        return $this->renderSitemap('sitemap-index', function (){
            return $this->sitemap->generateIndex([
               new IndexItem(Url::to(['categories'], true)),
               new IndexItem(Url::to(['products-index'], true)),
               new IndexItem(Url::to(['articles'], true)),
               new IndexItem(Url::to(['bonuses'], true)),
               new IndexItem(Url::to(['stocks'], true)),
            ]);
        });
    }

    public function actionStocks(): Response
    {
        return $this->renderSitemap('sitemap-stocks', function (){
            return $this->sitemap->generateMap(array_map(function (Stock $stock){
                return new MapItem(
                    Url::to(['/sites/stock/node', 'slug' => $stock->slug], true),
                    $stock->updated_at,
                    MapItem::WEEKLY
                );
            }, $this->stockes->getForSitemap()));
        }, new TagDependency(['tags' => ['stockes']]));
    }

    public function actionBonuses(): Response
    {
        return $this->renderSitemap('sitemap-bonuses', function (){
            return $this->sitemap->generateMap(array_map(function (Bonus  $bonus){
                return new MapItem(
                    Url::to(['/sites/bonus/node', 'slug' => $bonus->slug], true),
                    $bonus->updated_at,
                    MapItem::WEEKLY
                );
            }, $this->bonuses->getForSiteMap()));
        }, new TagDependency(['tags' => ['bonuses']]));
    }

    public function actionArticles(): Response
    {
        return $this->renderSitemap('sitemap-articles', function (){
            return $this->sitemap->generateMap(array_map(function (Article $article){
                return new MapItem(
                    Url::to(['/sites/article/node', 'slug' => $article->slug], true),
                    $article->updated_at,
                    MapItem::MONTHLY
                );
            }, $this->articles->getAll()));
        }, new TagDependency(['tags' => ['articles']]));
    }

    public function actionCategories(): Response
    {
        return $this->renderSitemap('sitemap-categories', function (){
            return $this->sitemap->generateMap(array_map(function (Category $category){
                return new MapItem(
                    Url::to(['/shop/catalog/category', 'id' => $category->id], true),
                    null,
                    MapItem::WEEKLY
                );
            }, $this->categories->getAll()));
        }, new TagDependency(['tags' => ['categories']]));
    }

    public function actionProductsIndex(): Response
    {
        return $this->renderSitemap('products-index', function (){
            return $this->sitemap->generateIndex(array_map(function ($start){
                return new IndexItem(Url::to(['products', 'start' => $start * self::ITEM_PER_PAGE], true));
            }, range(0, (int)($this->products->count() / self::ITEM_PER_PAGE))));
        },new TagDependency(['tags' => ['products']]));
    }

    public function actionProducts($start = 0): Response
    {
        return $this->renderSitemap(['shop-products', $start], function () use ($start){
            return $this->sitemap->generateMap(array_map(function (Product $product){
                return new MapItem(
                    Url::to(['/shop/catalog/product', 'id' => $product->id], true),
                    $product->updated_at,
                    MapItem::WEEKLY
                );
            }, $this->products->getAllByRange($start, self::ITEM_PER_PAGE)));
        }, new TagDependency(['tags' => ['products']]));
    }

    private function renderSitemap($key, callable $callback, Dependency $dependency = null): Response
    {
        return \Yii::$app->response->sendContentAsFile(\Yii::$app->cache->getOrSet($key, $callback, null, $dependency), Url::canonical(), [
            'mimeType' => 'application/xml',
            'inline' => true
        ]);
    }
}