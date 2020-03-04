<?php
    use yii\helpers\Html;
    use kartik\widgets\ActiveForm;

    use app\models\Leaderboard;
    use app\models\Track;

    $title = "Create Leaderboard";
    if ($leaderboardObject->id)
        $title = "Edit $leaderboardObject->name";

    $this->title = $title;

    $form = ActiveForm::begin([
        'options' => ['class' => 'form-vertical'],
        'fieldConfig' => [
            'template' => '
                    {label}
                    {input} 
                    {hint}{error} 
                ',
            'labelOptions' => ['class' => 'control-label'], 
            'inputOptions' => ['class' => 'form-control'],
            'hintOptions' => ['class' => 'hint-block'],
        ],
    ]);
?>
<div class="row">
    <div class="col-xs-12 col-lg-6 col-lg-offset-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?= $this->title ?></h4>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-xs-6"><?= $form->field($leaderboardObject, 'name') ?></div>
                    <div class="col-xs-6"><?= $form->field($leaderboardObject, 'track')->dropDownList(Track::getDropDownList($userObject->id)) ?></div>
                    <div class="col-xs-6"><?= $form->field($leaderboardObject, 'public')->dropDownList(Leaderboard::$publicTypes) ?></div>
                    <div class="col-xs-6"><?= $form->field($leaderboardObject, 'notify_owner')->dropDownList([1 => 'Notify me of all changes', 0 => 'Don\'t notify me']) ?></div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-xs-4"><?= $form->field($leaderboardObject, 'add')->dropDownList(['No', 'Yes']) ?></div>
                    <div class="col-xs-4"><?= $form->field($leaderboardObject, 'edit')->dropDownList(['No', 'Yes']) ?></div>
                    <div class="col-xs-4"><?= $form->field($leaderboardObject, 'delete')->dropDownList(['No', 'Yes']) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 text-center">
        <?= Html::submitButton($title . ' &amp; Save', ['class' => 'btn btn-success btn-lg btn-fill']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
