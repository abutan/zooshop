<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site_stocks`.
 */
class m180402_175747_create_site_stocks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%site_stocks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'dateFrom' => $this->string(),
            'dateTo' => $this->string(),
            'summary' => $this->text(),
            'body' => $this->text(),
            'slug' => $this->string(),
            'status' => $this->smallInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_stocks}}');
    }
}
