<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 30/03/2018
 * Time: 19:56
 */
header('Content-Type: application/json');
session_start();
const cap = 5;
const perSec = 1;
if(isset($_SESSION['isSignedIn']))
{
    if($_SESSION['isSignedIn'])
    {
        include_once ('Search.php');
        $search = new Search();

        $stamp_init = date("Y-m-d H:i:s");
        if( !isset( $_SESSION['FIRST_REQUEST_TIME'] ) ){
            $_SESSION['FIRST_REQUEST_TIME'] = $stamp_init;
        }
        $first_request_time = $_SESSION['FIRST_REQUEST_TIME'];

        //set expiry time to 3 seconds
        $stamp_expire = date( "Y-m-d H:i:s", strtotime( $first_request_time )+( perSec ) );
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
        header('X-RateLimit-Remaining: ' . ( cap-$req_count ) );
        if( $req_count > cap)//Too many requests
        {
            http_response_code( 429 );
            exit();
        }
        else
        {
            $query = $_REQUEST['q'];
            echo $search->returnAdvertAJAXFromSearchString($query);
        }
    }
}