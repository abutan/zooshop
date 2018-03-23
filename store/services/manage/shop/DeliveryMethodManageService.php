<?php

namespace store\services\manage\shop;


use store\entities\shop\DeliveryMethod;
use store\forms\manage\shop\DeliveryForm;
use store\repositories\manage\shop\DeliveryRepository;

class DeliveryMethodManageService
{
    private $methods;

    public function __construct(DeliveryRepository $methods) {
        $this->methods = $methods;
    }

    public function create(DeliveryForm $form): DeliveryMethod
    {
        $method = DeliveryMethod::create(
            $form->name,
            $form->cost,
            $form->minPrice,
            $form->maxPrice,
            $form->minWeight,
            $form->maxWeight,
            $form->sort
        );
        $this->methods->save($method);

        return $method;
    }

    public function edit($id, DeliveryForm $form)
    {
        $method = $this->methods->get($id);
        $method->edit(
            $form->name,
            $form->cost,
            $form->minPrice,
            $form->maxPrice,
            $form->minWeight,
            $form->maxWeight,
            $form->sort
        );
        $this->methods->save($method);
    }

    public function remove($id)
    {
        $method = $this->methods->get($id);
        $this->methods->remove($method);
    }
}