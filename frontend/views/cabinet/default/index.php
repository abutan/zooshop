<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Личный кабинет пользователя';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-index container-fluid">
    <h2>Здравствуйте <small><?= Yii::$app->user->identity['username'] ?: 'пользователь '. Yii::$app->user->id ?></small></h2>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <h4>Добавить к своему профилю социальные сети для входа на сайт</h4>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>
