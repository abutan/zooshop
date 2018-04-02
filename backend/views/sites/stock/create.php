<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\site\StockForm */

$this->title = 'Добавление акции (скидки)';
$this->params['breadcrumbs'][] = ['label' => 'Акции (скидки)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
