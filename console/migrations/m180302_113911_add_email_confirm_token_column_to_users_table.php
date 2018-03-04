<?php

use yii\db\Migration;

/**
 * Handles adding email_confirm_token to table `users`.
 */
class m180302_113911_add_email_confirm_token_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'email_confirm_token', $this->string()->unique()->after('email'));
        $this->addColumn('{{%users}}', 'phone', $this->string()->after('username'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'email_confirm_token');
        $this->dropColumn('{{%users}}', 'phone');
    }
}
