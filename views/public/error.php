<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container">
    <div class="site-error text-center">
        <h2><?= nl2br($message) ?></h2>
        <a href="#" onclick="window.history.back()" class="btn">Go Back</a>
    </div>
</div>
