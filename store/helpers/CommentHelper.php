<?php

namespace store\helpers;


use store\entities\site\Comment;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class CommentHelper
{
    public static function statusList(): array
    {
        return [
            Comment::STATUS_DRAFT => 'Отключен',
            Comment::STATUS_ACTIVE => 'Опубликован',
        ];
    }

    public static function StatusLabel($status)
    {
        switch ($status){
            case Comment::STATUS_DRAFT :
                $class = 'label label-danger'; break;
            case Comment::STATUS_ACTIVE :
                $class = 'label label-success'; break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }
}