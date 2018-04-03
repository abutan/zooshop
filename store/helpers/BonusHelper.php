<?php

namespace store\helpers;


use store\entities\site\Bonus;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class BonusHelper
{
    public static function statusList(): array
    {
        return [
            Bonus::STATUS_DRAFT => 'Отключено',
            Bonus::STATUS_ACTIVE => 'Опубликовано',
        ];
    }

    public static function StatusLabel($status)
    {
        switch ($status){
            case Bonus::STATUS_DRAFT :
                $class = 'label label-danger'; break;
            case Bonus::STATUS_ACTIVE :
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}