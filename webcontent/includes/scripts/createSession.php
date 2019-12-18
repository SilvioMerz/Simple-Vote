<?php
session_start();

$_SESSION['USER'] = array(
    "USERNAME" => $username,
    'LASTLOGIN' => time(),
    'SUCCESS' => "You are now logged in"
);
