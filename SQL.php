<h4>mySQL DB connection test</h4>



<form action="/sql.php" method="post">
    <select name="click">
        <option value='select * from Users'>select all users</option>
        <option value='select * from Adverts'>select all adverts</option>
        <option value='select * from AdvertPictures'>select all advert pics</option>
        <option value='select * from Wishlists'>select all wishlist</option>

    </select>
    <input type="submit" value="Quick Search">
</form>

<?php
require_once ('Models/DBConnection.php');
if(isset($_POST['click']))
{
    $sql = $_POST["click"];

    $dbHandle = DBConnection::getInstance();
    $sqlQuery = $sql; // put your students table name
    echo $sqlQuery;  //helpful for debugging to see what SQL query has been created

    $dbHandle->runQuery($sqlQuery);

    $data = $dbHandle->getRow();

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

    $dbHandle = null;
}
?>