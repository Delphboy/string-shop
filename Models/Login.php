<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 13/01/2018
 * Time: 10:04
 */

class Login
{
    function __construct()
    {
    }

    /**
     * Take an email and password and see if there is a user with those credentials
     * @param $email
     * @param $password
     *
     * @return true if a user exists with the specified email and password
     */
    function signIn($email, $password)
    {
        $dbConnection = DBConnection::getInstance();
        $testQuery = "SELECT userID, email, password, firstName FROM Users WHERE email LIKE :email;";
        $dbConnection->setQuery($testQuery);
        $dbConnection->bindQueryValue(':email', $email);
        $dbConnection->run();
        $row = $dbConnection->getAllResults();
//        echo 'Email: ' . $row[0][0] . " Password: " . $row[0][1];

        if($row == null)
            return false;

        if(($row[0][1] == $email) && password_verify($password, $row[0][2]))
        {
            $_SESSION['userID'] = $row[0][0];
            $_SESSION['firstName'] = $row[0][3];
            $_SESSION['isSignedIn'] = true;
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $fName
     * @param $sName
     * @param $email
     * @param $password
     * @param $address
     * @param $mobNum
     * Take parameters of a new user, and add them to the database if the user doesn't already exist
     *
     * @return true if the new user was created
     */
    function registerNewUser($fName, $sName, $email, $password, $address, $postcode, $mobNum)
    {
        $dbConnection = DBConnection::getInstance();
        $testQuery = "SELECT email FROM Users WHERE email LIKE :email;";
        $dbConnection->setQuery($testQuery);
        $dbConnection->bindQueryValue(':email', $email);
        $dbConnection->run();
        $row = $dbConnection->getAllResults();


        if($row == null)
        {
            $query = "INSERT INTO Users(firstName, surname, email, password, addressLineOne, postcode, mobileNumber) VALUES (:fName, :sName, :email, :pass, :address, :postcode, :mob)";

            $dbConnection->setQuery($query);
            $dbConnection->bindQueryValue(':fName', $fName);
            $dbConnection->bindQueryValue(':sName', $sName);
            $dbConnection->bindQueryValue(':email', $email);
            $dbConnection->bindQueryValue(':pass', $password);
            $dbConnection->bindQueryValue(':address', $address);
            $dbConnection->bindQueryValue(':postcode', $postcode);
            $dbConnection->bindQueryValue(':mob', $mobNum);

            $dbConnection->run();

            return true;
        }
        else
        {
            return false;
        }
    }
}