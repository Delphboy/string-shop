<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 13/01/2018
 * Time: 10:04
 */

require_once ('DBConnection.php');
require_once ('Advert.php');
require_once ('User.php');

class User
{
    private $userID;
    private $expireTimeString;
    private $expireTime;

    /**
     * User constructor.
     * @param $userID
     */
    function __construct($userID)
    {
        if(($userID != null))
            $this->userID = (int)$userID;
        else
        {
            throw new InvalidArgumentException("Cannot make a user object without a valid user ID");
        }

        $file = fopen("Models/expire.txt", "r") or die("Unable to open file!");
        $this->expireTimeString = fread($file,filesize("Models/expire.txt"));
        fclose($file);
        $this->calcExpireTime();
    }

    /**
     * Calcaulate the expiry time limit for the SQL select
     */
    private function calcExpireTime()
    {
        switch ($this->expireTimeString)
        {
            case "1 week":
                $this->expireTime = "7 DAY";
                break;
            case "2 weeks":
                $this->expireTime = "14 DAY";
                break;
            case "1 month":
                $this->expireTime = "30 DAY";
                break;

            default:
                $this->expireTime = "14 DAY";
                break;
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
        if($page < 0)
        {
            $page = 0;
            $_GET['page'] = 0;
        }
        $query = "SELECT * FROM Adverts WHERE userPK = :ID AND date > NOW() - INTERVAL $this->expireTime LIMIT " . ($page * 10) . ", 10;";
        $db->setQuery($query);
        $db->bindQueryValue(':ID', $this->userID);
        $data = $db->getAllResults();
        for($rowCount = 0; $rowCount < count($data); $rowCount++)
        {
            $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad;");
            $db->bindQueryValue(":ad", $data[$rowCount][0]);
            $pictures = $db->getAllResults();

            $advert = new Advert($data[$rowCount][0], $data[$rowCount][1], $data[$rowCount][2], $data[$rowCount][3], $data[$rowCount][4], $data[$rowCount][7],
                $data[$rowCount][8], $data[$rowCount][9], $data[$rowCount][10], $data[$rowCount][6], $pictures, $data[$rowCount][5]);
            $output = $output . $advert->createPreviewCode();
        }
        return $output;
    }

    /**
     * Load all the adverts on a users wishlist, then create the display code
     * for each advert on the list
     * @param $page
     * @return string
     */
    function loadWishlist($page)
    {
        $output = "";
        $db = DBConnection::getInstance();
        if($page < 0)
        {
            $page = 0;
            $_GET['page'] = 0;
        }
        $query = "SELECT * FROM wishlist INNER JOIN Adverts On wishlist.advertPK = Adverts.advertID WHERE wishlist.userPK = :ID AND date > NOW() - INTERVAL $this->expireTime LIMIT " . ($page * 10) . ", 10;";
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
                $data[$rowCount][11], $data[$rowCount][12], $data[$rowCount][13], $data[$rowCount][9], $pictures, $data[$rowCount][6]);
            $output = $output . $advert->createPreviewCode();
        }
        return $output;
    }

    /**
     * Delete the user
     */
    public function delete()
    {
        $db = DBConnection::getInstance();

        // REMOVE FROM WISHLIST TABLE
        $query = "DELETE FROM wishlist WHERE userPK = :user;";
        $db->setQuery($query);
        $db->bindQueryValue(':user', $this->userID);
        $db->run();

        // Delete Adverts
        $query = "SELECT advertID FROM Adverts WHERE userPK = :user;";
        $db->setQuery($query);
        $db->bindQueryValue(':user', $this->userID);
        $data = $db->getAllResults();
        for($i = 0; $i < count($data); $i++)
        {
            $ad = Advert::buildFromPK($data[$i][0]);
            $ad->delete();
        }

        //Delete User
        $query = "DELETE FROM Users WHERE userID = :user;";
        $db->setQuery($query);
        $db->bindQueryValue(':user', $this->userID);
        $db->run();
    }

    /**
     * Change whether or not the user is admin
     */
    public function toggleAdmin()
    {
        $db = DBConnection::getInstance();
        $query = "SELECT isAdmin FROM Users WHERE userID = :user;";
        $db->setQuery($query);
        $db->bindQueryValue(':user', $this->userID);
        $isAdmin = $db->getRow()[0];

        if($isAdmin == 1)
        {
            $query = "UPDATE Users SET isAdmin = 0 WHERE userID = :user;";
            $db->setQuery($query);
            $db->bindQueryValue(':user', $this->userID);
            $db->run();
            if($this->userID == $_SESSION['userID'])
            {
                $_SESSION['isAdmin'] = false;
            }
        }
        else
        {
            $query = "UPDATE Users SET isAdmin = 1 WHERE userID = :user;";
            $db->setQuery($query);
            $db->bindQueryValue(':user', $this->userID);
            $db->run();
        }
    }

}