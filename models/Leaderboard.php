<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leaderboard".
 *
 * @property int $id
 * @property int $owner
 * @property int|null $public 1 = public, 0 = private, null = unlisted (private)
 * @property int $add If anyone can add lap times
 * @property int $edit If anyone can edit lap times
 * @property int $delete If anyone can delete lap times
 * @property string|null $name
 * @property int|null $track
 * @property int $notify_owner Notify the owner via email if anything chanes that isn't them
 * @property int $created
 * @property int $active
 */
class Leaderboard extends \yii\db\ActiveRecord
{
    public static $publicTypes = [
        null => 'Unlisted (anyone with link can view)',
        0 => 'Private (only you can view)',
        1 => 'Public (anyone can view)',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leaderboard';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner', 'created'], 'required'],
            [['owner', 'public', 'add', 'edit', 'delete', 'track', 'notify_owner', 'created', 'active'], 'integer'],
            [['name'], 'string', 'min' => 5, 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner' => 'Owner',
            'public' => 'Leaderboard Privacy',
            'add' => 'Allow anyone to ADD their times?',
            'edit' => 'Allow anyone to EDIT their times?',
            'delete' => 'Allow anyone to DELETE their times?',
            'name' => 'Name of Leaderboard',
            'track' => 'Track',
            'notify_owner' => 'Would you like to be notified?',
            'created' => 'Created',
            'active' => 'Active',
        ];
    }

    public function getOwnerUserObject()
    {
        return $this->hasOne(User::className(), ['owner' => 'id']);
    }

    public function getLeaderboardTimeObjects()
    {
        return $this->hasMany(LeaderboardTime::className(), ['leaderboard' => 'id']);
    }

    public function getLeaderboardUserObjects()
    {
        return $this->hasMany(LeaderboardUser::className(), ['leaderboard' => 'id']);
    }

    public function getLeaderboardUserArray()
    {
        $array = [];
        foreach ($this->leaderboardUserObjects as $leaderboardUserObject)
            $array[$leaderboardUserObject->id] = $leaderboardUserObject->name;
        return $array;
    }

    public function getLeaderboardVehicleObjects()
    {
        return $this->hasMany(LeaderboardVehicle::className(), ['leaderboard' => 'id']);
    }

    public function getLeaderboardVehicleArray()
    {
        $array = [];
        foreach ($this->leaderboardVehicleObjects as $leaderboardVehicleObject)
            $array[$leaderboardVehicleObject->id] = "$leaderboardVehicleObject->make $leaderboardVehicleObject->model";
        return $array;
    }
}
