<?php

/* @var $this \yii\web\View */
/* @var $model \store\forms\site\CommentForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\captcha\Captcha;
use yii\helpers\Url;
use frontend\widgets\site\CommentWidget;

$this->title = 'Ваши предложения (сообщения, запросы)';

$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content => ']);

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="comments-index container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>


    <?php if (Yii::$app->user->isGuest): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    Необходимо <a href="<?= Url::to(['/auth/auth/login']) ?>" target="_blank">войти</a> или <a href="<?=  Url::to(['/auth/signup/request'])?>"  target="_blank">зарегистрироваться</a> чтобы отправлять сообщения на этой странице.
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $form = ActiveForm::begin() ?>
                <?= Html::activeHiddenInput($model, 'parent_id', ['value' => '']) ?>
                <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    <?php endif; ?>
    <?= CommentWidget::widget() ?>
</div>
