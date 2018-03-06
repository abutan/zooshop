<?php
/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $content ?>
        </div>
    </div>

<?php $this->endContent() ?>