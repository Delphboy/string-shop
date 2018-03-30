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
                $hint = "<li class=\"list-group-item\">$name</li>";
            else
                $hint .= "<li class=\"list-group-item\">$name</li>";
        }
    }
}
echo $hint === "" ? "<li class=\"list-group-item\">No suggestions</li>" : $hint;