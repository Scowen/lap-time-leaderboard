<?php

namespace app\controllers;

date_default_timezone_set("Europe/London");
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use Carbon\Carbon;

use app\components\Words;

use app\models\Leaderboard;
use app\models\LeaderboardTime;
use app\models\LeaderboardUser;
use app\models\LeaderboardVehicle;
use app\models\Track;
use app\models\User;
use app\models\Vehicle;

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
            throw new HttpException(404, "This leaderboard does not exist (E0001)");

        if (Yii::$app->user->isGuest || !$leaderboardObject->owner != $this->user->id) {
            if ($leaderboardObject->public === 0)
                throw new HttpException(404, "This leaderboard does not exist (E0002)");
         
            if (!$leaderboardObject->active)
                throw new HttpException(404, "This leaderboard does not exist (E0003)");
        }

        return $this->render('view', [
            'userObject' => $this->user,
            'leaderboardObject' => $leaderboardObject,
        ]);
    }

    public function actionDriver()
    {
        if (Yii::$app->user->isGuest)
            throw new HttpException(403, "Access Denied");

        $this->user = Yii::$app->user->getIdentity();

        $request = Yii::$app->request;

        $leaderboardObject = Leaderboard::find()->where(['id' => $request->post('id')])
            ->andWhere(['owner' => $this->user->id])
            ->andWhere(['active' => 1])
            ->one();

        if (!$leaderboardObject)
            throw new HttpException(404, "This leaderboard does not exist (E0001)");

        $displayName = $request->post('name');
        $emailAddress = $request->post('email');
        $userObject = null;

        if ($emailAddress) {
            $userObject = User::find()->where(['email' => $emailAddress])->one();

            if (!$userObject) {
                $word1 = ucwords(Words::$list[rand(0, count(Words::$list) - 1)]);
                $word2 = ucwords(Words::$list[rand(0, count(Words::$list) - 1)]);
                $password = $word1 . $word2 . rand(0, 9);
                $userObject = new User;
                $userObject->attributes = [
                    'username' => $emailAddress,
                    'password' => $password, // Yii::$app->getSecurity()->generatePasswordHash($password),
                    'created' => time(),
                    'email' => $emailAddress,
                    'active' => 1,
                    'display_name' => $displayName,
                ];
                if (!$userObject->save()) {
                    throw new HttpException(400, serialize($userObject->errors));
                }
            }

            $displayName = $userObject->display_name;
        }

        $leaderboardUserObject = new LeaderboardUser;
        $leaderboardUserObject->attributes = [
            'leaderboard' => $leaderboardObject->id,
            'user' => $userObject ? $userObject->id : null,
            'name' => $displayName,
            'created' => time(),
            'created_by' => $this->user->id,
        ];
        $leaderboardUserObject->save();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $leaderboardUserObject->attributes;
    }

    public function actionVehicle()
    {
        if (Yii::$app->user->isGuest)
            throw new HttpException(403, "Access Denied");

        $this->user = Yii::$app->user->getIdentity();

        $request = Yii::$app->request;

        $leaderboardObject = Leaderboard::find()->where(['id' => $request->post('id')])
            ->andWhere(['owner' => $this->user->id])
            ->andWhere(['active' => 1])
            ->one();

        if (!$leaderboardObject)
            throw new HttpException(404, "This leaderboard does not exist (E0001)");

        $make = $request->post('make');
        $model = $request->post('model');
        $colour = $request->post('colour');

        $vehicleObject = Vehicle::find()->where(['make' => $make])
            ->andWhere(['model' => $model])
            ->andWhere(['colour' => $colour])
            ->andWhere(['created_by' => $this->user->id])
            ->one();
        if (!$vehicleObject) {
            $vehicleObject = new Vehicle;
            $vehicleObject->attributes = [
                'make' => $make,
                'model' => $model,
                'colour' => $colour,
                'created' => time(),
                'created_by' => $this->user->id,
            ];
            $vehicleObject->save();
        }

        $leaderboardVehicleObject = new LeaderboardVehicle;
        $leaderboardVehicleObject->attributes = [
            'leaderboard' => $leaderboardObject->id,
            'vehicle' => $vehicleObject->id,
            'created' => time(),
            'created_by' => $this->user->id,
        ];
        $leaderboardVehicleObject->save();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'leaderboardVehicle' => $leaderboardVehicleObject->attributes,
            'vehicleObject' => $vehicleObject->attributes,
        ];
    }

    public function actionAdd()
    {
        if (Yii::$app->user->isGuest)
            throw new HttpException(403, "Access Denied");

        $this->user = Yii::$app->user->getIdentity();

        $request = Yii::$app->request;

        $leaderboardObject = Leaderboard::find()->where(['id' => $request->post('id')])
            ->andWhere(['owner' => $this->user->id])
            ->andWhere(['active' => 1])
            ->one();

        if (!$leaderboardObject)
            throw new HttpException(404, "This leaderboard does not exist (E0001)");

        $driver = $request->post('driver');
        $leaderboardUserObject = LeaderboardUser::find()->where(['id' => $driver])
            ->andWhere(['leaderboard' => $leaderboardObject->id])
            ->one();
        if (!$leaderboardUserObject)
            throw new HttpException(400, "Driver does not exist");

        $vehicle = $request->post('vehicle');
        $leaderboardVehicleObject = LeaderboardVehicle::find()->where(['id' => $vehicle])
            ->andWhere(['leaderboard' => $leaderboardObject->id])
            ->one();
        if (!$leaderboardVehicleObject)
            throw new HttpException(400, "Vehicle does not exist");

        $minute = (string) str_pad($request->post('minute'), 2, "0", STR_PAD_LEFT);
        $second = (string) str_pad($request->post('second'), 2, "0", STR_PAD_LEFT);
        $millisecond = (string) str_pad($request->post('millisecond'), 3, "0");

        $minuteMilliseconds = $minute * 60000;
        $secondMilliseconds = $second * 1000;
        $totalMilliseconds = $minuteMilliseconds + $secondMilliseconds + $millisecond;

        $leaderboardTimeObject = new LeaderboardTime;
        $leaderboardTimeObject->attributes = [
            'leaderboard' => $leaderboardObject->id,
            'leaderboard_user' => $leaderboardUserObject->id,
            'vehicle' => $leaderboardVehicleObject->vehicle,
            'milliseconds' => $totalMilliseconds,
            'created' => time(),
            'created_by' => $this->user->id,
        ];
        $leaderboardTimeObject->save();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $leaderboardTimeObject->attributes;
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest)
            throw new HttpException(403, "Access Denied");

        $this->user = Yii::$app->user->getIdentity();

        $timeObject = LeaderboardTime::find()->where(['id' => $id])->one();

        if (!$timeObject)
            throw new HttpException(404, "This time does not exist (E0001)");

        $leaderboardObject = $timeObject->leaderboardObject;

        if ($leaderboardObject->owner != $this->user->id)
            throw new HttpException(404, "This time does not exist (E0002)");

        if (!$timeObject->delete())
            throw new HttpException(400, serialize($timeObject->errors));

        return 200;
    }

    public function actionAjax($id, $view, $action = null)
    {
        if (Yii::$app->user->isGuest)
            throw new HttpException(403, "Access Denied");

        $this->user = Yii::$app->user->getIdentity();

        $request = Yii::$app->request;

        $leaderboardObject = Leaderboard::find()->where(['id' => $id])
            ->andWhere(['owner' => $this->user->id])
            ->andWhere(['active' => 1])
            ->one();

        if (!$leaderboardObject)
            throw new HttpException(404, "This leaderboard does not exist (E0001)");

        return $this->renderPartial($view, [
            'leaderboardObject' => $leaderboardObject,
            'userObject' => $this->user,
        ]);
    }
}
