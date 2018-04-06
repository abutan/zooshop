<?php

namespace store\useCases\manage\site;


use store\entities\site\Notification;
use store\forms\manage\site\NotificationForm;
use store\repositories\site\NotificationRepository;
use yii\helpers\Inflector;

class NotificationService
{
    private $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(NotificationForm $form): Notification
    {
        $notification = Notification::create(
            $form->name,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->repository->save($notification);

        return $notification;
    }

    public function edit($id, NotificationForm $form): void
    {
        $notification = $this->repository->get($id);
        $notification->edit(
            $form->name,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->repository->save($notification);
    }

    public function remove($id): void
    {
        $notification = $this->repository->get($id);
        $this->repository->remove($notification);
    }
}