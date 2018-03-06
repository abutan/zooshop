<?php

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class LtAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
    ];
    public $jsOptions = [
        'condition' => 'Lte IE9',
        'position' => View::POS_HEAD,
    ];
}