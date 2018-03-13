<?php

namespace store\entities\shop\product;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use store\entities\shop\Category;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
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
 * @property ModificationValue[] $values
 * @property Product $product
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

    public function getRootCategory(): int
    {
        $category = Category::findOne($this->product->category_id);
        $idx = ArrayHelper::getColumn($category->getParents()->all(), 'id');
        $root = Category::find()->andWhere(['id' => $idx])->andWhere(['depth' => 1])->one();
        return $root->id;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'code' => 'Артикул',
            'price' => 'Цена',
            'image' => 'Фото',
        ];
    }

    ############

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(ModificationValue::class, ['modification_id' => 'id']);
    }

    public function setValue($id, $value): void
    {
        $values = $this->values;
        foreach ($values as $val){
            if ($val->isFoeCharacteristic($id)){
                $val->changeValue($value);
                $this->values = $values;
                return;
            }
        }
        $values[] = ModificationValue::create($id, $value);
        $this->values = $values;
    }

    public function getValue($id): ModificationValue
    {
        $values = $this->values;
        foreach ($values as $val){
            if ($val->isFoeCharacteristic($id)){
                return $val;
            }
        }
        return ModificationValue::blank($id);
    }

    ############

    public static function tableName(): string
    {
        return '{{%product_modifications}}';
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
                ],
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['values'],
            ],
        ];
    }
}