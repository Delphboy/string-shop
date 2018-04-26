<?php
session_start();
header("text/html");
require_once ('Models/User.php');
require_once ('Models/Search.php');

$view = new stdClass();
$view->pageTitle = 'String Shop | Find an Instrument';
$viewLoaded = 0;

if(isset($_SESSION['isSignedIn']) && $_SESSION['isSignedIn'])
{
    require_once('Views/search.phtml');
}
else
{
    header('Location: login.php');
}
