<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Forgotten Password';
?>

<style type="text/css">
    body {
        background: #EEE !important;
        color: #333 !important;
        font-family: 'Product-Sans', sans-serif !important;
    }

    .form-horizontal .form-group {
         margin-right: 0px !important; 
         margin-left: 0px !important; 
         margin-bottom: 0px !important; 
    }
</style>

<h2 class="text-center hidden-xs">Forgotten your <strong class="text-pink"><?= Yii::$app->params['brand_long'] ?></strong> password?</h2>
<br />
<div class="row">
    <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <div class="card" data-background="color" data-color="blue">
            <div class="card-content text-center">
                <div class="row" id="form-input">
                    <div class="col-xs-12">
                        <h4>Enter your Username / Email Address</h4>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <input type="text" class="form-control" name="username" id="input-username">
                            </div>
                            <br />
                            <br />
                            <br />
                            <button class="btn btn-primary btn-fill" id="btn-request-reset">Request Reset</button>
                            <br />
                            <span id="error-message" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="row" id="on-success" style="display: none">
                    <div class="col-xs-12">
                        <h4>Request Reset Sent!</h4>
                        <br />
                        We have sent you an email containing a link to reset your password.
                        <br />
                        Please check your spam folder if you do not see the email within 5 minutes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function request() {
        let btn = $("#btn-request-reset");
        let val = $("#input-username").val();

        if (!val || val.length < 1)
            return;
    
        var request = $.ajax({
            url: baseUrl + '/public/forgot',
            type: 'GET',
            cache: false,
            data: {
                find: $("#input-username").val(),
            },
            beforeSend: function(data) {
                $(btn).removeClass("btn-primary")
                    .removeClass("btn-danger")
                    .addClass("disabled")
                    .addClass("btn-warning")
                    .html("Requesting");
                    $("#error-message").slideUp().html("");
            },
            success: function(data) {
                $("#form-input").slideUp();
                $("#on-success").slideDown();
            },
            error: function(data) {
                console.error(data);

                $(btn).removeClass("btn-warning")
                    .removeClass("disabled")
                    .addClass("btn-danger")
                    .html("Error");

                $("#error-message").html("<br />" + data.responseText.replace("Bad Request (#400): ", "")).slideDown();
            },
        });
    }

    $(document).ready( function() {
        $("#btn-request-reset").click(request);
        
        $("#input-username").keyup( function(e) {
            if (e.which == 13)
                request();
        })
    })
</script>