<?php

namespace store\services\shop;


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

class OrderService
{
    private $cart;
    private $orders;
    private $products;
    private $users;
    private $deliveryMethods;
    private $transactions;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        ProductRepository $products,
        UserRepository $users,
        DeliveryRepository $deliveryMethods,
        TransactionsManager $transactions
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
        $this->transactions = $transactions;
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

        return $order;
    }



    public function pay($id): void
    {
        $order = $this->orders->get($id);
        $order->paid();
        $this->orders->save($order);
    }

    public function fail($id): void
    {
        $order = $this->orders->get($id);
        $order->fail();
        $this->orders->save($order);
    }
}