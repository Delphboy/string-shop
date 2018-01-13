<h4>mySQL DB connection test</h4>



<?php
require_once ('Models/DBConnection.php');
$sql = $_POST["click"];

$dbHandle = DBConnection::getInstance();
$sqlQuery = $sql; // put your students table name
echo $sqlQuery;  //helpful for debugging to see what SQL query has been created

$dbHandle->runQuery($sqlQuery);

echo "<table border='1'>";
echo "<tr><td>PK</td><td>First Name</td><td>Surname</td><td>Email</td><td>Password</td><td>Address</td><td>Number</td></tr>";

while ($row = $dbHandle->getRow()) {
    echo "<tr><td>" . $row[0] ."</td><td>". $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3]  . "</td><td>" .
        $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td></tr>";}
echo "</table>";

$dbHandle = null;
?>
<form action="/sql.php" method="post">
    <select name="click">
        <option value='select * from Users'>select all users</option>

    </select>
    <input type="submit" value="Quick Search">
</form>