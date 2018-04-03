<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site_notifications`.
 */
class m180403_185456_create_site_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%site_notifications}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'summary' => $this->text(),
            'body' => $this->text(),
            'slug' => $this->string(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_notifications}}');
    }
}
