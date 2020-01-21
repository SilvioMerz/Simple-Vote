<?php
include_once('database.php');

$surveyId = $_POST['surveyId'];
$voteId = $_POST['voteId'];
$votesAnswerId = 'votesAnswer' . $voteId;

$getVotes = "SELECT $votesAnswerId FROM votes WHERE fksurveys = $surveyId";
$result = mysqli_query($db, $getVotes);
$tempVotes = mysqli_fetch_assoc($result);
$finalVotes = $tempVotes[$votesAnswerId] += 1;

$updateVotes = "UPDATE votes SET $votesAnswerId = $finalVotes WHERE fksurveys = $surveyId";
$ins = mysqli_query($db, $updateVotes);

