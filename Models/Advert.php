<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 27/01/2018
 * Time: 13:41
 */
require_once ('DBConnection.php');
class Advert
{
    private $PK;
    private $user;
    private $title;
    private $description;
    private $category;
    private $size;
    private $age;
    private $hasCase;
    private $hasBow;
    private $price;
    private $pictures;

    /**
     * Advert constructor.
     * @param $PK
     * @param $user
     * @param $title
     * @param $description
     * @param $category
     * @param $size
     * @param $age
     * @param $hasCase
     * @param $hasBow
     * @param $price
     * @param $pictures
     */
    public function __construct($PK, $user, $title, $description, $category, $size, $age, $hasCase, $hasBow, $price, $pictures)
    {
        $this->PK = $PK;
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->size = $size;
        $this->age = $age;
        $this->hasCase = $hasCase;
        $this->hasBow = $hasBow;
        $this->price = $price;
        $this->pictures = $pictures;
    }

    /**
     * Create an Advert object from the PK of a field
     * @param $PK
     * @return Advert
     */
    public static function buildFromPK($PK)
    {
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM Adverts WHERE advertID = :PK";
        $db->setQuery($query);
        $db->bindQueryValue(":PK", $PK);
        $data = $db->getAllResults();

        $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad");
        $db->bindQueryValue(":ad", $PK);
        $pictures = $db->getAllResults();

        //Create an advert with the data from DB, if DB doesn't return, create an empty advert
        if($data != null)
        {
            $advert = new Advert($PK, $data[0][1], $data[0][2], $data[0][3], $data[0][4], $data[0][7],
                $data[0][8], $data[0][9], $data[0][10], $data[0][6], $pictures);
        }
        else
        {
            $advert = new Advert(null, null, null, null, null, null, null, null, null, null, null);
        }

        return $advert;
    }

    /**
     * @return mixed
     */
    public function getPK()
    {
        return $this->PK;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return mixed
     */
    public function getHasCase()
    {
        return $this->hasCase;
    }

    /**
     * @return mixed
     */
    public function getHasBow()
    {
        return $this->hasBow;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Take the information held in the advert object and place it in a HTML div that can be used to display the information
     * @return string
     */
    public function createPreviewCode()
    {
        if(strlen($this->description) > 120)
            $descriptionPreview = substr($this->description, 0, 120) . "...";
        else
            $descriptionPreview = $this->description;

        $code = dechex(($this->PK * 7));

        $output = "<div class='col-md-6'>\n
        \t<div class='col-md-6'>\n";

        if($this->pictures == null)
            $output = $output . "\t\t<img src='/images/no-image.png' width='250px' alt='Picture of the product'/>\n";
        else
            $output = $output . "\t\t<img src='/images/uploads/" . $this->pictures[0][0] . "' width='250px' alt='Picture of the product'/>\n";


        $output = $output . "\t</div>\n
        \t<div class='col-md-6'>\n
        \t\t<h2><a href='/advert.php?advert=" . $code . "'>$this->title</a></h2>\n
        \t\t<p><strong>Price:</strong> £$this->price</p>\n
        \t\t<p>$descriptionPreview</p>\n
        \t</div>\n
        \t<div class=\"col-xs-12\" style=\"height:50px;\"></div>\n
        </div>\n\n";
        return $output;
    }

    public function createDisplayTitle()
    {
        if($this->title == null)
            return null;

        $output = "";
        $output = $output . "<div class='col-md-12'>\n";
        $output = $output . "\t<h1>$this->title</h1>\n";
        $output = $output . "</div>\n";
        return $output;
    }

    public function createDisplayDescription()
    {
        if($this->title == null)
            return null;
//        $output = "\t<div class='col-md-6'>\n";
        $output =  "\t\t<p>$this->description</p>\n";
//        $output = $output . "</div>";
        return $output;
    }

    public function createDisplayCategory()
    {
        if($this->title == null)
            return null;
//        $output = "\t<div class='col-md-12'>\n";
        $output = "\t\t<h4>$this->category</h4>\n";
//        $output = $output . "\t</div>\n";
        return $output;
    }

    public function createDisplayPrice()
    {
        if($this->title == null)
            return null;
//        $output = "\t<div class='col-md-3'>\n";
        $output = "\t\t<p><strong>Price:</strong> £$this->price</p>\n";
//        $output = $output . "\t</div>\n";
        return $output;
    }

    /**
     * Create the HTML needed to display the images in a carousel
     * @return string
     */
    public function createDisplayPictures()
    {
        if($this->title == null)
            return null;

        $output = "\t<div class='col-md-6'>\n";
        $numOfImgs = count($this->pictures);

        // Display images in a carousel
        if($this->pictures != null)
        {
            $output = $output . "<div id=\"advert-picture-slides\" class=\"carousel slide\" data-ride=\"carousel\">\n";
            $output = $output . "\t\t<ol class=\"carousel-indicators\">\n";
            $output = $output . "\t\t\t<li data-target=\"#advert-picture-slides\" data-slide-to=\"0\" class=\"active\"></li>\n";
            for($i = 1; $i < $numOfImgs; $i++)
                $output = $output . "\t\t\t<li data-target=\"#advert-picture-slides\" data-slide-to=\"" . $i . "\"></li>\n";
            $output = $output . "\t\t</ol>\n";

            $output = $output . "\t<div class=\"carousel-inner\">\n";
            $output = $output . "\t\t<div class=\"item active animated fadeInRight\">\n";
            $output = $output . "\t\t\t<img src='/images/uploads/" . $this->pictures[0][0] . "' class=\"img-responsive\" />\n";
            $output = $output . "\t\t</div>\n";
            for($j = 1; $j < $numOfImgs; $j++)
            {
                $output = $output . "\t\t<div class=\"item animated fadeInRight\">\n";
                $output = $output . "\t\t\t<img src='/images/uploads/" . $this->pictures[$j][0] . "' class=\"img-responsive\" />\n";
                $output = $output . "\t\t</div>\n";
            }
            $output = $output . "\t</div>\n";

            $output = $output . "\t<div id=\"my-carousel\" class=\"carousel slide\" data-ride=\"carousel\">\n";
            $output = $output . "\t</div>\n";
            $output = $output . "\t<a class=\"left carousel-control\" href=\"#advert-picture-slides\" data-slide=\"prev\">\n";
            $output = $output . "\t<span class=\"icon-prev\"></span>\n";
            $output = $output . "\t</a>\n";
            $output = $output . "\t<a class=\"right carousel-control\" href=\"#advert-picture-slides\" data-slide=\"next\">\n";
            $output = $output . "\t<span class=\"icon-next\"></span>\n";
            $output = $output . "\t</a>\n";
            $output = $output . "</div>\n";
        }
        // Display error image
        else
        {
            $output = $output . "<div id=\"advert-picture-slides\" class=\"carousel slide\" data-ride=\"carousel\">\n";
            $output = $output . "\t\t<ol class=\"carousel-indicators\">\n";
            $output = $output . "\t\t\t<li data-target=\"#advert-picture-slides\" data-slide-to=\"0\" class=\"active\"></li>\n";
            $output = $output . "\t\t</ol>\n";

            $output = $output . "\t<div class=\"carousel-inner\">\n";
            $output = $output . "\t\t<div class=\"item active animated fadeInRight\">\n";
            $output = $output . "\t\t\t<img src='/images/no-image.png' class=\"img-responsive\" />\n";
            $output = $output . "\t\t</div>\n";
            $output = $output . "\t</div>\n";

            $output = $output . "\t<div id=\"my-carousel\" class=\"carousel slide\" data-ride=\"carousel\">\n";
            $output = $output . "\t</div>\n";
            $output = $output . "\t<a class=\"left carousel-control\" href=\"#advert-picture-slides\" data-slide=\"prev\">\n";
            $output = $output . "\t<span class=\"icon-prev\"></span>\n";
            $output = $output . "\t</a>\n";
            $output = $output . "\t<a class=\"right carousel-control\" href=\"#advert-picture-slides\" data-slide=\"next\">\n";
            $output = $output . "\t<span class=\"icon-next\"></span>\n";
            $output = $output . "\t</a>\n";
            $output = $output . "</div>\n";
        }
        return $output;
    }

    public function isOnWishlist($userID)
    {
        $db = DBConnection::getInstance();
        $query = "SELECT * FROM wishlist WHERE userPK = :user AND :advert;";
        $db->setQuery($query);
        $db->bindQueryValue(':user', $userID);
        $db->bindQueryValue(':advert', $this->PK);
        $db->run();
        $count = $db->getRowCount();
        return($count != 0);
    }

    public function addToWishlist($userID)
    {
        $db = DBConnection::getInstance();
        $query = "INSERT INTO wishlist(userPK, advertPK) VALUES(:user, :advert);";
        $db->setQuery($query);
        $db->bindQueryValue(':user', $userID);
        $db->bindQueryValue(':advert', $this->PK);
        $db->run();
    }

    public function removeFromWishlist($userID)
    {
        $db = DBConnection::getInstance();
        $query = "DELETE FROM wishlist WHERE advertPK = :advert AND userPK = :userPK;";
        $db->setQuery($query);
        $db->bindQueryValue(':advert', $this->PK);
        $db->bindQueryValue(':userPK', $this->user);
        $db->run();
    }

    /**
     * Delete the advert from all the tables it exists in
     * Also removes any pictures associated with the advert
     */
    public function delete()
    {
        $db = DBConnection::getInstance();

        // REMOVE FROM WISHLIST TABLE
        $query = "DELETE FROM wishlist WHERE advertPK = :advert;";
        $db->setQuery($query);
        $db->bindQueryValue(':advert', $this->PK);
        $db->run();

        // REMOVE PICTURES
        $query = "SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :advert;";
        $db->setQuery($query);
        $db->bindQueryValue(':advert', $this->PK);
        $data = $db->getAllResults();
        for($i = 0; $i < count($data); $i++)
        {
            unlink("images/uploads/" . $data[$i][0]);
        }

        // REMOVE FROM PICTURES TABLE
        $query = "DELETE FROM AdvertPictures WHERE advertPK = :advert;";
        $db->setQuery($query);
        $db->bindQueryValue(':advert', $this->PK);
        $db->run();

        //REMOVE FROM ADVERTS TABLE
        $db = DBConnection::getInstance();
        $query = "DELETE FROM Adverts WHERE advertID = :advert;";
        $db->setQuery($query);
        $db->bindQueryValue(':advert', $this->PK);
        $db->run();
    }

}