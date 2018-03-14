<?php

namespace store\forms\manage\site;


use store\entities\shop\Category;
use store\entities\site\Slider;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SliderCategoriesForm extends Model
{
    public $categories = [];

    public function __construct(Slider $slider = null, array $config = [])
    {
        if ($slider){
            $this->categories = ArrayHelper::getColumn($slider->sliderAssignments, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['categories', 'each', 'rule' => ['integer']],
            ['categories', 'default', 'value' => []],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'categories' => 'Выберите нужные категории',
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(), 'id', function (array $category){
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1). ' ' : ''). $category['name'];
        });
    }
}