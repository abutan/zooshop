<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $discount \store\entities\shop\Discount */

$this->title = $discount->name;
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-view">

    <p>
        <?php if ($discount->active == true): ?>
        <?= Html::a('Отключить', ['draft', 'id' => $discount->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Активировать', ['activate', 'id' => $discount->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $discount->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $discount->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $discount,
                'attributes' => [
                    'id',
                    'percent',
                    'name',
                    'from_date',
                    'to_date',
                    'active',
                ],
            ]) ?>
        </div>
    </div>


</div>
