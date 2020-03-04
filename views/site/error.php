<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use Yii;
use yii\helpers\Html;

$user = Yii::$app->user->getIdentity();

$this->title = $name;
?>
<div class="site-error text-center">
    <h2 class="text-danger"><?= nl2br($message) ?></h2>
    <br />
    <p>
        Error details: <?= $this->title ?><br />
        If you think you shouldn't be seeing this page, contact <?= Yii::$app->params['adminBrand'] ?> on <strong><?= Yii::$app->params['adminNumber'] ?></strong> or email <strong><?= Yii::$app->params['adminEmail'] ?></strong>.<br />
        User: <?= $user ? "$user->id ($user->username)" : "none" ?> | IP: <?= $_SERVER['REMOTE_ADDR'] ?> | Branch: <?= $user && $user->branchObject ? "$user->branch (". $user->branchObject->name .")" : "none" ?>
    </p>
</div>
