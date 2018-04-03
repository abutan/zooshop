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
use store\forms\manage\shop\product\ReviewEditForm;
use store\forms\shop\ReviewForm;
use store\repositories\manage\shop\BrandRepository;
use store\repositories\manage\shop\CategoryRepository;
use store\repositories\manage\shop\MakerRepository;
use store\repositories\manage\shop\ProductRepository;
use store\repositories\manage\shop\TagRepository;
use store\services\TransactionsManager;
use yii\helpers\Inflector;
use yii\mail\MailerInterface;

class ProductManageService
{
    private $products;
    private $brands;
    private $makers;
    private $categories;
    private $tags;
    private $transactions;
    private $mailer;
    private $adminEmail;

    public function __construct($adminEmail, ProductRepository $products, BrandRepository $brands, MakerRepository $makers, CategoryRepository $categories, TagRepository $tags, TransactionsManager $transactions, MailerInterface $mailer)
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->makers = $makers;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transactions = $transactions;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
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

            foreach ($form->productValues as $productValue){
                $product->setProductValue($productValue->characteristicId, $productValue->value);
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

    public function addProductValue($id, ProductEditForm $form): void
    {
        $product = $this->products->get($id);
        foreach ($form->productValues as $productValue){
            $product->setProductValue($productValue->characteristicId, $productValue->value);
        }
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

        $modification = $product->getModification($modificationId);
        foreach ($form->modificationValues as $modificationValue){
            $modification->setModificationValue($modificationValue->characteristicId, $modificationValue->value);
        }

        $this->products->save($product);
    }

    public function removeModification($id, $modificationId): void
    {
        $product = $this->products->get($id);
        $product->removeModification($modificationId);
        $this->products->save($product);
    }

    public function addReview($id, $userId, ReviewForm $form): void
    {
        $product = $this->products->get($id);
        $product->addReview($userId, $form->vote, $form->text);
        $this->products->save($product);


        $subject = 'Внимание добавлен комментарий к товару.';
        $body = '<p>Подробности: <br>';
        $body .= 'Добавлен отзыв к товару ' . $product->id . '</p>';
        $body .= '<p>Сайт &laquo;'. \Yii::$app->name .'&raquo;</p>';
        $sent = $this->mailer->compose()
                    ->setTo($this->adminEmail)
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
        if (!$sent){
            throw new \DomainException('Ошибка отправки. Попробуйте позже.');
        }


    }

    public function editReview($id, $reviewId, ReviewEditForm $form): void
    {
        $product = $this->products->get($id);
        $product->editReview(
            $reviewId,
            $form->vote,
            $form->text
        );
        $this->products->save($product);
    }

    public function activateReview($id, $reviewId): void
    {
        $product = $this->products->get($id);
        $product->activateReview($reviewId);
        $this->products->save($product);
    }

    public function draftReview($id, $reviewId): void
    {
        $product = $this->products->get($id);
        $product->draftReview($reviewId);
        $this->products->save($product);
    }

    public function removeReview($id, $reviewId): void
    {
        $product = $this->products->get($id);
        $product->removeReview($reviewId);
        $this->products->save($product);
    }

    public function sale($id): void
    {
        $product = $this->products->get($id);
        $product->sale();
        $this->products->save($product);
    }

    public function unSale($id): void
    {
        $product = $this->products->get($id);
        $product->unSale();
        $this->products->save($product);
    }

    public function remove($id): void
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}