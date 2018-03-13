<?php

use yii\db\Migration;

/**
 * Handles adding product_id to table `product_reviews`.
 */
class m180311_110820_add_product_id_column_to_product_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_reviews}}', 'product_id', $this->integer()->after('user_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_reviews}}', 'product_id');
    }
}
