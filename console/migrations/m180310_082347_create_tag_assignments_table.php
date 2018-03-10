<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag_assignments`.
 */
class m180310_082347_create_tag_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%tag_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-tag_assignments}}', '{{%tag_assignments}}', ['product_id', 'tag_id']);

        $this->createIndex('{{%idx-tag_assignments-product-id}}', '{{%tag_assignments}}', 'product_id');
        $this->createIndex('{{%idx-tag_assignments-tag-id}}', '{{%tag_assignments}}', 'tag_id');

        $this->addForeignKey('{{%fk-tag_assignments-product-id-id}}', '{{%tag_assignments}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-tag_assignments-tag-id-id}}', '{{%tag_assignments}}', 'tag_id', '{{%product_tags}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_assignments}}');
    }
}
