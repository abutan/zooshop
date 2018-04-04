<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Результаты поиска';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="fast-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>



    <?php if (count($dataProvider->getModels()) > 0): ?>
        <?= $this->render('_list', [
            'dataProvider' => $dataProvider
        ]) ?>
    <?php else: ?>
        <h3>К сожалению поиск не принес результатов. <small>Попробуйте использовать другие параметры.</small></h3>
    <?php endif; ?>
</div>
