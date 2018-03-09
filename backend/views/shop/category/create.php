<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\CategoryForm */

$this->title = 'Добавление категории';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
