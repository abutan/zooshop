<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \store\forms\auth\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Запрос на восстановление (изменение) пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php
    $filedOptions1 = [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
    ];
    ?>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <p>Впишите сюда свой Email. Дальнейшие инструкции будут отправлены на этот электронный адрес.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'enableClientValidation' => false]); ?>
            <?=
            $form->field($model, 'email', $filedOptions1)
                ->label(FALSE)
                ->textInput(['placeholder' => 'Email'])
            ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить запрос', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>