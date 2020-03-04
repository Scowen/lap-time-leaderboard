<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken

 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    private $savedCustomerObject = null;
    private $savedGroupObject = null;
    private $explodedPermissions = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'created'], 'required'],
            ['password', 'match', 'pattern' => '/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', 'message' => 'Your password must contain a lowercase letter, an uppercase letter and a digit.'],
            [['password', 'authKey', 'accessToken', 'email'], 'string'],
            [['created', 'root', 'active'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username / Email',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'created' => 'Created',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $dbUser = User::find()
                ->where([
                    "id" => $id
                ])
                ->one();
        if (!$dbUser) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $userType = null) {
        $dbUser = User::find()
                ->where(["accessToken" => $token])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $dbUser = User::find()
                ->where([
                    "username" => $username
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * Finds user by email
     *
     * @param  string      $email
     * @return static|null
     */
    public static function findByEmail($email) {
        $dbUser = User::find()
                ->where([
                    "email" => $email
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($this->password != null)
            return (Yii::$app->getSecurity()->validatePassword($password, $this->password));
        else 
            return true;
    }

    public function getIps()
    {
        return $this->hasMany(UserIp::className(), ['user' => 'id'])->orderBy(['last' => SORT_DESC]);
    }

    public function getIp()
    {
        return $this->hasOne(UserIp::className(), ['user' => 'id'])->orderBy(['last' => SORT_DESC]);
    }

    public function getLastIp()
    {
        return UserIp::find()->where(['user' => $this->id])
            ->orderBy(['last' => SORT_DESC])
            ->one();
    }
}
