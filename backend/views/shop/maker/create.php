<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\MakerManageForm */

$this->title = 'Добавление производителя';
$this->params['breadcrumbs'][] = ['label' => 'Производители', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maker-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
