<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 27/01/2018
 * Time: 13:41
 */

class Advert
{
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
    public function __construct($title, $description, $category, $size, $age, $hasCase, $hasBow, $price, $pictures)
    {
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
    public function createDisplayCode()
    {
        if(strlen($this->description) > 325)
            $descriptionPreview = substr($this->description, 0, 325) . "...";
        else
            $descriptionPreview = $this->description;

        $output = "<div class='col-md-12'>\n";
        $output = $output . "\t<div class='col-md-2'>\n";
        $output = $output . "\t\t<img src='http://placehold.it/150x150' />\n";
        $output = $output . "\t</div>\n";
        $output = $output . "\t<div class='col-md-8'>\n";
        $output = $output . "\t\t<h2>$this->title</h2>\n";
        $output = $output . "\t\t<p><strong>Price:</strong> £$this->price</p>\n";
        $output = $output . "\t\t<p>$descriptionPreview</p>\n";
        $output = $output . "\t</div>\n";
        $output = $output . "\t<div class=\"col-xs-12\" style=\"height:50px;\"></div>\n"; //add vertical spacing between the adverts
        $output = $output . "</div>\n\n";
        return $output;
    }

}