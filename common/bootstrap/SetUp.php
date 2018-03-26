<?php

namespace common\bootstrap;


use store\services\manage\shop\ProductManageService;
use store\services\manage\site\CallManageService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class, function () use ($app){
            return $app->mailer;
        });

        $container->setSingleton(CallManageService::class, [], [
            $app->params['adminEmail'],
        ]);

        $container->setSingleton(ProductManageService::class, [], [
            $app->params['adminEmail'],
        ]);
    }
}