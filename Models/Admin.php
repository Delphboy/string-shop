<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 27/01/2018
 * Time: 13:41
 */
require_once ('DBConnection.php');
require_once ('Admin.php');
require_once ('User.php');
class Admin
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a container (div) for each user in the database.
     * Each attribute of the item in a sub div, allowing for responsive design
     * @return string
     */
    public function generateUserDivs()
    {
        $sqlQuery = "SELECT userID, firstName, surname, email, isAdmin FROM Users";

        $dbHandle = DBConnection::getInstance();
        $dbHandle->runQuery($sqlQuery);

        $data = $dbHandle->getAllResults();

        $output = "";


        for($i = 0; $i < count($data); $i++)
        {
            $output .= "<div class=\"col-md-12\" style=\"border: solid\">";
            for($j = 0; $j < (count($data[$i]) / 2); $j++)
            {
                if($j < 4)
                {
                    $output .= "<div class=\"col-md-2\">" . $data[$i][$j] . "</div>\n";
                }
                else
                {
                    if($data[$i][$j] == 1)
                    {
                        $output .= "<div class=\"col-md-2\"><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button type='submit' name='isAdminBtn' value='" . $data[$i][0] . "' class='btn btn-danger'>Remove Admin</button></form></div>";
                    }
                    else
                    {
                        $output .= "<div class=\"col-md-2\"><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button type='submit' name='isAdminBtn' value='" . $data[$i][0] . "' class='btn btn-success'>Make Admin</button></form></div>";
                    }
                }
            }
            $output .= "<div class=\"col-md-2\"><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button name='deleteUser' value='" . $data[$i][0] . "' type='submit' class='btn btn-danger'>Delete User</button></form></div>
                        </div><span class=\"col-md-12\" style=\"padding-top: 10px\"></span>";
        }

        return $output;
    }

    /**
     * Create a container (div) for each advert in the database.
     * Each attribute of the item in a sub div, allowing for responsive design
     * @return string
     */
    public function generateAdvertDivs()
    {
        $sqlQuery = "SELECT advertID, userPK, title, type, date, price FROM Adverts";

        $dbHandle = DBConnection::getInstance();
        $dbHandle->runQuery($sqlQuery);

        $data = $dbHandle->getAllResults();

        $output = "";


        for($i = 0; $i < count($data); $i++)
        {
            $output .= "<div class=\"col-md-12\" style=\"border: solid\">";
            for($j = 0; $j < (count($data[$i]) / 2); $j++)
            {
                if($j < 2)
                {
                    $output .= "<div class=\"col-md-1\">" . $data[$i][$j] . "</div>\n";
                }
                else
                {
                    $output .= "<div class=\"col-md-2\">" . $data[$i][$j] . "</div>\n";
                }
            }
            $output .= "<div class=\"col-md-2\"><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button name='deleteAdvert' value='" . $data[$i][0] . "' type='submit' class='btn btn-danger'>Delete Advert</button></form></div>";
            $output .= "</div><span class=\"col-md-12\" style=\"padding-top: 10px\"></span>";
        }

        return $output;
    }

    /**
     * Delete the user based on their ID
     * @param $ID
     */
    public function deleteUser($ID)
    {
        $user = new User($ID);
        $user->delete();
        header("Refresh: 0");
    }

    /**
     * Delete an advert based on its ID
     * @param $ID
     */
    public function deleteAdvert($ID)
    {
        $ad = Advert::buildFromPK($ID);
        $ad->delete();
        header("Refresh: 0");
    }

    /**
     * Toggle whether or not a user is admin
     * @param $ID
     */
    public function toggleAdmin($ID)
    {
        $user = new User($ID);
        $user->toggleAdmin();
        header("Refresh: 0");
    }

    /**
     * Return the expiry rate currently stored in the expire.txt
     * if the file doesn't exist, default to 2 weeks
     * @return bool|string
     */
    public function getExpiryTime()
    {
        try
        {
            $file = fopen("Models/expire.txt", "r");
            $rate = fread($file,filesize("Models/expire.txt"));
            fclose($file);
        }
        catch (Exception $exception)
        {
            $rate = "2 Weeks";
        }

        return $rate;
    }

    /**
     * Set the expiry time of the adverts based on the value passed to the function
     * @param $newTime
     */
    public function setExpiryTime($newTime)
    {
        $file = fopen("Models/expire.txt", "w") or die("Unable to open file!");
        fwrite($file, $newTime);
        fclose($file);
    }

}
