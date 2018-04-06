<?php

namespace store\useCases\manage\site;


use store\entities\site\Bonus;
use store\forms\site\BonusForm;
use store\repositories\site\BonusRepository;
use yii\helpers\Inflector;

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
    }

    public function draft($id): void
    {
        $bonus = $this->repository->get($id);
        $bonus->draft();
        $this->repository->save($bonus);
    }

    public function activate($id): void
    {
        $bonus = $this->repository->get($id);
        $bonus->activate();
        $this->repository->save($bonus);
    }

    public function remove($id): void
    {
        $bonus = $this->repository->get($id);
        $this->repository->remove($bonus);
    }
}