<?php
    date_default_timezone_set("Europe/London");

    /* @var $this \yii\web\View */
    /* @var $content string */

    use yii\web\HttpException;
    use yii\helpers\Html;
    use app\assets\AppAsset;
    use app\models\User;
    use app\models\UserIp;
    use yii\helpers\Url;

    $environment = Yii::$app->params["environment"];

    if (Yii::$app->user->isGuest) {
        Yii::$app->getResponse()->redirect(['/public/login']);
        Yii::$app->errorHandler->errorAction = '/public/error';
        header("Location: ". Url::to(['/public/login']));
        die();
    }

    $userObject = User::find()->where(['id' => Yii::$app->user->id])->one();

    if (!$userObject)
        throw new HttpException(403, "Access Denied");

    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $ip = UserIp::find()->where(['ip' => $ipAddress])
        ->andWhere(['user' => $userObject->id])
        ->orderBy(['last' => SORT_DESC])
        ->one();

    if (!$ip || (time() - $ip->last) > (60*30)) {
        $ip = new UserIp;
        $ip->ip = $ipAddress;
        $ip->user = $userObject->id;
        $ip->created = time();
    }
    $ip->last = time();
    $ip->save();

    $moduleName = Yii::$app->controller->module->id;
    $controllerName = Yii::$app->controller->id;
    $actionName = Yii::$app->controller->action->id;

    AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8">

    <?= Html::csrfMetaTags() ?>
    
    <link rel="icon" type="image/png" href="<?= Yii::$app->request->baseurl ?>/">

    <title><?= $this->title ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Bespoke Financial Lending Software tailored to business requirements">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">

    <?php $this->head() ?>

    <script type="text/javascript">
        var baseUrl = "<?= Yii::$app->request->baseurl ?>";
    </script>
    <script src="<?= Yii::$app->request->baseurl ?>/js/jquery1.9.1.min.js"></script>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrapper">
        <div class="sidebar">
            <div class="logo text-center">
                <a class="simple-text logo-normal">LOGO</a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-customer-dashboard">
                        <?= Html::a('<i class="ti-layout"></i><p>Dashboard</p>', ['/customer']) ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>
                        <a class="navbar-brand" href="#Dashboard">
                            <?= $this->title ?>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <!-- 
                            <li class="dropdown">
                                <a href="#notifications" class="dropdown-toggle btn-rotate" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <span class="notification">5</span>
                                    <p class="hidden-md hidden-lg">
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#not1">Notification 1</a></li>
                                    <li><a href="#not2">Notification 2</a></li>
                                    <li><a href="#not3">Notification 3</a></li>
                                    <li><a href="#not4">Notification 4</a></li>
                                    <li><a href="#another">Another notification</a></li>
                                </ul>
                            </li>
                            -->
                            <li class="dropdown">
                                <a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
                                    <p class="hidden-md hidden-lg"></p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><?= Html::a('<i class="ti-settings"></i> Settings', ['/site/settings'], ['class' => 'btn-rotate']) ?></li>
                                    <li><?= Html::a('<i class="ti-close"></i> Log Out', ['/site/logout']) ?></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    <?= $content ?>
                    <br />
                    <br />
                    <br />
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(".nav-collapse-<?= $moduleName ?>").addClass("in").attr("aria-expanded", true);
            $(".nav-collapse-<?= $moduleName ?>").parent().find(".nav-collapse").attr("aria-expanded", true);

            $(".nav-collapse-<?= $moduleName ?>-<?= $controllerName ?>").addClass("in").attr("aria-expanded", true);
            $(".nav-collapse-<?= $moduleName ?>-<?= $controllerName ?>").parent().find(".nav-collapse").attr("aria-expanded", true);

            $(".nav-<?= $moduleName ?>").addClass("active");
            $(".nav-<?= $moduleName ?>-<?= $controllerName ?>").addClass("active");
            $(".nav-<?= $moduleName ?>-<?= $controllerName ?>-<?= $actionName ?>").addClass("active");

            $(document).ready( function() {
                $("#minimizeSidebar").click( function() {
                    let state = $(this).attr("data-state");
                    if (state == 1) {
                        state = 0;
                    } else {
                        state = 1;
                    }
                    var request = $.ajax({
                        url: baseUrl + '/site/sidemenu',
                        type: 'GET',
                        cache: false,
                        data: {
                            user: <?= $userObject->id ?>,
                            state: state,
                        },
                        success: function(data) {
                            console.log('updated'); 
                        },
                    });

                    $(this).attr('data-state', state);
                });


                $(".btn").mouseup(function(){
                    $(this).blur();
                })

                $(".disabled").click( function(e) {
                    e.preventDefault();
                })

                <?php if (Yii::$app->session->hasFlash("success")): ?>
                    $.notify({
                        message: "<strong>Success!</strong> <?= Yii::$app->session->getFlash("success") ?>",
                    },{
                        type: 'success',
                        placement: {
                            from: "top",
                            align: "left"
                        },
                    });
                <?php endif ?>

                <?php if (Yii::$app->session->hasFlash("warning")): ?>
                    $.notify({
                        message: "<strong>Warning!</strong> <?= Yii::$app->session->getFlash("warning") ?>",
                    },{
                        type: 'warning',
                        placement: {
                            from: "top",
                            align: "left"
                        },
                    });
                <?php endif ?>

                <?php if (Yii::$app->session->hasFlash("danger")): ?>
                    $.notify({
                        message: "<strong>Error!</strong> <?= Yii::$app->session->getFlash("danger") ?>",
                    },{
                        type: 'danger',
                        placement: {
                            from: "top",
                            align: "left"
                        },
                    });
                <?php endif ?>
            })
        </script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
