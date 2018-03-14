<?php

namespace store\forms\manage\site;


use yii\base\Model;
use yii\web\UploadedFile;

class SliderPhotosForm extends Model
{
    public $files;

    public function rules(): array
    {
        return [
            ['files', 'each', 'rule' => ['image']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'files' => 'Слайды',
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