<?php

namespace frontend\urls;


use store\frontModels\shop\ProductReadRepository;
use yii\base\BaseObject;
use yii\caching\Cache;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class ProductUrlRules extends BaseObject implements UrlRuleInterface
{
    private $repository;
    private $cache;

    public function __construct(ProductReadRepository $repository, Cache $cache, array $config = []) {
        parent::__construct($config);
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function parseRequest($manager, $request) {
        $path = $request->pathInfo;
        $result = $this->cache->getOrSet(['vet_product_route', 'path' => $path], function () use ($path){
            if (!$product = $this->repository->findBySlug($path)){
                return ['id' => NULL, 'path' => NULL];
            }
            return ['id' => $product->id, 'path' => $product->slug];
        });

        if (empty($result['id'])){
            return FALSE;
        }

        if ($path != $result['path']){
            throw new UrlNormalizerRedirectException(['shop/catalog/product', 'id' => $result['id']]);
        }

        return ['shop/catalog/product', ['id' => $result['id']]];
    }

    public function createUrl($manager, $route, $params) {
        if ($route == 'shop/catalog/product'){
            if (empty($params['id'])){
                throw new \InvalidArgumentException('Отсутствует обязательный параметр id');
            }
            $id = $params['id'];

            $url = $this->cache->getOrSet(['vet_product_route', 'id' => $id], function () use ($id){
                if (!$product = $this->repository->find($id)){
                    return NULL;
                }
                return $product->slug;
            });

            unset($params['id']);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }

            return $url;
        }
        return FALSE;
    }
}