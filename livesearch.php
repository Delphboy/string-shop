<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 30/03/2018
 * Time: 19:56
 */
$items = array
(
    array("Anna", "images/uploads/no-image.png", "£150"),
    array("Amy", "http://www.hondahookup.com/images/100x100.jpg", "£300"),
    array("Bill", "http://www.hondahookup.com/images/100x100.jpg", "£300"),
    array("Ben", "http://www.hondahookup.com/images/100x100.jpg", "£300"),
    array("Charles", "http://www.hondahookup.com/images/100x100.jpg", "£300"),
    array("Charlie", "http://www.hondahookup.com/images/100x100.jpg", "£300"),
    array("Henry", "images/advert-pictures/expensive-fullsize-strings.jpg", "£700"),
);

$query = $_REQUEST['q'];

$hint = "";
if($query !== "")
{
    $query = strtolower($query);
    $len = strlen($query);
    for ($i = 0; $i < sizeof($items); $i++)
    {
        if(stristr($query, substr($items[$i][0], 0, $len)))
        {
            if($hint === "")
                $hint = "<li class='list-group-item container'>
                                <div class='col-md-1'>
                                    <img src='" . $items[$i][1] . "' style='width: 75px; height: auto' />
                                </div>
                                <div class='col-md-9 list-group-item-text'><h4>" . $items[$i][0] . "</h4></div>
                                <div class='col-md-9'>" . $items[$i][2] . "</div>
                         </li>";
            else
                $hint .= "<li class='list-group-item container'>
                                <div class='col-md-1'>
                                    <img src='" . $items[$i][1] . "' style='width: 75px; height: auto' />
                                </div>
                                <div class='col-md-9 list-group-item-text'><h4>" . $items[$i][0] . "</h4></div>
                                <div class='col-md-9'>" . $items[$i][2] . "</div>
                         </li>";
        }
    }
}
echo $hint === "" ? "<li class=\"list-group-item\">No suggestions</li>" : $hint;