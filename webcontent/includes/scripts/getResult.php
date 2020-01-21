<?php
include_once('database.php');

$surveyId = $_REQUEST['survey'];

$getVotes = "SELECT votesAnswer1, votesAnswer2 FROM votes WHERE fksurveys = $surveyId";
$result = mysqli_query($db, $getVotes);
$tempVotes = mysqli_fetch_assoc($result);

$width1 = 100 * round($tempVotes['votesAnswer1'] / max(($tempVotes['votesAnswer2'] + $tempVotes['votesAnswer1']), 1), 2);
$width2 = 100 * round( $tempVotes['votesAnswer2'] / max(($tempVotes['votesAnswer2'] + $tempVotes['votesAnswer1']), 1), 2);
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
        <td>Yes:</td>
        <td class="w-100">
            <div class="poll poll1">
               <span>&nbsp; <?php echo $width1 ?>%</span>
            </div>
        </td>
    </tr>
    <tr>
        <td>No:</td>
        <td>
            <div class="poll poll2">
                <span>&nbsp; <?php echo $width2 ?>%</span>
            </div>
        </td>
    </tr>
</table>
<button onclick="closeResult(<?php echo $surveyId - 1?>, <?php echo $surveyId ?>)">Close</button>
<p><?php echo $tempVotes['votesAnswer1'] + $tempVotes['votesAnswer2'] ?> People have voted for this question</p>