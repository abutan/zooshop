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
                    ['label' => 'Заказы звонка', 'icon' => 'phone-volume', 'url' => ['/sites/call/index']],
                    ['label' => 'Магазин', 'icon' => 'shopping-bag', 'url' => ['#'], 'items' => [
                        ['label' => 'Бренды', 'icon' => 'copyright', 'url' => ['/shop/brand/index']],
                        ['label' => 'Производители', 'icon' => 'industry', 'url' => ['/shop/maker/index']],
                        ['label' => 'Теги (метки)', 'icon' => 'code', 'url' => ['/shop/tag/index']],
                        ['label' => 'Категории', 'icon' => 'server', 'url' => ['/shop/category/index']],
                        ['label' => 'Атрибуты', 'icon' => 'cog', 'url' => ['/shop/characteristic/index']],
                        ],
                    ],
                    ['label' => 'Сайт', 'icon' => 'paste', 'url' => ['#'], 'items' => [
                            ['label' => 'Статьи', 'icon' => 'clone', 'url' => ['/sites/article/index']],
                            ['label' => 'Слайдеры', 'icon' => 'magic', 'url' => ['/sites/slider/index']],
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
