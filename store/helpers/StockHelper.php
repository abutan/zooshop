<?php

namespace store\helpers;


use store\entities\site\Stock;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class StockHelper
{
    public static function statusList(): array
    {
        return [
            Stock::STATUS_DRAFT => 'Отключено',
            Stock::STATUS_ACTIVE => 'Опубликовано',
        ];
    }

    public static function StatusLabel($status)
    {
        switch ($status){
            case Stock::STATUS_DRAFT :
                $class = 'label label-danger'; break;
            case Stock::STATUS_ACTIVE :
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}