<?php

namespace store\services\manage\shop;


use store\entities\shop\Brand;
use store\forms\manage\shop\BrandForm;
use store\repositories\manage\shop\BrandRepository;
use yii\helpers\Inflector;

class BrandManageService
{
    private $brands;

    public function __construct(BrandRepository $brands) {
        $this->brands = $brands;
    }

    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug ? : Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->brands->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            $form->slug ? : Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->brands->save($brand);
    }

    public function remove($id)
    {
        $brand = $this->brands->get($id);
        $this->brands->remove($brand);
    }
}