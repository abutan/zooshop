<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\BonusHelper;

/* @var $this yii\web\View */
/* @var $bonus \store\entities\site\Bonus */

$this->title = $bonus->name;
$this->params['breadcrumbs'][] = ['label' => 'Бонусы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-view">

    <p>
        <?php if ($bonus->isDraft()): ?>
        <?= Html::a('Опубликовать', ['activate', 'id' => $bonus->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Отключить', ['draft', 'id' => $bonus->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $bonus->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $bonus->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Общее</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $bonus,
                'attributes' => [
                    'id',
                    'name',
                    'summary:html',
                    'body:html',
                    'slug',
                    [
                        'attribute' => 'status',
                        'value' => BonusHelper::StatusLabel($bonus->status),
                        'format' => 'raw',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $bonus,
                'attributes' => [
                    'title',
                    'description',
                    'keywords',
                ],
            ]) ?>
        </div>
    </div>


</div>
