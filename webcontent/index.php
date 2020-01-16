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
                <div class="survey">
                    <h3><?php echo $surveys[$i]['question']; ?></h3>
                    <p><?php echo $surveys[$i]['description']; ?></p><br>

                    <button class="participate"><strong>Participate</strong></button>

                    <div class="answers hide">
                        <button><?php echo $split[$i][0]; ?></button>
                        <button><?php echo $split[$i][1]; ?></button>
                        <br><button class="back">back</button>
                    </div>

                    <p>Created by: <?php echo $surveys[$i]['username']; ?></p>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
<?php include_once('includes/footer.html'); ?>
</body>
</html>