<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_125433_insert_users extends Migration
{
    public function up()
    {
        $this->insert("{{user}}", array(
            'username' => 'Luke',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('password'),
            'email' => "lmscowen@gmail.com",
            'root' => 1,
            'created' => time(),
        ));
    }

    public function down()
    {
        echo "m151216_125433_insert_users cannot be reverted.\n";
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
