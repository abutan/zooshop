<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\UserHelper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model store\entities\user\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?php if ($model->isUnSubscribe()): ?>
        <?= Html::a('Подписать на рассылку', ['subscribe', 'id' => $model->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Отписать от рассылки', ['un-subscribe', 'id' => $model->id], ['class' => 'btn btn-warning', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
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
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'phone',
                    'email:email',
                    [
                        'label' => 'Роль',
                        'value' => implode(', ', ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($model->id), 'description')),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => UserHelper::statusLabel($model->status),
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'subscribe',
                        'value' => $model->subscribe ? '<span class="label label-success">Подписан на рассылку</span>' : '<span class="label label-warning">Отписан от рассылки</span>',
                        'format' => 'raw',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>


</div>
