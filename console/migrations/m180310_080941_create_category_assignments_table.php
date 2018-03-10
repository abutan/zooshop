<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_assignments`.
 */
class m180310_080941_create_category_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%category_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-category_assignments}}', '{{%category_assignments}}', ['product_id', 'category_id']);

        $this->createIndex('{{%idx-category_assignments-product-id}}', '{{%category_assignments}}', 'product_id');
        $this->createIndex('{{%idx-category_assignments-category-id}}', '{{%category_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-category_assignments-product-id-id}}', '{{%category_assignments}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-category_assignments-category-id-id}}', '{{%category_assignments}}', 'category_id', '{{%shop_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category_assignments}}');
    }
}
