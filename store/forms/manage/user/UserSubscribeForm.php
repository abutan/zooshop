<?php

namespace store\forms\manage\user;


use store\entities\user\User;
use yii\base\Model;

class UserSubscribeForm extends Model
{
    public $subscribe;

    public function rules(): array
    {
        return [
            ['subscribe', 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'subscribe' => 'Подписаться на новостную рассылку сайта',
        ];
    }
}