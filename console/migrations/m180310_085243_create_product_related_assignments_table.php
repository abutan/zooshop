<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_related_assignments`.
 */
class m180310_085243_create_product_related_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_related_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'related_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-product_related_assignments}}', '{{%product_related_assignments}}', ['product_id', 'related_id']);

        $this->createIndex('{{%idx-product_related_assignments-product-id}}', '{{%product_related_assignments}}', 'product_id');
        $this->createIndex('{{%idx-product_related_assignments-related-id}}', '{{%product_related_assignments}}', 'related_id');

        $this->addForeignKey('{{%fk-product_related_assignments-product-id-id}}', '{{%product_related_assignments}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-product_related_assignments-related-id-id}}', '{{%product_related_assignments}}', 'related_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_related_assignments}}');
    }
}
