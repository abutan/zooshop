<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\CallHelper;

/* @var $this yii\web\View */
/* @var $call store\entities\site\Call */

$this->title = $call->name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы звонка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-view">

    <p>
        <?php if ($call->isDraft()): ?>
        <?= Html::a('Отметить как обработанное', ['activate', 'id' => $call->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::tag('span', 'Обработанное', ['class' => 'btn btn-default']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $call->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $call->id], [
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
                'model' => $call,
                'attributes' => [
                    'id',
                    'name',
                    'phone',
                    [
                        'attribute' => 'status',
                        'value' => CallHelper::statusLabel($call->status),
                        'format' => 'html',
                    ],
                    'created_at:datetime',
                ],
            ]) ?>
        </div>
    </div>


</div>
