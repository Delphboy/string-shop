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
    public function __construct($PK, $title, $description, $category, $size, $age, $hasCase, $hasBow, $price, $pictures)
    {
        $this->PK = $PK;
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
        $data = $db->getResults();

        $db->setQuery("SELECT pictureLocation FROM AdvertPictures WHERE advertPK = :ad");
        $db->bindQueryValue(":ad", $PK);
        $pictures = $db->getResults();

        $advert = new Advert($PK, $data[0][2], $data[0][3], $data[0][4], $data[0][7],
            $data[0][8], $data[0][9], $data[0][10], $data[0][6], $pictures);

        return $advert;
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
        if(strlen($this->description) > 325)
            $descriptionPreview = substr($this->description, 0, 325) . "...";
        else
            $descriptionPreview = $this->description;

        $code = dechex(($this->PK * 7));

        $output = "<div class='col-md-12'>\n
        \t<div class='col-md-2'>\n
        \t\t<img src='/images/uploads/" . $this->pictures[0][0] . "' width='150px' alt='Picture of the product'/>\n
        \t</div>\n
        \t<div class='col-md-8'>\n
        \t\t<h2><a href='/advert.php?advert=" . $code . "'>$this->title</a></h2>\n
        \t\t<p><strong>Price:</strong> £$this->price</p>\n
        \t\t<p>$descriptionPreview</p>\n
        \t</div>\n
        \t<div class=\"col-xs-12\" style=\"height:50px;\"></div>\n
        </div>\n\n";
        return $output;
    }

    /**
     * Take the information held in the advert object and place it in a HTML div that can be used to display the information
     * @return string
     */
    public function createDisplayCode()
    {
        $numOfImgs = count($this->pictures);

        $output = "<div class='col-md-12'>\n";
        $output = $output . "\t<h1>$this->title</h1>\n\n\n";
//        $output = $output . "\t<div class='col-md-4'>\n";



//        $output = $output . "\t\t<img src='/images/uploads/" . $this->pictures[0][0] . "' alt='Picture of the product'/>\n";

        $output = $output . "<div id=\"carouselExampleControls\" class=\"carousel slide\" data-ride=\"carousel\">\n
        <div class=\"carousel-inner\" role=\"listbox\">\n
        <div class=\"carousel-item active\">\n
        <img class=\"d-block img-fluid\" src='/images/uploads/" . $this->pictures[0][0] . "' alt=\"User uploaded image\">\n
        </div>\n";

        for($i = 1; $i < $numOfImgs; $i++)
        {
            $output = $output . "<div class=\"carousel-item \">\n";
            $output = $output . "<img class=\"d-block img-fluid\" src='/images/uploads/" . $this->pictures[$i][0] . "' alt=\"User uploaded image\">\n";
            $output = $output . "</div>\n";
        }

        $output = $output . "<a class=\"carousel-control-prev\" href=\"#carouselExampleControls\" role=\"button\" data-slide=\"prev\">\n";
        $output = $output . "<span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>\n";
        $output = $output . "<span class=\"sr-only\">Previous</span>\n";
        $output = $output . "</a>\n";
        $output = $output . "<a class=\"carousel-control-next\" href=\"#carouselExampleControls\" role=\"button\" data-slide=\"next\">\n";
        $output = $output . "<span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>\n";
        $output = $output . "<span class=\"sr-only\">Next</span>\n";
        $output = $output . "</a>\n";
        $output = $output . "</div>\n";



//        $output = $output . "\t</div>\n";
        $output = $output . "\t<div class='col-md-8'>\n";
        $output = $output . "\t\t<h3>Description</h3>\n";
        $output = $output . "\t\t<p>$this->description</p>\n";
        $output = $output . "\t\t<p><strong>Price:</strong> £$this->price</p>\n";
        $output = $output . "\t<input type='button' value='Add To Wishlist' class='glyphicon-bullhorn'/>";
        $output = $output . "\t<input type='button' value='Message Seller' class='glyphicon-bullhorn'/>";
        $output = $output . "\t</div>\n";
        $output = $output . "</div>\n\n";
        return $output;
    }

}