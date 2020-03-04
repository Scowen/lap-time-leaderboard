<?php

namespace app\controllers;

date_default_timezone_set("Europe/London");
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;
use yii\web\HttpException;

class SiteController extends Controller
{
    private $user = null;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['error'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['/public/login']);
                },
            ],
        ];
    }

    public function init() {
        if (Yii::$app->user->isGuest)
            $this->redirect(['/public/login']);

        $this->user = Yii::$app->user->getIdentity();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}