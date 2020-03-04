<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Register';

    $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '
                    {label}
                    {input}
                    {hint}{error}
                ',
            'labelOptions' => ['class' => ''],
            'inputOptions' => ['class' => 'form-control'],
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

    .form-horizontal .form-group {
        margin-right: 0px !important;
        margin-left: 0px !important;
        margin-bottom: 0px !important;
    }
</style>

<h1 class="text-center">Enlist Today!</h1>

<div class="row">
    <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <?php if ($model->errors): ?>
            <div class="alert alert-danger text-center">
                <?php foreach ($model->errors as $error): ?>
                    <?= $error[0] ?><br />
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
        <div class="card" data-background="color" data-color="blue">
            <div class="card-content">
                <?= $form->field($model, 'emailAddress') ?>
                <?= $form->field($model, 'password') ?>
                <?= $form->field($model, 'confirmPassword') ?>
            </div>
            <div class="card-footer text-center">
                <?= Html::submitButton('Register', ['class' => 'btn btn-fill btn-wd btn-lg']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
