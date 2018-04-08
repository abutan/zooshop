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
                <a href="<?= Html::encode(Url::to(['/cabinet/profile/edit'])) ?>" class="list-group-item">
                    Редактировать профиль
                </a>
                <a href="<?= Html::encode(Url::to(['/auth/reset/request'])) ?>" class="list-group-item">
                    Изменить пароль
                </a>
                <a href="<?= Html::encode(Url::to(['/cabinet/whishlist/index'])) ?>" class="list-group-item">
                    Избранное (лист желаний)
                </a>
                <a href="<?= Html::encode(Url::to(['/cabinet/order/index'])) ?>" class="list-group-item">
                    История заказов
                </a>
                <?php if (Yii::$app->user->identity['subscribe'] == 0): ?>
                <a href="<?= Html::encode(Url::to(['/cabinet/subscribe/subscribe'])) ?>" class="list-group-item">
                    Управление подписками
                </a>
                <?php else: ?>
                <a href="<?= Html::encode(Url::to(['/cabinet/subscribe/un-subscribe'])) ?>" class="list-group-item">
                    Управление подписками
                </a>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>
<?php $this->endContent() ?>
