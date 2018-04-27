<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 25/05/2018
 * Time: 19:56
 */
//header('Content-Type: application/json');
header('Content-Type: text/plain');
session_start();
if(isset($_SESSION['isSignedIn']))
{
    if($_SESSION['isSignedIn'])
    {
        include_once ('Search.php');
        $search = new Search();

        switch($_REQUEST['order'])
        {
            case "relevant":
                $group = " ORDER BY title";
                break;
            case "highToLow":
                $group = " ORDER BY price DESC";
                break;
            case "lowToHigh":
                $group = " ORDER BY price";
                break;
            case "newToOld":
                $group = " ORDER BY date DESC";
                break;
            case "oldToNew":
                $group = " ORDER BY date";
                break;
            default:
                $group = " ORDER BY title";
                break;
        }

        $cat = $_REQUEST['cat'];

        $searchString = "";
        if(!isset($_REQUEST['search']) || $_REQUEST['search'] === "")
            $searchString = "";
        else
            $searchString = $_REQUEST['search'];

        $bow = $_REQUEST['bow'];
        $case = $_REQUEST['case'];
        $page = $_REQUEST['page'];
        echo $search->loadAdvertDisplayCode($cat, $searchString, $bow, $case, $group, $page);
    }
}