<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\site\NotificationForm */

$this->title = 'Добавление объявления';
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
