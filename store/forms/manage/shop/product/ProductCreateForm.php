<?php

namespace store\forms\manage\shop\product;


use elisdn\compositeForm\CompositeForm;
use store\entities\shop\Brand;
use store\entities\shop\Maker;
use store\entities\shop\product\Product;
use store\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * @property PriceForm $price
 * @property QuantityForm $quantity
 * @property CategoriesForm $categories
 * @property PhotosForm $photos
 * @property TagsForm $tags
 * @property ProductRelatesForm $relates
 */
class ProductCreateForm extends CompositeForm
{
    public $code;
    public $name;
    public $brandId;
    public $makerId;
    public $body;
    public $weight;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    public function __construct(array $config = [])
    {
        $this->price = new PriceForm();
        $this->quantity = new QuantityForm();
        $this->categories = new CategoriesForm();
        $this->photos = new PhotosForm();
        $this->tags = new TagsForm();
        $this->relates = new ProductRelatesForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['code', 'name', 'brandId', 'makerId'], 'required'],
            [['code', 'name', 'slug', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            ['body', 'string'],
            [['brandId', 'makerId'], 'integer'],
            ['weight', 'number', 'min' => 0],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'targetClass' => Product::class, 'message' => 'Такой алиас уже используется. Введите другой алиас, или модифицируйте действующий.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Артикул',
            'name' => 'Название',
            'brandId' => 'Бренд',
            'makerId' => 'Производитель',
            'body' => 'Описание',
            'weight' => 'Вес',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }

    public function brandList(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function makerList(): array
    {
        return ArrayHelper::map(Maker::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return [
            'price', 'quantity', 'categories', 'photos', 'tags', 'relates',
        ];
    }
}