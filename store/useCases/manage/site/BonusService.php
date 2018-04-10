<?php

namespace store\useCases\manage\site;


use store\entities\site\Bonus;
use store\forms\site\BonusForm;
use store\repositories\site\BonusRepository;
use yii\helpers\Inflector;
use yii\caching\TagDependency;

class BonusService
{
    private $repository;

    public function __construct(BonusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(BonusForm $form): Bonus
    {
        $bonus = Bonus::create(
            $form->name,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->repository->save($bonus);
        TagDependency::invalidate(\Yii::$app->cache, ['bonuses']);
        return $bonus;
    }

    public function edit($id, BonusForm $form): void
    {
        $bonus = $this->repository->get($id);
        $bonus->edit(
            $form->name,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->repository->save($bonus);
        TagDependency::invalidate(\Yii::$app->cache, ['bonuses']);
    }

    public function draft($id): void
    {
        $bonus = $this->repository->get($id);
        $bonus->draft();
        TagDependency::invalidate(\Yii::$app->cache, ['bonuses']);
        $this->repository->save($bonus);
    }

    public function activate($id): void
    {
        $bonus = $this->repository->get($id);
        $bonus->activate();
        TagDependency::invalidate(\Yii::$app->cache, ['bonuses']);
        $this->repository->save($bonus);
    }

    public function remove($id): void
    {
        $bonus = $this->repository->get($id);
        TagDependency::invalidate(\Yii::$app->cache, ['bonuses']);
        $this->repository->remove($bonus);
    }
}