<?php
    use yii\helpers\Html;

    $this->title = $leaderboardObject->name;
?>

<style type="text/css">
    #enter-times input, #enter-times select {
        font-size: 1.5em !important;
        height: 47px !important;
    }
</style>

<div id="debug"></div>

<div class="row">
    <div class="col-xs-12 col-xl-10 col-xl-offset-1">
        <div class="card">
            <div class="card-content">
                <div class="row" id='enter-times'>
                    <div class="col-xs-12 col text-right">
                        <?= Html::dropDownList('leaderboard_user', null, $leaderboardObject->leaderboardUserArray, ['class' => 'form-control', 'prompt' => 'Select a Driver']) ?>
                        <?php if ($leaderboardObject->owner == $userObject->id): ?>
                            <?= Html::a("+ Add Driver", '#modal-add-driver', ['class' => 'btn btn-xs', 'style' => 'margin-top: 3px', 'data-toggle' => 'modal']) ?>
                        <?php endif ?>
                    </div>
                    <div class="col-xs-12 col text-right">
                        <?= Html::dropDownList('leaderboard_vehicle', null, $leaderboardObject->leaderboardVehicleArray, ['class' => 'form-control', 'prompt' => 'Select a Vehicle']) ?>
                        <?php if ($leaderboardObject->owner == $userObject->id): ?>
                            <?= Html::a("+ Add Vehicle", '#modal-add-vehicle', ['class' => 'btn btn-xs', 'style' => 'margin-top: 3px', 'data-toggle' => 'modal']) ?>
                        <?php endif ?>
                    </div>
                    <div class="col-xs-12 col">
                        <div class="input-group">
                            <?= Html::input('text', 'lap_time_minute', null, ['class' => 'form-control text-lg-right', 'placeholder' => '0', 'maxlength' => 2]) ?>
                            <span class="input-group-addon">:</span>
                            <?= Html::input('text', 'lap_time_second', null, ['class' => 'form-control text-lg-right', 'placeholder' => '00', 'maxlength' => 2]) ?>
                            <span class="input-group-addon">.</span>
                            <?= Html::input('text', 'lap_time_millisecond', null, ['class' => 'form-control text-lg-right', 'placeholder' => '000', 'maxlength' => 3]) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <?= Html::a("Add", null, ['class' => 'btn btn-primary btn-lg btn-block btn-fill', 'id' => 'btn-add-time']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <h4 class="text-center">LEADERBOARD</h4>
                <div id="leaderboard"><?= $this->render('leaderboard', ['leaderboardObject' => $leaderboardObject, 'userObject' => $userObject]); ?></div>
            </div>
            <div class="col-xs-12 col-lg-6">
                <h4 class="text-center">RECENT TIMES</h4>
                <div id="times"><?= $this->render('times', ['leaderboardObject' => $leaderboardObject, 'userObject' => $userObject]); ?></div>
            </div>
        </div>
    </div>
</div>

<?php if ($leaderboardObject->owner == $userObject->id): ?>
    <?= $this->render('driver', ['leaderboardObject' => $leaderboardObject]); ?>
    <?= $this->render('vehicle', ['leaderboardObject' => $leaderboardObject]); ?>
<?php endif ?>

<script type="text/javascript">
    $(document).ready( function() {
        function addTime() {
            let btn = $("#btn-add-time");
            let driver = $("select[name=leaderboard_user]").val();
            let vehicle = $("select[name=leaderboard_vehicle]").val();
            let minute = $("input[name=lap_time_minute]").val();
            let second = $("input[name=lap_time_second]").val();
            let millisecond = $("input[name=lap_time_millisecond]").val();

            console.log(driver, vehicle, minute, second, millisecond);

            if (!driver || !vehicle || (!minute && !second)) { 
                btnDanger(btn, "").delay(500).queue( function(next) {
                    $(btn).removeClass("btn-danger")
                        .addClass("btn-primary")
                        .html("Add");
                    next();
                })
                return;
            }

            var request = $.ajax({
                url: `${baseUrl}/leaderboard/add`,
                type: 'POST',
                cache: false,
                data: {
                    id: <?= $leaderboardObject->id ?>,
                    driver: driver,
                    vehicle: vehicle,
                    minute: minute,
                    second: second,
                    millisecond: millisecond,
                    _csrf: "<?=Yii::$app->request->getCsrfToken()?>",
                },
                beforeSend: function(data) {
                    btnWarning(btn, "Adding"); 
                },
                success: function(data) {
                    console.log(data);
                    $("#debug").html(data);
                    btnSuccess(btn, "Added"); 

                    var request = $.ajax({
                        url: `${baseUrl}/leaderboard/ajax`,
                        type: 'GET',
                        cache: false,
                        data: {
                            id: <?= $leaderboardObject->id ?>,
                            view: 'leaderboard',
                        },
                        beforeSend: function(data) {
                            console.log("Reloading");
                        },
                        success: function(data) {
                            $("#leaderboard").html(data);
                        },
                        error: function(data) {
                            console.error(data);
                            // Code goes here... 
                        },
                    });

                    var request = $.ajax({
                        url: `${baseUrl}/leaderboard/ajax`,
                        type: 'GET',
                        cache: false,
                        data: {
                            id: <?= $leaderboardObject->id ?>,
                            view: 'times',
                        },
                        beforeSend: function(data) {
                            console.log("Reloading");
                        },
                        success: function(data) {
                            $("#times").html(data);
                        },
                        error: function(data) {
                            console.error(data);
                            // Code goes here... 
                        },
                    });

                    $("input[name=lap_time_minute]").val("").focus();
                    $("input[name=lap_time_second]").val("");
                    $("input[name=lap_time_millisecond]").val("");
                },
                error: function(error, status) {
                    $("#debug").html(error.responseText);
                    console.error(error);
                    btnDanger(btn, "Error"); 
                },
                done: function(done, status) {

                    console.log("DONE");
                    delay(500).queue( function(next) {
                        $(btn).removeClass("btn-danger")
                            .addClass("btn-primary")
                            .html("Add");
                        next();
                    });
                }
            });
        }

        $("#btn-add-time").click(addTime);

        $(".btn-delete-time").click( function() {
            let btn = $(this);
            let id = $(this).attr("data-id");

            var request = $.ajax({
                url: `${baseUrl}/leaderboard/delete`,
                type: 'GET',
                cache: false,
                data: {
                    id: id
                },
                beforeSend: function(data) {
                    btnWarning(btn, ""); 
                },
                success: function(data) {
                    console.log(data);
                    btnSuccess(btn, ""); 

                    $(`.time-${id}`).remove();
                },
                error: function(error, status) {
                    console.error(error);
                    btnWarning(btn, ""); 
                },
            });
        })
    })
</script>
