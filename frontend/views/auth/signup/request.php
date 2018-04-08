<?php
/* @var $this \yii\web\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \store\forms\auth\SignupForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\helpers\Url;

$this->title = 'Регистрация';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php
    $fieldOptions1 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
    ];
    $filedOptions2 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
    ];
    $filedOptions3 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
    ];
    $filedOptions4 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-earphone form-control-feedback'></span>"
    ];
    ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableClientValidation' => false]); ?>
            <?=
            $form->field($model, 'username', $fieldOptions1)
                ->label(FALSE)
                ->textInput(['placeholder' => 'Логин'])
            ?>
            <?=
            $form->field($model, 'email', $filedOptions2)
                ->label(FALSE)
                ->textInput(['placeholder' => 'Email'])
            ?>
            <?=
            $form->field($model, 'phone', $filedOptions4)
                ->label(false)
                ->widget(MaskedInput::class, [
                    'mask' => '+7 (999) 999-99-99',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Контактный телефон',
                    ]
                ])
            ?>
            <?=
            $form->field($model, 'password', $filedOptions3)
                ->label(FALSE)
                ->passwordInput(['placeholder' => 'Пароль'])
            ?>
            <?= $form->field($model, 'subscribe')->checkbox() ?>
            <?= $form->field($model, 'accept')->checkbox() ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="site-signup-agreement">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <p>
                    Нажимая кнопку "ЗАРЕГИСТРИРОВАТЬСЯ", Вы автоматически принимаете условия
                    <a href="<?= Url::to(['/sites/article/node', 'slug' => 'soglasenie-ob-obrabotke-personalnyh-dannyh']) ?>" target="_blank">"Соглашения об обработке персональных данных"</a>. Подробнее с ним можно ознакомиться <a href="<?= Url::to(['/sites/article/node', 'slug' => 'soglasenie-ob-obrabotke-personalnyh-dannyh']) ?>" target="_blank">на этой странице</a>. Если Вы не согласны с данным соглашением, то просто покиньте сайт.
                </p>
            </div>
        </div>
    </div>

</div>
