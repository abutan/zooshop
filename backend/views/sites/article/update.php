<?php

/* @var $this yii\web\View */
/* @var $article store\entities\site\Article */
/* @var $model \store\forms\manage\site\ArticleManageForm */

$this->title = 'Редактирование статьи: ' . $article->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $article->name, 'url' => ['view', 'id' => $article->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
