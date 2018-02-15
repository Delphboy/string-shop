<?php
/**
 * Created by PhpStorm.
 * User: stc765
 * Date: 01/02/18
 * Time: 10:46
 */

class Search
{
    private $expireTimeString;
    private $expireTime;

    function __construct()
    {
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

    function loadAdvertsBySearch($category, $search, $hasBow, $hasCase, $group, $page)
    {
        $output = "";
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE date > NOW() - INTERVAL $this->expireTime";

        if(($category != null) && ($category !="everything")) $query = $query . " AND type = :cat";
        if(($search != null) && ($search !="")) $query = $query . " AND title LIKE :searchTitle";
        if(($hasBow != null) && ($hasBow == true)) $query = $query . " AND hasBow = :bow";
        if(($hasCase != null) && ($hasCase == true)) $query = $query . " AND hasCase = :case";

//        if(($group != null) && ($group != "")) $query = $query . " ORDER BY :group";
        if(($group != null) && ($group != "")) $query = $query . $group;
        if(($page !=null) && ($page >= 0)) $query = $query . " LIMIT " . ($page * 10) . ", 10";

        $query = $query . ";";
        $db->setQuery($query);

        if(($category != null) && ($category !="everything")) $db->bindQueryValue(':cat', $category);
        if(($search != null) && ($search !="")) $db->bindQueryValue(':searchTitle', "%" . $search . "%");
        if(($hasBow != null) && ($hasBow == 1)) $db->bindQueryValue(':bow', $hasBow);
        if(($hasCase != null) && ($hasCase == 1)) $db->bindQueryValue(':case', $hasCase);

//        if(($group != null) && ($group != "")) $db->bindQueryValue(':group', $group);

        $data = $db->getAllResults();
        if(! empty($data))
        {
            for($rowCount = 0; $rowCount < count($data); $rowCount++)
            {
                $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad");
                $db->bindQueryValue(":ad", $data[$rowCount][0]);
                $pictures = $db->getAllResults();

                $advert = new Advert($data[$rowCount][0], $data[$rowCount][1], $data[$rowCount][2], $data[$rowCount][3], $data[$rowCount][4], $data[$rowCount][7],
                    $data[$rowCount][8], $data[$rowCount][9], $data[$rowCount][10], $data[$rowCount][6], $pictures, $data[$rowCount][5]);
                $output = $output . $advert->createPreviewCode();
            }
        }
        return $output;
    }
}