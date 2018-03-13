<?php

use yii\db\Migration;

/**
 * Handles adding quantity to table `product_modifications`.
 */
class m180311_080152_add_quantity_column_to_product_modifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_modifications}}', 'quantity', $this->integer()->after('price'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_modifications}}', 'quantity');
    }
}
