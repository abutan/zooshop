<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_categories`.
 */
class m180308_070713_create_shop_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'parent_id' => $this->integer(),
            'body' => $this->text(),
            'slug' => $this->string(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop-categories-slug}}', '{{%shop_categories}}', 'slug', TRUE);

        $this->insert('{{%shop_categories}}', [
            'id' => 1,
            'name' => '',
            'parent_id' => null,
            'body' => null,
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'keywords' => null,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_categories}}');
    }
}
