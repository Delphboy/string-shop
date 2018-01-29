<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop';

require_once ('Models/DBConnection.php');
require_once ('Models/User.php');

if($_SESSION['isSignedIn'])
{
    $user = new User($_SESSION['userID']);

    require_once('Views/settings.phtml');
}
else
{
    header('Location: login.php');
}
