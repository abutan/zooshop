<?php

namespace frontend\controllers\auth;

use store\forms\auth\ResetPasswordForm;
use Yii;
use store\forms\auth\PasswordResetRequestForm;
use store\useCases\auth\PasswordResetService;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\base\Module;

class ResetController extends Controller
{
    public $layout = 'blank';

    private $service;

    public function __construct(
        string $id,
        Module $module,
        PasswordResetService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->request($form);
                Yii::$app->session->setFlash('info', 'Проверьте свою почту. На указанный Email отправлено письмо с дальнейшими инструкциями');
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

    public function actionReset($token)
    {
        try{
            $this->service->validateToken($token);
        }catch (\DomainException $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'Новый пароль успешно сохранен.');
                return $this->goHome();
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->goHome();
            }
        }
        return $this->render('reset', [
            'model' => $form,
        ]);
    }
}