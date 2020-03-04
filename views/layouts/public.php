<?php
    date_default_timezone_set("GMT");

    /* @var $this \yii\web\View */
    /* @var $content string */

    use yii\web\HttpException;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use app\assets\PublicAsset;

    use app\models\LoadLog;
    use app\models\Server;
    
    $controllerName = Yii::$app->controller->id;
    $actionName = Yii::$app->controller->action->id;

    $user = null;
    if (!Yii::$app->user->isGuest)
        $user = Yii::$app->user->identity;

    PublicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8">
    <?= Html::csrfMetaTags() ?>
    <!-- <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png"> -->
    <link rel="icon" type="image/png" href="<?= Yii::$app->request->baseurl ?>/images/logo/favicon.png">

    <title><?= $this->title ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta name="viewport" content="width=device-width">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa&display=swap" rel="stylesheet">

    <?php $this->head() ?>
    <!--     Fonts and icons     -->
    <!-- Polyfill for older browsers -->
    <script type="text/javascript">
        var baseUrl = "<?= Yii::$app->request->baseurl ?>";
    </script>
    <script src="<?= Yii::$app->request->baseurl ?>/js/jquery1.9.1.min.js"></script>

    <style type="text/css">
        body {
            background-color: #eee !important;
            font-family: 'Product-Sans', sans-serif !important;
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

        <div class="hidden-xs" style="height: 10%;"></div>
        <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
