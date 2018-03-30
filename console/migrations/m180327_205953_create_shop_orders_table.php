<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_orders`.
 */
class m180327_205953_create_shop_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'delivery_method_id' => $this->integer(),
            'delivery_method_name' => $this->string()->notNull(),
            'delivery_cost' => $this->integer()->notNull(),
            'payment_method' => $this->string(),
            'cost' => $this->integer()->notNull(),
            'note' => $this->text(),
            'cancel_reason' => $this->text(),
            'status' => $this->integer(),
            'customer_phone' => $this->string(),
            'customer_name' => $this->string(),
            'delivery_address' => $this->text(),
            'delivery_index' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_orders-user}}', '{{%shop_orders}}', 'user_id');
        $this->createIndex('{{%idx-shop_orders-delivery-method}}', '{{%shop_orders}}', 'delivery_method_id');

        $this->addForeignKey('{{%fk-shop_orders-user-id-id}}', '{{%shop_orders}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-shop_orders-delivery-method-id-id}}', '{{%shop_orders}}', 'delivery_method_id', '{{%shop_delivery_methods}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_orders}}');
    }
}
