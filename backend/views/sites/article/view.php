<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\ArticleHelper;

/* @var $this yii\web\View */
/* @var $article store\entities\site\Article */

$this->title = $article->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <p>
        <?php if ($article->isDraft()): ?>
        <?= Html::a('Опубликовать', ['activate', 'id' => $article->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Отключить', ['draft', 'id' => $article->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $article->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $article->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Статья</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $article,
                'attributes' => [
                    'id',
                    'name',
                    'summary:html',
                    'body:html',
                    'slug',
                    [
                        'attribute' => 'status',
                        'value' => ArticleHelper::statusLabel($article->status),
                        'format' => 'html',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $article,
                'attributes' => [
                    'title',
                    'description',
                    'keywords',
                ],
            ]) ?>
        </div>
    </div>


</div>
