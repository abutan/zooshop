<?php
/* @var $this \yii\web\View */
/* @var $model \store\entities\site\Stock */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['/sites/stock/node', 'slug' => $model->slug]);
?>

<div class="stock-item container-fluid">
    <a href="<?= Html::encode($url) ?>">
        <h3><?= Html::encode($model->name) ?></h3>
    </a>


    <?= $model->summary ?>

</div>
