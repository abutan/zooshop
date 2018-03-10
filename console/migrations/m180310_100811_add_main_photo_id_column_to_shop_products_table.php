<?php

use yii\db\Migration;

/**
 * Handles adding main_photo_id to table `shop_products`.
 */
class m180310_100811_add_main_photo_id_column_to_shop_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_products}}', 'main_photo_id', $this->integer()->after('name'));

        $this->createIndex('{{%idx-shop_products-photo}}', '{{%shop_products}}', 'main_photo_id');

        $this->addForeignKey('{{%fk-shop-products-photo-id-id}}', '{{%shop_products}}', 'main_photo_id', '{{%product_photos}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_products}}', 'main_photo_id');
    }
}
