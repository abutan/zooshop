<?php

namespace store\services\manage\shop;


use store\entities\shop\Maker;
use store\forms\manage\shop\MakerManageForm;
use store\repositories\manage\shop\MakerRepository;
use yii\helpers\Inflector;

class MakerManageService
{
    private $makers;

    public function __construct(MakerRepository $makers) {
        $this->makers = $makers;
    }

    public function create(MakerManageForm $form): Maker
    {
        $maker = Maker::create(
            $form->name,
            $form->slug ? : Inflector::slug($form->name),
            $form->body,
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->makers->save($maker);
        return $maker;
    }

    public function edit($id, MakerManageForm $form)
    {
        $maker = $this->makers->get($id);
        $maker->edit(
            $form->name,
            $form->slug ? : Inflector::slug($form->name),
            $form->body,
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->makers->save($maker);
    }

    public function remove($id)
    {
        $maker = $this->makers->get($id);
        $this->makers->remove($maker);
    }
}