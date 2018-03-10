<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_products`.
 */
class m180309_200934_create_shop_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_products}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'maker_id' => $this->integer()->notNull(),
            'body' => $this->text(),
            'price_old' => $this->integer(),
            'price_new' => $this->integer()->notNull(),
            'weight' => $this->float()->defaultValue(0)->notNull(),
            'quantity' => $this->integer()->notNull(),
            'rating' => $this->decimal(3, 2),
            'slug' => $this->string(),
            'status' => $this->smallInteger(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_products-code}}', '{{%shop_products}}', 'code');
        $this->createIndex('{{%idx-shop_products-category-id}}', '{{%shop_products}}', 'category_id');
        $this->createIndex('{{%idx-shop_products-brand-id}}', '{{%shop_products}}', 'brand_id');
        $this->createIndex('{{%idx-shop_products-maker-id}}', '{{%shop_products}}', 'maker_id');
        $this->createIndex('{{%idx-shop_products-slug}}', '{{%shop_products}}', 'slug');

        $this->addForeignKey('{{%fk-shop_products-category-id-id}}', '{{%shop_products}}', 'category_id', '{{%shop_categories}}', 'id');
        $this->addForeignKey('{{%fk-shop_products-brand-id-id}}', '{{%shop_products}}', 'brand_id', '{{%product_brands}}', 'id');
        $this->addForeignKey('{{%fk-shop_products-maker-id-id}}', '{{%shop_products}}', 'maker_id', '{{%product_makers}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_products}}');
    }
}
