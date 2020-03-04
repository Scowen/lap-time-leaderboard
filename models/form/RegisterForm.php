<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Log;

class RegisterForm extends Model
{
    public $emailAddress;
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['emailAddress', 'password', 'confirmPassword'], 'required'],
            ['password', 'match', 'pattern' => '/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', 'message' => 'Your password must contain a lowercase letter, an uppercase letter and a digit.'],
            ['emailAddress', 'email'],
            ['emailAddress', 'validateEmailAddress'],
            ['password', 'string', 'min' => 8],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function validateEmailAddress($attribute, $params, $validator)
    {
        $exists = User::find()->where(['username' => $attribute])->exists();

        if ($exists)
            $this->addError($attribute, 'An account already exists');
    }
}
