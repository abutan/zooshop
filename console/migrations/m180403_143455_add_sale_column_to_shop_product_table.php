<?php

use yii\db\Migration;

/**
 * Handles adding sale to table `shop_product`.
 */
class m180403_143455_add_sale_column_to_shop_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_products}}', 'sale', $this->smallInteger()->after('quantity'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_products}}', 'sale');
    }
}
