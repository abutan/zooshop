<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_values`.
 */
class m180310_133028_create_product_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_values}}', [
            'product_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-product_values}}', '{{%product_values}}', ['product_id', 'characteristic_id']);

        $this->createIndex('{{%idx-product_values-product}}', '{{%product_values}}', 'product_id');
        $this->createIndex('{{%idx-product_values-characteristic_id}}', '{{%product_values}}', 'characteristic_id');

        $this->addForeignKey('{{%fk-product_values-product-id-id}}', '{{%product_values}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-product_values-characteristic-id-id}}', '{{%product_values}}', 'characteristic_id', '{{%characteristics}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{product_values}}');
    }
}
