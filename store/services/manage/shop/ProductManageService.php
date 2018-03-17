<?php

namespace store\services\manage\shop;


use store\entities\shop\product\Product;
use store\entities\shop\Tag;
use store\forms\manage\shop\product\ModificationCreateForm;
use store\forms\manage\shop\product\ModificationEditForm;
use store\forms\manage\shop\product\PhotosForm;
use store\forms\manage\shop\product\PriceForm;
use store\forms\manage\shop\product\ProductCreateForm;
use store\forms\manage\shop\product\ProductEditForm;
use store\forms\manage\shop\product\QuantityForm;
use store\repositories\manage\shop\BrandRepository;
use store\repositories\manage\shop\CategoryRepository;
use store\repositories\manage\shop\MakerRepository;
use store\repositories\manage\shop\ProductRepository;
use store\repositories\manage\shop\TagRepository;
use store\services\TransactionsManager;
use yii\helpers\Inflector;

class ProductManageService
{
    private $products;
    private $brands;
    private $makers;
    private $categories;
    private $tags;
    private $transactions;

    public function __construct(ProductRepository $products, BrandRepository $brands, MakerRepository $makers, CategoryRepository $categories, TagRepository $tags, TransactionsManager $transactions)
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->makers = $makers;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transactions = $transactions;
    }

    public function create(ProductCreateForm $form): Product
    {
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);
        $maker = $this->makers->get($form->makerId);

        $product = Product::create(
            $form->code,
            $form->name,
            $category->id,
            $brand->id,
            $maker->id,
            $form->body,
            $form->weight,
            $form->quantity->quantity,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );

        $product->setPrice(
            $form->price->old,
            $form->price->new);

        foreach ($form->categories->others as $otherId){
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }

        foreach ($form->photos->files as $file){
            $product->addPhoto($file);
        }

        foreach ($form->tags->existing as $tagId){
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }

        $this->transactions->wrap(function () use ($product, $form){
            foreach ($form->tags->newNames as $tagName){
                if (!$tag = $this->tags->findByName($tagName)){
                    $tag = Tag::create($tagName, Inflector::slug($tagName));
                    $this->tags->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->products->save($product);
        });
        return $product;
    }

    public function edit($id, ProductEditForm $form): void
    {
        $product = $this->products->get($id);
        $brand = $this->brands->get($form->brandId);
        $maker = $this->makers->get($form->makerId);
        $category = $this->categories->get($form->categories->main);

        $product->edit(
            $form->code,
            $form->name,
            $brand->id,
            $maker->id,
            $form->body,
            $form->weight,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );

        $product->changeMainCategory($category->id);

        $this->transactions->wrap(function () use ($product, $form){
            $product->revokeCategories();
            $product->revokeTags();
            $this->products->save($product);

            foreach ($form->categories->others as $otherId){
                $category = $this->categories->get($otherId);
                $product->assignCategory($category->id);
            }

            foreach ($form->values as $value){
                $product->setValue($value->characteristicId, $value->text);
            }

            foreach ($form->tags->existing as $tagId){
                $tag = $this->tags->get($tagId);
                $product->assignTag($tag->id);
            }

            foreach ($form->tags->newNames as $tagName){
                if (!$tag = $this->tags->findByName($tagName)){
                    $tag = Tag::create($tagName, Inflector::slug($tagName));
                    $this->tags->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->products->save($product);
        });
    }

    public function changePrice($id, PriceForm $form): void
    {
        $product = $this->products->get($id);
        $product->setPrice(
            $form->old,
            $form->new
        );
        $this->products->save($product);
    }

    public function changeQuantity($id, QuantityForm $form): void
    {
        $product = $this->products->get($id);
        $product->setQuantity($form->quantity);
        $this->products->save($product);
    }

    public function addValues($id, ProductEditForm $form): void
    {
        $product = $this->products->get($id);
        foreach ($form->values as $value){
            $product->setValue($value->characteristicId, $value->text);
        }
    }

    public function activate($id): void
    {
        $product = $this->products->get($id);
        $product->activate();
        $this->products->save($product);
    }

    public function draft($id): void
    {
        $product = $this->products->get($id);
        $product->draft();
        $this->products->save($product);
    }

    public function addPhotos($id, PhotosForm $form): void
    {
        $product = $this->products->get($id);
        foreach ($form->files as $file){
            $product->addPhoto($file);
        }
        $this->products->save($product);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->movePhotoUp($photoId);
        $this->products->save($product);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->movePhotoDown($photoId);
        $this->products->save($product);
    }

    public function removePhoto($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->removePhoto($photoId);
        $this->products->save($product);
    }

    public function addRelatedProduct($id, $otherId): void
    {
        $product = $this->products->get($id);
        $other = $this->products->get($otherId);
        $product->assignRelatedProduct($other->id);
        $this->products->save($product);
    }

    public function removeRelatedProduct($id, $otherId): void
    {
        $product = $this->products->get($id);
        $other = $this->products->get($otherId);
        $product->revokeRelatedProduct($other->id);
        $this->products->save($product);
    }

    public function addModification($id, ModificationCreateForm $form): void
    {
        $product = $this->products->get($id);
        $product->addModification(
            $form->id,
            $form->name,
            $form->code,
            $form->price,
            $form->quantity
            );
        $this->products->save($product);
        if (!empty($form->image)){
            $product->addModificationPhoto($form->id, $form->image);
        }
        $this->products->save($product);
    }

    public function editModification($id, $modificationId, ModificationEditForm $form): void
    {
        $product = $this->products->get($id);
        $product->editModification(
            $modificationId,
            $form->name,
            $form->code,
            $form->price,
            $form->quantity
        );
        $this->products->save($product);
        if (!empty($form->image)){
            $product->addModificationPhoto($modificationId, $form->image);
        }
        foreach ($form->values as $value){
            $modification = $product->getModification($modificationId);
            $modification->setValue($value->characteristicId, $value->text);
        }
        $this->products->save($product);
    }

    public function removeModification($id, $modificationId): void
    {
        $product = $this->products->get($id);
        $product->removeModification($modificationId);
        $this->products->save($product);
    }

    public function remove($id): void
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}