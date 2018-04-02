<?php

namespace frontend\widgets\shop;


use store\frontModels\shop\ProductReadRepository;
use yii\base\Widget;

class FeaturedWidget extends Widget
{
    public $limit;

    private $repository;

    public function __construct(ProductReadRepository $repository, array $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->render('featured', [
            'products' => $this->repository->getFeatured($this->limit),
        ]);
    }
}