<?php
/**
 * Created by PhpStorm.
 * User: diogo
 * Date: 08.07.2019
 * Time: 20:43
 */
session_start();

// Checks if the user is logged in
include_once('../includes/scripts/sessionHandler.php');

include_once('../includes/scripts/database.php');
include_once('../includes/scripts/create.php');

if (isset($_GET['id']) && isset($_GET['list'])) {
    $_SESSION['list'] = array(
        "list_ID" => $_GET['id'],
        "description" => $_GET['list']
    );
} else {
    header('Location: http://localhost/To-Do-List/sites/main.php');
}

$bulletpointdone = $con->prepare("UPDATE bulletpoints  SET done = 1 WHERE bulletpoint_ID IN (?)");
if (isset($_POST['submitDone'])) {
    $bulletpointdone->bind_param("i", $_POST['bulletpointID']);
    if ($bulletpointdone->execute()) {
        $bulletpointdone->close();
        $successMessage = 'Your bulletpoint has been changed to done.';
    } else {
        $bulletpointdone->close();
        $message = 'Your bulletpoint could not be changed to done. Please contact the development team.';
    }
}
$bulletpointnotdone = $con->prepare("UPDATE bulletpoints  SET done = 0 WHERE bulletpoint_ID IN (?)");
if (isset($_POST['submitNotDone'])) {
    $bulletpointnotdone->bind_param("i", $_POST['bulletpointID']);
    if ($bulletpointnotdone->execute()) {
        $bulletpointnotdone->close();
        $successMessage = 'Your bulletpoint has been changed to not done.';

    } else {
        $bulletpointnotdone->close();
        $message = 'Your bulletpoint could not be changed to not done. Please contact the development team.';
    }
}

$bulletpointrename = $con->prepare("UPDATE bulletpoints  SET description = (?) WHERE bulletpoint_ID IN (?)");
if (isset($_POST['submitRename'])) {
    $bulletpointrename->bind_param("si", $_POST['renameBulletpoint'], $_POST['bulletpointID']);
    if ($bulletpointrename->execute()) {
        $bulletpointrename->close();
        $successMessage = 'The description of your bulletpoint has been changed.';
    } else {
        $bulletpointrename->close();
        $message = 'The description of your bulletpoint could not be changed. Please contact the development team.';
    }
}

$bulletpointdelete = $con->prepare("DELETE FROM bulletpoints WHERE bulletpoint_ID = (?)");
if (isset($_POST['submitDelete'])) {
    $bulletpointdelete->bind_param("i", $_POST['bulletpointID']);
    if ($bulletpointdelete->execute()) {
        $bulletpointdelete->close();
        $successMessage = 'Your bulletpoint has been deleted.';
    } else {
        $bulletpointdelete->close();
        $message = 'Your bulletpoint could not be deleted Please contact the development team.';
    }
}

$bulletpoints = $con->prepare("SELECT bulletpoint_ID, description, done FROM bulletpoints WHERE list_FK IN (?)");
$bulletpoints->bind_param("i", $_SESSION['list']['list_ID']);
if ($bulletpoints->execute()) {
    $results = $bulletpoints->get_result();
} else {
    $message = 'The bulletpoints could not be loaded. Please contact the development team.';
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php
    include_once('../includes/files/head.html');
    ?>
</head>
<body>
<header>
    <?php
    include_once('../includes/files/navbar.php');
    ?>
</header>
<main data-aos="fade-right" data-aos-delay="300">
    <div class="container">
        <div class="row mt-5 border-bottom border-primary">
            <div class="col-md-9">
                <h1 style="word-wrap: break-word;"><?= $_SESSION['list']['description'] ?></h1>
            </div>
            <div class="col-md-3">
                <button type="button" data-toggle="modal" data-target="#createBulletpointModal"
                        class="btn btn-primary mb-2 ml-auto">Create New Bulletpoint
                </button>
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
                                echo '<tr class="border-bottom">
                                    <td style="width: 50%;word-wrap: break-word;">' . $row[1] . '</td>
                                    <form action"" method="post">';
                                if ($row[2] == 1) {
                                    echo '<td style="width: 20%;"><button type="submit" name="submitNotDone" class="btn btn-primary">Done</button>
                                        <input type="hidden" name="bulletpointID" value="' . $row[0] . '"></td>';
                                } elseif ($row[2] == 0) {
                                    echo '<td style="width: 20%;"><button type="submit" name="submitDone" class="btn btn-danger">Not done</button>
                                        <input type="hidden" name="bulletpointID" value="' . $row[0] . '"></td>';
                                }
                                echo '</form>
                                    <td style="width: 10%;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#renameModal" data-bulletpointname="' . $row[1] . '" data-bulletpointid="' . $row[0] . '">Rename</button></td>
                                    <td style="width: 10%;"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-bulletpointid="' . $row[0] . '">Delete</button></td>
                                    </tr>';
                            }
                        } else {
                            echo '<h3>No bulletpoints found</h3>';
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
include_once('../includes/files/bulletpointmodals/createBulletpointModal.html');
include_once('../includes/files/bulletpointmodals/renameModal.html');
include_once('../includes/files/bulletpointmodals/deleteModal.html');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#Link').click(function () {
            $.post("example.php", {n: "203000"});
        });
    });
</script>
</body>
</html>