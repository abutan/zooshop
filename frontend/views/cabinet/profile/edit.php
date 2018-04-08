<?php
/* @var $this \yii\web\View */
/* @var $model \store\forms\user\ProfileEditForm */
/* @var $user \store\entities\user\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\widgets\Breadcrumbs;

$this->title = 'Редактирование профиля';

$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = 'Профиль';
?>

<div class="user-update">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">

            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
            ?>

            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '+7 (999) 999 - 99 - 99',
                'options' => [
                    'class' => 'form-control',
                ],
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
