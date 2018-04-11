<?php

namespace frontend\controllers;

use Yii;
use store\forms\ContactForm;
use store\useCases\ContactService;
use yii\base\Module;
use yii\web\Controller;

class ContactController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        ContactService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->sendMail($form);
                Yii::$app->session->setFlash('success', 'Спасибо! Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время.');
                return $this->refresh();
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
        ]);
    }
}