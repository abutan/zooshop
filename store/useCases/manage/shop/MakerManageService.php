<?php

namespace store\useCases\manage\shop;


use store\entities\shop\Maker;
use store\forms\manage\shop\MakerManageForm;
use store\repositories\manage\shop\MakerRepository;
use store\repositories\manage\shop\ProductRepository;
use yii\helpers\Inflector;

class MakerManageService
{
    private $makers;
    private $products;

    public function __construct(MakerRepository $makers, ProductRepository $products)
    {
        $this->makers = $makers;
        $this->products = $products;
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
        if ($this->products->existsByMaker($maker->id)){
            throw new \DomainException('Невозможно удалить производителя к которому привязаны товары.');
        }
        $this->makers->remove($maker);
    }
}