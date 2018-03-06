<?php

/* @var $this yii\web\View */
/* @var $user \store\entities\user\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/reset', 'token' => $user->password_reset_token]);
?>
Здравствуйте <?= $user->username ?>,

Пройдите по этой ссылке :

<?= $resetLink ?>
