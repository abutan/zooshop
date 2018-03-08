<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\TagForm */

$this->title = 'Добавление тега (метки)';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
