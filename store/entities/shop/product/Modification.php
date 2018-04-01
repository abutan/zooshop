<?php

namespace store\entities\shop\product;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property int $id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $code [varchar(255)]
 * @property int $price [int(11)]
 * @property int $quantity [int(11)]
 * @property string $image [varchar(255)]
 *
 * @property ModificationValue[] $modificationValues
 * @property Product $product
 * @mixin ImageUploadBehavior
 */
class Modification extends ActiveRecord
{
    public static function create($id, $name, $code, $price, $quantity): self
    {
        $modification = new static();
        $modification->id = $id;
        $modification->name = $name;
        $modification->code = $code;
        $modification->price = $price;
        $modification->quantity = $quantity;

        return $modification;
    }

    public function edit($name, $code, $price, $quantity): void
    {
        $this->name = $name;
        $this->code = $code;
        $this->price = $price;
        $this->quantity = $quantity;
    }



    public function setPhoto(UploadedFile $image): void
    {
        $this->image = $image;
    }

    public function isEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function isEqualToCode($code): bool
    {
        return $this->code === $code;
    }

    public function checkout($quantity): void
    {
        if ($quantity > $this->quantity){
            throw new \DomainException('Извините, но только '. $this->quantity . ' экземпляров товара доступно для заказа. Добавьте товар в избранное (лист жуданий), и при появлении товара на складе, Вы будете проинформированы.');
        }
        $this->quantity -= $quantity;
    }

    ##########

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getModificationValues(): ActiveQuery
    {
        return $this->hasMany(ModificationValue::class, ['modification_id' => 'id']);
    }

    public function setModificationValue($id, $value): void
    {
        $modificationValues = $this->modificationValues;
        foreach ($modificationValues as $modificationValue){
            if ($modificationValue->isForCharacteristic($id)){
                $modificationValue->change($value);
                $this->modificationValues = $modificationValues;
                return;
            }
        }
        $modificationValues[] = ModificationValue::create($id, $value);
        $this->modificationValues = $modificationValues;
    }

    public function getModificationValue($id): ModificationValue
    {
        $modificationValues = $this->modificationValues;
        foreach ($modificationValues as $modificationValue){
            if ($modificationValue->isForCharacteristic($id)){
                return $modificationValue;
            }
        }
        return ModificationValue::blank($id);
    }

    ############

    public static function tableName(): string
    {
        return '{{%product_modifications}}';
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название модели',
            'code' => 'Артикул модели',
            'price' => 'Цена',
            'quantity' => 'Количество на складе',
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/modifications/origin/[[id]].[[extension]]',
                'fileUrl' => '@static/modifications/origin/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/modifications/cache/[[profile]]/[[id]].[[extension]]',
                'thumbUrl' => '@static/modifications/cache/[[profile]]/[[id]].[[extension]]',
                'thumbs' => [
                    'modification' => ['width' => 50, 'height' => 120],
                    'full' => ['width' => 1200, 'height' => 1200],
                ],
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['modificationValues'],
            ],
        ];
    }
}