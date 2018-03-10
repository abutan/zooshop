<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_modifications`.
 */
class m180310_123508_create_product_modifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_modifications}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'price' => $this->integer()->notNull(),
            'image' => $this->string(),
        ]);

        $this->createIndex('{{%idx-product_modifications-product-id}}', '{{%product_modifications}}', 'product_id');
        $this->createIndex('{{%idx-product_modifications-code}}', '{{%product_modifications}}', 'code');
        $this->createIndex('{{%idx-product_modifications-product-id-code}}', '{{%product_modifications}}', ['product_id', 'code'], true);

        $this->addForeignKey('{{%fk-product_modifications-product-id-id}}', '{{%product_modifications}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_modifications}}');
    }
}
