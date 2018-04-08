<?php

namespace store\forms\manage\user;


use yii\base\Model;

class UserUnSubscribeForm extends Model
{
    public $unSubscribe;

    public function rules(): array
    {
        return [
            ['unSubscribe', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'unSubscribe' => 'Отписаться от новостной рассылки сайта',
        ];
    }
}