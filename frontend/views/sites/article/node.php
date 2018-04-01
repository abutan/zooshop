<?php

/* @var $this \yii\web\View */
/* @var $article null|\store\entities\site\Article */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $article->title ?: $article->name;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="article-node container-fluid">
    <h1><?= Html::encode($article->name) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $article->body ?>
</div>
