<?php

use yii\db\Migration;

/**
 * Class m200304_172013_add_column_to_user
 */
class m200304_172013_add_column_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user", "display_name", $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("user", "display_name");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200304_172013_add_column_to_user cannot be reverted.\n";

        return false;
    }
    */
}
