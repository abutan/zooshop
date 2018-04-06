<?php

namespace store\useCases\manage\shop;


use store\entities\shop\Category;
use store\forms\manage\shop\CategoryForm;
use store\repositories\manage\shop\CategoryRepository;
use store\repositories\manage\shop\ProductRepository;
use yii\helpers\Inflector;

class CategoryManageService
{
    private $categories;
    private $products;

    public function __construct(CategoryRepository $categories, ProductRepository $products)
    {
        $this->categories = $categories;
        $this->products = $products;
    }

    public function create(CategoryForm $form): Category
    {
        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            $form->parentId,
            $form->body,
            $form->slug ? : Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $category->appendTo($parent);
        $this->categories->save($category);

        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->parentId,
            $form->body,
            $form->slug ? : Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        if ($form->parentId !== $category->parent_id){
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }

        $this->categories->save($category);
    }

    public function moveUp($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($prev = $category->prev){
            $category->insertBefore($prev);
        }
        $this->categories->save($category);
    }

    public function moveDown($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($next = $category->next){
            $category->insertAfter($next);
        }
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($this->products->existsByCategory($category->id)){
            throw new \DomainException('Невозможно удалить категорию к которой привязаны товары.');
        }
        $this->categories->remove($category);
    }

    private function assertIsNotRoot(Category $category)
    {
        if ($category->isRoot()){
            throw new \DomainException('Эту категорию нельзя редактировать');
        }
    }
}