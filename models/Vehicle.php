<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle".
 *
 * @property int $id
 * @property string|null $make
 * @property string|null $model
 * @property string|null $colour
 * @property int $created
 * @property int|null $created_by
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created'], 'required'],
            [['created', 'created_by'], 'integer'],
            [['make', 'model', 'colour'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'make' => 'Make',
            'model' => 'Model',
            'colour' => 'Colour',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }
}
