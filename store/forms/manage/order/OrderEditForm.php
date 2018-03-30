<?php

namespace store\forms\manage\order;


use elisdn\compositeForm\CompositeForm;
use store\entities\shop\order\Order;
use store\entities\shop\order\PaymentMethod;
use yii\helpers\ArrayHelper;

/**
 * @property DeliveryForm $delivery
 */
class OrderEditForm extends CompositeForm
{
    public $customerName;
    public $customerPhone;
    public $payment;
    public $note;
    public $cancelReason;

    public function __construct(Order $order, array $config = [])
    {
        $this->customerName = $order->customer_name;
        $this->customerPhone = $order->customer_phone;
        $this->payment = $order->payment_method;
        $this->note = $order->note;
        $this->cancelReason = $order->cancel_reason;
        $this->delivery = new DeliveryForm($order);
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['customerName', 'customerPhone', 'payment'], 'required'],
            [['customerName', 'customerPhone'], 'string', 'max' => 255],
            ['payment', 'integer'],
            ['note', 'string'],
            ['cancelReason', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'customerName' => 'ФИО',
            'customerPhone' => 'Контактный телефон',
            'payment' => 'Метод оплаты',
            'note' => 'Комментарий к заказу',
            'cancelReason' => 'Причина аннуляции заказа',
        ];
    }

    public function paymentList()
    {
        return ArrayHelper::map(PaymentMethod::find()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return [
            'delivery',
        ];
    }
}