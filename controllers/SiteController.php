<?php

namespace app\controllers;

date_default_timezone_set("Europe/London");
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

use app\models\Leaderboard;
use app\models\User;

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
        $ownerLeaderboardObjects = Leaderboard::find()->where(['owner' => $this->user->id])
            ->andWhere(['active' => 1])
            ->all();

        $sql = "SELECT 
                leaderboard.*
                FROM leaderboard 
                LEFT JOIN leaderboard_user ON leaderboard_user.leaderboard = leaderboard.id 
                WHERE 
                    leaderboard_user.user = :user 
                    AND leaderboard.owner != :user 
                    AND leaderboard.active = 1";
        $joinedLeaderboardObjects = Leaderboard::findBySql($sql, [
            ':user' => $this->user->id,
        ])->all();

        return $this->render('index', [
            'ownerLeaderboardObjects' => $ownerLeaderboardObjects,
            'joinedLeaderboardObjects' => $joinedLeaderboardObjects,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
