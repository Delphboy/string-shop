<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Post an Advert';


if(isset($_POST))
{

}


if($_SESSION['isSignedIn'])
{
    require_once('Views/post.phtml');
}
else
{
    header('Location: login.php');
}
