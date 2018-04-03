<?php

namespace frontend\controllers\sites;


use store\frontModels\site\BonusReadRepository;
use yii\base\Module;
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

    public function actionIndex()
    {
        $dataProvider = $this->service->getAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNode($slug)
    {
        if (!$bonus = $this->service->findBySlug($slug)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        return $this->render('node', [
            'bonus' => $bonus,
        ]);
    }
}