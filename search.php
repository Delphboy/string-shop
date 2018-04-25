<?php
session_start();

require_once ('Models/User.php');
require_once ('Models/Search.php');

$view = new stdClass();
$view->pageTitle = 'String Shop | Find an Instrument';
$viewLoaded = 0;
// Check whether page can be displayed and handle GET vars in URL
if(isset($_SESSION['isSignedIn']) && $_SESSION['isSignedIn'])
{
    $category = "everything";
    $searchString = "";
    $page = 0;

    //$user = new User($_SESSION['userID']);
    $search = new Search();
    if(isset($_POST['search']))
    {
        if(isset($_POST['hasCase']))
            $case = 1;
        else
            $case = 0;

        if(isset($_POST['hasBow']))
            $bow = 1;
        else
            $bow= 0;

        if(isset($_POST['order']))
        {
            switch($_POST['order'])
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
        }
        else
        {
            $group = " ORDER BY title";
        }
        $view->searchResults =  $search->loadAdvertDisplayCode($category, htmlentities($_POST['search']), $bow, $case, $group, $page);
    }
    require_once('Views/search.phtml');
}
else
{
    header('Location: login.php');
}
