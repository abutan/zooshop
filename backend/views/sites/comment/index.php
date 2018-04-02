<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\site\Comment;
use store\helpers\CommentHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предложения (вопросы, комментарии и т.п.)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'id',
                        'value' => function(Comment $comment)
                        {
                            return Html::a(Html::encode($comment->id), ['view', 'id' => $comment->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => function(Comment $comment)
                        {
                            return $comment->user->username ?: 'Пользователь ' . $comment->user->id;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => CommentHelper::statusList(),
                        'value' => function(Comment $comment)
                        {
                            return CommentHelper::StatusLabel($comment->status);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
