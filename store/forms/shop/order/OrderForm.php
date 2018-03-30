<?php

namespace store\forms\shop\order;


use elisdn\compositeForm\CompositeForm;
use store\entities\shop\order\PaymentMethod;
use yii\helpers\ArrayHelper;

/**
 * @property DeliveryForm $delivery
 */
class OrderForm extends CompositeForm
{
    public $customerName;
    public $customerPhone;
    public $payment;
    public $note;

    public function __construct($price, int $weight, array $config = [])
    {
        $this->delivery = new DeliveryForm($price, $weight);
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['customerName', 'customerPhone', 'payment'], 'required'],
            [['customerName', 'customerPhone'], 'string', 'max' => 255],
            ['payment', 'integer'],
            ['note', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'note' => 'Комментарии к заказу (этаж, домофон, ориентиры и т.п.)',
            'payment' => 'Способ оплаты',
            'paymentMethod' => 'Способ оплаты',
            'customerName' => 'ФИО',
            'customerPhone' => 'Телефон',
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