<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_reviews`.
 */
class m180310_130511_create_product_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'active' => $this->boolean(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-product_reviews-user}}', '{{%product_reviews}}', 'user_id');

        $this->addForeignKey('{{%fk-product_reviews-user-id-id}}', '{{%product_reviews}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_reviews}}');
    }
}
