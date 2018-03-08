<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\TagForm */
/* @var $tag \store\entities\shop\Tag */

$this->title = 'Редактирование тега (метки): ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Теги (метки)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
