<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\site\NotificationForm */
/* @var $notification \store\entities\site\Notification */

$this->title = 'Редактироание объявления: ' . $notification->name;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $notification->name, 'url' => ['view', 'id' => $notification->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="notification-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
