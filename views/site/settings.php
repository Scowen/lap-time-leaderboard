<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Settings';

?>
<div class="row">
    <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-xl-4 col-xl-offset-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Password</h4>
            </div>
            <div class="card-content">
                <?php 
                    $form = ActiveForm::begin([
                        'options' => ['class' => ''],
                        'fieldConfig' => [
                            'template' => "
                                    {label}
                                    {input} 
                                    {hint}{error} 
                                ",
                            'labelOptions' => ['class' => 'control-label'], 
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => ''],
                            'hintOptions' => ['class' => 'hint-block'],
                        ],
                    ]);
                ?>
                    <?= $form->field($model, 'current')->input('password') ?>
                    <?= $form->field($model, 'password')->input('password') ?>
                    <?= $form->field($model, 'confirmpassword')->input('password') ?>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <?= Html::submitButton('Update Password', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>