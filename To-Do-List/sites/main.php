<?php
session_start();

include_once('../includes/scripts/sessionHandler.php');
include_once('../includes/scripts/database.php');
include_once('../includes/scripts/create.php');

$listrename = $con->prepare("UPDATE lists  SET name = (?) WHERE list_ID IN (?)");
if (isset($_POST['submitRename'])) {
    $listrename->bind_param("si", $_POST['renameList'], $_POST['listID']);
    if ($listrename->execute()) {
        $listrename->close();
        $successMessage = 'The list name has been changed.';
    } else {
        $listrename->close();
        $message = 'The list name could not be changed. Please contact the development team.';
    }

}

$listdelete = $con->prepare("DELETE FROM lists WHERE list_ID = (?)");
if (isset($_POST['submitDelete'])) {
    $listdelete->bind_param("i", $_POST['listID']);
    if ($listdelete->execute()) {
        $listdelete->close();
        $successMessage = 'The list has been deleted.';
    } else {
        $listdelete->close();
        $message = 'The list could not be deleted. Please contact the development team.';

    }

}

$lists = $con->prepare("SELECT list_ID, name FROM lists WHERE user_FK  IN (?)");
$lists->bind_param("i", $_SESSION['user']['user_ID']);
if ($lists->execute()) {
    $results = $lists->get_result();
} else {
    $message = 'The lists could not be loaded. Please contact the development team.';
}


?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php include_once('../includes/files/head.html'); ?>
</head>
<body>
<header>
    <?php include_once('../includes/files/navbar.php'); ?>
</header>
<main data-aos="fade-right" data-aos-delay="300">

    <div class="container my-5 py-5">
        <div class="row my-3">
            <div class="col text-center border-bottom border-primary">
                <h1>Your lists</h1>
            </div>
        </div>
        <div class="row my-3">
            <div class="col text-center">
                <?= "<h4>Welcome back " . $_SESSION['user']['username'] . "!</h4>" ?>
            </div>
        </div>
        <div class="row my-3">
            <div class="col text-center">
                <?php
                if (isset($message)) {
                    echo '<div class="alert alert-dismissible alert-danger">';
                    echo $message;
                    echo '</div>';
                }
                if (isset($successMessage)) {
                    echo '<div class="alert alert-dismissible alert-success">';
                    echo $successMessage;
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div class="table-responsive table-sm table-borderless">
                    <table class="table table-sm" style="table-layout: fixed; width: 100%;">
                        <?php
                        if ($results->num_rows > 0) {
                            while ($row = $results->fetch_array()) {
                                echo '<tr class="border-bottom">';
                                echo '<td style="width: 60%"><h3 style="word-wrap: break-word;"><a href="list.php?list=' . $row[1] . '&id=' . $row[0] . '">' . $row[1] . '</a></h3></td>';
                                echo '<td style="width: 10%"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#renameModal" data-listname="' . $row[1] . '" data-listid="' . $row[0] . '">Rename</button></td>';
                                echo '<td style="width: 10%"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-listname="' . $row[1] . '" data-listid="' . $row[0] . '">Delete</button></td>';
                                echo '</tr>';
                            }
                            $results->close();
                        } else {
                            echo '<h3>No lists found</h3>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="push"></div>
</main>
<?php
include_once('../includes/files/footer.html');
include_once('../includes/files/bootstrapDependecies.html');
include_once('../includes/files/listmodals/createListModal.html');
include_once('../includes/files/listmodals/renameModal.html');
include_once('../includes/files/listmodals/deleteModal.html');
?>
</body>
</html>