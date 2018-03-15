<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $slider store\entities\site\Slider */
/* @var $model \store\forms\manage\site\SliderEditForm */

$this->title = 'Редактирование слайдера: ' . $slider->name;
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $slider->name, 'url' => ['view', 'id' => $slider->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="slider-update">

    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Категории</div>
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
