<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\CharacteristicForm */
/* @var $characteristic \store\entities\shop\Characteristic */

$this->title = 'Редактирование атрибута: ' . $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $characteristic->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="characteristic-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
