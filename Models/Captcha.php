<?php
/**
 * Created by PhpStorm.
 * User: Henry Senior
 *
 * A Class to outline the captcha system used by the website.
 * Generate a string of random digits and place them in an image
 * The answer is stored in a session
 */

class Captcha
{
    /**
     * Captcha constructor.
     * Private as part of singleton design pattern
     */
    public function __construct()
    {    }

    /**
     * Return a captcha that can be completed by the user
     */
    public function getNextQuestion()
    {
        $number = mt_rand(100, 999);
        $_SESSION['captchaAnswer'] = $number;
        $imageToMake = imagecreate(100,100);
        $bgColour = imagecolorallocate($imageToMake, 0, 0, 255);
        $textColour = imagecolorallocate($imageToMake, 255, 255, 255);

        imagestring($imageToMake, 10, 10, 10, $number, $textColour);

        header("Content-type:image/png");
        return $image = imagepng($imageToMake);
    }

    private function createImage($number)
    {

    }

}