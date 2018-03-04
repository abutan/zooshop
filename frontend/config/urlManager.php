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
    ],
];