<?php
/**
 * Created by PhpStorm.
 * User: stc765
 * Date: 29/01/18
 * Time: 15:22
 */

require_once ('DBConnection.php');

class Settings
{
    private $user;
    function __construct($user)
    {
        if($user != null)
        {
            $this->user = $user;
        }
    }
}