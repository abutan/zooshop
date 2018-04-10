<?php

/* @var $this yii\web\View */
/* @var $user \store\entities\user\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
    Здравствуйте <?= $user->username ?>,

    Пройдите по этой ссылке для подтверждения своего Email:

<?= $confirmLink ?>

    Если Вы не собирались регистрироваться на нашем сайте, то просто удалите это письмо.
