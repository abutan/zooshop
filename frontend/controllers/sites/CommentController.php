<?php

namespace frontend\controllers\sites;


use Yii;
use store\forms\site\CommentForm;
use store\services\site\CommentService;
use yii\base\Module;
use yii\web\Controller;

class CommentController extends Controller
{
    public $layout = 'content';

    private $service;

    public function __construct(
        string $id,
        Module $module,
        CommentService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new CommentForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $comment = $this->service->create(Yii::$app->user->id, $form);
                return $this->redirect(['index', '#' => 'comment' . $comment->id]);
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