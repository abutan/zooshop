<?php

namespace store\entities\shop\product;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property int $id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $code [varchar(255)]
 * @property int $price [int(11)]
 * @property string $image [varchar(255)]
 */
class Modification extends ActiveRecord
{
    public static function create($id, $name, $code, $price): self
    {
        $modification = new static();
        $modification->id = $id;
        $modification->name = $name;
        $modification->code = $code;
        $modification->price = $price;

        return $modification;
    }

    public function edit($name, $code, $price): void
    {
        $this->name = $name;
        $this->code = $code;
        $this->price = $price;
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

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'code' => 'Артикул',
            'price' => 'Цена',
            'image' => 'Фото',
        ];
    }

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
        ];
    }
}