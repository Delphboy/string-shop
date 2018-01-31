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

if(isset($_GET['advert']))
{
    $advertCode = $_GET['advert'];

    $advertPK = (hexdec($advertCode) / 7);
    $advert = Advert::buildFromPK($advertPK);
    if($advert->getTitle() != null)
    {
        $view->advert = $advert->createDisplayTitle() . "\t<div class='col-md-6' xmlns=\"http://www.w3.org/1999/html\">\n" . $advert->createDisplayCategory() .
            $advert->createDisplayPrice() . $advert->createDisplayDescription() . "</div>"  . $advert->createDisplayPictures();
    }
}


if($_SESSION['isSignedIn'])
{
    require_once('Views/advert.phtml');
}
else
{
    header('Location: login.php');
}