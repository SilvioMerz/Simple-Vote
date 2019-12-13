<?php

if (!isset($_SESSION['user']) || $_SESSION['user'] == NULL) {
    header("Location: http://localhost/To-Do-List");
    die();
}
?>