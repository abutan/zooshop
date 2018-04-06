<?php

namespace store\frontModels\shop;


use store\entities\shop\DeliveryMethod;

class DeliveryMethodReadRepository
{
    public function getAll(): array
    {
        return DeliveryMethod::find()->orderBy('sort')->all();
    }
}