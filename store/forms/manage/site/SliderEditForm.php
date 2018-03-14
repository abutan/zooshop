<?php

namespace store\forms\manage\site;


use elisdn\compositeForm\CompositeForm;
use store\entities\site\Slider;

/**
 * @property SliderCategoriesForm $categories
 */
class SliderEditForm extends CompositeForm
{
    public $name;

    public function __construct(Slider $slider, array $config = [])
    {
        $this->categories = new SliderCategoriesForm($slider);
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название слайдера',
        ];
    }

    protected function internalForms(): array
    {
        return [
            'categories',
        ];
    }
}