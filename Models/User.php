<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 13/01/2018
 * Time: 10:04
 */

require_once ('DBConnection.php');
require_once ('Advert.php');

class User
{
    private $userID;

    function __construct($userID)
    {
        if(($userID != null))
            $this->userID = (int)$userID;
        else
        {
            throw new InvalidArgumentException("Cannot make a user object without a valid user ID");
        }
    }

    /**
     * Load user's adverts and store them in a displayable string
     * @param $page
     * @return string
     */
    function loadUserMadeAdverts($page)
    {
        $output = "";
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE userPK = :ID LIMIT " . ($page * 10) . ", 10;";
        $db->setQuery($query);
        $db->bindQueryValue(':ID', $this->userID);
        $data = $db->getAllResults();
        for($rowCount = 0; $rowCount < count($data); $rowCount++)
        {
            $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad;");
            $db->bindQueryValue(":ad", $data[$rowCount][0]);
            $pictures = $db->getAllResults();

            $advert = new Advert($data[$rowCount][0], $data[$rowCount][1], $data[$rowCount][2], $data[$rowCount][3], $data[$rowCount][4], $data[$rowCount][7],
                $data[$rowCount][8], $data[$rowCount][9], $data[$rowCount][10], $data[$rowCount][6], $pictures);
            $output = $output . $advert->createPreviewCode();
        }
        return $output;
    }

    function loadWishlist($page)
    {
        $output = "";
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM wishlist INNER JOIN Adverts On wishlist.advertPK = Adverts.advertID WHERE wishlist.userPK = :ID LIMIT " . ($page * 10) . ", 10;";
        $db->setQuery($query);
        $db->bindQueryValue(':ID', $this->userID);
        $data = $db->getAllResults();
        for($rowCount = 0; $rowCount < count($data); $rowCount++)
        {
            $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad");
            $db->bindQueryValue(":ad", $data[$rowCount][2]);
            $pictures = $db->getAllResults();

            //__construct($PK, $title, $description, $category, $size, $age, $hasCase, $hasBow, $price, $pictures)
            $advert = new Advert($data[$rowCount][2], $data[$rowCount][1], $data[$rowCount][5], $data[$rowCount][6], $data[$rowCount][7], $data[$rowCount][10],
                $data[$rowCount][11], $data[$rowCount][12], $data[$rowCount][13], $data[$rowCount][9], $pictures);
            $output = $output . $advert->createPreviewCode();
        }
        return $output;
    }

}