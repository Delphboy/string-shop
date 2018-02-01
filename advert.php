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
    $view->PKCode = $advertCode;
    if($advert->getTitle() != null)
    {
        $view->isMadeByUser = ($advert->getUser() == $_SESSION['userID']);
        $view->advert = $advert->createDisplayTitle() . "\t<div class='col-md-6' xmlns=\"http://www.w3.org/1999/html\">\n" . $advert->createDisplayCategory() .
            $advert->createDisplayPrice() . $advert->createDisplayDescription() . "</div>"  . $advert->createDisplayPictures();
    }
    //check if advert is on wishlist
    $view->isOnWishlist = $advert->isOnWishlist($_SESSION['userID']);

}

if(isset($_POST['wishList']))
{
    if($advertPK != null)
    {
        $advert->addToWishlist($_SESSION['userID']);
        header("Refresh:0");
    }
}

if(isset($_POST['wishListRemove']))
{
    echo "HI";
   $advert->removeFromWishlist($_SESSION['userID']);
    header("Refresh: 0");
}

if(isset($_POST['msgSeller']))
{
    echo "Send a message to the seller";
}

if(isset($_POST['deleteAdvert']))
{
    $advert->delete();
    header("Location: user.php");
}

if($_SESSION['isSignedIn'])
{
    require_once('Views/advert.phtml');
}
else
{
    header('Location: login.php');
}