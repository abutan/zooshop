<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $category null|\store\entities\shop\Category */
/* @var $tagData array */
/* @var $brandData array */
/* @var $makerData array */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Select2;
use frontend\widgets\site\CategorySlider;

$this->title = $category->getTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $category->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $category->keywords]);

foreach ($category->parents as $parent){
    if (!$parent->isRoot()){
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = $category->name;
$this->params['active_category'] = $category;

?>

    <h1 class="text-center"><?= Html::encode($category->name) ?></h1>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<div class="search-widget">
    <?= Html::beginForm(['/shop/catalog/fast'], 'get', ['class' => 'form-inline']) ?>
    <div class="row">
        <div class="col-sm-1">
            <strong>Поиск</strong>
        </div>
        <div class="col-sm-3">
            <?=
            Select2::widget([
                'name' => 'maker',
                'data' => $makerData,
                'theme' => Select2::THEME_KRAJEE,
                'options' => ['placeholder' => 'Производители ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>
        <div class="col-sm-3">
            <?=
            Select2::widget([
                'name' => 'brand',
                'data' => $brandData,
                'theme' => Select2::THEME_KRAJEE,
                'options' => ['placeholder' => 'Бренды ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>
        <div class="col-sm-3">
            <?=
            Select2::widget([
                'name' => 'tag',
                'data' => $tagData,
                'theme' => Select2::THEME_KRAJEE,
                'options' => ['placeholder' => 'Выберите метку ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton('Искать', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>

<?= CategorySlider::widget([
    'category' => $category
]) ?>

<?=
$this->render('_subcategories', [
        'category' => $category]
)
?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>

<?php if (trim($category->description)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Yii::$app->formatter->asHtml($category->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
<?php endif; ?>
