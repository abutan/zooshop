<?php

namespace store\entities\site;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property UploadedFile file
 * @property int $id [int(11)]
 * @property int $slider_id [int(11)]
 * @property int $sort [int(11)]
 *
 * @mixin ImageUploadBehavior
 */
class Slide extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $slide = new static();
        $slide->file = $file;

        return $slide;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%slider_photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/sliders/origin/[[attribute_slider_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/sliders/origin/[[attribute_slider_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/sliders/cache/[[attribute_slider_id]]/[[profile]]/[[id]].[[extension]]',
                'thumbUrl' => '@static/sliders/cache/[[attribute_slider_id]]/[[profile]]/[[id]].[[extension]]',
                'thumbs' => [
                    'main' => ['width' => 330, 'height' => 100],
                    'front' => ['width' => 850, 'height' => 260],
                    'slick' => ['width' => 150, 'height' => 102],
                ],
            ],
        ];
    }
}