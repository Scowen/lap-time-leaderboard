<?php
    use yii\helpers\Html;
    use app\models\Leaderboard;

    $this->title = "Dashboard";
?>
<div class="row">
    <div class="col-xs-12 col-lg-6 text-xs-center text-lg-left">
        <h3>My Leaderboards</h3>
    </div>
    <div class="col-xs-12 col-lg-6 text-xs-center text-lg-right">
        <?= Html::a("Create a Leaderboard", ['/leaderboard/modify'], ['class' => 'btn btn-success btn-lg btn-fill']) ?>
    </div>
</div>
<?php if ($ownerLeaderboardObjects): ?>
    <div class="row">
        <?php foreach ($ownerLeaderboardObjects as $leaderboardObject): ?>
            <div class="col-xs-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4 class="card-title"><?= $leaderboardObject->name ?></h4>
                            </div>
                            <div class="col-xs-6 text-right">
                                <?= Html::a("<i class='fa fa-edit'></i>", ['/leaderboard/modify', 'id' => $leaderboardObject->id], ['class' => '']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-6">
                                <h6># Participants</h6>
                                <?= $leaderboardObject->numParticipants ?>
                            </div>
                            <div class="col-xs-6">
                                <h6># Lap Times</h6>
                                <?= $leaderboardObject->numTimes ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <h6>Date Created</h6>
                                <?= date("d/m/Y", $leaderboardObject->created) ?>
                            </div>
                            <div class="col-xs-6">
                                <h6>Privacy</h6>
                                <?= Leaderboard::$publicTypesShort[$leaderboardObject->public] ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?= Html::a("View Leaderboard", ['/leaderboard/view', 'id' => $leaderboardObject->id], ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <h2 class="text-center">You do not have any leaderboards</h2>
    <div class="row">
        <div class="col-xs-12 text-center">
            <?= Html::a("Create a Leaderboard", ['/leaderboard/modify'], ['class' => 'btn btn-success btn-lg btn-fill']) ?>
        </div>
    </div>
<?php endif ?>

<?php if ($joinedLeaderboardObjects): ?>
    <h3 class="text-center">Leaderboards I've Joined</h3>
    <div class="row">
        <?php foreach ($joinedLeaderboardObjects as $leaderboardObject): ?>
            <div class="col-xs-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $leaderboardObject->name ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-6">
                                <h6># Participants</h6>
                                <?= $leaderboardObject->numParticipants ?>
                            </div>
                            <div class="col-xs-6">
                                <h6># Lap Times</h6>
                                <?= $leaderboardObject->numTimes ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <h6>Date Created</h6>
                                <?= date("d/m/Y", $leaderboardObject->created) ?>
                            </div>
                            <div class="col-xs-6">
                                <h6>Privacy</h6>
                                <?= Leaderboard::$publicTypesShort[$leaderboardObject->public] ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?= Html::a("View Leaderboard", ['/leaderboard/view', 'id' => $leaderboardObject->id], ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
