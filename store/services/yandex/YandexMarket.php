<?php

namespace store\services\yandex;


use store\entities\shop\DeliveryMethod;
use store\frontModels\shop\CategoryReadRepository;
use store\frontModels\shop\DeliveryMethodReadRepository;
use store\frontModels\shop\ProductReadRepository;
use yii\helpers\Html;

class YandexMarket
{
    private $shop;
    private $categories;
    private $products;
    private $deliveryMethods;

    public function __construct(ShopInfo $shop, ProductReadRepository $products, DeliveryMethodReadRepository $deliveryMethods, CategoryReadRepository $categories)
    {
        $this->shop = $shop;
        $this->products = $products;
        $this->deliveryMethods = $deliveryMethods;
        $this->categories = $categories;
    }

    public function generate(callable $productUrlGenerator): string
    {
        ob_start();

        $writer = new \XMLWriter();
        $writer->openURI('php://output');

        $writer->startDocument('1.0', 'UTF-8');
        $writer->startDTD('yml_catalog SYSTEM "shops.dtd"');
        $writer->endDTD();

        $writer->startElement('yml_catalog');
        $writer->writeAttribute('date', date('Y-m-d H:i'));

        $writer->startElement('shop');
        $writer->writeElement('name', Html::encode($this->shop->name));
        $writer->writeElement('company', Html::encode($this->shop->company));
        $writer->writeElement('url', Html::encode($this->shop->url));

        $writer->startElement('currencies');

        $writer->startElement('currency');
        $writer->writeAttribute('id', 'RUR');
        $writer->writeAttribute('rate', 1);
        $writer->endElement();/* currency */

        $writer->endElement();/* currencies */

        $writer->startElement('categories');

        foreach ($this->categories->getAll() as $category){
            $writer->startElement('category');
            $writer->writeElement('id', $category->id);
            if ($category->parent_id !== 1){
                $writer->writeElement('parentId', $category->parent_id);
            }
            $writer->writeRaw(Html::encode($category->name));
            $writer->endElement();/* category */
        }

        $writer->endElement();/* categories */

        $writer->startElement('offers');

        $deliveries = $this->deliveryMethods->getAll();

        foreach ($this->products->getAllIterator() as $product){
            $writer->startElement('offer');

            $writer->writeAttribute('id', $product->id);
            $writer->writeAttribute('type', 'vendor.model');
            $writer->writeAttribute('available', $product->isAvailable() ? 'true' : 'false');

            $writer->writeElement('url', Html::encode($productUrlGenerator($product)));
            $writer->writeElement('price', $product->price_new);
            $writer->writeElement('currencyId', 'RUR');
            $writer->writeElement('categoryId', $product->category_id);

            $available = array_filter($deliveries, function (DeliveryMethod $method) use ($product){
                return $method->isAvailableForDeliveryMethod($product->weight, $product->price_new);
            });

            if ($available){
                $writer->writeElement('delivery', 'true');
                $writer->writeElement('local_delivery_cost', max(array_map(function (DeliveryMethod $method) use($product){
                    return $method->cost;
                }, $available)));
            }else{
                $writer->writeElement('delivery', 'false');
            }

            $writer->writeElement('vendor', Html::encode($product->brand->name));
            $writer->writeElement('model', Html::encode($product->code));
            $writer->writeElement('description', Html::encode(strip_tags($product->body)));

            foreach ($product->productValues as $value){
                if (!empty($value->value)){
                    $writer->startElement('param');
                    $writer->writeAttribute('name', $value->characteristic->name);
                    $writer->text($value->value);
                    $writer->endElement(); /* param */
                }
            }

            $writer->endElement(); /* offer */
        }

        $writer->endElement();/* offers */

        $writer->fullEndElement(); /* shop */
        $writer->fullEndElement(); /* yml_catalog */

        $writer->endDocument();

        return ob_get_clean();
    }
}