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

    echo "<table border='1'>";
//echo "<tr><td>PK</td><td>First Name</td><td>Surname</td><td>Email</td><td>Password</td><td>Address Line 1</td><td>Postcode</td><td>Number</td></tr>";

    while ($row = $dbHandle->getRow())
    {
        echo "<tr>";
        for($i = 0; $i < sizeof($row) / 2; $i++)
        {
            if($row != null)
                echo "<td>" . $row[$i] ."</td>";
        }
        echo "</tr>";
    }

    echo "</table>";

    $dbHandle = null;
}
?>