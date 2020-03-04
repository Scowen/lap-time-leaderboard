<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_ip".
 *
 * @property integer $id
 * @property integer $user
 * @property string $ip
 * @property integer $created
 * @property integer $last
 */
class UserIp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'ip', 'created', 'last'], 'required'],
            [['user', 'created', 'last'], 'integer'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'ip' => 'Ip',
            'created' => 'Created',
            'last' => 'Last',
        ];
    }

    public function getIps()
    {
        return $this->hasMany(UserIp::className(), ['user' => 'user']);
    }

    public function getUser()
    {
        return $this->hasOne(UserIp::className(), ['id' => 'user']);
    }
}
