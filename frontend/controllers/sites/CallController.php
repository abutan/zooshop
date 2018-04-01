<?php

namespace frontend\controllers\sites;


use store\forms\manage\site\CallForm;
use store\services\manage\site\CallManageService;
use yii\base\Module;
use yii\web\Controller;

class CallController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        CallManageService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionNode()
    {
        $form = new CallForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            $this->service->create($form);
            \Yii::$app->session->setFlash('success', 'Спасибо! Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время.');
            return $this->redirect(\Yii::$app->request->referrer);
        }
        return $this->renderAjax('node', [
            'model' => $form,
        ]);
    }
}