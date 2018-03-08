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
        $this->createTable('shop_categories', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('shop_categories');
    }
}
