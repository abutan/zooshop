<?php

namespace store\entities\shop\product;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use store\entities\shop\Brand;
use store\entities\shop\Category;
use store\entities\shop\Maker;
use store\entities\shop\product\queries\ProductQuery;
use store\entities\shop\Tag;
use store\entities\user\WhishlistItem;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id [int(11)]
 * @property string $code [varchar(255)]
 * @property string $name [varchar(255)]
 * @property int $main_photo_id [int(11)]
 * @property int $category_id [int(11)]
 * @property int $brand_id [int(11)]
 * @property int $maker_id [int(11)]
 * @property string $body
 * @property int $price_old [int(11)]
 * @property int $price_new [int(11)]
 * @property float $weight [float]
 * @property int $quantity [int(11)]
 * @property int $sale [smallint(6)]
 * @property string $rating [decimal(3,2)]
 * @property string $slug [varchar(255)]
 * @property int $status [smallint(6)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 *
 * @property Brand $brand
 * @property Maker $maker
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[] $categories
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property Modification[] $modifications
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 * @property RelatedAssignment[] $relatedAssignments
 * @property Product[] $relates
 * @property Review[] $reviews
 * @property WhishlistItem[] $whishlistItems
 * @property ProductValue[] $productValues
 */
class Product extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($code, $name, $categoryId, $brandId, $makerId, $body, $weight, $quantity, $slug, $title, $description, $keywords): self
    {
        $product = new static();
        $product->code = $code;
        $product->name = $name;
        $product->category_id = $categoryId;
        $product->brand_id = $brandId;
        $product->maker_id = $makerId;
        $product->body = $body;
        $product->weight = $weight;
        $product->quantity = $quantity;
        $product->slug = $slug;
        $product->title = $title;
        $product->description = $description;
        $product->keywords = $keywords;
        $product->status = self::STATUS_DRAFT;
        $product->created_at = time();

        return $product;
    }

    public function edit($code, $name, $brandId, $makerId, $body, $weight, $slug, $title, $description, $keywords): void
    {
        $this->code = $code;
        $this->name = $name;
        $this->brand_id = $brandId;
        $this->maker_id = $makerId;
        $this->body = $body;
        $this->weight = $weight;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->updated_at = time();
    }

    public function setPrice($old, $new): void
    {
        $this->price_old = $old;
        $this->price_new = $new;
    }

    public function changeQuantity($quantity): void
    {
        $this->setQuantity($quantity);
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity ;
    }

    public function changeMainCategory($categoryId): void
    {
        $this->category_id = $categoryId;
    }

    ###########

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if ($this->isActive()){
            throw new \DomainException('Товар уже активирован.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()){
            throw new \DomainException('Товар уже отключен.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isSale(): bool
    {
        return $this->sale == 1;
    }

    public function sale(): void
    {
        if ($this->isSale()){
            throw new \DomainException('Товар уже добавлен в распродажу');
        }
        $this->sale = 1;
    }

    public function unSale(): void
    {
        if (!$this->isSale()){
            throw new \DomainException('Товар уже удален из распродажи');
        }
        $this->sale = 0;
    }

    ###########

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }

    public function canChangeQuantity(): bool
    {
        return !$this->modifications;
    }

    public function canBeCheckout($modificationId, $quantity): bool
    {
        if ($modificationId){
            return $quantity <= $this->getModification($modificationId)->quantity;
        }
        return $quantity <= $this->quantity;
    }

    public function checkout($modificationId, $quantity): void
    {
        if ($modificationId){
            $modifications = $this->modifications;
            foreach ($modifications as $i => $modification){
                if ($modification->isEqualTo($modificationId)){
                    $modification->checkout($quantity);
                    $this->updateModifications($modifications);
                    return;
                }
            }
        }
        if ($quantity > $this->quantity){
            throw new \DomainException('Извините, но только '. $this->quantity . ' экземпляров товара доступно для заказа. Добавьте товар в избранное (лист жуданий), и при появлении товара на складе, Вы будете проинформированы.');
        }
        $this->setQuantity($this->quantity - 1);
    }

    public function getTitle(): string
    {
        return $this->title ?: $this->name;
    }

    ###########



    public function getModification($id): Modification
    {
        foreach ($this->modifications as $modification){
            if ($modification->isEqualTo($id)){
                return $modification;
            }
        }
        throw new \DomainException('Модификация не найдена.');
    }

    public function getModificationPrice($id): int
    {
        foreach ($this->modifications as $modification){
            if ($modification->isEqualTo($id)){
                return $modification->price ?: $this->price_new;
            }
        }
        throw new \DomainException('Модификация не найдена.');
    }

    public function addModification($id, $name, $code, $price, $quantity): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $modification){
            if ($modification->isEqualToCode($code)){
                throw new \DomainException('Такая модификация уже существует.');
            }
        }
        $modifications[] = Modification::create($id, $name, $code, $price, $quantity);
        $this->updateModifications($modifications);
    }

    public function editModification($id, $name, $code, $price, $quantity): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $modification){
            if ($modification->isEqualTo($id)){
                $modification->edit($name, $code, $price, $quantity);
                $this->updateModifications($modifications);
                return;
            }
        }
        throw new \DomainException('Модификация не найдена.');
    }

    public function addModificationPhoto($id, UploadedFile $file): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $modification){
            if ($modification->isEqualTo($id)){
                $modification->setPhoto($file);
                $modification->save();
                return;
            }
        }
        throw new \DomainException('Что то явно не так.');
    }

    public function removeModification($id): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification){
            if ($modification->isEqualTo($id)){
                unset($modifications[$i]);
                $this->updateModifications($modifications);
                return;
            }
        }
        throw new \DomainException('Модификация не найдена.');
    }

    private function updateModifications(array $modifications): void
    {
        $this->modifications = $modifications;
        $this->setQuantity(array_sum(array_map(function (Modification $modification){
            return $modification->quantity;
        }, $this->modifications)));
    }

    ###########

    public function assignCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment){
            if ($assignment->isForCategory($id)){
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    public function revokeCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment){
            if ($assignment->isForCategory($id)){
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Не найдено.');
    }

    public function revokeCategories(): void
    {
        $this->categoryAssignments = [];
    }

    ###########

    public function assignTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment){
            if ($assignment->isForTag($id)){
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment){
            if ($assignment->isForTag($id)){
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Таг не найден.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    ###########

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo){
            if ($photo->isEqualTo($id)){
                if ($this->main_photo_id == $photo->id){
                    $this->updateAttributes(['main_photo_id' => null]);
                    unset($photos[$i]);
                    $this->updatePhotos($photos);
                }else{
                    unset($photos[$i]);
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo){
            if ($photo->isEqualTo($id)){
                if ($prev = $photos[$i - 1] ?? null){
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo){
            if ($photo->isEqualTo($id)){
                if ($next = $photos[$i + 1] ?? null){
                    $photos[$i + 1] = $photo;
                    $photos[$i] = $next;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo){
            $photo->setSort($i);
        }
        $this->photos = $photos;
    }

    ###########

    public function assignRelatedProduct($id): void
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $assignment){
            if ($assignment->isForProduct($id)){
                return;
            }
        }
        $assignments[] = RelatedAssignment::create($id);
        $this->relatedAssignments = $assignments;
    }

    public function revokeRelatedProduct($id): void
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $i => $assignment){
            if ($assignment->isForProduct($id)){
                unset($assignments[$i]);
                $this->relatedAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Сопутствующий продукт не найден.');
    }

    ###########

    public function getReview($id): Review
    {
        $reviews = $this->reviews;
        foreach ($reviews as $review){
            if ($review->isEqualTo($id)){
                return $review;
            }
        }
        throw new \DomainException('Отзыв не найден.');
    }

    public function addReview($userId, $vote, $text): void
    {
        $reviews = $this->reviews;
        $reviews[] = Review::create($userId, $vote, $text);
        $this->updateReviews($reviews);
    }

    public function editReview($id, $vote, $text): void
    {
        $this->doWithReview($id, function (Review $review) use ($vote, $text){
            $review->edit($vote, $text);
        });
    }

    public function activateReview($id): void
    {
        $this->doWithReview($id, function (Review $review){
            $review->activate();
        });
    }

    public function draftReview($id): void
    {
        $this->doWithReview($id, function (Review $review){
            $review->draft();
        });
    }

    public function removeReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review){
            if ($review->isEqualTo($id)){
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден.');
    }

    private function doWithReview($id, callable $callback): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $review){
            if ($review->isEqualTo($id)){
                $callback($review);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден.');
    }

    private function updateReviews(array $reviews): void
    {
        $total = 0;
        foreach ($reviews as $review){
            if ($review->isActive()){
                $total += $review->vote;
            }
        }
        $this->reviews = $reviews;
        $amount = count($this->reviews);
        $this->rating = $amount ? $total/$amount : null;
    }

    ###########

    public function setProductValue($characteristicId, $value): void
    {
        $productValues = $this->productValues;
        foreach ($productValues as $productValue){
            if ($productValue->isForCharacteristic($characteristicId)){
                $productValue->change($value);
                $this->productValues = $productValues;
                return;
            }
        }
        $productValues[] = ProductValue::create($characteristicId, $value);
        $this->productValues = $productValues;
    }

    public function getProductValue($characteristicId): ProductValue
    {
        $productValues = $this->productValues;
        foreach ($productValues as $productValue){
            if ($productValue->isForCharacteristic($characteristicId)){
                return $productValue;
            }
        }
        return ProductValue::blank($characteristicId);
    }

    ###########

    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getMaker(): ActiveQuery
    {
        return $this->hasOne(Maker::class, ['id' => 'maker_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['product_id' => 'id']);
    }
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['product_id' => 'id']);
    }
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function getModifications(): ActiveQuery
    {
        return $this->hasMany(Modification::class, ['product_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }
    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getRelatedAssignments(): ActiveQuery
    {
        return $this->hasMany(RelatedAssignment::class, ['product_id' => 'id']);
    }
    public function getRelates(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['id' => 'related_id'])->via('relatedAssignments');
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    public function getWishlistItems(): ActiveQuery
    {
        return $this->hasMany(WhishlistItem::class, ['product_id' => 'id']);
    }

    public function getProductValues(): ActiveQuery
    {
        return $this->hasMany(ProductValue::class, ['product_id' => 'id']);
    }

    ###########

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'categoryAssignments', 'tagAssignments', 'relatedAssignments', 'photos', 'reviews', 'modifications', 'productValues',
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){
            foreach ($this->photos as $photo){
                $photo->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!empty($this->photos)){
            $this->updateAttributes(['main_photo_id' => $this->photos[0]->id]);
        }
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

    ###########

    public static function tableName(): string
    {
        return '{{%shop_products}}';
    }

    public function attributeLabels(): array
    {
        return [
            'code' => 'Артикул',
            'name' => 'Название',
            'category_id' => 'Категория',
            'maker_id' => 'Производитель',
            'brand_id' => 'Бренд',
            'main_photo_id' => 'Главное фото',
            'price_new' => 'Цена',
            'price_old' => 'Старая цена',
            'body' => 'Описание',
            'rating' => 'Рейтинг',
            'slug' => 'Алиас',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'status' => 'Состояние',
            'weight' => 'Вес',
            'quantity' => 'Количество на складе',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }
}