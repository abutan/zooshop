<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_photos`.
 */
class m180310_083908_create_product_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-product_photos-product-id}}', '{{%product_photos}}', 'product_id');

        $this->addForeignKey('{{%fk-product_photos-product-id-id}}', '{{%product_photos}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_photos}}');
    }
}
