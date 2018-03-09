<?php

namespace store\repositories\manage\shop;


use store\entities\shop\Characteristic;
use yii\web\NotFoundHttpException;

class CharacteristicRepository
{
    /**
     * @param $id
     * @return Characteristic
     * @throws NotFoundHttpException
     */
    public function get($id): Characteristic
    {
        if (!$characteristic = Characteristic::findOne($id)){
            throw new NotFoundHttpException('Атрибут не найден.');
        }
        return $characteristic;
    }

    /**
     * @param Characteristic $characteristic
     */
    public function save(Characteristic $characteristic): void
    {
        if (!$characteristic->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    /**
     * @param Characteristic $characteristic
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Characteristic $characteristic): void
    {
        if (!$characteristic->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}