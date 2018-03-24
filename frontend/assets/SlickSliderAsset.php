<?php

namespace frontend\assets;


use yii\web\AssetBundle;

class SlickSliderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/slick.css',
    ];
    public $js = [
        'js/slick.js',
        'js/slickSlider.js',
    ];
}