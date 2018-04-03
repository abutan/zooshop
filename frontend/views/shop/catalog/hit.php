<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\widgets\shop\HitWidget;

$this->title = 'Хиты продаж';

$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="featured-node">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= HitWidget::widget([
        'limit' => 9,
    ]) ?>
</div>
