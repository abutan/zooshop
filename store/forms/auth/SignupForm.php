<?php
namespace store\forms\auth;

use yii\base\Model;
use store\entities\user\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $subscribe;
    public $accept = true;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['phone', 'required'],
            ['phone', 'string', 'max' => 255],

            ['accept', 'boolean'],
            ['accept', 'compare', 'compareValue' => true, 'message' => 'Необходимо Ваше согласие на обработку персональных данных.'],

            ['subscribe', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'accept' => 'Согласен на обработку моих данных',
            'subscribe' => 'Подписать на новостную рассылку сайта',
        ];
    }
}
