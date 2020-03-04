<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Login';

    $form = ActiveForm::begin([
        'options' => ['class' => 'form-vertical'],
        'fieldConfig' => [
            'template' => '
                    {input} 
                    {hint}{error} 
                ',
            'labelOptions' => ['class' => 'control-label'], 
            'inputOptions' => ['class' => 'form-control'],
            'hintOptions' => ['class' => 'hint-block'],
        ],
    ]);
?>

<style type="text/css">
    .form-horizontal .form-group {
         margin-right: 0px !important; 
         margin-left: 0px !important; 
         margin-bottom: 0px !important; 
    }
</style>

<h1 class="text-center"><?= strtoupper(Yii::$app->params['name']) ?></h1>

<div class="row">
    <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <div class="card" data-background="color" data-color="blue">
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label>Email Address</label>
                            <?= $form->field($model, 'username')->label(false) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-fill btn-wd btn-lg']) ?>
                <br />
                <h6 style="padding-top: 10px;"><?= Html::a("Forgotten Password?", ['/public/forgot']) ?></h6>
            </div>
        </div>
    </div>
</div>

<h3 class="text-center">DON'T HAVE AN ACCOUNT?</h3>
<div class="row">
    <div class="col-xs-12 text-center">
        <?= Html::a("Register Now", ['/public/register'], ['class' => 'btn btn-success btn-fill btn-lg']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
