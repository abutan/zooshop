<?php

namespace frontend\controllers\cabinet;

use store\forms\user\ProfileEditForm;
use Yii;
use store\entities\user\User;
use store\services\cabinet\ProfileService;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public $layout = 'blank';

    private $service;

    public function __construct(
        string $id,
        Module $module,
        ProfileService $service,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionEdit()
    {
        $user = $this->findModel(Yii::$app->user->id);
        $form = new ProfileEditForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->edit($user->id, $form);
                return $this->redirect(['/cabinet/default/index', 'id' => $user->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('edit', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundHttpException
     */
    protected function findModel($id): User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
    }
}