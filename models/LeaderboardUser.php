<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leaderboard_user".
 *
 * @property int $id
 * @property int $leaderboard
 * @property int|null $user
 * @property string|null $name
 * @property string|null $notify all, above, top_3
 * @property int $created
 * @property int|null $created_by
 */
class LeaderboardUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leaderboard_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leaderboard', 'created'], 'required'],
            [['leaderboard', 'user', 'created', 'created_by'], 'integer'],
            [['name'], 'string', 'max' => 75],
            [['notify'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leaderboard' => 'Leaderboard',
            'user' => 'User',
            'name' => 'Name',
            'notify' => 'Notify',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }

    public function getLeaderboardObject()
    {
        return $this->hasOne(Leaderboard::className(), ['leaderboard' => 'id']);
    }

    public function getUserObject()
    {
        return $this->hasOne(User::className(), ['user' => 'id']);
    }

    public function getCreatedByUserObject()
    {
        return $this->hasOne(User::className(), ['created_by' => 'id']);
    }
}
