<?php

/* @var $notification null|\store\entities\site\Notification */
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $notification->getTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $notification->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $notification->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notification-node">
    <h1><?= Html::encode($notification->name) ?></h1>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <?= $notification->body ?>
</div>
