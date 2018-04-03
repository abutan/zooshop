<?php

/* @var $this \yii\web\View */
/* @var $stock null|\store\entities\site\Stock */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $stock->getTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $stock->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $stock->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Акции и скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-node container-fluid">
    <h1><?= Html::encode($stock->name) ?></h1>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <?= $stock->body ?>
</div>
