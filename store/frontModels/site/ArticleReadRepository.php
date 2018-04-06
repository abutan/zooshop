<?php

namespace store\frontModels\site;


use store\entities\site\Article;

class ArticleReadRepository
{
    public function findBySlug($slug): ?Article
    {
        return Article::find()->andWhere(['slug' => $slug])->andWhere(['status' => 1])->one();
    }

    public function getAll(): array
    {
        return Article::find()->andWhere(['status' => 1])->all();
    }
}