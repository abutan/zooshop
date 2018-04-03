<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Бонусы';

$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bonus-index container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <?=
        \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'itemView' => '_bonus',
        ])
    ?>
</div>
