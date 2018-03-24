<?php

namespace frontend\widgets\shop;


use store\entities\shop\Category;
use store\frontModels\shop\CategoryReadRepository;
use store\frontModels\shop\ProductReadRepository;
use yii\base\Widget;
use yii\helpers\Html;

class CategoryWidget extends Widget
{
    public $active;

    private $categories;
    private $products;

    public function __construct(CategoryReadRepository $categories, ProductReadRepository $products, array $config = [])
    {
        parent::__construct($config);
        $this->categories = $categories;
        $this->products = $products;
    }

    public function run()
    {
        $cats = $this->categories->getTreeWithSubsOf($this->active);
        $level = 1;
        foreach ($cats as $category){
            $active = $this->getActive($category);
            $suffix = $this->getSuffix($category);
            if ($category->depth == $level){
                echo '</li>'.PHP_EOL;
            }elseif ($category->depth > $level){
                echo '<ul>'.PHP_EOL;
            }else{
                echo '</li>'.PHP_EOL;
                for ($i = $level - $category->depth; $i; $i--){
                    echo '</ul>'.PHP_EOL;
                    echo '</li>'.PHP_EOL;
                }
            }
            echo '<li>';
            echo Html::a(Html::encode($category->name).'('. $this->products->getCount($category) .')' .$suffix, ['/shop/catalog/category', 'id' => $category->id], ['class' => $active ? 'active' : NULL, 'title' => $category->name]);
            $level = $category->depth;
        }
        for ($i = $level; $i; $i--){
            echo '</li>'.PHP_EOL;
            echo '</ul>'.PHP_EOL;
        }
    }

    private function getActive($category)
    {
        return $this->active && ($this->active->id == $category->id || $this->active->isChildOf($category));
    }


    private function getSuffix($category): string
    {
        /* @var Category $category */
        $descendants = $category->descendants;
        if (!empty($descendants)){
            $suffix = '<i class="fa fa-plus pull-right"></i> ';
        }else{
            $suffix = '';
        }
        return $suffix;
    }
}