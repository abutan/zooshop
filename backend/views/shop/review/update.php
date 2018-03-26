<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\product\ReviewEditForm */
/* @var $product \store\entities\shop\product\Product */
/* @var $review \store\entities\shop\product\Review */

$this->title = 'Редактирование отзыва: ' . $review->id;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['/shop/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $review->id;
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="review-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
