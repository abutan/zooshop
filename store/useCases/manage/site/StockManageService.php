<?php

namespace store\useCases\manage\site;


use store\entities\site\Stock;
use store\forms\site\StockForm;
use store\repositories\site\StockRepository;
use yii\helpers\Inflector;

class StockManageService
{
    private $stocks;

    public function __construct(StockRepository $stocks)
    {
        $this->stocks = $stocks;
    }

    public function create(StockForm $form): Stock
    {
        $stock = Stock::create(
            $form->name,
            $form->dateFrom,
            $form->dateTo,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->stocks->save($stock);

        return $stock;
    }

    public function edit($id, StockForm $form): void
    {
        $stock = $this->stocks->get($id);
        $stock->edit(
            $form->name,
            $form->dateFrom,
            $form->dateTo,
            $form->summary,
            $form->body,
            $form->slug ?: Inflector::slug($form->name),
            $form->title,
            $form->description,
            $form->keywords
        );
        $this->stocks->save($stock);
    }

    public function draft($id): void
    {
        $stock = $this->stocks->get($id);
        $stock->draft();
        $this->stocks->save($stock);
    }

    public function activate($id): void
    {
        $stock = $this->stocks->get($id);
        $stock->activate();
        $this->stocks->save($stock);
    }

    public function remove($id): void
    {
        $stock = $this->stocks->get($id);
        $this->stocks->remove($stock);
    }
}