<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 30/03/2018
 * Time: 19:56
 */

include_once ('Search.php');
$search = new Search();

$query = $_REQUEST['q'];
echo $search->returnAdvertAJAXFromSearch($query);