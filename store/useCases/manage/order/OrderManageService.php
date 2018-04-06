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
            $subject = 'Статус Вашего заказа '. $order->id .' изменился.';
            $body = '<p>Ваш заказ '. $order->id .' укомплектован. <br>';
            $body .= 'Подробности и историю Ваших заказов можно посмотреть на сайте в Вашем личном кабинете в разделе "ИСТОРИЯ ЗАКАЗОВ"<br>';
            $body .= 'Команда сайта &laquo;' . \Yii::$app->name . '&raquo;</p>';
            $sent = $this->mailer->compose()
                        ->setTo($order->user->email)
                        ->setSubject($subject)
                        ->setHtmlBody($body)
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
            $subject = 'Статус Вашего заказа '. $order->id .' изменился.';
            $body = '<p>Ваш заказ '. $order->id .' отправлен. <br>';
            $body .= 'Подробности и историю Ваших заказов можно посмотреть на сайте в Вашем личном кабинете в разделе "ИСТОРИЯ ЗАКАЗОВ"<br>';
            $body .= 'Команда сайта &laquo;' . \Yii::$app->name . '&raquo;</p>';
            $sent = $this->mailer->compose()
                ->setTo($order->user->email)
                ->setSubject($subject)
                ->setHtmlBody($body)
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