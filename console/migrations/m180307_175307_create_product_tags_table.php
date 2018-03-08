<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_tags`.
 */
class m180307_175307_create_product_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-product_tags-slug}}', '{{%product_tags}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tags}}');
    }
}
