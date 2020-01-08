<?php
session_start();

$_SESSION['USER'] = array(
    "USERNAME" => $username,
    "USERID" => $userId,
    'LASTLOGIN' => time(),
    'SUCCESS' => "You are now logged in"
);
