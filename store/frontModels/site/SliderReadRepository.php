<?php

namespace store\frontModels\site;


use store\entities\site\Slider;

class SliderReadRepository
{
    public function findByCategory($category): ?int
    {
        if ($slider = Slider::find()->joinWith(['sliderAssignments sa'], false)->andWhere(['status' => 1])->andWhere(['sa.category_id' => $category->id])->limit(1)->one()) {
            return $slider->id;
        }
       return false;
    }

    public function findById($id): ?Slider
    {
        return Slider::find()->andWhere(['status' => 1])->andWhere(['id' => $id])->one();
    }
}