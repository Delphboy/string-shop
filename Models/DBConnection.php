<?php
/**
 * Created by PhpStorm.
 * User: HPS19
 * Date: 13/01/2018
 * Time: 09:19
 *
 * A Singleton Class to connect to a database
 */

class DBConnection
{
    private static $instance = NULL;

    public $db = NULL; //PDO Object to be accessed

    private $host = "helios.csesalford.com";
    private $dbName = "stc765";
    private $user = "stc765";
    private $pass = 'MySQLPassword';

    private  $SQLQuery;

    /**
     * Return an instance of the database connection object
     */
    public static function getInstance()
    {
        if(self::$instance == null)
        {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    /**
     * DBConnection constructor.
     * Private as part of singleton design pattern
     */
    private function __construct()
    {
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
        try
        {
            $this->db = new PDO($dsn, $this->user, $this->pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //get PDO to throw exceptions
        }
        catch (PDOException $ex)
        {
            echo "<h1>Connection failed: " . $ex->getMessage() . "</h1>";
            $this->db = NULL;
        }
    }

    public function setQuery($query)
    {
        $this->SQLQuery = $this->db->prepare($query);
    }

    public function bindQueryValue($parameter, $value)
    {
        $type = null;
        if(is_int($value)) $type = PDO::PARAM_INT;
        else if(is_bool($value)) $type = PDO::PARAM_BOOL;
        else if(is_null($value)) $type = PDO::PARAM_NULL;
        else $type = PDO::PARAM_STR;

        if($type != null)
        {
            $this->SQLQuery->bindValue($parameter, $value, $type);
        }
    }

    public function runQuery($newQuery)
    {
        $this->SQLQuery = $this->db->prepare($newQuery);
        $this->SQLQuery->execute();
    }

    public function run()
    {
        try
        {
            $this->SQLQuery->execute();
        }
        catch (PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function getResults()
    {
        $this->run();
        return $this->SQLQuery->fetchAll();
    }

    public function getLastID()
    {
        return $this->db->lastInsertId();
    }


}