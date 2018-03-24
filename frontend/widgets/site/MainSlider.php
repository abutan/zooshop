<?php

namespace frontend\widgets\site;


use store\entities\site\Slider;
use yii\base\Widget;

class MainSlider extends Widget
{
    public function run()
    {
        $slider = Slider::findOne(1);
        $slides = $slider->slides;

        return $this->render('mainSlider', [
            'slides' => $slides,
        ]);
    }
}