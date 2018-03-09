<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $category store\entities\shop\Category */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $category->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Категория</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $category,
                'attributes' => [
                    'id',
                    'name',
                    'body:html',
                    'slug',
                    ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $category,
                'attributes' => [
                    'title',
                    'description',
                    'keywords',
                ],
            ]) ?>
        </div>
    </div>


</div>
