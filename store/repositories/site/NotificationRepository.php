<?php

namespace store\repositories\site;


use store\entities\site\Notification;
use yii\web\NotFoundHttpException;

class NotificationRepository
{
    public function get($id): Notification
    {
        if (!$notification = Notification::findOne($id)){
            throw new NotFoundHttpException('Такой комментарий не найден.');
        }
        return $notification;
    }

    public function save(Notification $notification)
    {
        if (!$notification->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Notification $notification)
    {
        if (!$notification->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}