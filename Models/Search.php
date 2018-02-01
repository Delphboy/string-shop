<?php
/**
 * Created by PhpStorm.
 * User: stc765
 * Date: 01/02/18
 * Time: 10:46
 */

class Search
{
    function __construct()
    {
    }

    function loadAdvertsBySearch($category)
    {
        $output = "";
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE TRUE ";

        if(($category != null) && ($category !="everything")) $query = $query . "AND type LIKE :cat";

        $query = $query . ";";
        $db->setQuery($query);

        if(($category != null) && ($category !="everything")) $db->bindQueryValue(':cat', $category);

        $data = $db->getAllResults();
        for($rowCount = 0; $rowCount < count($data); $rowCount++)
        {
            $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad");
            $db->bindQueryValue(":ad", $data[$rowCount][0]);
            $pictures = $db->getAllResults();

            $advert = new Advert($data[$rowCount][0], $data[$rowCount][1], $data[$rowCount][2], $data[$rowCount][3], $data[$rowCount][4], $data[$rowCount][7],
                $data[$rowCount][8], $data[$rowCount][9], $data[$rowCount][10], $data[$rowCount][6], $pictures);
            $output = $output . $advert->createPreviewCode();
        }
        return $output;
    }
}