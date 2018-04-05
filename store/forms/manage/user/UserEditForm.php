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

    private $_user;

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
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
            'role' => 'Роль',
        ];
    }

    public function roleList(): array
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}