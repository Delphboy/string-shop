<?php
/**
 * Created by PhpStorm.
 * User: stc765
 * Date: 30/01/18
 * Time: 09:06
 */
session_start();
require_once ('Models/Advert.php');
$view = new stdClass();
$view->pageTitle = 'Advert Page';

$advertCode = $_GET['advert'];
$advertPK = (hexdec($advertCode) / 7);
$advert = Advert::buildFromPK($advertPK);
$view->advert = $advert->createDisplayTitle() . "\t<div class='col-md-6'>\n" . $advert->createDisplayCategory() .
    $advert->createDisplayPrice() . $advert->createDisplayDescription() . "</div>"  . $advert->createDisplayPictures() .
    "<br>" .
    "<a href=\"\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-plus\"></span> Add to Wish List</a>" .
    "<a href=\"\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-envelope\"></span> Message Seller</a>" .
    "</div>";

if($_SESSION['isSignedIn'])
{
    require_once('Views/advert.phtml');
}
else
{
    header('Location: login.php');
}