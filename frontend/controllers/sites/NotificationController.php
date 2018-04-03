<?php

namespace frontend\controllers\sites;


use store\frontModels\site\NotificationReadRepository;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NotificationController extends Controller
{
    public $layout = 'content';

    private $service;

    public function __construct(
        string $id,
        Module $module,
        NotificationReadRepository $service,
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
        if (!$notification = $this->service->findBySlug($slug)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
        return $this->render('node', [
            'notification' => $notification,
        ]);
    }
}