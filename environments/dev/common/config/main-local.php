<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=zoo',
            'username' => 'root',
            'password' => '19abutan66',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => FALSE,
            'transport' =>[
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.timeweb.ru',
                'username' => 'info@abutan.tmweb.ru',
                'password' => '19abutan66',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig' => [
                'from' => ['info@abutan.tmweb.ru' => 'Дежурная ветаптека'],
            ],
        ],
    ],
];
