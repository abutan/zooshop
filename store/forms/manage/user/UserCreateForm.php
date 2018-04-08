<?php

namespace store\forms\manage\user;


use store\entities\user\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $role;
    public $subscribe;

    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'password', 'role'], 'required'],
            [['username', 'email', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            [['username', 'email', 'phone'], 'unique', 'targetClass' => User::class],
            ['subscribe', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'phone' => 'Контактный телефон',
            'password' => 'Пароль',
            'role' => 'Роль',
            'subscribe' => 'Подписать на новостную рассылку сайта',
        ];
    }

    public function roleList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}