<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $category null|\store\entities\shop\Category */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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

<?=
$this->render('_subcategories', [
        'category' => $category]
)
?>

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

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>