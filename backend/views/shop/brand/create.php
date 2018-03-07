<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\shop\BrandForm */

$this->title = 'Добавление бренда';
$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
