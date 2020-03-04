<?php

namespace app\controllers;

date_default_timezone_set("Europe/London");

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\HttpException;

use app\models\form\LoginForm;
use app\models\form\RegisterForm;
use app\models\Log;
use app\models\User;
use app\models\Forgot;

class PublicController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = "public";

        Yii::$app->errorHandler->errorAction = '/public/error';
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->redirect(['/public/login']);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/site/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister() // slick-solutions.com/public/register
    {
        $model = new RegisterForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userObject = new User;
            $userObject->attributes = [
                'username' => $model->emailAddress,
                'password' => Yii::$app->getSecurity()->generatePasswordHash($model->password),
                'created' => time(),
            ];
            $userObject->save();

            Yii::$app->user->login($userObject);

            return $this->redirect(['/site/dashboard']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionForgot($find = null, $code = null)
    {
        return $this->render('forgot');
    }
}
