<?php
include_once('database.php');

$surveyId = $_REQUEST['survey'];

$getVotes = "SELECT votesAnswer1, votesAnswer2 FROM votes WHERE fksurveys = $surveyId";
$result = mysqli_query($db, $getVotes);
$votes = mysqli_fetch_assoc($result);

$getSurveyQuery = "SELECT answers FROM `surveys` WHERE idsurveys = $surveyId";
$surveyResult = mysqli_query($db, $getSurveyQuery);
$survey = mysqli_fetch_assoc($surveyResult);

$width1 = 100 * round($votes['votesAnswer1'] / max(($votes['votesAnswer2'] + $votes['votesAnswer1']), 1), 2);
$width2 = 100 * round( $votes['votesAnswer2'] / max(($votes['votesAnswer2'] + $votes['votesAnswer1']), 1), 2);
?>

<style>
    .poll {
        background-color: #1a82ae;
        height: 20px;
        overflow: visible;
        white-space: nowrap
    }
    .poll1 {
        width: <?=$width1?>%;
    }

    .poll2 {
        width: <?=$width2?>%;
    }

    #result-table {
        margin-bottom: 1em;
    }
</style>

<script>

</script>

<h4>Result:</h4>
<table id="result-table">
    <tr>
        <td><?php echo explode(";", $survey['answers'])[0]; ?>: </td>
        <td class="w-100">
            <div class="poll poll1">
               <span>&nbsp; <?php echo $width1 ?>%</span>
            </div>
        </td>
    </tr>
    <tr>
        <td><?php echo explode(";", $survey['answers'])[1]; ?>: </td>
        <td>
            <div class="poll poll2">
                <span>&nbsp; <?php echo $width2 ?>%</span>
            </div>
        </td>
    </tr>
</table>
<button onclick="closeResult(<?php echo $surveyId - 1?>, <?php echo $surveyId ?>)">Close</button>
<p><?php echo $votes['votesAnswer1'] + $votes['votesAnswer2'] ?> People have voted for this question</p>