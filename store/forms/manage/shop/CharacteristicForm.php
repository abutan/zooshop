<?php

namespace store\forms\manage\shop;


use store\entities\shop\Category;
use store\entities\shop\Characteristic;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CharacteristicForm extends Model
{
    public $name;
    public $categoryId;
    public $sort;

    public function __construct(Characteristic $characteristic = null, array $config = [])
    {
        if ($characteristic){
            $this->name = $characteristic->name;
            $this->categoryId = $characteristic->category_id;
            $this->sort = $characteristic->sort;
        }else{
            $this->sort = Characteristic::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['sort', 'categoryId'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название атрибута',
            'category_id' => 'Категория',
            'categoryId' => 'Категория',
            ];
    }

    public function categoryList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array  $category){
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth']-1).' ' : '').$category['name'];
        });
    }
}