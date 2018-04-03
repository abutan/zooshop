<?php

/* @var $this \yii\web\View */
/* @var $directoryAsset false|string */
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image" style="height: 45px;">

            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity['username'] ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu администратора', 'options' => ['class' => 'header']],
                    ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/user/index']],
                    ['label' => 'Заказы', 'icon' => 'shopping-basket', 'url' => ['/shop/order/index']],
                    ['label' => 'Заказы звонка', 'icon' => 'phone', 'url' => ['/sites/call/index']],
                    ['label' => 'Магазин', 'icon' => 'shopping-bag', 'url' => ['#'], 'items' => [
                        ['label' => 'Бренды', 'icon' => 'copyright', 'url' => ['/shop/brand/index']],
                        ['label' => 'Производители', 'icon' => 'industry', 'url' => ['/shop/maker/index']],
                        ['label' => 'Теги (метки)', 'icon' => 'code', 'url' => ['/shop/tag/index']],
                        ['label' => 'Категории', 'icon' => 'server', 'url' => ['/shop/category/index']],
                        ['label' => 'Атрибуты', 'icon' => 'cog', 'url' => ['/shop/characteristic/index']],
                        ['label' => 'Методы доставки', 'icon' => 'truck', 'url' => ['/shop/delivery/index']],
                        ['label' => 'Методы оплаты', 'icon' => 'gg-circle', 'url' => ['/shop/payment/index']],
                        ['label' => 'Скидки', 'icon' => 'arrow-circle-down', 'url' => ['/shop/discount/index']],
                        ['label' => 'Товары', 'icon' => 'cart-arrow-down', 'url' => ['/shop/product/index']],
                        ],
                    ],
                    ['label' => 'Сайт', 'icon' => 'paste', 'url' => ['#'], 'items' => [
                            ['label' => 'Статьи', 'icon' => 'clone', 'url' => ['/sites/article/index']],
                            ['label' => 'Слайдеры', 'icon' => 'magic', 'url' => ['/sites/slider/index']],
                            ['label' => 'Предложения', 'icon' => 'edit', 'url' => ['/sites/comment/index']],
                            ['label' => 'Акции (скидки)', 'icon' => 'line-chart', 'url' => ['/sites/stock/index']],
                            ['label' => 'Бонусы', 'icon' => 'calendar-plus-o', 'url' => ['/sites/bonus/index']],
                        ],

                    ],

                    /*['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/
                ],
            ]
        ) ?>

    </section>

</aside>
