<?php

namespace store\forms\manage\site;


use elisdn\compositeForm\CompositeForm;

/**
 * @property SliderPhotosForm $slides
 * @property SliderCategoriesForm $categories
 */
class SliderCreateForm extends CompositeForm
{
    public $name;

    public function __construct(array $config = [])
    {
        $this->slides = new SliderPhotosForm();
        $this->categories = new SliderCategoriesForm();
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
            'slides', 'categories',
        ];
    }
}