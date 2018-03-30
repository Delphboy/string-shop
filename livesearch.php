<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 30/03/2018
 * Time: 19:56
 */

$a[] = "Anna";
$a[] = "Amy";
$a[] = "Bilyana";
$a[] = "Bill";
$a[] = "Charlie";
$a[] = "Charles";
$a[] = "Henry";

$query = $_REQUEST['q'];
$hint = "";
if($query !== "")
{
    $query = strtolower($query);
    $len = strlen($query);
    foreach ($a as $name)
    {
        if(stristr($query, substr($name, 0, $len)))
        {
            if($hint === "")
                $hint = "<li class='list-group-item container'>
                                <div class='col-md-1'>
                                    <img src='http://www.hondahookup.com/images/100x100.jpg' style='width: 50px; height: auto' />
                                </div>
                                <div class='col-md-9 list-group-item-text'><h4>$name</h4></div>
                                <div class='col-md-9'>$300</div>
                         </li>";
            else
                $hint .= "<li class='list-group-item container'>
                                <div class='col-md-1'>
                                    <img src='http://www.hondahookup.com/images/100x100.jpg' style='width: 50px; height: auto' />
                                </div>
                                <div class='col-md-9 list-group-item-text'><h4>$name</h4></div>
                                <div class='col-md-9'>$300</div>
                         </li>";
        }
    }
}
echo $hint === "" ? "<li class=\"list-group-item\">No suggestions</li>" : $hint;