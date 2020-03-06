<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leaderboard_vehicle".
 *
 * @property int $id
 * @property int $leaderboard
 * @property int $vehicle
 * @property int $created
 * @property int|null $created_by
 */
class LeaderboardVehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leaderboard_vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leaderboard', 'vehicle', 'created'], 'required'],
            [['leaderboard', 'vehicle', 'created', 'created_by'], 'integer'],
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
            'vehicle' => 'Vehicle',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }

    public function getLeaderboardObject()
    {
        return $this->hasOne(Leaderboard::className(), ['leaderboard' => 'id']);
    }

    public function getVehicleObject()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle']);
    }


    public function getCreatedByUserObject()
    {
        return $this->hasOne(User::className(), ['created_by' => 'id']);
    }
}
