<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <?= $content ?>
        </div>
        <aside class="col-sm-3 cabinet-layout">
            <div class="list-group">
                <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>" class="list-group-item">
                    Личные данные
                </a>
            </div>
        </aside>
    </div>
</div>
<?php $this->endContent() ?>
