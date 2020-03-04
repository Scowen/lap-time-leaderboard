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

<div class="row">
    <div class="col-xs-12 col-xl-10 col-xl-offset-1">
        <div class="card">
            <div class="card-content">
                <div class="row" id='enter-times'>
                    <div class="col-xs-12 col text-right">
                        <?= Html::dropDownList('leaderboard_user', null, $leaderboardObject->leaderboardUserArray, ['class' => 'form-control', 'prompt' => 'Select a Driver']) ?>
                        <?= Html::a("+ Add Driver", '#modal-add-driver', ['class' => 'btn btn-xs btn-link', 'style' => 'margin-top: 3px']) ?>
                    </div>
                    <div class="col-xs-12 col text-right">
                        <?= Html::dropDownList('leaderboard_vehicle', null, $leaderboardObject->leaderboardVehicleArray, ['class' => 'form-control', 'prompt' => 'Select a Vehicle']) ?>
                        <?= Html::a("+ Add Vehicle", '#modal-add-vehicle', ['class' => 'btn btn-xs btn-link', 'style' => 'margin-top: 3px']) ?>
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
        <br />
        <?php if ($timeObjects = $leaderboardObject->leaderboardTimeObjects): ?>

        <?php else: ?>
            <h3 class="text-center">You have not added any times yet</h3>
        <?php endif ?>
    </div>
</div>

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

            if (!driver || !vehicle || (!minute && !second))
                return;

            var request = $.ajax({
                url: `${baseUrl}/leaderboard/add`,
                type: 'POST',
                cache: false,
                data: {
                    id: <?= $leaderboardObject->id ?>,
                },
                beforeSend: function(data) {
                    btnWarning(btn, ""); 
                },
                success: function(data) {
                    console.log(data);
                    btnSuccess(btn, ""); 
                },
                error: function(error, status) {
                    console.error(error);
                    btnWarning(btn, ""); 
                },
            });
        }

        $("#btn-add-time").click(addTime);
    })
</script>
