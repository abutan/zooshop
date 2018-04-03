<?php

namespace frontend\controllers\sites;


use store\frontModels\site\StockReadRepository;
use yii\base\Module;
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

    public function actionIndex()
    {
        $dataProvider = $this->stocks->getAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNode($slug)
    {
        if (!$stock = $this->stocks->findBySlug($slug)){
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }

        return$this->render('node', [
            'stock' => $stock,
        ]);
    }
}