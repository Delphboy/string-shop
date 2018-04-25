<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 25/05/2018
 * Time: 19:56
 */
//header('Content-Type: application/json');
session_start();
if(isset($_SESSION['isSignedIn']))
{
    if($_SESSION['isSignedIn'])
    {
        include_once ('Search.php');
        $search = new Search();

        $cat = $_REQUEST['c'];
//        $search = $_REQUEST['s'];
//        $bow = $_REQUEST['b'];
//        $case = $_REQUEST['ca'];
//        $group = $_REQUEST['g'];

//        echo $_REQUEST['a'] . "<br/>";
//        echo $_REQUEST['b'] . "<br/>";
//        echo $_REQUEST['c'] . "<br/>";

//        echo $search->loadAdvertDisplayCode($cat, $search, $bow, $case, $group, 1);
        echo $search->loadAdvertDisplayCode($cat, null, null, null, null, 0);
    }
}