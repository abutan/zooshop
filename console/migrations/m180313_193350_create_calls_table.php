<?php

use yii\db\Migration;

/**
 * Handles the creation of table `calls`.
 */
class m180313_193350_create_calls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%calls}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'status' => $this->smallInteger(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%calls}}');
    }
}
