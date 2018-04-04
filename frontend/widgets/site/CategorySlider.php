<?php

namespace frontend\widgets\site;


use store\frontModels\site\SliderReadRepository;
use yii\base\Widget;

class CategorySlider extends Widget
{
    public $category;

    private $sliders;

    public function __construct(SliderReadRepository $sliders,  array $config = [])
    {
        parent::__construct($config);
        $this->sliders = $sliders;
    }

    public function run()
    {
        if (!$id = $this->sliders->findByCategory($this->category)){
            return false;
        }

        $slider = $this->sliders->findById($id);

        return $this->render('categorySlider', [
            'slider' => $slider,
        ]);
    }
}