<?php

/* @var $this yii\web\View */

$this->title = 'Главная';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Здравствуйте <small><?= Yii::$app->user->identity['username'] ?></small>!</h1>

        <p class="lead">Вы вошли в панель управления сайтом &laquo;<?= Yii::$app->name ?>&raquo;.</p>

        <p>Приятной работы.</p>
    </div>
</div>
