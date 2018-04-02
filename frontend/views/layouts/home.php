<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\site\MainSlider;
use frontend\widgets\site\BrandSlider;
use frontend\widgets\shop\CategoryWidget;
use yii\bootstrap\Nav;

$this->title = 'Главная';

$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="aside-menu">
                    <ul>
                        <?= CategoryWidget::widget([
                            'active' => $this->params['active'] ?? null,
                        ]) ?>
                    </ul>
                </div>

                <div class="sale">
                    <?= Html::a('Распродажа', ['#']) ?>
                </div>

                <div class="article-menu">
                    <?=
                    Nav::widget([
                        'encodeLabels' => FALSE,
                        'items' => [
                            ['label' => Html::img(Yii::getAlias('@web/files/default/08_mnu_icon.png'), ['alt' => 'О нас']).'<p>О нас</p>', 'url' => ['/sites/article/node', 'slug' => 'o-kompanii']],
                            ['label' => Html::img('/files/default/09_mnu_icon.png', ['alt' => 'Магазины и контакты']).'<p>Магазины и контакты</p>', 'url' => ['/sites/article/node', 'slug' => 'magaziny-i-kontakty']],
                            ['label' => Html::img('/files/default/10_mnu_icon.png', ['alt' => 'Доставка и оплата']).'<p>Доставка и оплата</p>', 'url' => ['/sites/article/node', 'slug' => 'dostavka-i-oplata']],
                            ['label' => Html::img('/files/default/11_mnu_icon.png', ['alt' => 'Ваши предложения']).'<p>Ваши предложения</p>', 'url' => ['/sites/comment/index']],
                            ['label' => Html::img('/files/default/12_mnu_icon.png', ['alt' => 'Объявления']).'<p>Объявления</p>', 'url' => ['#']]
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-sm-9">
                <?= MainSlider::widget() ?>

                <div class="bonus-block">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="bonus-title text-center">
                                <a href="<?= Url::to(['/shop/catalog/featured']) ?>">
                                    <h4>Новинки</h4>
                                </a>
                            </div>
                            <div class="bonus-image">
                                <a href="<?= Url::to(['/shop/catalog/featured']) ?>">
                                    <?= Html::img(Yii::getAlias('@web/files/default/new_icon.png'), ['alt' => 'Новинки', 'class' => 'img-responsive']) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="bonus-title text-center">
                                <a href="<?= Url::to(['#']) ?>">
                                    <h4>Хит продаж</h4>
                                </a>
                            </div>
                            <div class="bonus-image">
                                <a href="<?= Url::to(['#']) ?>">
                                    <?= Html::img(Yii::getAlias('@web/files/default/hit_icon.png'), ['alt' => 'Хит продаж', 'class' => 'img-responsive']) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="bonus-title text-center">
                                <a href="<?= Url::to(['#']) ?>">
                                    <h4>Акции и скидки</h4>
                                </a>
                            </div>
                            <div class="bonus-image">
                                <a href="<?= Url::to(['#']) ?>">
                                    <?= Html::img(Yii::getAlias('@web/files/default/akcii_icon.png'), ['alt' => 'Акции и скидки', 'class' => 'img-responsive']) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="bonus-title text-center">
                                <a href="<?= Url::to(['#']) ?>">
                                    <h4>Бонусы</h4>
                                </a>
                            </div>
                            <div class="bonus-image">
                                <a href="<?= Url::to(['#']) ?>">
                                    <?= Html::img(Yii::getAlias('@web/files/default/bonus_icon.png'), ['alt' => 'Бонусы', 'class' => 'img-responsive']) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?= BrandSlider::widget() ?>
            </div>
        </div>
    </div>
<?php $this->endContent() ?>
