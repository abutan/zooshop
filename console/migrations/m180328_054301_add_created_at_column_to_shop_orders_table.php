<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `shop_orders`.
 */
class m180328_054301_add_created_at_column_to_shop_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_orders}}', 'created_at', $this->integer()->after('delivery_index'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_orders}}', 'created_at');
    }
}
