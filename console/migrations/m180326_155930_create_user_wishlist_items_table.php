<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_wishlist_items`.
 */
class m180326_155930_create_user_wishlist_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user_wishlist_items}}', [
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%user_wishlist_items-primary}}', '{{%user_wishlist_items}}', ['user_id', 'product_id']);

        $this->createIndex('{{%idx-user_wishlist_items-user-id}}', '{{%user_wishlist_items}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_items-product-id}}', '{{%user_wishlist_items}}', 'product_id');

        $this->addForeignKey('{{%fk-user_wishlist_items-user-id-id}}', '{{%user_wishlist_items}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_items-product-id-id}}', '{{%user_wishlist_items}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_items}}');
    }
}
