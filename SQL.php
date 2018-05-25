<?php session_start();?>
<h4>mySQL DB connection test</h4>

<form action="/SQL.php" method="post">
    <select name="click">
        <option value='select * from Users'>select all users</option>
        <option value='select * from Adverts'>select all adverts</option>
        <option value='select * from AdvertPictures'>select all advert pics</option>
        <option value='select * from wishlist'>select all wishlist</option>

    </select>
    <input type="submit" value="Quick Search" name="search">
    <input type="submit" value="Generate 100 Adverts" name="generate">
</form>

<?php
require_once ('Models/DBConnection.php');
require_once ('Models/Captcha.php');

if(isset($_POST['search']))
{
    $sql = $_POST["click"];

    $dbHandle = DBConnection::getInstance();
    $sqlQuery = $sql; // put your students table name
    echo $sqlQuery;  //helpful for debugging to see what SQL query has been created

    $dbHandle->runQuery($sqlQuery);

    $data = $dbHandle->getAllResults();

    echo "<table border='1'>";

    for($i = 0; $i < count($data); $i++)
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

if(isset($_POST['generate']))
{
    for($i = 200; $i < 300; $i++)
    {
        $db = DBConnection::getInstance();
        $date = date('Y-m-d');
        $userPK = $_SESSION['userID'];

        $advertQuery = "INSERT INTO Adverts(userPK, title, description, type, date, price, size, age, hasCase, hasBow) VALUES(:userPK, :title, :descr, :type, :today, :price, :size, :age, :hasCase, :bow);";
        $db->setQuery($advertQuery);
        $db->bindQueryValue(':userPK', $userPK);
        $db->bindQueryValue(':title', "Test: " . $i);
        $db->bindQueryValue(':descr', "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce imperdiet odio vitae faucibus pretium. Phasellus dictum nisi lobortis, venenatis augue eu, pretium dolor. Curabitur sit amet bibendum erat. Ut vel aliquet lectus. Fusce lacus velit, venenatis in est non, lobortis sagittis odio. Morbi id enim pellentesque, varius sapien nec, accumsan nisi. Nullam et arcu hendrerit, molestie lacus sit amet, convallis eros. Aliquam pulvinar bibendum molestie. Curabitur velit risus, blandit a mi eu, sagittis ornare orci. Nam pharetra, leo quis tincidunt porttitor, lorem leo sollicitudin dui, sit amet finibus ligula enim at turpis. In sollicitudin finibus nisi, ut posuere augue scelerisque iaculis. Proin non aliquet nisl. Phasellus feugiat, sem rhoncus mattis auctor, sem nisl vestibulum orci, et consectetur est nulla id nulla. ");

        $rndCat = random_int(1,6);
        switch ($rndCat)
        {
            case 1:
                $db->bindQueryValue(':type', "violin");
                break;
            case 2:
                $db->bindQueryValue(':type', "viola");
                break;
            case 3:
                $db->bindQueryValue(':type', "cello");
                break;
            case 4:
                $db->bindQueryValue(':type', "bass");
                break;
            case 5:
                $db->bindQueryValue(':type', "music");
                break;
            case 6:
                $db->bindQueryValue(':type', "accessory");
                break;
        }

        $rndSize = random_int(1,8);
        switch ($rndSize)
        {
            case 1:
                $db->bindQueryValue(':size', "0");
                break;
            case 2:
                $db->bindQueryValue(':size', "4/4");
                break;
            case 3:
                $db->bindQueryValue(':size', "3/4");
                break;
            case 4:
                $db->bindQueryValue(':size', "1/2");
                break;
            case 5:
                $db->bindQueryValue(':size', "1/4");
                break;
            case 6:
                $db->bindQueryValue(':size', "1/8");
                break;
            case 7:
                $db->bindQueryValue(':size', "1/16");
                break;
            case 8:
                $db->bindQueryValue(':size', "1/64");
                break;
        }

        $rndAge= random_int(1,7);
        switch ($rndAge)
        {
            case 1:
                $db->bindQueryValue(':age', "unknown");
                break;
            case 2:
                $db->bindQueryValue(':age', "new");
                break;
            case 3:
                $db->bindQueryValue(':age', "<10");
                break;
            case 4:
                $db->bindQueryValue(':age', ">10");
                break;
            case 5:
                $db->bindQueryValue(':age', "<50");
                break;
            case 6:
                $db->bindQueryValue(':age', "<100");
                break;
            case 7:
                $db->bindQueryValue(':age', ">100");
                break;
        }

        $db->bindQueryValue(':today', $date);
        $db->bindQueryValue(':price', random_int(0, 1000));
        $db->bindQueryValue(':hasCase', random_int(0, 1));
        $db->bindQueryValue(':bow', random_int(0, 1));
        $db->run();

        $advertPK = $db->getLastID();

        //Handle Images
        $noImage = "no-image.png";
        $pictureQuery = "INSERT INTO AdvertPictures(advertPK, pictureLocation) VALUES (:advert, :fileLoc);";
        $db->setQuery($pictureQuery);
        $db->bindQueryValue(':advert', $advertPK);
        $db->bindQueryValue(':fileLoc', $noImage);
        $db->run();
    }
}
?>