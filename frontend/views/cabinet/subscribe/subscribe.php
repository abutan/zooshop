<?php

/* @var $this \yii\web\View */
/* @var $model \store\forms\manage\user\UserSubscribeForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

$this->title = 'Управление подписками';

$this->params['breadcrumbs'][] = ['label' =>'Личный кабинет', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="subscribe-index container-fluid">

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'subscribe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>

</div>
