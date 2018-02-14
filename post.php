<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop | Post an Advert';
$view->errorMsg = "";
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
    if($images['name'][0] != null)
    {
        $maxsize    = 2097152;
        $acceptable = array(
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
        );

        for ($i = 0; $i < count($images['name']); $i++)
        {
            if(($images['size'][$i] >= $maxsize) || ($images["size"][$i] == 0))
            {
                $view->errorMsg .= "<p class='label-warning'>File too large. File must be less than 2 megabytes.</p>";
            }

            if((!in_array($images['type'][$i], $acceptable)) && (!empty($images["type"][$i])))
            {
                $view->errorMsg .= "<p class='label-warning'>Invalid file type. Only JPG, GIF and PNG types are accepted.</p>";
            }
        }
    }
    if(strlen($view->errorMsg) <= 0)
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
