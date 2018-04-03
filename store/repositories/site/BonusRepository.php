<?php

namespace store\repositories\site;


use store\entities\site\Bonus;
use yii\web\NotFoundHttpException;

class BonusRepository
{
    public function get($id): Bonus
    {
        if (!$bonus = Bonus::findOne($id)){
            throw new NotFoundHttpException('Такой комментарий не найден.');
        }
        return $bonus;
    }

    public function save(Bonus $bonus)
    {
        if (!$bonus->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Bonus $bonus)
    {
        if (!$bonus->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}