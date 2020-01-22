<?php
include_once('database.php');

$surveyId = $_REQUEST['survey'];
$surveyIndex = $surveyId - 1;
$getShownSurveysQuery = "SELECT s.question, s.description, s.answers, u.username FROM `surveys` AS s INNER JOIN users AS u ON s.fkuser=u.idusers WHERE s.idsurveys = $surveyId";
$result = mysqli_query($db, $getShownSurveysQuery);
$survey = mysqli_fetch_assoc($result);


$getAllSurveysQuery = "SELECT s.question, s.description, s.answers, u.username FROM `surveys` AS s INNER JOIN users AS u ON s.fkuser=u.idusers ORDER BY s.idsurveys";
$resultAll = mysqli_query($db, $getAllSurveysQuery);
?>

<h3><?php echo $survey['question']; ?></h3>
<p><?php echo $survey['description']; ?></p><br>

<button class="participate<?php echo $surveyIndex ?>"
        onclick="showAnswers(<?php echo $surveyIndex ?>)">
    <strong>Participate</strong>
</button>

<button class="result<?php echo $surveyIndex ?>"
        onclick="showResult(<?php echo $surveyIndex ?>, <?php echo $surveyId ?>, <?php echo mysqli_num_rows($resultAll) ?>)">
    <strong>Show result</strong>
</button>

<div class="answers<?php echo $surveyIndex ?> hide">
    <button onclick="vote(<?php echo $surveyId ?>, 1, '<?php echo $survey['question'] ?>')">
        <?php echo explode(";", $survey['answers'])[0]; ?>
    </button>

    <button onclick="vote(<?php echo $surveyId ?>, 2, '<?php echo $survey['question'] ?>')">
        <?php echo explode(";", $survey['answers'])[1]; ?>
    </button>

    <br>
    <button onclick="closeParticipate(<?php echo $surveyIndex ?>)">Close</button>
</div>

<p>Created by: <?php echo $survey['username']; ?></p>