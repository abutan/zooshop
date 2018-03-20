<?php

namespace store\entities\shop\product;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property UploadedFile file
 * @property int $id [int(11)]
 * @property int $product_id [int(11)]
 * @property int $sort [int(11)]
 *
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;

        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName(): string
    {
        return '{{%product_photos}}';
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Фото',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/products/origin/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/products/origin/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/products/cache/[[attribute_product_id]]/[[profile]]/[[id]].[[extension]]',
                'thumbUrl' => '@static/products/cache/[[attribute_product_id]]/[[profile]]/[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'list' => ['width' => 150, 'height' => 100],
                    'product' => ['width' => 300, 'height' => 200],
                    'full' => ['width' => 1200, 'height' => 1200],
                ],
            ],
        ];
    }
}