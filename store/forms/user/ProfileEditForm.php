<?php

namespace store\forms\user;


use store\entities\user\User;
use yii\base\Model;

class ProfileEditForm extends Model
{
    public $phone;
    public $email;

    private $_user;

    public function __construct(User $user, array $config = [])
    {
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['phone', 'email'], 'required'],
            [['phone', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['phone', 'email'], 'unique', 'targetClass' => User::class, 'message' => 'Такое значение уже занято.', 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'phone' => 'Телефон',
        ];
    }
}