<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use store\helpers\SliderHelper;

/* @var $this yii\web\View */
/* @var $slider store\entities\site\Slider */
/* @var $slideForm \store\forms\manage\site\SliderPhotosForm */

$this->title = $slider->name;
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view">

    <p>
        <?php if ($slider->isDraft()): ?>
        <?= Html::a('Опубликовать', ['activate', 'id' => $slider->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Отключить', ['draft', 'id' => $slider->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $slider->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $slider->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Слайдер</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $slider,
                'attributes' => [
                    'id',
                    'name',
                    [
                        'label' => 'Категории',
                        'value' => implode(', ', ArrayHelper::getColumn($slider->sliderCategories, 'name'))
                    ],
                    [
                        'attribute' => 'status',
                        'value' => SliderHelper::statusLabel($slider->status),
                        'format' => 'html',
                    ],
                    'created_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box" id="slides">
        <div class="box-header with-border">Слайды</div>
        <div class="box-body">
            <div class="row">
                <?php foreach ($slider->slides as $slide): ?>
                    <div class="col-sm-4 text-center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-slide-up', 'id' => $slider->id, 'slideId' => $slide->id], ['class' => 'btn btn-default', 'data-method' => 'post']) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['remove-slide', 'id' => $slider->id, 'slideId' => $slide->id], ['class' => 'btn btn-default', 'data-method' => 'post', 'data-confirm' => 'Удалить слайд?']) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-slide-down', 'id' => $slider->id, 'slideId' => $slide->id], ['class' => 'btn btn-default', 'data-method' => 'post']) ?>
                        </div>
                        <br>
                        <?= Html::img($slide->getThumbFileUrl('file', 'main')) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data'],
            ]) ?>

            <?= $form->field($slideForm, 'files[]')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Закачать', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>


</div>
