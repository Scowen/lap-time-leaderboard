<?php 
    use yii\helpers\Html;
    
    use app\models\LeaderboardTime;

    $previousTimeObject = null;
?>
<?php if ($timeObjects = $leaderboardObject->leaderboardTimeObjects): ?>
    <?php 
        $position = 1;
    ?>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Vehicle</th>
                    <th>Time</th>
                    <th>Gap</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timeObjects as $timeObject): ?>
                    <?php if (!$previousTimeObject) $previousTimeObject = $timeObject ?>
                    <tr class="time-<?= $timeObject->id ?>" style="background: <?= LeaderboardTime::getTrColour($position); ?>">
                        <td class="f1"><?= $position++ ?></td>
                        <td><?= $timeObject->leaderboardUserObject->name ?></td>
                        <td><?= $timeObject->vehicleObject->make ?> <?= $timeObject->vehicleObject->model ?></td>
                        <td class="oxanium">
                            <?php 
                                $time = $timeObject->time;
                                echo $time['minutes'] . ":" . $time['seconds'] . "." . $time['milliseconds'];
                            ?>
                        </td>
                        <td class="oxanium"><?= $timeObject->gapTo($previousTimeObject->milliseconds); ?></td>
                        <td>
                            <?php if ($leaderboardObject->owner == $userObject->id): ?>
                                <?= Html::a("<i class='fa fa-times text-danger'></i>", '#', ['class' => 'btn-delete-time', 'data-id' => $timeObject->id]) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h3 class="text-center">You have not added any times yet</h3>
<?php endif ?>
