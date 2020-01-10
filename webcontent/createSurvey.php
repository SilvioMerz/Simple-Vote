<?php
session_start();
include_once('includes/scripts/checkSession.php');
$title = "Create survey";

include_once('includes/scripts/database.php');
$errors = array();
$insertSurvey = $db->prepare("INSERT INTO surveys (question, description, answers, fkuser) VALUES (?, ?, ?, ?)");

if (isset($_POST["submitCreateSurvey"])) {
    $question = mysqli_real_escape_string($db, $_POST['question']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $answer1 = mysqli_real_escape_string($db, $_POST['answer1']);
    $answer2 = mysqli_real_escape_string($db, $_POST['answer2']);
    $answers = $answer1 . ';' . $answer2;

    $insertSurvey->bind_param("sssi", $question, $description, $answers, $_SESSION['USER']['USERID']);

    if (isset($question) && $question == "") {
        array_push($errors, "Question is required");
    }
    if (isset($answer1) && $answer1 == "") {
        array_push($errors, "Answer is required");
    }
    if (isset($answer2) && $answer2 == "") {
        array_push($errors, "Answer is required");
    }

    if (count($errors) == 0) {
        $insertSurvey->execute();
        $insertSurvey->close();
        $insertVotes = "INSERT INTO votes (fksurveys) VALUES ($db->insert_id)";
        $result = mysqli_query($db, $insertVotes);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('includes/dependencies.html'); ?>
    <?php include_once('includes/head.html'); ?>
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
</head>
<body>
<?php include_once('includes/header.php'); ?>

<?php include_once('includes/navbar.php'); ?>

<div class="modal-dialog" role="document">

    <?php if (count($errors) > 0) : ?>
        <div class="alert alert-dismissible alert-danger">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create survey</h5>
        </div>
        <form method="post" action="createSurvey.php">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-form-label">Question:</label>
                    <input type="text" name="question" class="form-control">
                </div>

                <div class="form-group">
                    <label class="col-form-label">Answer:</label>
                    <input type="text" name="answer1" class="form-control">
                </div>

                <div class="form-group">
                    <label class="col-form-label">Answer:</label>
                    <input type="text" name="answer2" class="form-control">
                </div>

                <div class="form-group">
                    <label class="col-form-label">description:</label>
                    <textarea type="text" name="description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submitCreateSurvey" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php include_once('includes/footer.html'); ?>
</body>
</html>