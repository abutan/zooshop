<?php

namespace store\helpers;


use store\entities\shop\order\Order;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class OrderHelper
{
    public static function statusList(): array
    {
        return [
            Order::NEW => 'Новый заказ',
            Order::COMPLETED => 'Заказ укомплектован',
            Order::PAID => 'Заказ оплачен',
            Order::SENT => 'Заказ отправлен',
            Order::CANCELLED => 'Заказ аннулирован',
            Order::FAIL => 'Оплата не прошла',
        ];
    }

    public static function statusLabel($status): string
    {
        switch ($status){
            case Order::NEW :
                $class = 'label label-primary'; break;
            case Order::COMPLETED :
                $class = 'label label-warning'; break;
            case Order::PAID :
                $class = 'label label-info'; break;
            case Order::SENT :
                $class = 'label label-success'; break;
            case Order::CANCELLED :
                $class = 'label label-danger'; break;
            case Order::FAIL :
                $class = 'label label-default'; break;
            default:
                $class = 'label label-default'; break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}