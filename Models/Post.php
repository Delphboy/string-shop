<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 13/01/2018
 * Time: 10:04
 */

require_once ('DBConnection.php');
class Post
{
    function __construct()
    {
    }

    function postAdvert($title, $description, $category, $size, $age, $hasCase, $hasBow, $price, $pictures)
    {
        $db = DBConnection::getInstance();
        $date = date('Y-m-d');
        $userPK = $_SESSION['userID'];

        $advertQuery = "INSERT INTO Adverts(userPK, title, description, type, date, price, size, age, hasCase, hasBow) VALUES(:userPK, :title, :descr, :type, :today, :price, :size, :age, :hasCase, :bow);";
        $db->setQuery($advertQuery);
        $db->bindQueryValue(':userPK', $userPK);
        $db->bindQueryValue(':title', $title);
        $db->bindQueryValue(':descr', $description);
        $db->bindQueryValue(':type', $category);
        $db->bindQueryValue(':today', $date);
        $db->bindQueryValue(':price', $price);
        $db->bindQueryValue(':size', $size);
        $db->bindQueryValue(':age', $age);
        $db->bindQueryValue(':hasCase', $hasCase);
        $db->bindQueryValue(':bow', $hasBow);
        $db->run();

        $advertPK = $db->getLastID();

        //Handle Images
        if($pictures['name'][0] != null)
        {
            for ($i = 0; $i < count($pictures['name']); $i++)
            {
                $fileTmp = $_FILES['PostImages']['tmp_name'][$i];
                $fileName = $_FILES['PostImages']['name'][$i];
                $newFileName = $this->renameImage($fileName);
                $pictureQuery = "INSERT INTO AdvertPictures(advertPK, pictureLocation) VALUES (:advert, :fileLoc);";
                $db->setQuery($pictureQuery);
                $db->bindQueryValue(':advert', $advertPK);
                $db->bindQueryValue(':fileLoc', $newFileName);
                $db->run();
                $filePath = "images/uploads/" . $newFileName;
                move_uploaded_file($fileTmp, $filePath);
            }
        }
        else
        {
            $noImage = "no-image.png";
            $pictureQuery = "INSERT INTO AdvertPictures(advertPK, pictureLocation) VALUES (:advert, :fileLoc);";
            $db->setQuery($pictureQuery);
            $db->bindQueryValue(':advert', $advertPK);
            $db->bindQueryValue(':fileLoc', $noImage);
            $db->run();
        }

    }

    /**
     * Randomise the image file name to prevent web scrapping
     * @param $originalName
     * @return string
     */
    function renameImage($originalName)
    {
        $charBank = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $rndString = "";
        $explosion = explode(".", $originalName);
        $extension = end($explosion);
        for ($i = 0; $i < 20; $i++)
        {
            $rndNum = random_int(1, 61);
            $rndString = $rndString . $charBank[$rndNum];
        }
        return $rndString . "." . $extension;
    }

}