<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider|\yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="row select-panel">
    <div class="col-md-2 col-sm-4 hidden-xs">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-default  active" id="grid-view" data-toggle="tooltip" title="Просмотр в виде сетки"><i class="fa fa-th"></i></button>
            <button type="button" class="btn btn-default" id="list-view" data-toggle="tooltip" title="Просмотр списком"><i class="fa fa-th-list"></i></button>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="form-group input-group input-group-sm">
            <label for="sort-input" class="input-group-addon">Сортировать по: </label>
            <select id="sort-input" class="form-control" onchange="location=this.value">
                <?php
                $values = [
                    '' => '',
                    'name' => 'По алфавиту',
                    '-name' => 'В обратном порядке',
                    'price' => 'Увеличению цены',
                    '-price' => 'Уменьшению цены',
                    'rating' => 'Увеличение рейтинга',
                    '-rating' => 'Уменьшение рейтинга',
                ];
                $current = Yii::$app->request->get('sort');
                ?>
                <?php foreach ($values as $value => $label): ?>
                    <option value="<?= Html::encode(Url::current(['sort' => $value ? : NULL])) ?>" <?php if ($current == $value): ?>selected="selected" <?php endif ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="form-group input-group input-group-sm">
            <label for="limit-input" class="input-group-addon">Показывать: </label>
            <select id="limit-input" class="form-control" onchange="location=this.value">
                <?php
                $values = [
                    15, 25, 50, 75, 100
                ];
                $current = $dataProvider->getPagination()->getPageSize();
                ?>
                <?php foreach ($values as $value): ?>
                    <option value="<?= Html::encode(Url::current(['per-page' => $value])) ?>" <?php  if ($current == $value): ?>selected="selected" <?php endif; ?>>
                        <?= $value ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>



<div id="product-panel" class="row product-panel">
    <?php foreach ($dataProvider->getModels() as $product): ?>
        <?= $this->render('_product', [
            'product' => $product,
        ]) ?>
    <?php endforeach; ?>
</div>

<div class="row pagination-panel">
    <div class="col-sm-6 text-left">
        <?=
        LinkPager::widget([
            'pagination' => $dataProvider->getPagination()
        ])
        ?>
    </div>
    <div class="col-sm-6 text-right product-quantity">
        Показано <?= $dataProvider->getCount() ?> товаров из <?= $dataProvider->getTotalCount() ?>
    </div>
</div>