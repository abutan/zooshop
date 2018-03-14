<?php

namespace store\repositories\manage\site;


use store\entities\site\Slider;
use yii\web\NotFoundHttpException;

class SliderRepository
{
    public function get($id): Slider
    {
        if (!$slider = Slider::findOne($id)){
            throw new NotFoundHttpException('Слайдер не найден.');
        }
        return $slider;
    }

    public function save(Slider $slider): void
    {
        if (!$slider->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Slider $slider): void
    {
        if (!$slider->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}