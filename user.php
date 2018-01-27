<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop';
require_once ('Models/DBConnection.php');



$db = DBConnection::getInstance();
$query = "SELECT * FROM Adverts WHERE userPK LIKE :ID;";
$db->setQuery($query);
$db->bindQueryValue(':ID', $_SESSION['userID']);
$data = $db->getRow();

echo "<table border='1'>";

for($i = 0; $i < count($data) / 2; $i++)
{
    echo "<tr>";
    for($j = 0; $j < count($data[$i]) / 2; $j++)
    {
        echo "<td>" . $data[$i][$j] . "</td>\n";
    }
    echo "</tr>\n";
}

echo "</table>";




if($_SESSION['isSignedIn'])
{
    require_once('Views/user.phtml');
}
else
{
    header('Location: login.php');
}
