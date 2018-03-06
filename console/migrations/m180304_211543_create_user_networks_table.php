<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_networks`.
 */
class m180304_211543_create_user_networks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%user_networks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'identity' => $this->string()->notNull(),
            'network' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_networks-identity-network}}', '{{%user_networks}}', ['identity', 'network'], true);
        $this->createIndex('{{%idx-user_networks-user}}', '{{%user_networks}}', 'user_id');

        $this->addForeignKey('{{%fk-user_networks-user-id-id}}', '{{%user_networks}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_networks}}');
    }
}
