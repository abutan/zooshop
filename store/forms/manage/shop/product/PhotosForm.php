<?php

namespace store\forms\manage\shop\product;


use yii\base\Model;
use yii\web\UploadedFile;

class PhotosForm extends Model
{
    /* @var UploadedFile */
    public $files;

    public function rules(): array
    {
        return [
            ['files', 'each', 'rule' => ['image']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'files' => 'Фото',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()){
            $this->files = UploadedFile::getInstances($this, 'files');
            return true;
        }
        return false;
    }
}