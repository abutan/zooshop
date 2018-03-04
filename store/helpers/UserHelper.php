<?php

namespace store\helpers;


use store\entities\user\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    public static function statusList(): array
    {
        return [
            User::STATUS_WAIT => 'В ожидании',
            User::STATUS_ACTIVE => 'Активный',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status){
            case User::STATUS_WAIT :
                $class = 'label label-danger'; break;
            case User::STATUS_ACTIVE :
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}