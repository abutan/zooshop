<?php

namespace frontend\urls;


use store\entities\shop\Category;
use store\frontModels\shop\CategoryReadRepository;
use yii\base\BaseObject;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class CategoryUrlRules extends BaseObject implements UrlRuleInterface
{
    public $prefix = 'catalog';

    private $repository;
    private $cache;

    public function __construct(CategoryReadRepository $repository, Cache $cache, array $config = []) {
        parent::__construct($config);
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function parseRequest($manager, $request) {
        if (preg_match('#^'.$this->prefix.'/(.*[a-z])$#is', $request->pathInfo, $matches)){
            $path = $matches[1];

            $result = $this->cache->getOrSet(['vet_category_route', 'path' => $path], function () use ($path){
                if (!$category = $this->repository->findBySlug($this->getPathSlug($path))){
                    return ['id' => NULL, 'path' => NULL];
                }
                return ['id' => $category->id, 'path' => $this->getCategoryPath($category)];
            }, NULL, new TagDependency(['tags' => ['categories']]));

            if (empty($result['id'])){
                return FALSE;
            }

            if ($path != $result['path']){
                throw new UrlNormalizerRedirectException(['shop/catalog/category', 'id' => $result['id'], 301]);
            }
            return ['/shop/catalog/category', ['id' => $result['id']]];
        }
        return FALSE;
    }

    public function createUrl($manager, $route, $params) {
        if ($route == 'shop/catalog/category'){
            if (empty($params['id'])){
                throw new \InvalidArgumentException('Отсутствует обязательный параметр id');
            }
            $id = $params['id'];

            $url = $this->cache->getOrSet(['vet_category_route', 'id' => $id], function () use ($id){
                if (!$category = $this->repository->find($id)){
                    return NULL;
                }
                return $this->getCategoryPath($category);
            }, NULL, new TagDependency(['tags' => ['categories']]));

            if (!$url){
                throw new \InvalidArgumentException('Несуществующий id');
            }

            $url = $this->prefix.'/'.$url;

            unset($params['id']);
            if (!empty($params) && ($query = http_build_query($params))){
                $url .= '?'.$query;
            }
            return $url;
        }
        return FALSE;
    }

    private function getPathSlug($path)
    {
        $shunks = explode('/', $path);
        return end($shunks);
    }

    public function getCategoryPath(Category $category)
    {
        $shunks  = ArrayHelper::getColumn($category->getParents()->andWhere(['>', 'depth', 0])->all(), 'slug');
        $shunks[] = $category->slug;
        return implode('/', $shunks);
    }
}