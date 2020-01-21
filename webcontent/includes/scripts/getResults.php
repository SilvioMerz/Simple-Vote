<?php
include_once('database.php');

$surveyId = $_REQUEST['survey'];

$getVotes = "SELECT votesAnswer1, votesAnswer2 FROM votes WHERE fksurveys = $surveyId";
$result = mysqli_query($db, $getVotes);
$tempVotes = mysqli_fetch_assoc($result);

$width1 = 100 * round($tempVotes['votesAnswer1'] / ($tempVotes['votesAnswer2'] + $tempVotes['votesAnswer1']), 2);
$width2 = 100 * round($tempVotes['votesAnswer2'] / ($tempVotes['votesAnswer2'] + $tempVotes['votesAnswer1']), 2);


?>

<style>
    .poll1 {
        background-color: #1a82ae;
        height: 20px;
        width: <?=$width1?>%;
    }

    .poll2 {
        background-color: #1a82ae;
        height: 20px;
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
            <div class="poll1">
               <span><?php echo $width1 ?>%</span>
            </div>
        </td>
    </tr>
    <tr>
        <td>No:</td>
        <td>
            <div class="poll2">
                <span><?php echo $width2 ?>%</span>
            </div>
        </td>
    </tr>
    <tr>
        <td><button onclick="closeResult(<?php echo $surveyId - 1?>, <?php echo $surveyId ?>)">Close</button></td>
    </tr>
</table>