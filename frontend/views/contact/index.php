<?php

/* @var $this \yii\web\View */
/* @var $model \store\forms\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\captcha\Captcha;

$this->title = 'Обратная связь';

$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="contact-index container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Логин или имя']) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email для ответа']) ?>

            <?= $form->field($model, 'subject')->textInput() ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
