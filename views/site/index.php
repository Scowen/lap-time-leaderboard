<?php
    use yii\helpers\Html;
    use kartik\widgets\ActiveForm;

    $this->title = "Dashboard";
?>
<?php if ($ownerLeaderboardObjects): ?>

<?php else: ?>
    <h2 class="text-center">You do not have any leaderboards</h2>
    <div class="row">
        <div class="col-xs-12 text-center">
            <?= Html::a("Create a Leaderboard", ['/leaderboard/modify'], ['class' => 'btn btn-success btn-lg btn-fill']) ?>
        </div>
    </div>
<?php endif ?>

<?php if ($joinedLeaderboardObjects): ?>
    <div class="row">
        <?php foreach ($joinedLeaderboardObjects as $leaderboardObject): ?>

        <?php endforeach ?>
    </div>
<?php endif ?>
