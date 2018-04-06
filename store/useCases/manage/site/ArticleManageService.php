<?php

namespace store\useCases\manage\site;


use store\entities\site\Article;
use store\forms\manage\site\ArticleManageForm;
use store\repositories\manage\site\ArticleRepository;
use yii\helpers\Inflector;

class ArticleManageService
{
    private $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function create(ArticleManageForm $form): Article
    {
        $article = Article::create(
            $form->name,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->articles->save($article);

        return $article;
    }

    public function edit($id, ArticleManageForm $form): void
    {
        $article = $this->articles->get($id);
        $article->edit(
            $form->name,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->articles->save($article);
    }

    public function draft($id): void
    {
        $article = $this->articles->get($id);
        $article->draft();
        $this->articles->save($article);
    }

    public function activate($id): void
    {
        $article = $this->articles->get($id);
        $article->activate();
        $this->articles->save($article);
    }

    public function remove($id): void
    {
        $article = $this->articles->get($id);
        $this->articles->remove($article);
    }
}