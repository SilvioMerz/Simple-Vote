<?php

$con = new mysqli("localhost", "root", "", "to-do-list-database");
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}
