<?php
return [
    'class' => '\yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [
        '' => 'site/index',
        'login' => 'auth/auth/entry',
        'logout' => 'auth/auth/logout',
        'signup' => 'auth/signup/request',
        'password' => 'auth/reset/request-password-reset',
        'reset' => 'auth/reset/reset-password',

        'akcii-i-skidki' => 'sites/stock/index',

        'bonusi' => 'sites/bonus/index',

        'obyavlenia' => 'sites/notification/index',

        'hits' => 'shop/catalog/hit',
        'novinki' => 'shop/catalog/featured',
        'predlogeniya' => 'sites/comment/index',

        ['pattern' => 'yandex-market', 'route' => 'market/index', 'suffix' => '.xml'],

        ['pattern' => 'sitemap', 'route' => 'sitemap/index', 'suffix' => '.xml'],
        ['pattern' => 'sitemap-<target:[a-z-]+>-<start:\d+>', 'route' => 'sitemap/<target>', 'suffix' => '.xml'],
        ['pattern' => 'sitemap-<target:[a-z-]+>', 'route' => 'sitemap/<target>', 'suffix' => '.xml'],

        'cart' => 'shop/cart/index',

        'catalog' => 'shop/catalog/index',
        ['class' => 'frontend\urls\CategoryUrlRules'],
        ['class' => 'frontend\urls\ProductUrlRules'],

        'cabinet' => 'cabinet/default/index',
        'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
        'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
        'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
        'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',

        '<slug:[\w\-]+>' => 'sites/article/node',
        'akcii-i-skidki/<slug:[\w\-]+>' => 'sites/stock/node',
        'bonusi/<slug:[\w\-]+>' => 'sites/bonus/node',
    ],
];