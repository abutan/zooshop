<?php

namespace frontend\controllers\sites;


use store\frontModels\site\ArticleReadRepository;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;

class ArticleController extends Controller
{
    public $layout = 'content';

    private $articles;

    public function __construct(
        string $id,
        Module $module,
        ArticleReadRepository $articles,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->articles = $articles;
    }

    public function actionNode($slug)
    {
        $article = \Yii::$app->cache->getOrSet('article-'.$slug, function () use ($slug) {
            return $this->articles->findBySlug($slug);
        }, null, new TagDependency(['tags' => ['articles']]));
        if (!$article){
            throw new NotAcceptableHttpException('Запрашиваемая страница не найдена.');
        }

        return $this->render('node', [
            'article' => $article,
        ]);
    }
}