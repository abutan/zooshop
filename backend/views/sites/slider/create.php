<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\site\SliderCreateForm */

$this->title = 'Добавление слайдера';
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-create">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => FALSE,
        'options' => ['enctype' => 'multipart/form-data'],
    ]) ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-border with-border">Слайдер</div>
                <div class="box-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="box">
                <div class="box-border with-border">Слайдер</div>
                <div class="box-body">
                    <?= $form->field($model->slides, 'files[]')->widget(FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => TRUE,
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-border with-border">Категории</div>
                <div class="box-body">
                    <?= $form->field($model->categories, 'categories')->checkboxList($model->categories->categoriesList(), ['prompt' => '']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
