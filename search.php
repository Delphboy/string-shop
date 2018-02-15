<?php
session_start();

require_once ('Models/User.php');
require_once ('Models/Search.php');

$view = new stdClass();
$view->pageTitle = 'String Shop | Find an Instrument';


if(isset($_SESSION['isSignedIn']) && $_SESSION['isSignedIn'])
{
    $user = new User($_SESSION['userID']);
    $search = new Search();
    if(isset($_GET['search']))
    {
        if(isset($_GET['hasCase']))
            $case = 1;
        else
            $case = 0;

        if(isset($_GET['hasBow']))
            $bow = 1;
        else
            $bow= 0;

        if(isset($_GET['order']))
        {
            switch($_GET['order'])
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
                    $group = null;
                    break;
            }
        }
        else
        {
            $group = null;
        }

        $view->searchResults =  $search->loadAdvertsBySearch(htmlentities($_GET['category']), htmlentities($_GET['search']), $bow, $case, $group, $_GET['page']);
    }

    require_once('Views/search.phtml');
}
else
{
    header('Location: login.php');
}
