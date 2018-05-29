<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\widgets\shop\CategoryWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\caching\TagDependency;
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-sm-3">
                <div class="aside-menu">
                    <ul>
                        <?=
                        CategoryWidget::widget([
                            'active' => $this->params['active_category'] ?? NULL,
                        ]);
                        ?>
                    </ul>
                </div>

                <div class="sale">
                    <?= Html::a('Распродажа', ['/shop/catalog/sale']) ?>
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
                            ['label' => Html::img('/files/default/12_mnu_icon.png', ['alt' => 'Объявления']).'<p>Объявления</p>', 'url' => ['/sites/notification/index']]
                        ],
                    ]);
                    ?>
                </div>

                <div class="others-menu">
                    <?=
                    Nav::widget([
                        'encodeLabels' => FALSE,
                        'items' => [
                            ['label' => Html::img(Yii::getAlias('@web/files/default/13_mnu_icon.png'), ['alt' => 'Новинки']).'<p>Новинки</p>', 'url' => ['/shop/catalog/featured']],
                            ['label' => Html::img(Yii::getAlias('@web/files/default/14_mnu_icon.png'), ['alt' => 'Хит продаж']).'<p>Хит продаж</p>', 'url' => ['/shop/catalog/hit']],
                            ['label' => Html::img(Yii::getAlias('@web/files/default/15_mnu_icon.png'), ['alt' => 'Акции и скидки']).'<p>Акции и скидки</p>', 'url' => ['/sites/stock/index']],
                            ['label' => Html::img(Yii::getAlias('@web/files/default/16_mnu_icon.png'), ['alt' => 'Бонусы']).'<p>Бонусы</p>', 'url' => ['/sites/bonus/index']],
                        ],
                    ])
                    ?>
                </div>
            </aside>
            <div class="col-sm-9">
                <?= $content ?>
            </div>
        </div>
    </div>
<?php $this->endContent() ?>
