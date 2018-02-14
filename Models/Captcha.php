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
        $rnd1 = random_int(1,100);
        $rnd2 = random_int(1,100);
        $_SESSION['captchaAns'] = $rnd1 + $rnd2;
        return "$rnd1 + $rnd2";
    }
}