<?php
/* @var $this \yii\web\View */
/* @var $model \store\entities\site\Bonus */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['/sites/bonus/node', 'slug' => $model->slug]);
?>

<div class="bonus-item">
    <a href="<?= $url ?>">
        <h3><?= Html::encode($model->name) ?></h3>
    </a>

    <?=$model->summary ?>
</div>
