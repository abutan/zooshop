<?php

use yii\db\Migration;

/**
 * Handles adding subscribe to table `users`.
 */
class m180408_081711_add_subscribe_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'subscribe', $this->smallInteger()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'subscribe');
    }
}
