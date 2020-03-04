<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int $severity
 * @property string $type
 * @property int|null $user
 * @property string|null $user_ip
 * @property string|null $url
 * @property string|null $description
 * @property string|null $serialized
 * @property string $created
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['severity', 'type'], 'required'],
            [['severity', 'user'], 'integer'],
            [['description', 'serialized'], 'string'],
            [['created'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['user_ip'], 'string', 'max' => 15],
            [['url'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'severity' => 'Severity',
            'type' => 'Type',
            'user' => 'User',
            'user_ip' => 'User Ip',
            'url' => 'Url',
            'description' => 'Description',
            'serialized' => 'Serialized',
            'created' => 'Created',
        ];
    }
}
