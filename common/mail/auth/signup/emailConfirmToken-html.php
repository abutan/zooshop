<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \store\entities\user\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>

    <p>Пройдите по этой ссылке для подтверждения своего Email:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>

    <p>Если Вы не собираетесь регистрироваться на нашем сайте, просто удалите это письмо</p>
</div>
