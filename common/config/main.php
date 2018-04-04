<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'robokassa' => [
            'class' => '\robokassa\Merchant',
            'baseUrl' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
            'isTest' => !YII_ENV_PROD,
        ],
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'backendUrlManager' => require  __DIR__ . '/../../backend/config/urlManager.php',
    ],
];
