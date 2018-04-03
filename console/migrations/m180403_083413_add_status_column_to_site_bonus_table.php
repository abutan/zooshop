<?php

use yii\db\Migration;

/**
 * Handles adding status to table `site_bonus`.
 */
class m180403_083413_add_status_column_to_site_bonus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%site_bonus}}', 'status', $this->smallInteger()->after('slug'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%site_bonus}}', 'status');
    }
}
