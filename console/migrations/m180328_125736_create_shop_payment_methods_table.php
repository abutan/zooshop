<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_payment_methods`.
 */
class m180328_125736_create_shop_payment_methods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_payment_methods}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_payment_methods}}');
    }
}
