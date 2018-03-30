<?php

namespace store\entities\shop\order;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use store\entities\shop\DeliveryMethod;
use store\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property int $delivery_method_id [int(11)]
 * @property string $delivery_method_name [varchar(255)]
 * @property int $delivery_cost [int(11)]
 * @property string $payment_method [varchar(255)]
 * @property int $cost [int(11)]
 * @property string $note
 * @property string $cancel_reason
 * @property int $status [int(11)]
 * @property string $customer_phone [varchar(255)]
 * @property string $customer_name [varchar(255)]
 * @property string $delivery_address
 * @property string $delivery_index [varchar(255)]
 * @property int $created_at [int(11)]
 *
 * @property OrderItem[] $items
 * @property User $user
 */
class Order extends ActiveRecord
{
    const NEW = 1;
    const COMPLETED = 2;
    const PAID = 3;
    const SENT = 4;
    const CANCELLED = 5;
    const FAIL = 6;

    public static function create($userId, $customerName, $customerPhone, array $items, $cost, $payment, $note): self
    {
        $order = new static();
        $order->user_id = $userId;
        $order->customer_name = $customerName;
        $order->customer_phone = $customerPhone;
        $order->items = $items;
        $order->cost = $cost;
        $order->payment_method = $payment;
        $order->note = $note;
        $order->status = self::NEW;
        $order->created_at = time();

        return $order;
    }

    public function edit($customerName, $customerPhone, $note, $payment, $cancelReason): void
    {
        $this->customer_name = $customerName;
        $this->customer_phone = $customerPhone;
        $this->note = $note;
        $this->payment_method = $payment;
        $this->cancel_reason = $cancelReason;
    }

    public function setDeliveryInfo(DeliveryMethod $method, $deliveryAddress, $deliveryIndex): void
    {
        $this->delivery_method_id = $method->id;
        $this->delivery_method_name = $method->name;
        $this->delivery_cost = $method->cost;
        $this->delivery_address = $deliveryAddress;
        $this->delivery_index = $deliveryIndex;
    }

    ##############

    public function isNew(): bool
    {
        return $this->status == self::NEW;
    }

    public function isCompleted(): bool
    {
        return $this->status == self::COMPLETED;
    }

    public function isPaid(): bool
    {
        return $this->status == self::PAID;
    }

    public function isSent(): bool
    {
        return $this->status == self::SENT;
    }

    public function isCancelled(): bool
    {
        return $this->status == self::CANCELLED;
    }

    public function isFail(): bool
    {
        return $this->status == self::FAIL;
    }

    public function complete(): void
    {
        if ($this->isCompleted() || $this->isSent() || $this->isCancelled()){
            throw new \DomainException('Такая операция не допустима.');
        }
        $this->status = self::COMPLETED;
    }

    public function paid(): void
    {
        if ($this->isPaid() || $this->isCancelled()){
            throw new \DomainException('Такая операция не допустима.');
        }
        $this->status = self::PAID;
    }

    public function sent(): void
    {
        if ($this->isSent() || $this->isCancelled()){
            throw new \DomainException('Такая операция не допустима.');
        }
        $this->status = self::SENT;
    }

    public function cancel(): void
    {
        if ($this->isCancelled()){
            throw new \DomainException('Заказ уже аннулирован.');
        }
        $this->status = self::CANCELLED;
    }

    public function fail(): void
    {
        $this->status = self::FAIL;
    }

    ##############

    public function getTotalCost(): int
    {
        return $this->cost + $this->delivery_cost;
    }

    public function canBePaid(): bool
    {
        return !$this->isCancelled();
    }

    ##############

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getDeliveryMethod(): ActiveQuery
    {
        return $this->hasOne(DeliveryMethod::class, ['id' => 'delivery_method_id']);
    }

    public function getPayment(): ActiveQuery
    {
        return $this->hasOne(PaymentMethod::class, ['id' => 'payment_method']);
    }

    public function getItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    ##############

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['items'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    ##############

    public static function tableName()
    {
        return '{{%shop_orders}}';
    }

    public function attributeLabels(): array
    {
        return [
            'created_at' => 'Дата создания заказа',
            'user_id' => 'Пользователь',
            'delivery_method_id' => 'ID метода доставки',
            'delivery_method_name' => 'Название метода доставки',
            'delivery_cost' => 'Цена доставки',
            'payment_method' => 'Способ оплаты',
            'cost' => 'Сумма заказа',
            'note' => 'Комментарии к заказу',
            'current_status' => 'Текущий статус заказа',
            'cancel_reason' => 'Причина аннуляции заказа',
            'customer_phone' => 'Телефон заказчика',
            'customer_name' => 'ФИО заказчика',
            'delivery_index' => 'Доставка - индекс',
            'delivery_address' => 'Доставка - адрес',
            'deliveryData.index' => 'Почтовый индекс',
            'deliveryData.address' => 'Адрес доставки',
            'paymentMethod' => 'Способ оплаты',
            'id' => 'Номер заказа',
            'status' => 'Состояние заказа',
        ];
    }
}