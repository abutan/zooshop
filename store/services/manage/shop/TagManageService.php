<?php

namespace store\services\manage\shop;


use store\entities\shop\Tag;
use store\forms\manage\shop\TagForm;
use store\repositories\manage\shop\TagRepository;
use yii\helpers\Inflector;

class TagManageService
{
    private $tags;

    public function __construct(TagRepository $tags) {
        $this->tags = $tags;
    }

    public function create(TagForm $form): Tag
    {
        $tag = Tag::create(
            $form->name,
            $form->slug ? : Inflector::slug($form->name)
        );
        $this->tags->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form)
    {
        $tag = $this->tags->get($id);
        $tag->edit(
            $form->name,
            $form->slug ? : Inflector::slug($form->name)
        );
        $this->tags->save($tag);
    }

    public function remove($id)
    {
        $tag = $this->tags->get($id);
        $this->tags->remove($tag);
    }
}