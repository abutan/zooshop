<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \store\forms\auth\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменение пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php
    $filedOptions1 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
    ];
    ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <p>Введите свой новый пароль:</p>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'enableClientValidation' => false]); ?>
            <?=
            $form->field($model, 'password', $filedOptions1)
                ->label(FALSE)
                ->passwordInput(['placeholder' => 'Пароль']) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>