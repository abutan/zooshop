<?php

namespace store\helpers;


use store\entities\site\Slider;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class SliderHelper
{
    public static function statusList(): array
    {
        return [
            Slider::STATUS_DRAFT => 'Отключен',
            Slider::STATUS_ACTIVE => 'Опубликован',
        ];
    }

    public function statusLabel($status): string
    {
        switch ($status){
            case Slider::STATUS_DRAFT :
                $class = 'label label-danger'; break;
            case Slider::STATUS_ACTIVE:
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}