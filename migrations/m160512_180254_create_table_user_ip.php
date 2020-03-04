<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_user_ip`.
 */
class m160512_180254_create_table_user_ip extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{user_ip}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'ip' => $this->string()->notNull(),
            'created' => $this->integer()->notNull(),
            'last' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{user_ip}}');
    }
}
