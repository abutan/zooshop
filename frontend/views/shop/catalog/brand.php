<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $brand null|\store\entities\shop\Brand */

use yii\bootstrap\Html;
use yii\widgets\Breadcrumbs;

$this->title = $brand->getTitle();

$this->params['breadcrumbs'][] = $brand->name;
?>

    <h1><?= Html::encode($brand->name) ?></h1>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<?=
$this->render('_list', [
    'dataProvider' => $dataProvider
])
?>