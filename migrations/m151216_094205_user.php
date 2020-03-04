<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_094205_user extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{user}}',
            array(
                'id' => $this->primaryKey(),
                'username' => $this->string(128)->notNull(),
                'password' => $this->text(),
                'authKey' => $this->text(),
                'accessToken' => $this->text(),
                'created' => $this->integer()->notNull(),
                'email' => $this->string(128),
                'root' => $this->boolean()->defaultValue(false)->notNull(),
                'active' => $this->boolean()->defaultValue(true)->notNull(),
            ),
            implode(' ', array(
                'ENGINE          = InnoDB',
                'DEFAULT CHARSET = utf8',
                'COLLATE         = utf8_general_ci',
                'COMMENT         = ""',
                'AUTO_INCREMENT  = 1',
            ))
        );
    }

    public function down()
    {   
        $this->dropTable("{{user}}");

        return true;
    }
}
