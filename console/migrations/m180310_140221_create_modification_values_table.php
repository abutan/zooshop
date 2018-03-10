<?php

use yii\db\Migration;

/**
 * Handles the creation of table `modification_values`.
 */
class m180310_140221_create_modification_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%modification_values}}', [
            'modification_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-modification_values}}', '{{%modification_values}}', ['modification_id', 'characteristic_id']);

        $this->createIndex('{{%idx-modification_values-modification}}', '{{%modification_values}}', 'modification_id');
        $this->createIndex('{{%idx-modification_values-characteristic}}', '{{%modification_values}}', 'characteristic_id');

        $this->addForeignKey('{{%fk-modification_values-modification-id-id}}', '{{%modification_values}}', 'modification_id', '{{%product_modifications}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-modification_values-characteristic-id-id}}', '{{%modification_values}}', 'characteristic_id', 'characteristics', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modification_values}}');
    }
}
