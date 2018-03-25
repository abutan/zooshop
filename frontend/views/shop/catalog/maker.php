<?php
/* @var $this \yii\web\View */
/* @var $maker null|\store\entities\shop\Maker */
/* @var $dataProvider \yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $maker->getTitle();

$this->params['breadcrumbs'][] = $maker->name;
?>

    <h1><?= Html::encode($maker->name) ?></h1>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

    <div class="product-description">
        <?=
        Yii::$app->formatter->asHtml($maker->description, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ])
        ?>
    </div>

<?=
$this->render('_list', [
    'dataProvider' => $dataProvider
])
?>