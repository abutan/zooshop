<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;
?>

<h1 class="text-center text-danger">
    Внимание!
</h1>

<p class="text-center">
    Для того чтобы совершить это действие на сайте, необходимо <?= Html::a('зарегистрироваться', ['/auth/signup/signup'], ['target' => '_blank']) ?> или <?= Html::a('войти на сайт', ['/auth/auth/login'], ['target' => '_blank']) ?> под своими учетными данными.
</p>