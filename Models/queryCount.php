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

//Allow 3 requests
const cap = 3;

if(isset($_SESSION['isSignedIn']))
{
    if($_SESSION['isSignedIn'])
    {
        $stamp_init = date("Y-m-d H:i:s");
        if( !isset( $_SESSION['FIRST_REQUEST_TIME'] ) ){
            $_SESSION['FIRST_REQUEST_TIME'] = $stamp_init;
        }
        $first_request_time = $_SESSION['FIRST_REQUEST_TIME'];

        //set expiry time to 3 seconds
        $stamp_expire = date( "Y-m-d H:i:s", strtotime( $first_request_time )+( 3 ) );
        if( !isset( $_SESSION['REQ_COUNT'] ) ){
            $_SESSION['REQ_COUNT'] = 0;
        }
        $req_count = $_SESSION['REQ_COUNT'];
        $req_count++;
        if( $stamp_init > $stamp_expire ){//Expired
            $req_count = 1;
            $first_request_time = $stamp_init;
        }
        $_SESSION['REQ_COUNT'] = $req_count;
        $_SESSION['FIRST_REQUEST_TIME'] = $first_request_time;
        header('X-RateLimit-Limit: '.cap);
        header('X-RateLimit-Remaining: ' . ( cap - $req_count ) );
        if( $req_count > cap)//Too many requests
        {
            http_response_code( 429 );
            exit();
        }
        else
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
            echo $search->getResultCount($cat, $searchString, $bow, $case, $group);
        }
    }
}