<?php
/**
 * Created by PhpStorm.
 * User: 650680
 * Date: 09.07.2019
 * Time: 09:57
 */

$listcreate = $con->prepare("INSERT INTO lists (name,user_FK) VALUES ((?),(?))");
if (isset($_POST['submitCreateList'])) {
    $listcreate->bind_param("si", $_POST['createList'], $_SESSION['user']['user_ID']);
    $listcreate->execute();
    $listcreate->close();
}

$bulletpointcreate = $con->prepare("INSERT INTO bulletpoints (description, done, list_FK) VALUES ((?),0,(?))");
if (isset($_POST['submitCreateBulletpoint'])) {
    $bulletpointcreate->bind_param("si", $_POST['createBulletpoint'], $_SESSION['list']['list_ID']);
    $bulletpointcreate->execute();
    $bulletpointcreate->close();
}