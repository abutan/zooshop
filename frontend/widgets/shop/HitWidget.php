<?php

namespace frontend\widgets\shop;


use store\frontModels\shop\ProductReadRepository;
use yii\base\Widget;

class HitWidget extends Widget
{
    public $limit;

    private $service;

    public function __construct(ProductReadRepository $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
    }

    public function run()
    {
        return $this->render('hit', [
            'hits' => $this->service->getHits($this->limit),
        ]);
    }
}