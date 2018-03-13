<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site_articles`.
 */
class m180313_135719_create_site_articles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%site_articles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'summary' => $this->text(),
            'body' => $this->text(),
            'slug' => $this->string(),
            'status' => $this->smallInteger(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-site_articles-slug}}', '{{%site_articles}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_articles}}');
    }
}
