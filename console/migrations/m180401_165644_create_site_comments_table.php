<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site_comments`.
 */
class m180401_165644_create_site_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%site_comments}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'text' => $this->text(),
            'parent_id' => $this->integer(),
            'created_at' => $this->integer()->unsigned(),
            'status' => $this->boolean()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-site_comments-user}}', '{{%site_comments}}', 'user_id');
        $this->createIndex('{{%idx-site_comments-parent}}', '{{%site_comments}}', 'parent_id');

        $this->addForeignKey('{{%fk-site_comments-user-id-id}}', '{{%site_comments}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-site_comments-parent-id-id}}', '{{%site_comments}}', 'parent_id', '{{%site_comments}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_comments}}');
    }
}
