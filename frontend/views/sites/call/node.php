<?php

/* @var $this \yii\web\View */
/* @var $model \store\forms\manage\site\CallForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin(['id' => 'callForm']) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => TRUE, 'placeholder' => 'ФИО']) ?>
<?= $form->field($model, 'phone')->widget(MaskedInput::class, [
    'mask' => '+7 (999) 999-99-99',
    'options' => [
        'class' => 'form-control',
        'placeholder' => 'Контактный телефон',
    ],
]) ?>
<?= $form->field($model, 'accept')->checkbox() ?>
<div class="form-group">
    <?= Html::submitButton('Заказать звонок', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>

<p>
    <a href="<?= Url::to(['/sites/article/node', 'slug' => 'soglasenie-ob-obrabotke-personalnyh-dannyh']) ?>" target="_blank">
        Соглашение об обработке персональных данных
    </a>
</p>