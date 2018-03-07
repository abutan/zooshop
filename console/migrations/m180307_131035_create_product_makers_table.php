<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_makers`.
 */
class m180307_131035_create_product_makers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_makers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string(),
            'body' => $this->text(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-product_makers-slug}}', '{{%product_makers}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_makers}}');
    }
}
