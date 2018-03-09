<?php

use yii\db\Migration;

/**
 * Handles the creation of table `characteristic`.
 */
class m180309_112017_create_characteristic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%characteristics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'category_id' => $this->integer(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-characteristics-name}}', '{{%characteristics}}', 'name');
        $this->createIndex('{{%idx-characteristics-category-id}}', '{{%characteristics}}', 'category_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%characteristic}}');
    }
}
