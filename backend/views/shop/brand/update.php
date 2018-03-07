<?php

/* @var $this yii\web\View */
/* @var $brand store\entities\shop\Brand */
/* @var $model \store\forms\shop\BrandForm */

$this->title = 'Редактирование бренда: '. $brand->name;
$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brand->name, 'url' => ['view', 'id' => $brand->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
