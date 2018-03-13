<?php

namespace store\forms\manage\shop\product;

use store\entities\shop\product\Product;
use store\entities\shop\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $newNames
 */
class TagsForm extends Model
{
    public $existing = [];
    public $text_new;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product){
            $this->existing = ArrayHelper::getColumn($product->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['existing', 'default', 'value' => []],
            ['text_new', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'existing' => 'Существующие теги',
            'text_new' => 'Добавить новые теги',
        ];
    }

    public function tagList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function getNewNames(): array
    {
        return array_filter(array_map('trim', preg_split('#\s*,\s*#i', $this->text_new)));
    }
}