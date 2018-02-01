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

    if(isset($_GET['search']))
    {
        if(isset($_GET['hasCase']))
            $case = 1;
        else
            $case = 0;

        if(isset($_GET['hasBow']))
            $bow = 1;
        else
            $bow= 0;

        $view->searchResults =  $search->loadAdvertsBySearch(htmlentities($_GET['category']), htmlentities($_GET['search']), $bow, $case);
    }

    require_once('Views/search.phtml');
}
else
{
    header('Location: login.php');
}
