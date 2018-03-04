<?php

namespace frontend\controllers\auth;

use Yii;
use store\forms\auth\SignupForm;
use store\services\auth\SignupService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\base\Module;

class SignupController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        SignupService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ]
            ],
        ];
    }

    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->signup($form);
                Yii::$app->session->setFlash('info', 'Проверьте свою почту. На указанный Email Вам отправлено письмо с дальнейшими инструкциями.');
                return $this->goHome();
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('request', [
            'model' => $form,
        ]);
    }

    public function actionConfirm($token)
    {
        try{
            $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Вы успешно зарегистрированы в системе. Можете войти на сайт.');
            return $this->redirect(['/auth/auth/login']);
        }catch (\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }
}