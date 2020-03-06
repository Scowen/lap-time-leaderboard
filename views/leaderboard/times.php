<?php 
    use yii\helpers\Html;

    use app\models\LeaderboardTime;
?>
<?php if ($timeObjects = $leaderboardObject->recentLeaderboardTimeObjects): ?>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vehicle</th>
                    <th>Time</th>
                    <th>Date &amp; Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timeObjects as $timeObject): ?>
                    <tr class="time-<?= $timeObject->id ?>">
                        <td><?= $timeObject->leaderboardUserObject->name ?></td>
                        <td><?= $timeObject->vehicleObject->make ?> <?= $timeObject->vehicleObject->model ?></td>
                        <td>
                            <?php 
                                $time = $timeObject->time;
                                echo $time['minutes'] . ":" . $time['seconds'] . "." . $time['milliseconds'];
                            ?>
                        </td>
                        <td><?= date("d/m/Y H:i", $timeObject->created) ?></td>
                        <td>
                            <?php if ($leaderboardObject->owner == $userObject->id): ?>
                                <?= Html::a("<i class='fa fa-times text-danger'></i>", '#', ['class' => 'btn-delete-time', 'data-id' => $timeObject->id]) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
<?php else: ?>
    <h3 class="text-center">You have not added any times yet</h3>
<?php endif ?>
