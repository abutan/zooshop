<?php
/* @var $this \yii\web\View */
/* @var $userName  */
/* @var $userId int|string */
/* @var $email  */
/* @var $phone  */
/* @var $created  */

//use Yii;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = 'Личный кабинет пользователя';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-index container-fluid">
    <h2>Здравствуйте <small><?= Yii::$app->user->identity['username'] ?: 'пользователь '. Yii::$app->user->id ?></small></h2>

    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tr>
                <td><strong>Зарегистрирован</strong></td>
                <td><?= \Yii::$app->formatter->asDatetime($created) ?></td>
            </tr>
            <tr>
                <td>
                    <strong>Логин</strong>
                </td>
                <td>
                    <?php if ($userName): ?>
                    <?= $userName ?>
                    <?php else: ?>
                    Пользователь <?= $userId ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>
                    <?php if ($email): ?>
                    <?= $email ?>
                    <?php else: ?>
                    Заполните данные <a href="<?= Url::to(['/cabinet/profile/edit']) ?>" target="_blank">своего профиля</a>, для получения оповещения.
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Телефон</strong></td>
                <td>
                    <?php if ($phone): ?>
                    <?= $phone ?>
                    <?php else: ?>
                        Заполните данные <a href="<?= Url::to(['/cabinet/profile/edit']) ?>" target="_blank">своего профиля</a>, для получения оповещения.
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <h4>Добавить к своему профилю социальные сети для входа на сайт</h4>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>
