<?php
return [
    'class' => '\yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        'login' => 'auth/auth/login',
        'logout' => 'auth/auth/logout',
        'signup' => 'auth/signup/request',
        'password' => 'auth/reset/request-password-reset',
        'reset' => 'auth/reset/reset-password',

        ['pattern' => 'yandex-market', 'route' => 'market/index', 'suffix' => '.xml'],

        'cart' => 'shop/cart/index',

        ['class' => 'frontend\urls\CategoryUrlRules'],
        ['class' => 'frontend\urls\ProductUrlRules'],
    ],
];