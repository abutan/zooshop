<?php

/* @var $product null|\store\entities\shop\product\Product */
/* @var $this \yii\web\View */
/* @var $model \store\forms\shop\AddToCartForm */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление в корзину';

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cart-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?php $form = ActiveForm::begin() ?>

            <?php if ($modifications = $model->modificationsList()): ?>
                <?= $form->field($model, 'modification')->dropDownList($modifications, ['prompt' => '--- Выбрать ---']) ?>
            <?php endif; ?>

            <?= $form->field($model, 'quantity')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Добавить в корзину', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
