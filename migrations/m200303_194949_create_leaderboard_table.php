<?php

use yii\db\Migration;

/**
 * Handles the creation of table `leaderboard`.
 */
class m200303_194949_create_leaderboard_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('leaderboard', [
            'id' => $this->primaryKey(),
            'owner' => $this->integer()->notNull(),
            'public' => $this->boolean()->defaultValue(false)->comment("1 = public, 0 = private, null = unlisted (private)"),
            'add' => $this->boolean()->notNull()->defaultValue(false)->comment("If anyone can add lap times"),
            'edit' => $this->boolean()->notNull()->defaultValue(false)->comment("If anyone can edit lap times"),
            'delete' => $this->boolean()->notNull()->defaultValue(false)->comment("If anyone can delete lap times"),
            'name' => $this->string(80),
            'track' => $this->integer(),
            'notify_owner' => $this->boolean()->notNull()->defaultValue(false)->comment("Notify the owner via email if anything chanes that isn't them"),
            'created' => $this->integer()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(true),
        ]);

        $this->createTable('track', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'country' => $this->string(),
            'city' => $this->string(),
            'year_built' => $this->integer(),
            'created' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
        ]);

        $this->createTable('leaderboard_user', [
            'id' => $this->primaryKey(),
            'leaderboard' => $this->integer()->notNull(),
            'user' => $this->integer(),
            'name' => $this->string(75),
            'notify' => $this->string()->comment("all, above, top_3"),
            'created' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
        ]);

        $this->createTable('vehicle', [
            'id' => $this->primaryKey(),
            'make' => $this->string(),
            'model' => $this->string(),
            'colour' => $this->string(),
            'created' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
        ]);

        $this->createTable('leaderboard_vehicle', [
            'id' => $this->primaryKey(),
            'leaderboard' => $this->integer()->notNull(),
            'vehicle' => $this->integer()->notNull(),
            'created' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
        ]);

        $this->createTable('leaderboard_time', [
            'id' => $this->primaryKey(),
            'leaderboard_user' => $this->integer()->notNull(),
            'vehicle' => $this->integer()->notNull(),
            'milliseconds' => $this->double()->notNull(),
            'created' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('leaderboard');
        $this->dropTable('track');
        $this->dropTable('leaderboard_user');
        $this->dropTable('vehicle');
        $this->dropTable('leaderboard_vehicle');
        $this->dropTable('leaderboard_time');
    }
}
