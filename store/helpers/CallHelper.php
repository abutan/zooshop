<?php

namespace store\helpers;


use store\entities\site\Call;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CallHelper
{
    public static function statusList()
    {
        return [
            Call::STATUS_DRAFT => 'Не прочитано',
            Call::STATUS_ACTIVE => 'Прочитано',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status){
            case Call::STATUS_DRAFT :
                $class = 'label label-danger'; break;
            case Call::STATUS_ACTIVE :
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}