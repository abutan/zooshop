<?php

use yii\db\Migration;

/**
 * Class m180302_115602_change_users_fields_requirements
 */
class m180302_115602_change_users_fields_requirements extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('{{%users}}', 'username', $this->string());
        $this->alterColumn('{{%users}}', 'password_hash', $this->string());
        $this->alterColumn('{{%users}}', 'email', $this->string());
    }

    public function down()
    {
        $this->alterColumn('{{%users}}', 'username', $this->string()->notNull());
        $this->alterColumn('{{%users}}', 'password_hash', $this->string()->notNull());
        $this->alterColumn('{{%users}}', 'email', $this->string()->notNull());
    }
}
