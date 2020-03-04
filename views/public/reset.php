<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'New Password';

    $form = ActiveForm::begin([
        'options' => ['class' => 'form-vertical'],
        'fieldConfig' => [
            'template' => '
                    <div class="row">
                        {label}
                        <div class="col-md-6">
                            {input} 
                            {hint}{error}
                        </div>
                    </div>
                ',
            'labelOptions' => ['class' => 'control-label col-md-4 text-right', 'style' => 'padding: 8px'], 
            'inputOptions' => ['class' => 'form-control col-md-6'],
            'hintOptions' => ['class' => 'hint-block'],
        ],
    ]);
?>

<style type="text/css">
    body {
        background: #EEE !important;
        color: #333 !important;
        font-family: 'Product-Sans', sans-serif !important;
    }
</style>

<h2 class="text-center hidden-xs">Reset your <strong class="text-blue"><?= Yii::$app->params['brand_long'] ?></strong> account</h2>
<br />
<div class="row">
    <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <div class="card" data-background="color" data-color="blue">
            <div class="card-content text-center">
                <div class="row" id="form-input">
                    <div class="col-xs-12">
                        <h3>Please enter your new password and click submit</h3>
                        <?= $form->field($model, 'password')->passwordInput()->label("New Password") ?>
                        <?= $form->field($model, 'password_confirm')->passwordInput()->label("Confirm Password") ?>
                        <br />
                        <?= Html::submitButton('Update Account Password', ['class' => 'btn btn-primary btn-fill']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>