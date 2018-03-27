<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $category \store\entities\shop\Category */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

<?= $this->render('_subcategories', [
    'category' => $category,
]) ?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider,
]) ?>