<?php

namespace frontend\controllers\sites;


use store\frontModels\site\StockReadRepository;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StockController extends Controller
{
    public $layout = 'content';

    private $stocks;

    public function __construct(
        string $id,
        Module $module,
        StockReadRepository $stocks,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->stocks = $stocks;
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => null,
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => ['stocks'],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = $this->stocks->getAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNode($slug)
    {
        $stock = \Yii::$app->cache->getOrSet('stock'. $slug, function () use ($slug){
            return $this->stocks->findBySlug($slug);
        }, null, new TagDependency(['tags' => ['stocks']]));

        if (!$stock){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        return$this->render('node', [
            'stock' => $stock,
        ]);
    }
}