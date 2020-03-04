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
    </p>
</div>
