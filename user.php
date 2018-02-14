<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop | Your Adverts';
require_once ('Models/DBConnection.php');
require_once ('Models/User.php');

if($_SESSION['isSignedIn'])
{
    $user = new User($_SESSION['userID']);
    if(! isset($_GET['page']))
    {
        $_GET['page'] = 0;
    }
    $view->userAdverts = $user->loadUserMadeAdverts($_GET['page']);

    require_once('Views/user.phtml');
}
else
{
    header('Location: login.php');
}
