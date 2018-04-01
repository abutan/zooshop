<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\product\ProductEditForm */
/* @var $product \store\entities\shop\product\Product */

$this->title = 'Редактирование товара: ' . $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="product-update">

   <?php $form = ActiveForm::begin() ?>
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
    <div class="box">
        <div class="box-header with-border">Складские значения</div>
        <div class="box-body">
            <?= $form->field($model, 'weight')->textInput(['maxlength' => true])->hint('Значения писать только в ГРАММАХ. Другие единицы измерения вызовут сбои в работе. Если вес не используется, просто ставьте 0 (ноль)') ?>
        </div>
    </div>
    <div>
        <?= $form->field($model, 'body')->widget(CKEditor::class) ?>
    </div>
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
                <div class="box-header with-border">Атрибуты</div>
                <div class="box-body">
                    <?php foreach ($model->productValues as $i => $productValue): ?>
                        <?= $form->field($productValue, '[' . $i . ']value')->textInput() ?>
                    <?php endforeach; ?>
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
