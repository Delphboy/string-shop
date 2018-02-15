<?php
session_start();
require_once ('Models/Admin.php');

$view = new stdClass();
$view->pageTitle = 'String Shop | Admin';


$model = new Admin();
$view->usersTable = $model->generateTableOfUsers();
$view->advertsTable = $model->generateTableOfAdverts();
$view->expiryTime = $model->getExpiryTime();


if(isset($_POST['isAdminBtn']))
{
    $model->toggleAdmin($_POST['isAdminBtn']);
}

if(isset($_POST['deleteUser']))
{
    $model->deleteUser($_POST['deleteUser']);
}

if(isset($_POST['deleteAdvert']))
{
    $model->deleteAdvert($_POST['deleteAdvert']);
}


if(isset($_POST['changeAdvertExpirySubmit']))
{
    $model->setExpiryTime($_POST['expiryTime']);
    header("refresh: 0");
}

if(isset($_SESSION['isSignedIn']) && $_SESSION['isSignedIn'] && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])
{
    require_once('Views/admin.phtml');
}
else
{
    header('Location: login.php');
}