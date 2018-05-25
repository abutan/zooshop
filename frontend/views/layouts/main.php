<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\LtAppAsset;
use yii\helpers\Url;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use frontend\widgets\shop\CartWidget;

AppAsset::register($this);
LtAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Дежурная ветаптека | '.$this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="page-wrapper container">
    <div class="top-block">
        <div class="row">
            <?php if (Yii::$app->user->isGuest): ?>
                <div class="enter col-sm-1 col-sm-offset-4">
                    <p>
                        <i class="fa fa-sign-in-alt fa-2x" ></i>  <?= Html::a('<span>Вход</span>', ['/auth/auth/login']) ?>
                    </p>
                </div><!--enter-->

                <div class="registration col-sm-2 col-sm-offset-1">
                    <p>
                        <i class="fa fa-user-plus"></i>  <?= Html::a('<span>Регистрация</span>', ['/auth/signup/request']) ?>

                    </p>
                </div><!--registration-->

                <div class="backcall col-sm-3">
                    <p>
                        <i class="fa fa-phone-volume fa-2x"></i>   <?= Html::a('<span>Обратный звонок</span>', ['/sites/call/node'], ['class' => 'backPhone']) ?>
                    </p>
                </div><!--backcall-->

            <?php else: ?>

                <div class="user-office col-sm-3 col-sm-offset-2">
                    <p>
                        <i class="fa fa-user"></i>  <?= Html::a('<span>Личный кабинет</span>', ['/cabinet/default/index']) ?>

                    </p>
                </div><!--user-office-->

                <div class="logout-user col-sm-4">
                    <?= Html::beginForm(['/auth/auth/logout'], 'post') ?>
                    <?= Html::submitButton('<i class="fa fa-sign-out-alt fa-2x pull-left"></i> &nbsp; <span>Выход  '.Yii::$app->user->identity['username'].'</span>', ['class' => 'btn btn-link logout btn-block btn-lg']) ?>
                    <?= Html::endForm() ?>
                </div><!--logout-->

                <div class="backcall col-sm-3">
                    <p>
                        <i class="fa fa-phone-volume fa-2x"></i>   <?= Html::a('<span>Обратный звонок</span>', ['/sites/call/node'], ['class' => 'backPhone']) ?>
                    </p>
                </div><!--backcall-->
            <?php endif; ?>
        </div>

    </div><!--top-block-->

    <div class="alert-message">
        <?= Alert::widget() ?>
    </div>

    <header class="header">
        <div class="row">
            <div class="logo-1 col-sm-5 col-sm-offset-1">
                <a href="<?= Url::to(Yii::$app->homeUrl) ?>">
                    <?= Html::img(YII::getAlias('@web/files/default/logo_01.png'), ['alt' => 'На главную', 'class' => 'img-responsive']) ?>
                </a>
            </div><!--logo-1-->

            <div class="logo-2 col-sm-6">
                <a href="<?= Url::to(Yii::$app->homeUrl) ?>">
                    <?= Html::img(YII::getAlias('@web/files/default/logo_02.png'), ['alt' => 'На главную', 'class' => 'img-responsive']) ?>
                </a>
            </div><!--logo-2-->
        </div>
    </header><!--header-->

    <div class="down-block">
        <div class="down-block-inner">
            <div class="row">

                <div class="shop-phone col-sm-2 text-center">
                    <i class="fa fa-phone hidden-sm"></i>  <span>+7(999)1234567</span>
                </div><!--shop-phone-->

                <div class="shop-search col-sm-3">
                    <?= Html::beginForm(['/shop/catalog/search'], 'get', ['class' => '']) ?>
                    <div class="input-group">
                        <input type="text" name="text" class="form-control" placeholder="Поиск товаров ...">
                        <span class="input-group-btn">
                         <button class="btn btn-info" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                         </button>
                    </span>
                    </div>
                    <?= Html::endForm() ?>
                </div><!--shop-search-->

                <div class="shop-pay col-sm-1 text-right">
                    <i class="fa fa-database hidden-sm"></i>
                    <?= Html::a('Оплата', ['/sites/article/node', 'slug' => 'oplata']) ?>
                </div><!--shop-pay-->

                <div class="shop-shipping col-sm-2  text-right" >
                    <i class="fa fa-truck hidden-sm"></i>
                    <?= Html::a('Доставка', ['/sites/article/node', 'slug' => 'dostavka']) ?>
                </div><!--shop-shipping-->

                <div class="shop-card col-sm-4 text-center">
                    <?= CartWidget::widget() ?>
                </div><!--shop-card-->
            </div>
        </div>

    </div><!--down-block-->

    <div class="picture-menu">
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Ветаптека', ['/shop/catalog/category', 'id' => 2]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 2]) ?>">
                    <?= Html::img('/files/default/01_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Собаки', ['/shop/catalog/category', 'id' => 3]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 3]) ?>">
                    <?= Html::img('/files/default/02_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Кошки', ['/shop/catalog/category', 'id' => 4]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 4]) ?>">
                    <?= Html::img('/files/default/03_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Птицы', ['/shop/catalog/category', 'id' => 5]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 5]) ?>">
                    <?= Html::img('/files/default/04_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Грызуны', ['/shop/catalog/category', 'id' => 6]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 6]) ?>">
                    <?= Html::img('/files/default/05_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Рептилии', ['/shop/catalog/category', 'id' => 7]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 7]) ?>">
                    <?= Html::img('/files/default/06_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
        <div class="item-block">
            <div class="block-title text-center">
                <?= Html::a('Рыбы', ['/shop/catalog/category', 'id' => 8]) ?>
            </div>
            <div class="block-picture">
                <a href="<?= Url::to(['/shop/catalog/category', 'id' => 8]) ?>">
                    <?= Html::img('/files/default/07_icon_categ.png', ['alt' => 'Icon', 'class' => 'img-responsive']) ?>
                </a>
            </div>
        </div>
    </div><!--picture-menu-->

    <div class="main-content">
        <?= $content ?>
    </div><!--main-content-->

    <div class="footer-push"></div><!--footer-push-->
</div><!--page-wrapper-->

<footer class="footer container">

</footer><!--footer-->
<?php
Modal::begin([
    'id' => 'attModal',
    'headerOptions' => ['id' => 'modal-header'],
    'header' => '',
    'size' => 'modal-lg',
    'clientOptions' => false
])
?>
<div id="modal-content"></div>
<?php Modal::end() ?>
<?php
Modal::begin([
    'id' => 'phoneModal',
    'headerOptions' => ['id' => 'modal-header'],
    'header' => '<h4>Заказать звонок</h4>',
    'size' => 'modal-sm',
    'clientOptions' => false
])
?>
<div id="modal-content"></div>
<?php Modal::end() ?>

<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>


