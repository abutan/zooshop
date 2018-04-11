<?php

namespace store\useCases\shop;


use store\cart\Cart;
use store\cart\CartItem;
use store\entities\shop\order\Order;
use store\entities\shop\order\OrderItem;
use store\forms\shop\order\OrderForm;
use store\repositories\manage\shop\DeliveryRepository;
use store\repositories\manage\shop\ProductRepository;
use store\repositories\shop\OrderRepository;
use store\repositories\UserRepository;
use store\services\TransactionsManager;
use yii\mail\MailerInterface;

class OrderService
{
    private $cart;
    private $orders;
    private $products;
    private $users;
    private $deliveryMethods;
    private $transactions;
    private $mailer;
    private $adminEmail;

    public function __construct(
        $adminEmail,
        Cart $cart,
        OrderRepository $orders,
        ProductRepository $products,
        UserRepository $users,
        DeliveryRepository $deliveryMethods,
        TransactionsManager $transactions,
        MailerInterface $mailer
    )
    {
        $this->adminEmail = $adminEmail;
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
        $this->transactions = $transactions;
        $this->mailer = $mailer;
    }

    public function checkout($userId, OrderForm $form): Order
    {
        $user = $this->users->get($userId);

        $products = [];

        $items = array_map(function (CartItem $item){
            $product = $item->getProduct();
            $product->checkout($item->getModificationId(), $item->getQuantity());
            $products[] = $product;
            return OrderItem::create(
                $product,
                $item->getModificationId(),
                $item->getPrice(),
                $item->getQuantity()
            );
        }, $this->cart->getItems());

        $order = Order::create(
            $user->id,
            $form->customerName,
            $form->customerPhone,
            $items,
            $this->cart->getCost()->getTotal(),
            $form->payment,
            $form->note
        );

        $order->setDeliveryInfo(
           $this->deliveryMethods->get($form->delivery->method),
            $form->delivery->address,
            $form->delivery->index
        );

        $this->transactions->wrap(function () use ($order, $products){
           $this->orders->save($order);
           foreach ($products as $product){
               $this->products->save($product);
           }
           $this->cart->clear();
        });

        $userName = $user->username ?: 'Пользователь '. $user->id;
        $subject = 'Пользователь '. $userName . ' сделал заказ на сайте.';
        $sent = $this->mailer->compose(
              ['html' => 'order/orderCreate-html', 'txt' => 'order/orderCreate-txt'],
              ['userName' => $userName, 'order' => $order]
          )
              ->setSubject($subject)
              ->setTo($this->adminEmail)
              ->send();
        if (!$sent){
            throw new \RuntimeException('Ошибка отправки. Попробуйте повторить позже.');
        }

        return $order;
    }



    public function pay($id): void
    {
        $order = $this->orders->get($id);
        $order->paid();
        $this->orders->save($order);

        $subject = 'Внимание заказ ' . $order->id .' оплачен';
        $sent =  $this->mailer->compose(
                    ['html' => 'order/orderPay-html', 'txt' => 'orderPay-txt'],
                    ['order' => $order]
                )
                    ->setSubject($subject)
                    ->setTo($this->adminEmail)
                    ->send();
        if (!$sent){
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    public function fail($id): void
    {
        $order = $this->orders->get($id);
        $order->fail();
        $this->orders->save($order);
    }
}