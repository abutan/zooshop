<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Распродажа';

$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sale-index">
    <?= Html::encode($this->title) ?>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?=
        $this->render('_list', [
            'dataProvider' => $dataProvider,
        ])
    ?>
</div>
