<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop';

if($_SESSION['isSignedIn'])
{
    require_once('Views/user.phtml');
}
else
{
    header('Location: login.php');
}