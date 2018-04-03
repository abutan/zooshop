<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\site\BonusForm */
/* @var $bonus \store\entities\site\Bonus */

$this->title = 'Редактирование бонуса: ' . $bonus->name;
$this->params['breadcrumbs'][] = ['label' => 'Бонусы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $bonus->name, 'url' => ['view', 'id' => $bonus->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="bonus-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
