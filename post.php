<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Post an Advert';

require_once ('Models/Post.php');
require_once ('Models/Advert.php');

//$bool = false;
//if(!(empty($_FILES['PostImages'])))
//{
//    $bool = true;
//}
//if($bool==true)
//{
//    echo "<h1>SET</h1>";
//    $bool=false;
//} else {
//    echo "<h1>UNSET</h1>";
//}

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
//    if($_FILES['PostImages']['name'][0] == "")
//    {
//        echo "<h1>No file</h1>";
//    }
//    else
//    {
//        echo "<h1>File</h1>";
//    }

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
