<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop | Wishlist';
require_once ('Models/DBConnection.php');
require_once ('Models/User.php');

if(isset($_SESSION['isSignedIn']) && $_SESSION['isSignedIn'])
{
    $user = new User($_SESSION['userID']);
    if(! isset($_GET['page']))
    {
        $_GET['page'] = 0;
    }
    $view->userWishlist = $user->loadWishlist($_GET['page']);

    require_once('Views/wishlist.phtml');
}
else
{
    header('Location: login.php');
}
