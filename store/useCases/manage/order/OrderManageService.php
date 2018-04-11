<?php

namespace store\useCases\manage\order;


use store\forms\manage\order\OrderEditForm;
use store\repositories\manage\shop\DeliveryRepository;
use store\repositories\shop\OrderRepository;
use yii\mail\MailerInterface;

class OrderManageService
{
    private $orders;
    private $deliveryMethods;
    private $mailer;

    public function __construct(MailerInterface $mailer,  OrderRepository $orders, DeliveryRepository $deliveryMethods)
    {
        $this->orders = $orders;
        $this->deliveryMethods = $deliveryMethods;
        $this->mailer = $mailer;
    }

    public function edit($id, OrderEditForm $form): void
    {
        $order = $this->orders->get($id);
        $order->edit(
            $form->customerName,
            $form->customerPhone,
            $form->note,
            $form->payment,
            $form->cancelReason
        );
        $order->setDeliveryInfo(
            $this->deliveryMethods->get($form->delivery->method),
            $form->delivery->address,
            $form->delivery->index
        );

        $this->orders->save($order);
    }

    public function complete($id): void
    {
        $order = $this->orders->get($id);
        $order->complete();
        $this->orders->save($order);
        if ($order->user->email !== null){
            $userName = $order->user->username ?: 'Пользователь '. $order->user->id;
            $subject = 'Статус Вашего заказа '. $order->id .' изменился.';
            $sent = $this->mailer->compose(
                ['html' => 'order/orderComplete-html', 'txt' => 'orderComplete-txt.php'],
                ['order' => $order, 'userName' => $userName]
            )
                        ->setTo($order->user->email)
                        ->setSubject($subject)
                        ->send();
            if (!$sent){
                throw new \DomainException('Ошибка отправки. Попробуйте повторить позже.');
            }
        }
    }

    public function sent($id): void
    {
        $order = $this->orders->get($id);
        $order->sent();
        $this->orders->save($order);
        if ($order->user->email){
            $subject = 'Статус Вашего ЗАКАЗА №'. $order->id .' изменился.';
            $userName = $order->user->username ?: 'Пользователь '. $order->user->id;
            $sent = $this->mailer->compose(
                ['html' => 'order/orderSent-html', 'txt' => 'order/orderSent-txt'],
                ['order' => $order, 'userName' => $userName]
            )
                ->setTo($order->user->email)
                ->setSubject($subject)
                ->send();
            if (!$sent){
                throw new \DomainException('Ошибка отправки. Попробуйте повторить позже.');
            }
        }
    }

    public function pay($id): void
    {
        $order = $this->orders->get($id);
        $order->paid();
        $this->orders->save($order);
    }

    public function cancel($id): void
    {
        $order = $this->orders->get($id);
        $order->cancel();
        $this->orders->save($order);
    }

    public function remove($id): void
    {
        $order = $this->orders->get($id);
        $this->orders->remove($order);
    }
}