<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['success']);
$_SESSION = array();
session_destroy();
header('Location: ../webcontent/index.php');
