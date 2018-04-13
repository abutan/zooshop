<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;



/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\product\ProductCreateForm */

$this->title = 'Добавление товара';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]) ?>

    <div class="box">
        <div class="box-header with-border">Общие свойства товара</div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'makerId')->dropDownList($model->makerList(), ['prompt' => '']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'brandId')->dropDownList($model->brandList(), ['prompt' => '']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-8">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Не заполняйте это поле. При появлении ошибок или замечаний обратитесь к администратору.') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Складские значения</div>
                <div class="box-body">
                    <?= $form->field($model->quantity, 'quantity')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'weight')->textInput(['maxlength' => true])->hint('Значения писать только в ГРАММАХ. Другие единицы измерения вызовут сбои в работе. Если вес не используется, просто ставьте 0 (ноль)') ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Цена</div>
                <div class="box-body">
                    <?= $form->field($model->price, 'old')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model->price, 'new')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'body')->widget(CKEditor::class) ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Категории</div>
                <div class="box-body">
                    <?= $form->field($model->categories, 'main')->dropDownList($model->categories->categoriesList(), ['prompt' => '']) ?>
                    <?= $form->field($model->categories, 'others')->checkboxList($model->categories->categoriesList()) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Теги</div>
                <div class="box-body">
                    <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagList()) ?>
                    <?= $form->field($model->tags, 'text_new')->textInput()->hint('Если Вы решили добавить новые теги к товару прямо сейчас, то впишите их через запятую.') ?>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <button type="button" data-toggle="dropdown" data-loading-text="Загрузка ..." class="dropdown-toggle vetshop-cart" aria-expanded="false">
                        Сопутствующие товары
                    </button>
                    <ul id="dropdown-relates" class="dropdown-menu">
                        <li>
                            <?=$form->field($model->relates, 'products')->label(false)->checkboxList($model->relates->relatedList()) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">Фотографии</div>
                <div class="box-body">
                    <?= $form->field($model->photos, 'files[]')->widget(FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => TRUE,
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">SEO</div>
                <div class="box-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
