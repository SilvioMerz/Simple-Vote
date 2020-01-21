<?php
include_once('database.php');

$surveys = [];
$split = [];
$surveyId = $_REQUEST['survey'];
$realSurveyId = $surveyId - 1;
$getAllSurveysQuery = "SELECT s.question, s.description, s.answers, u.username FROM `surveys` AS s INNER JOIN users AS u ON s.fkuser=u.idusers WHERE s.idsurveys = $surveyId";
$result = mysqli_query($db, $getAllSurveysQuery);
if (isset($result)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $surveys[] = $row;
    }

    foreach ($surveys as $splitedAnswer) {
        array_push($split, explode(";", $splitedAnswer['answers']));
    }
}
?>

<h3><?php echo $surveys[0]['question']; ?></h3>
<p><?php echo $surveys[0]['description']; ?></p><br>

<button onclick="showAnswers(<?php echo $realSurveyId ?>)" class="participate<?php echo $realSurveyId ?>"><strong>Participate</strong>
</button>
<button onclick="showResult(<?php echo $realSurveyId?>, <?php echo $surveyId ?>)" class="result<?php echo $realSurveyId ?>"><strong>Show
        result</strong>
</button>

<div class="answers<?php echo $realSurveyId ?> hide">
    <button onclick="vote(<?php echo $surveyId ?>, 1, '<?php echo $surveys[0]['question'] ?>')"><?php echo $split[0][0]; ?></button>
    <button onclick="vote(<?php echo $surveyId ?>, 2, '<?php echo $surveys[0]['question'] ?>')"><?php echo $split[0][1]; ?></button>
    <br>
    <button onclick="closeParticipate(<?php echo $realSurveyId ?>)">Close</button>
</div>

<p>Created by: <?php echo $surveys[0]['username']; ?></p>