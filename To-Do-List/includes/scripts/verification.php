<?php
/**
 * Created by PhpStorm.
 * User: 650680
 * Date: 08.07.2019
 * Time: 10:16
 */

include_once('database.php');
$confirmUser = $con->prepare("UPDATE users  SET confirmed = 1 WHERE verificationkey = (?)");
$key = htmlspecialchars(trim($_GET['key']));
$confirmUser->bind_param("i", $key);
if ($confirmUser->execute()) {
    $confirmUser->close();
    header("Location: http://localhost/To-Do-List/index.php?verified=true");
} else {
    $confirmUser->close();
    header("Location: http://localhost/To-Do-List/index.php?verified=false");
}
