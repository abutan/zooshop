<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\CategoryForm */
/* @var $category \store\entities\shop\Category */

$this->title = 'Редактирование категории: '. $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
