<?php
/**
 * Created by PhpStorm.
 * User: stc765
 * Date: 01/02/18
 * Time: 10:46
 */

require_once ('DBConnection.php');
require_once ('Advert.php');
class Search
{
    private $expireTimeString;
    private $expireTime;

    /**
     * Search constructor.
     */
    function __construct()
    {
        try
        {
            //Accounts for different file referencing - PHP is stupid
            if(file_exists("Models/expire.txt"))
            {
                $file = fopen("Models/expire.txt", "r") or die("Unable to open file!");
                $this->expireTimeString = fread($file,filesize("Models/expire.txt"));
            }
            else
            {
                $file = fopen("expire.txt", "r") or die("Unable to open file!");
                $this->expireTimeString = fread($file,filesize("expire.txt"));
            }
            fclose($file);
            $this->calcExpireTime();
        }
        catch (ErrorException $exception)
        {
            $this->expireTime = "14 DAY";
        }
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
     * Generate a list of adverts based on createSearchString conditions and return the display code for the createSearchString results
     * @param $category
     * @param $search
     * @param $hasBow
     * @param $hasCase
     * @param $group
     * @param $page
     * @return string
     */
    public function loadAdvertDisplayCode($category, $search, $hasBow, $hasCase, $group, $page)
    {
        $output = "";
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE date > NOW() - INTERVAL $this->expireTime";

        if(($category != null) && ($category !="everything")) $query = $query . " AND type = :cat";
        if(($search != null) && ($search !="")) $query = $query . " AND title LIKE :searchTitle";

        if(($hasBow != null) && ($hasBow == true)) $query = $query . " AND hasBow = :bow";
        if(($hasCase != null) && ($hasCase == true)) $query = $query . " AND hasCase = :case";

        if(($group != null) && ($group != "")) $query = $query . $group;
        if(($page !== null) && ($page >= 0)) $query = $query . " LIMIT " . ($page * 10) . ", 10";

        $query = $query . ";";

//        echo "<h2>$query</h2>";

        $db->setQuery($query);

        if(($category != null) && ($category !="everything")) $db->bindQueryValue(':cat', $category);
        if(($search != null) && ($search !="")) $db->bindQueryValue(':searchTitle', $search . "%");
        if(($hasBow != null) && ($hasBow == true)) $db->bindQueryValue(':bow', $hasBow);
        if(($hasCase != null) && ($hasCase == true)) $db->bindQueryValue(':case', $hasCase);

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


    /**
     * Generate a JSON object to be returned for use in the live createSearchString feature
     * @param $searchString
     * @return string
     */
    public function returnAdvertAJAXFromSearchString($searchString)
    {
        $adverts = array();
        $db = DBConnection::getInstance();
        $query = "SELECT advertID, title, description FROM Adverts WHERE date > NOW() - INTERVAL $this->expireTime";

        if(($searchString != null) && ($searchString !=""))
        {
            $query = $query . " AND title LIKE :searchTitle LIMIT 3;";
            $db->setQuery($query);
            $db->bindQueryValue(':searchTitle', $searchString . "%"); //applies a wildcard to the end of the query

            $data = $db->getAllResults();
            if(! empty($data))
            {
                for($rowCount = 0; $rowCount < count($data); $rowCount++)
                {
                    $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad LIMIT 1;");
                    $db->bindQueryValue(":ad", $data[$rowCount][0]);
                    $picture = $db->getRow();

                    $advert = new Advert($data[$rowCount][0], null, $data[$rowCount][1], $data[$rowCount][2], null, null, null, null, null, null, $picture,null);

                    $adverts[] = $advert;
                }
            }
        }

        return json_encode($adverts);
    }

    /**
     * Take the createSearchString parameters and return the Adverts as a JSON object
     * @param $category
     * @param $search
     * @param $hasBow
     * @param $hasCase
     * @param $group
     * @param $page
     * @return string
     */
    public function returnAdvertAJAXFromSearchQuery($category, $search, $hasBow, $hasCase, $group, $page)
    {
        $adverts = array();

        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE date > NOW() - INTERVAL $this->expireTime";

        if(($category != null) && ($category !="everything")) $query = $query . " AND type = :cat";
        if(($search != null) && ($search !="")) $query = $query . " AND title LIKE :searchTitle";
        if(($hasBow != null) && ($hasBow == true)) $query = $query . " AND hasBow = :bow";
        if(($hasCase != null) && ($hasCase == true)) $query = $query . " AND hasCase = :case";

        if(($group != null) && ($group != "")) $query = $query . $group;
        if(($page !== null) && ($page >= 0)) $query = $query . " LIMIT 10 OFFSET " . ($page * 10);
        $query = $query . ";";
        $db->setQuery($query);

        if(($category != null) && ($category !="everything")) $db->bindQueryValue(':cat', $category);
        if(($search != null) && ($search !="")) $db->bindQueryValue(':searchTitle', "%" . $search . "%");
        if(($hasBow != null) && ($hasBow == 1)) $db->bindQueryValue(':bow', $hasBow);
        if(($hasCase != null) && ($hasCase == 1)) $db->bindQueryValue(':case', $hasCase);

        $data = $db->getAllResults();
        if(! empty($data))
        {
            for($rowCount = 0; $rowCount < count($data); $rowCount++)
            {
                $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad LIMIT 1");
                $db->bindQueryValue(":ad", $data[$rowCount][0]);
                $picture = $db->getRow();

                $advert = new Advert($data[$rowCount][0], $data[$rowCount][1], $data[$rowCount][2], $data[$rowCount][3], $data[$rowCount][4], $data[$rowCount][7],
                    $data[$rowCount][8], $data[$rowCount][9], $data[$rowCount][10], $data[$rowCount][6], $picture, $data[$rowCount][5]);
                $adverts[] = $advert;
            }
        }
        return json_encode($adverts);
    }

    public function getResultCount($category, $search, $hasBow, $hasCase, $group)
    {
        $db = DBConnection::getInstance();
        $query = "SELECT title FROM Adverts WHERE date > NOW() - INTERVAL $this->expireTime";

        if(($category != null) && ($category !="everything")) $query = $query . " AND type = :cat";
        if(($search != null) && ($search !="")) $query = $query . " AND title LIKE :searchTitle";
        if(($hasBow != null) && ($hasBow == true)) $query = $query . " AND hasBow = :bow";
        if(($hasCase != null) && ($hasCase == true)) $query = $query . " AND hasCase = :case";

        if(($group != null) && ($group != "")) $query = $query . $group;

        $query = $query . ";";
        $db->setQuery($query);

        if(($category != null) && ($category !="everything")) $db->bindQueryValue(':cat', $category);
        if(($search != null) && ($search !="")) $db->bindQueryValue(':searchTitle', "%" . $search . "%");
        if(($hasBow != null) && ($hasBow == 1)) $db->bindQueryValue(':bow', $hasBow);
        if(($hasCase != null) && ($hasCase == 1)) $db->bindQueryValue(':case', $hasCase);

        return $db->getRowCount();
    }

}