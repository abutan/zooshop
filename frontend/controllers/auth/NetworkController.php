<?php

namespace frontend\controllers\auth;

use Yii;
use store\useCases\auth\NetworkService;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\web\Controller;
use yii\base\Module;
use yii\helpers\ArrayHelper;

class NetworkController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        NetworkService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client): void
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');
        try{
            $user = $this->service->auth($identity, $network);
            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}