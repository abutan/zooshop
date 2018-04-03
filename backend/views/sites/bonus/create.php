<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\site\BonusForm */

$this->title = 'Добавление бонуса';
$this->params['breadcrumbs'][] = ['label' => 'Бонусы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
