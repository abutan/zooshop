<?php

namespace frontend\controllers\sites;


use store\frontModels\site\BonusReadRepository;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BonusController extends Controller
{
    public $layout = 'content';

    private $service;

    public function __construct(
        string $id,
        Module $module,
        BonusReadRepository $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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
                    'tags' => ['bonuses'],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = $this->service->getAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNode($slug)
    {
        $bonus = \Yii::$app->cache->getOrSet('bonus'. $slug, function () use ($slug){
            return $this->service->findBySlug($slug);
        }, null, new TagDependency(['tags' => ['bonuses']]));

        if (!$bonus){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        return $this->render('node', [
            'bonus' => $bonus,
        ]);
    }
}