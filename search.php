<?php
session_start();

require_once ('Models/User.php');
require_once ('Models/Search.php');

$view = new stdClass();
$view->pageTitle = 'String Shop';


if($_SESSION['isSignedIn'])
{
    $user = new User($_SESSION['userID']);
    $search = new Search();

    if(isset($_GET['category']))
    {
        $view->searchResults =  $search->loadAdvertsBySearch($_GET['category']);
    }

    require_once('Views/search.phtml');
}
else
{
    header('Location: login.php');
}
