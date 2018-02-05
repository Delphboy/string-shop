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

    public function generateTableOfUsers()
    {
        $output = "";

        $sqlQuery = "SELECT userID, firstName, surname, email, isAdmin FROM Users";

        $dbHandle = DBConnection::getInstance();
        $dbHandle->runQuery($sqlQuery);

        $data = $dbHandle->getAllResults();

        for($i = 0; $i < count($data); $i++)
        {
            $output .= "<tr>";
            for($j = 0; $j < (count($data[$i]) / 2); $j++)
            {
                if($j < 4)
                    $output .= "<td>" . $data[$i][$j] . "</td>\n";
                else
                {
                    if($data[$i][$j] == 1)
                    {
                        $output .= "<td><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button type='submit' name='isAdminBtn' value='" . $data[$i][0] . "' class='btn btn-danger'>Remove Admin</button></form></td>";
                    }
                    else
                    {
                        $output .= "<td><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button type='submit' name='isAdminBtn' value='" . $data[$i][0] . "' class='btn btn-success'>Make Admin</button></form></td>";
                    }
                }
            }
            $output .= "<td><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button name='deleteUser' value='" . $data[$i][0] . "' type='submit' class='btn btn-danger'>Delete User</button></form></td>";
            $output .= "</tr>\n";
        }

        $dbHandle = null;

        return $output;
    }

    public function generateTableOfAdverts()
    {
        $output = "";

        $sqlQuery = "SELECT advertID, userPK, title, type, date, price FROM Adverts";

        $dbHandle = DBConnection::getInstance();
        $dbHandle->runQuery($sqlQuery);

        $data = $dbHandle->getAllResults();

        for($i = 0; $i < count($data); $i++)
        {
            $output .= "<tr>";
            for($j = 0; $j < (count($data[$i]) / 2); $j++)
            {
                $output .= "<td>" . $data[$i][$j] . "</td>\n";
            }
            $output .= "<td><form action=" . $_SERVER['PHP_SELF'] . " method='post'><button name='deleteAdvert' value='" . $data[$i][0] . "' type='submit' class='btn btn-danger'>Delete Advert</button></form></td>";
            $output .= "</tr>\n";
        }

        $dbHandle = null;

        return $output;
    }

    public function deleteUser($ID)
    {
        $user = new User($ID);
        $user->delete();
        header("Refresh: 0");
    }

    public function deleteAdvert($ID)
    {
        $ad = Advert::buildFromPK($ID);
        $ad->delete();
        header("Refresh: 0");
    }

    public function toggleAdmin($ID)
    {
        $user = new User($ID);
        $user->toggleAdmin();
        header("Refresh: 0");
    }

}
