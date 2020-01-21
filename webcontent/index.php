<?php
session_start();
include_once('includes/scripts/checkSession.php');

$title = "Simple Vote";

include_once('includes/scripts/database.php');

$surveys = [];
$split = [];
$getAllSurveysQuery = "SELECT s.question, s.description, s.answers, u.username FROM `surveys` AS s INNER JOIN users AS u ON s.fkuser=u.idusers";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('includes/dependencies.html'); ?>
    <?php include_once('includes/head.html'); ?>
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <script src="includes/scripts/participate.js"></script>
</head>
<body>
<?php include_once('includes/header.php'); ?>

<?php include_once('includes/navbar.php'); ?>

<div class="container" style="margin-top:30px">
    <div class="row">
        <?php for ($i = 0; $i < count($surveys); $i++): ?>
            <div class="col-sm-4">
                <div class="survey" id="survey<?php echo $i ?>">
                    <h3><?php echo $surveys[$i]['question']; ?></h3>
                    <p><?php echo $surveys[$i]['description']; ?></p><br>

                    <button onclick="showAnswers(<?php echo $i ?>)" class="participate<?php echo $i ?>"><strong>Participate</strong></button>
                    <button onclick="showResult(<?php echo $i?>, <?php echo $i + 1 ?>)" class="result<?php echo $i ?>"><strong>Show result</strong></button>

                    <div class="answers<?php echo $i ?> hide">
                        <button onclick="vote(<?php echo $i + 1 ?>, 1, '<?php echo $surveys[$i]['question'] ?>')"><?php echo $split[$i][0]; ?></button>
                        <button onclick="vote(<?php echo $i + 1 ?>, 2, '<?php echo $surveys[$i]['question'] ?>')"><?php echo $split[$i][1]; ?></button>
                        <br><button onclick="closeParticipate(<?php echo $i ?>)">Close</button>
                    </div>

                    <p>Created by: <?php echo $surveys[$i]['username']; ?></p>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
<div id="toastr"></div>
<?php include_once('includes/footer.html'); ?>
</body>
</html>