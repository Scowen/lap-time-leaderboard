<?php

use yii\db\Schema;
use yii\db\Migration;

class m160121_140214_create_table_log extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{log}}',
            array(
                'id'                => $this->primaryKey(),
                'severity'          => $this->integer()->notNull(),
                'type'              => $this->string()->notNull(),
                'user'              => $this->integer(),
                'user_ip'           => $this->string(15),
                'url'               => $this->string(75),
                'description'       => $this->text(),
                'serialized'        => $this->text(),
                'created'           => $this->timestamp()->notNull(),
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
        $this->dropTable('{{log}}');

        return true;
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
