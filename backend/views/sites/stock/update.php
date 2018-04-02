<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\site\StockForm */
/* @var $stock \store\entities\site\Stock */

$this->title = 'Редактирование акции (скидки): ' . $stock->name;
$this->params['breadcrumbs'][] = ['label' => 'Акции (скидки)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $stock->name, 'url' => ['view', 'id' => $stock->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="stock-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
