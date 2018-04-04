<?php

/* @var $slider null|\store\entities\site\Slider */
/* @var $this \yii\web\View */

use yii\bootstrap\Carousel;
use yii\helpers\Html;
?>

<div class="slider">
    <?php $carousel = [] ?>
    <?php foreach ($slider->slides as $slide): ?>
        <?php $carousel[] = [
            'content' => Html::img($slide->getThumbFileUrl('file', 'front'), ['alt' => $slide->id])
        ] ?>
    <?php endforeach; ?>

    <?= Carousel::widget([
        'items' => $carousel,
        'options' => ['class' => 'carousel slide'],
        'controls' => FALSE,
    ]) ?>
</div>