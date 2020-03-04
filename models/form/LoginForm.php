<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Log;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'string'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) 
                $this->addError($attribute, 'Incorrect username or password.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $user = $this->getUser();

        if ($user && $user->password && !$this->password) {
            $this->addError('password', 'Please supply a password.');

            return false;
        }

        if ($this->validate()) {
            $log = new \app\models\Log;
            $log->attributes = [
                'severity' => 0,
                'type' => 'LOGIN',
                'user' => $user->id,
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'url' => Yii::$app->request->url,
                'description' => 'User logged in.',
                'serialized' => serialize($user->attributes),
            ];
            $log->save();

            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->where(['username' => $this->username])
                ->orWhere(['email' => $this->username])
                ->one();
        }

        return $this->_user;
    }
}
