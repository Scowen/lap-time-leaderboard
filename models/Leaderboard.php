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
            [['name'], 'string', 'max' => 80],
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
            'public' => 'Public',
            'add' => 'Add',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'name' => 'Name',
            'track' => 'Track',
            'notify_owner' => 'Notify Owner',
            'created' => 'Created',
            'active' => 'Active',
        ];
    }

    public function getOwnerUserObject()
    {
        return $this->hasOne(User::className(), ['owner' => 'id']);
    }
}
