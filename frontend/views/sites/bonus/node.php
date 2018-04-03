<?php

/* @var $bonus null|\store\entities\site\Bonus */
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $bonus->getTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $bonus->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $bonus->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Бонусы', 'url' => ['/sites/bonus/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bonus-node container-fluid">
    <h1><?= Html::encode($bonus->name) ?></h1>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <?= $bonus->body ?>
</div>
