<?php

namespace frontend\widgets\site;


use store\entities\site\Slider;
use yii\base\Widget;

class BrandSlider extends Widget
{
    public function run()
    {
        $slider = Slider::findOne(2);
        $slides = $slider->slides;

        return $this->render('brandSlider', [
            'slides' => $slides,
        ]);
    }
}