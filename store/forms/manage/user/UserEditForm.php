<?php

namespace store\forms\manage\user;


use store\entities\user\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;

    private $_user;

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->_user = $user;
    }

    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'password'], 'required'],
            [['username', 'email', 'phone'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['email', 'email'],
            [['username', 'email', 'phone'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
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