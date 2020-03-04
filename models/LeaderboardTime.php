<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leaderboard_time".
 *
 * @property int $id
 * @property int $leaderboard_user
 * @property int $vehicle
 * @property float $milliseconds
 * @property int $created
 * @property int|null $created_by
 */
class LeaderboardTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leaderboard_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leaderboard_user', 'vehicle', 'milliseconds', 'created'], 'required'],
            [['leaderboard_user', 'vehicle', 'created', 'created_by'], 'integer'],
            [['milliseconds'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leaderboard_user' => 'Leaderboard User',
            'vehicle' => 'Vehicle',
            'milliseconds' => 'Milliseconds',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }

    public function getLeaderboardUserObject()
    {
        return $this->hasOne(LeaderboardUser::className(), ['leaderboard_user' => 'id']);
    }

    public function getVehicleObject()
    {
        return $this->hasOne(Vehicle::className(), ['vehicle' => 'id']);
    }

    public function getCreatedByUserObject()
    {
        return $this->hasOne(User::className(), ['created_by' => 'id']);
    }
}
