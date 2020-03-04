<?php

namespace app\controllers;

date_default_timezone_set("Europe/London");
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

use app\models\Leaderboard;
use app\models\Track;
use app\models\User;

class LeaderboardController extends Controller
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

    public function actionModify($id = null)
    {
        if (Yii::$app->user->isGuest)
            $this->redirect(['/public/login']);

        $this->user = Yii::$app->user->getIdentity();

        $leaderboardObject = null;
        if ($id) {
            $leaderboardObject = Leaderboard::find()->where(['id' => $id])
                ->andwhere(['active' => 1])
                ->andWhere(['owner' => $this->user->id])
                ->one();

            if (!$leaderboardObject)
                throw new HttpException(403, "You do not have access to this leaderboard");
        }

        if (!$leaderboardObject) { 
            $leaderboardObject = new Leaderboard;
            $leaderboardObject->created = time();
            $leaderboardObject->owner = $this->user->id;
        }

        if ($leaderboardObject->load(Yii::$app->request->post()) && $leaderboardObject->validate()) {
            $trackObject = Track::find()->where(['created_by' => $this->user->id])
                ->orWhere(['IS', 'created_by', null])
                ->andWhere(['id' => $leaderboardObject->track])
                ->one();
            if (!$trackObject) 
                throw new HttpException(403, "This is not the track you are looking for...");

            if (!$leaderboardObject->save()) {
                var_dump($leaderboardObject->errors);
                var_dump($leaderboardObject->attributes);
                exit;
            }

            return $this->redirect(['/leaderboard/view', 'id' => $leaderboardObject->id]);
        }

        return $this->render('modify', [
            'userObject' => $this->user,
            'leaderboardObject' => $leaderboardObject,
        ]);
    }

    public function actionView($id)
    {
        if (!Yii::$app->user->isGuest)
            $this->user = Yii::$app->user->getIdentity();

        $leaderboardObject = Leaderboard::find()->where(['id' => $id])->one();

        if (!$leaderboardObject)
            throw new HttpException(404, "This leaderbord does not exist (E0001)");

        if (Yii::$app->user->isGuest || !$leaderboardObject->owner != $this->user->id) {
            if ($leaderboardObject->public === 0)
                throw new HttpException(404, "This leaderbord does not exist (E0002)");
         
            if (!$leaderboardObject->active)
                throw new HttpException(404, "This leaderbord does not exist (E0003)");
        }

        return $this->render('view', [
            'userObject' => $this->user,
            'leaderboardObject' => $leaderboardObject,
        ]);
    }
}
