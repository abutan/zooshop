<?php

namespace store\repositories\manage\site;


use store\entities\site\Article;
use yii\web\NotFoundHttpException;

class ArticleRepository
{
    public function get($id): Article
    {
        if (!$article = Article::findOne($id)){
            throw new NotFoundHttpException('Статья не найдена.');
        }
        return $article;
    }

    public function save(Article $article): void
    {
        if (!$article->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Article $article): void
    {
        if (!$article->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}