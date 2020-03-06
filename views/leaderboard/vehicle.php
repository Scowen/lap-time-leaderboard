<?php
    use yii\helpers\Html;
?>
<div class="modal fade" id="modal-add-vehicle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Add Vehicle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                        <strong>Make</strong>
                        <?= Html::input('text', 'vehicle_make', null, ['class' => 'form-control', 'placeholder' => 'Required']) ?>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <strong>Model</strong>
                        <?= Html::input('text', 'vehicle_model', null, ['class' => 'form-control', 'placeholder' => 'Required']) ?>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <strong>Colour</strong>
                        <?= Html::input('text', 'vehicle_colour', null, ['class' => 'form-control', 'placeholder' => 'Optional']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?= Html::a("Add Vehicle", null, ['class' => 'btn btn-primary', 'id' => 'modal-add-vehicle-btn']) ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready( function() {
        $("#modal-add-vehicle-btn").click( function() {
            let btn = $(this);
            let make = $("input[name=vehicle_make]").val();
            let model = $("input[name=vehicle_model]").val();
            let colour = $("input[name=vehicle_colour]").val();

            if (!make || make.length < 5 || !model || model.length < 5) {
                btnDanger(btn, "").delay(500).queue( function(next) {
                    $(btn).removeClass("btn-danger")
                        .addClass("btn-primary")
                        .html("Add Vehicle");
                    next();
                });
            }

            var request = $.ajax({
                url: `${baseUrl}/leaderboard/vehicle`,
                type: 'POST',
                cache: false,
                data: {
                    id: <?= $leaderboardObject->id ?>,
                    make: make,
                    model: model,
                    colour: colour,
                    _csrf: "<?=Yii::$app->request->getCsrfToken()?>",
                },
                beforeSend: function(data) {
                    btnWarning(btn, "Adding Vehicle"); 
                },
                success: function(data) {
                    console.log(data);
                    btnSuccess(btn, "Done!").delay(500).queue( function(next) {
                        $(btn).removeClass("btn-success")
                            .addClass("btn-primary")
                            .html("Add Vehicle");
                        next();
                    });

                    let colourString = "";
                    if (colour && colour.length > 1)
                        colourString = `(${colour}) `;
                    $("select[name=leaderboard_vehicle]").prepend(`<option value='${data.leaderboardVehicle.id}'>${colourString}${data.vehicleObject.make} ${data.vehicleObject.model}</option>`);
                    $("select[name=leaderboard_vehicle]").val(data.id);

                    $("#modal-add-vehicle").modal('hide');
                },
                error: function(error, status) {
                    console.error(error);
                    btnDanger(btn, "Error"); 
                },
                done: function(done, status) {
                    console.log("DONE");
                }
            });
        })
    })
</script>
