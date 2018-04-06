<?php
namespace backend\controllers;

use store\forms\auth\LoginForm;
use store\useCases\auth\AuthService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest){
            return $this->goBack();
        }

        $this->layout = 'main-login';

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
        return $this->render('login', [
            'model' => $form
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
