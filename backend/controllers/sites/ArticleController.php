<?php

namespace backend\controllers\sites;

use store\forms\manage\site\ArticleManageForm;
use store\useCases\manage\site\ArticleManageService;
use Yii;
use store\entities\site\Article;
use backend\forms\ArticleSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    private $service;

    public function __construct(
        string $id,
        Module $module,
        ArticleManageService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'draft' => ['POST'],
                    'activate' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'article' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ArticleManageForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $article = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Новая статья создана.');
                return $this->redirect(['view', 'id' => $article->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $article = $this->findModel($id);
        $form = new ArticleManageForm($article);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($article->id, $form);
                Yii::$app->session->setFlash('success', 'Статья отредактирована.');
                return $this->redirect(['view', 'id' => $article->id]);
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'article' => $article,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDraft($id)
    {
        $this->service->draft($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionActivate($id)
    {
        $this->service->activate($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
