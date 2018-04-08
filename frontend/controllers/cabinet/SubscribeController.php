<?php

namespace frontend\controllers\cabinet;


use store\forms\manage\user\UserSubscribeForm;
use store\forms\manage\user\UserUnSubscribeForm;
use store\repositories\UserRepository;
use Yii;
use store\useCases\manage\user\UserManageService;
use yii\base\Module;
use yii\web\Controller;

class SubscribeController extends Controller
{
    public $layout = 'cabinet';

    private $service;
    private $users;

    public function __construct(
        string $id,
        Module $module,
        UserManageService $service,
        UserRepository $users,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->users = $users;
    }

    public function actionSubscribe()
    {
        $user = $this->users->get(Yii::$app->user->id);
        $form = new UserSubscribeForm();

        if (!$user->email){
            Yii::$app->session->setFlash('warning', 'Пожалуйста  отредактируйте свой профиль и добавьте адрес своей электронной почты.');
            return $this->redirect(['/cabinet/profile/edit', 'id' => $user->id]);
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->subscribe($user->id);
                Yii::$app->session->setFlash('success', 'Вы подписаны на новостную рассылку сайта.');
                return $this->redirect(['/cabinet/default/index']);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('subscribe', [
            'model' => $form,
        ]);
    }

    public function actionUnSubscribe()
    {
        $user = $this->users->get(Yii::$app->user->id);
        $form = new UserUnSubscribeForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->unSubscribe($user->id);
                Yii::$app->session->setFlash('success', 'Вы отписаны от новостной рассылки сайта.');
                return $this->redirect(['/cabinet/default/index']);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('un-subscribe', [
            'model' => $form,
        ]);
    }
}

