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
</style>

<script>

</script>

<h2>Result:</h2>
<table>
    <tr>
        <td>Yes:</td>
        <td class="w-100">
            <div class="poll poll1">
               <span><?php echo $width1 ?>%</span>
            </div>
        </td>
    </tr>
    <tr>
        <td>No:</td>
        <td>
            <div class="poll poll2">
                <span><?php echo $width2 ?>%</span>
            </div>
        </td>
    </tr>
    <tr>
        <td><button onclick="closeResult(<?php echo $surveyId - 1?>, <?php echo $surveyId ?>)">Close</button></td>
    </tr>
</table>