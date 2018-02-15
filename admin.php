<?php
session_start();
require_once ('Models/Admin.php');

$view = new stdClass();
$view->pageTitle = 'String Shop | Admin';

//Load model and create displayable information
$model = new Admin();
$view->usersTable = $model->generateTableOfUsers();
$view->advertsTable = $model->generateTableOfAdverts();
$view->expiryTime = $model->getExpiryTime();

//Check if the admin button has been pressed
if(isset($_POST['isAdminBtn']))
{
    $model->toggleAdmin($_POST['isAdminBtn']);
}

//Check if the deleteUser button has been selected
if(isset($_POST['deleteUser']))
{
    $model->deleteUser($_POST['deleteUser']);
}

//Check if the deleteAdvert button has been pressed
if(isset($_POST['deleteAdvert']))
{
    $model->deleteAdvert($_POST['deleteAdvert']);
}

// Check if the advert expiry has been changed
if(isset($_POST['changeAdvertExpirySubmit']))
{
    $model->setExpiryTime($_POST['expiryTime']);
    header("refresh: 0"); //refresh to update graphics
}

//Check conditions for displaying page. If fail, redirect to login page
if(isset($_SESSION['isSignedIn']) && $_SESSION['isSignedIn'] && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])
{
    require_once('Views/admin.phtml');
}
else
{
    header('Location: login.php');
}