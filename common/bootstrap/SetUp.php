<?php

namespace common\bootstrap;


use frontend\urls\CategoryUrlRules;
use frontend\urls\ProductUrlRules;
use store\cart\Cart;
use store\cart\cost\calculator\DynamicCost;
use store\cart\cost\calculator\SimpleCost;
use store\cart\storage\HybridStorage;
use store\frontModels\shop\CategoryReadRepository;
use store\frontModels\shop\ProductReadRepository;
use store\services\manage\shop\ProductManageService;
use store\services\manage\site\CallManageService;
use store\services\site\CommentService;
use yii\base\BootstrapInterface;
use yii\di\Instance;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;

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

        $container->setSingleton(CommentService::class, [], [
            $app->params['adminEmail'],
        ]);

        $container->setSingleton(Cart::class, function () use ($app){
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                new DynamicCost(new SimpleCost())
            );
        });

        $container->setSingleton('cache', function () use ($app){
           return $app->cache;
        });

        $container->set(CategoryUrlRules::class, [], [
            Instance::of(CategoryReadRepository::class),
            Instance::of('cache'),
        ]);

        $container->set(ProductUrlRules::class, [], [
            Instance::of(ProductReadRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(ManagerInterface::class, function () use ($app){
            return $app->authManager;
        });
    }
}