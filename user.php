<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop';
require_once ('Models/DBConnection.php');
require_once ('Models/User.php');

$user = new User($_SESSION['userID']);
$view->userAdverts = $user->loadUserMadeAdverts();

if($_SESSION['isSignedIn'])
{
    require_once('Views/user.phtml');
}
else
{
    header('Location: login.php');
}
