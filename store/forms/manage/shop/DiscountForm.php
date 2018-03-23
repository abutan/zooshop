<?php

namespace store\forms\manage\shop;


use store\entities\shop\Discount;
use yii\base\Model;

class DiscountForm extends Model
{
    public $percent;
    public $name;
    public $fromDate;
    public $toDate;
    public $sort;

    private $_discount;

    public function __construct(Discount $discount = null, array $config = [])
    {
        if ($discount){
            $this->percent = $discount->percent;
            $this->name = $discount->name;
            $this->fromDate = $discount->from_date;
            $this->toDate = $discount->to_date;
            $this->sort = $discount->sort;
            $this->_discount = $discount;
        }else{
            $this->sort = Discount::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['percent', 'name', 'sort'], 'required'],
            ['name', 'string', 'max' => 255],
            [['percent', 'sort'], 'integer'],
            [['fromDate', 'toDate'], 'date'],
            ['name', 'unique', 'targetClass' => Discount::class, 'message' => 'Такое название скидки уже используется.', 'filter' => $this->_discount ? ['<>', 'id', $this->_discount->id] : null],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'percent' => 'Размер скидки %',
            'name' => 'Название',
            'fromDate' => 'Дата начала',
            'toDate' => 'Дата окончания',
            'sort' => 'Номер по порядку',
        ];
    }
}