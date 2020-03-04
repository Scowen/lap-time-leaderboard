<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $country
 * @property string|null $city
 * @property int|null $year_built
 * @property int $created
 * @property int|null $created_by
 */
class Track extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year_built', 'created', 'created_by'], 'integer'],
            [['created'], 'required'],
            [['name', 'country', 'city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'country' => 'Country',
            'city' => 'City',
            'year_built' => 'Year Built',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }

    public static function getDropDownList($user = null)
    {
        $array = [null => 'Please Select'];

        $trackObjects = $user ?
            self::find()->where(['created_by' => $user])->orWhere(['IS', 'created_by', null])->all() :
            self::find()->where(['IS', 'created_by', null])->all();

        foreach ($trackObjects as $trackObject)
            $array[$trackObject->id] = $trackObject->name . " " . ($trackObject->year_built ? "($trackObject->year_built)" : "");

        return $array;
    }
}
