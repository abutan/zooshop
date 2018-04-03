<?php
/* @var $this \yii\web\View */
/* @var $model \store\entities\site\Notification */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['/sites/notification/node', 'slug' => $model->slug]);
?>

<div class="notification-item">
    <a href="<?= Html::encode($url) ?>">
        <h3><?= Html::encode($model->name) ?></h3>
    </a>
    <p><?= Yii::$app->formatter->asDate($model->created_at, 'long') ?></p>
    <?= $model->summary ?>
</div>


