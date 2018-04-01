<?php

/* @var $product null|\store\entities\shop\product\Product */
/* @var $this \yii\web\View */

?>

<div class="values-table container-fluid">

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tbody>
            <?php foreach ($product->productValues as $productValue): ?>
                <tr>
                    <td><strong><?= $productValue->characteristic->name ?></strong></td>
                    <td><?= $productValue->value ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
