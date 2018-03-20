<?php

namespace store\forms\manage\shop\product;


use elisdn\compositeForm\CompositeForm;
use store\entities\shop\Brand;
use store\entities\shop\Characteristic;
use store\entities\shop\Maker;
use store\entities\shop\product\Product;
use store\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * @property CategoriesForm $categories
 * @property ProductValueForm[] values
 * @property TagsForm $tags
 */
class ProductEditForm extends CompositeForm
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

    private $_product;

    public function __construct(Product $product, array $config = [])
    {
        $this->code = $product->code;
        $this->name = $product->name;
        $this->brandId = $product->brand_id;
        $this->makerId = $product->maker_id;
        $this->body = $product->body;
        $this->weight = $product->weight;
        $this->slug = $product->slug;
        $this->title = $product->title;
        $this->description = $product->description;
        $this->keywords = $product->keywords;
        $this->categories = new CategoriesForm($product);
        $this->tags = new TagsForm($product);
        $this->values = array_map(function (Characteristic $characteristic) use ($product){
            return new ProductValueForm($characteristic, $product->getValue($characteristic->id));
        }, Characteristic::find()->andWhere(['category_id' => $product->getRootCategory()])->orderBy('sort')->all());
        $this->_product = $product;
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
            ['slug', 'unique', 'targetClass' => Product::class, 'message' => 'Такой алиас уже используется. Введите другой алиас, или модифицируйте действующий.', 'filter' => ['<>', 'id', $this->_product->id]]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'code' => 'Артикул',
            'name' => 'Название',
            'category_id' => 'Категория',
            'maker_id' => 'Производитель',
            'brand_id' => 'Бренд',
            'main_photo_id' => 'Главное фото',
            'price_new' => 'Цена',
            'price_old' => 'Старая цена',
            'body' => 'Описание',
            'rating' => 'Рейтинг',
            'slug' => 'Алиас',
            'status' => 'Состояние',
            'weight' => 'Вес',
            'quantity' => 'Количество на складе',
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
            'categories', 'values', 'tags',
        ];
    }
}