<?php

namespace store\services\manage\site;


use store\entities\site\Slider;
use store\forms\manage\site\SliderCreateForm;
use store\forms\manage\site\SliderEditForm;
use store\repositories\manage\shop\CategoryRepository;
use store\repositories\manage\site\SliderRepository;
use store\services\TransactionsManager;

class SliderManageService
{
    private $sliders;
    private $categories;
    private $transactions;

    public function __construct(SliderRepository $sliders, CategoryRepository $categories, TransactionsManager $transactions)
    {
        $this->sliders = $sliders;
        $this->categories = $categories;
        $this->transactions = $transactions;
    }

    public function create(SliderCreateForm $form): Slider
    {
        $slider = Slider::create(
            $form->name
        );

        foreach ($form->slides->files as $file){
            $slider->addSlide($file);
        }

        foreach ($form->categories->categories as $categoryId){
            $category = $this->categories->get($categoryId);
            $slider->assignCategory($category->id);
        }

        $this->sliders->save($slider);

        return $slider;
    }

    public function edit($id, SliderEditForm $form): void
    {
        $slider = $this->sliders->get($id);
        $slider->edit(
            $form->name
        );

        $this->transactions->wrap(function () use ($slider, $form){
            $slider->revokeCategories();
            $this->sliders->save($slider);

            foreach ($form->categories->categories as $categoryId){
                $category = $this->categories->get($categoryId);
                $slider->assignCategory($category->id);
            }

            $this->sliders->save($slider);
        });
    }

    public function draft($id): void
    {
        $slider = $this->sliders->get($id);
        $slider->draft();
        $this->sliders->save($slider);
    }

    public function activate($id): void
    {
        $slider = $this->sliders->get($id);
        $slider->activate();
        $this->sliders->save($slider);
    }

    public function remove($id): void
    {
        $slider = $this->sliders->get($id);
        $this->sliders->remove($slider);
    }
}