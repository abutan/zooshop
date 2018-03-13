<?php

namespace store\forms\manage\shop\product;


use elisdn\compositeForm\CompositeForm;
use store\entities\shop\Characteristic;
use store\entities\shop\product\Modification;
use yii\web\UploadedFile;

/**
 * @property ModificationValueForm[] $values
 */
class ModificationEditForm extends CompositeForm
{
    public $name;
    public $code;
    public $price;
    public $quantity;
    public $image;

    public function __construct(Modification $modification, array $config = [])
    {
        if ($modification){
            $this->name = $modification->name;
            $this->code = $modification->code;
            $this->price = $modification->price;
            $this->quantity = $modification->quantity;
            $this->values = array_map(function (Characteristic $characteristic) use ($modification){
                return new ModificationValueForm($characteristic, $modification->getValue($characteristic->id));
            }, Characteristic::find()->orderBy('name')->andWhere(['category_id' => $modification->getRootCategory()])->all());
        }
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

    protected function internalForms(): array
    {
        return [
            'values',
        ];
    }
}