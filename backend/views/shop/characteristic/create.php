<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\CharacteristicForm */

$this->title = 'Добавление атрибута';
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
