<?php

namespace frontend\controllers\auth;

use store\forms\auth\LoginForm;
use Yii;
use store\useCases\auth\AuthService;
use yii\web\Controller;
use yii\base\Module;

class AuthController extends Controller
{

    private $service;

    public function __construct(
        string $id,
        Module $module,
        AuthService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionEntry()
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $user = $this->service->auth($form);
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                return $this->goBack();
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('entry', [
            'model' => $form,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}