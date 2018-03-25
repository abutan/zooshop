<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $tag null|\store\entities\shop\Tag */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $tag->name;

$this->params['breadcrumbs'][] = $tag->name;
?>

    <h1>Товары с тегом &laquo;<?= Html::encode($this->title) ?>&raquo;</h1>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<?=
$this->render('_list', [
    'dataProvider' => $dataProvider,
])
?>