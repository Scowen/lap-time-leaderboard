<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leaderboard_time".
 *
 * @property int $id
 * @property int $leaderboard
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
            [['leaderboard', 'leaderboard_user', 'vehicle', 'milliseconds', 'created'], 'required'],
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
            'leaderboard' => 'Leaderboard',
            'leaderboard_user' => 'Leaderboard User',
            'vehicle' => 'Vehicle',
            'milliseconds' => 'Milliseconds',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }

    public function getLeaderboardObject()
    {
        return $this->hasOne(Leaderboard::className(), ['id' => 'leaderboard']);
    }

    public function getLeaderboardUserObject()
    {
        return $this->hasOne(LeaderboardUser::className(), ['id' => 'leaderboard_user']);
    }

    public function getVehicleObject()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle']);
    }

    public function getCreatedByUserObject()
    {
        return $this->hasOne(User::className(), ['created_by' => 'id']);
    }

    public function getTime()
    {
        $input = $this->milliseconds;
        $input = floor($input / 1000);
        $milliseconds = $this->milliseconds - (floor($this->milliseconds / 1000) * 1000);

        $seconds = $input % 60;
        $input = floor($input / 60);

        $minutes = $input % 60;
        $input = floor($input / 60); 

        return [
            'minutes' => str_pad($minutes, 2, "0", STR_PAD_LEFT),
            'seconds' => str_pad($seconds, 2, "0", STR_PAD_LEFT),
            'milliseconds' => str_pad($milliseconds, 3, "0"),
        ];
    }

    public static function getTrColour($position)
    {
        if ($position == 1) return "#fff9dc";
        if ($position == 2) return "#e4e3e8";
        if ($position == 3) return "#ecd7c5";

        return "inherit";
    }

    public function gapTo($milliseconds)
    {
        $gap = ($this->milliseconds - $milliseconds) / 1000;

        return ($gap > 0 ? '+' : $gap < 0 ? '-' : '') . number_format($gap, 3);
    }
}
