<?php

/* @var $slides \store\entities\site\Slide[] */
/* @var $this \yii\web\View */

use yii\helpers\Html;
use frontend\assets\SlickSliderAsset;

SlickSliderAsset::register($this);
?>

<div class="brand">
    <div class="brand-carousel">
        <?php foreach ($slides as $slide): ?>
            <?= Html::img($slide->getThumbFileUrl('file', 'slick'), ['alt' => $slide->id]) ?>
        <?php endforeach; ?>
    </div>

</div>
