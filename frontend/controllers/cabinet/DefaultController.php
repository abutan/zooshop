<?php

namespace frontend\controllers\cabinet;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'cabinet';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $userName = Yii::$app->user->identity['username'];
        $email = Yii::$app->user->identity['email'];
        $userId = Yii::$app->user->id;
        $phone = Yii::$app->user->identity['phone'];
        $created = Yii::$app->user->identity['created_at'];

        return $this->render('index', [
            'userName' => $userName,
            'email' => $email,
            'userId' => $userId,
            'phone' => $phone,
            'created' => $created,
        ]);
    }
}