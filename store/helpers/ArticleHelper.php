<?php

namespace store\helpers;


use store\entities\site\Article;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class ArticleHelper
{
    public static function statusList(): array
    {
        return [
            Article::STATUS_DRAFT => 'Отключено',
            Article::STATUS_ACTIVE => 'Опубликовано',
        ];
    }

    public static function statusLabel($status): string
    {
        switch ($status){
            case Article::STATUS_DRAFT :
                $class = 'label label-danger'; break;
            case Article::STATUS_ACTIVE :
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}