<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $maker store\entities\shop\Maker */
/* @var $model \store\forms\manage\shop\MakerManageForm */

$this->title = 'Редактирование производителя: '. $maker->name;
$this->params['breadcrumbs'][] = ['label' => 'Производители', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $maker->name, 'url' => ['view', 'id' => $maker->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="maker-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
