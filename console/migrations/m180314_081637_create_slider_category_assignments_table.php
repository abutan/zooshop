<?php

use yii\db\Migration;

/**
 * Handles the creation of table `slider_category_assignments`.
 */
class m180314_081637_create_slider_category_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%slider_category_assignments}}', [
            'slider_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-slider_category_assignments}}', '{{%slider_category_assignments}}', ['slider_id', 'category_id']);

        $this->createIndex('{{%idx-slider_category_assignments-slider}}', '{{%slider_category_assignments}}', 'slider_id');
        $this->createIndex('{{%idx-slider_category_assignments-category}}', '{{%slider_category_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-slider_category_assignments-slider-id-id}}', '{{%slider_category_assignments}}', 'slider_id', '{{%site_sliders}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-slider_category_assignments-category-id-id}}', '{{%slider_category_assignments}}', 'category_id', 'shop_categories', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%slider_category_assignments}}');
    }
}
