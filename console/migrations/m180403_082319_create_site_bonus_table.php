<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site_bonus`.
 */
class m180403_082319_create_site_bonus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%site_bonus}}', [
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
        $this->dropTable('{{%site_bonus}}');
    }
}
