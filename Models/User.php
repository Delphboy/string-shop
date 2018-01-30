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
     * @return string
     */
    function loadUserMadeAdverts()
    {
        $output = "";
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE userPK = :ID;";
        $db->setQuery($query);
        $db->bindQueryValue(':ID', $this->userID);
        $data = $db->getResults();
        for($rowCount = 0; $rowCount < count($data); $rowCount++)
        {
            $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad");
            $db->bindQueryValue(":ad", $data[$rowCount][0]);
            $pictures = $db->getResults();

            $advert = new Advert($data[$rowCount][0], $data[$rowCount][2], $data[$rowCount][3], $data[$rowCount][4], $data[$rowCount][7],
                $data[$rowCount][8], $data[$rowCount][9], $data[$rowCount][10], $data[$rowCount][6], $pictures);
            $output = $output . $advert->createPreviewCode();
        }
        return $output;
    }

}