<?php

namespace frontend\controllers;


use yii\caching\TagDependency;
use yii\helpers\Url;
use store\entities\shop\product\Product;
use store\services\yandex\YandexMarket;
use yii\base\Module;
use yii\web\Controller;
use yii\web\Response;

class MarketController extends Controller
{
    private $generator;

    public function __construct(
        string $id,
        Module $module,
        YandexMarket $generator,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->generator = $generator;
    }

    public function actionIndex(): Response
    {
        $xml = \Yii::$app->cache->getOrSet('yandex_market', function (){
            return $this->generator->generate(function (Product $product){
                return Url::to(['/shop/catalog/product', 'id' => $product->id], true);
            });
        }, null, new TagDependency(['tags' => ['categories', 'products']]));

        return \Yii::$app->response->sendContentAsFile($xml, 'yandex-market.xml', [
            'mimeType' => 'application/xml',
            'inline' => true,
        ]);
    }
}