<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\product\Modification;
use yii\base\Model;
use yii\web\UploadedFile;

class ModificationCreateForm extends Model
{
    public $id;
    public $name;
    public $code;
    public $price;
    public $quantity;
    public $image;

    public function __construct(array $config = [])
    {
        $this->id = Modification::find()->max('id') + 1;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'price', 'code', 'quantity'], 'required'],
            [['name', 'code'], 'string', 'max' => 255],
            [['quantity', 'price'], 'integer'],
            ['image', 'image'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'code' => 'Артикул',
            'price' => 'Цена',
            'quantity' => 'Количество',
            'image' => 'Фото',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()){
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }
}