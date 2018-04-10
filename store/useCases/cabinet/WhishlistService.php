<?php

namespace store\useCases\cabinet;


use store\repositories\manage\shop\ProductRepository;
use store\repositories\UserRepository;
use yii\mail\MailerInterface;

class WhishlistService
{
    private $users;
    private $products;
    private $mailer;
    private $adminEmail;

    public function __construct($adminEmail, UserRepository $users, ProductRepository $products, MailerInterface $mailer)
    {
        $this->users = $users;
        $this->products = $products;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function add($userId, $productId): void
    {
        $user = $this->users->get($userId);
        $product = $this->products->get($productId);
        $user->addToWhishlist($product->id);
        $this->users->save($user);

        $subject = 'Пользователь ' . $user->username . ' добавил товар в избранное';
        $sent = $this->mailer->compose(
              ['html' => 'cabinet/whishlist/whishlistAdd-html', 'text' => 'cabinet/whishlist/whishlistAdd-text'],
              ['user' => $user, 'product' => $product]
            )
              ->setTo($this->adminEmail)
              ->setSubject($subject)
              ->send();
        if (!$sent){
            throw new \RuntimeException('Ошибка отправки. Попробуйте повторить позже.');
        }
    }

    public function remove($userId, $productId): void
    {
        $user = $this->users->get($userId);
        $product = $this->products->get($productId);
        $user->removeFromWhishlist($product->id);
        $this->users->save($user);
    }
}