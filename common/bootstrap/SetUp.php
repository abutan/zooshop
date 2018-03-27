<?php

namespace common\bootstrap;


use store\cart\Cart;
use store\cart\cost\calculator\DynamicCost;
use store\cart\cost\calculator\SimpleCost;
use store\cart\storage\HybridStorage;
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

        $container->setSingleton(Cart::class, function () use ($app){
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                new DynamicCost(new SimpleCost())
            );
        });
    }
}