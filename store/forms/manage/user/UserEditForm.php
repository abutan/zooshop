<?php

namespace store\forms\manage\user;


use Yii;
use store\entities\user\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $role;
    public $subscribe;

    private $_user;

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->subscribe = $user->subscribe;
        $roles = Yii::$app->authManager->getRolesByUser($user->id);
        $this->role = $roles ? reset($roles)-> name : null;
        $this->_user = $user;
    }

    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'password', 'role'], 'required'],
            [['username', 'email', 'phone'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['email', 'email'],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['phone', 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'phone', $this->_user->phone]],
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
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}