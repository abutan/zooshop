<?php
/* @var $this \yii\web\View */
/* @var $model \store\forms\auth\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вход';
?>

<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php
    $fieldOptions1 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
    ];
    $filedOptions2 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
    ];
    ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
            <?=
            $form->field($model, 'username', $fieldOptions1)
                ->label(FALSE)
                ->textInput(['placeholder' => 'Логин'])
            ?>
            <?=
            $form->field($model, 'password', $filedOptions2)
                ->label(FALSE)
                ->passwordInput(['placeholder' => 'Пароль'])
            ?>

            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <div class="col-xs-4">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
            </div>

            <div class="text-center" style="color:#999;margin:1em 0">
                Если Вы забыли свой пароль, то  <?= Html::a('его можно восстановить', ['/auth/reset/request']) ?>.
            </div>

            <?php ActiveForm::end(); ?>
            <h4 class="text-center">ИЛИ</h4>
            <h4>Войти на сайт через социальные сети</h4>
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['auth/network/auth']
            ]); ?>
    </div>
