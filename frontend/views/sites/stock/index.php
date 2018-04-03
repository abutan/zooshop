<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Акции и скидки';

$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-index container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <?=
        $this->render('_list', [
            'dataProvider' => $dataProvider,
        ])
    ?>
</div>
