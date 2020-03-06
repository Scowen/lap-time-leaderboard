<?php
    use yii\helpers\Html;
?>
<div class="modal fade" id="modal-add-driver">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Add Driver</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-6">
                        <strong>Display Name</strong>
                        <?= Html::input('text', 'driver_display_name', null, ['class' => 'form-control', 'placeholder' => 'Required']) ?>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <strong>Email Address</strong>
                        <?= Html::input('text', 'driver_email', null, ['class' => 'form-control', 'placeholder' => 'Optional']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?= Html::a("Add Driver", null, ['class' => 'btn btn-primary', 'id' => 'modal-add-driver-btn']) ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready( function() {
        $("#modal-add-driver-btn").click( function() {
            let btn = $(this);
            let displayName = $("input[name=driver_display_name]").val();
            let emailAddress = $("input[name=driver_email]").val();

            if (!displayName || displayName.lenth < 5) {
                btnDanger(btn, "").delay(500).queue( function(next) {
                    $(btn).removeClass("btn-danger")
                        .addClass("btn-primary")
                        .html("Add Driver");
                    next();
                });
            }

            var request = $.ajax({
                url: `${baseUrl}/leaderboard/driver`,
                type: 'POST',
                cache: false,
                data: {
                    id: <?= $leaderboardObject->id ?>,
                    name: displayName,
                    email: emailAddress,
                    _csrf: "<?=Yii::$app->request->getCsrfToken()?>",
                },
                beforeSend: function(data) {
                    btnWarning(btn, "Adding Driver"); 
                },
                success: function(data) {
                    console.log(data);
                    btnSuccess(btn, "Done!").delay(500).queue( function(next) {
                        $(btn).removeClass("btn-success")
                            .addClass("btn-primary")
                            .html("Add Driver");
                        next();
                    });

                    $("select[name=leaderboard_user]").prepend(`<option value='${data.id}'>${data.name}</option>`);
                    $("select[name=leaderboard_user]").val(data.id);

                    $("#modal-add-driver").modal('hide');
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
