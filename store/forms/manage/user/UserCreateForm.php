<?php

namespace store\forms\manage\user;


use store\entities\user\User;
use yii\base\Model;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'password'], 'required'],
            [['username', 'email', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            [['username', 'email', 'phone'], 'unique', 'targetClass' => User::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'phone' => 'Контактный телефон',
            'password' => 'Пароль',
        ];
    }
}