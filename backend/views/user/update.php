<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;


/* @var $this yii\web\View */
/* @var $user store\entities\user\User */
/* @var $model \store\forms\manage\user\UserEditForm */

$this->title = 'Редактирование пользователя: '. $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <?php $form = ActiveForm::begin() ?>
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '+7 (999) 999-99-99',
                'options' => [
                    'class' => 'form-control',
                ],
            ]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>
