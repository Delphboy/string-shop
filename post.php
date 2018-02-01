<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Post an Advert';

require_once ('Models/Post.php');
require_once ('Models/Advert.php');


if(isset($_POST['submit']))
{
    $postObj = new Post();
    $title = $_POST['PostTitle'];
    $desc = $_POST['PostDescription'];
    $category = $_POST['PostCategory'];
    $size = $_POST['PostSize'];
    $age = $_POST['PostAge'];
    $price = $_POST['PostPrice'];

    if(isset($_POST['PostCase']))
        $case = 1;
    else
        $case = 0;

    if(isset($_POST['PostBow']))
        $bow = 1;
    else
        $bow= 0;

    $images = $_FILES['PostImages'];
    $postObj->postAdvert($title, $desc, $category, $size, $age, $case, $bow, $price, $images);
}

if($_SESSION['isSignedIn'])
{
    require_once('Views/post.phtml');
}
else
{
    header('Location: login.php');
}
