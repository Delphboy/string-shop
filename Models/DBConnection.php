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

//    private $host = "den1.mysql3.gear.host";
//    private $dbName = "stringshop";
//    private $user = "stringshop";
//    private $pass = 'Sx1Mlm_L_W0i';

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

    /**
     * Set the query so that values can be bound
     * @param $query
     */
    public function setQuery($query)
    {
        $this->SQLQuery = $this->db->prepare($query);
    }

    /**
     * Bind an actual values to the placeholder given in the query
     * @param $parameter
     * @param $value
     */
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

    /**
     * Run a simple query given as a string
     * @param $newQuery
     */
    public function runQuery($newQuery)
    {
        $this->SQLQuery = $this->db->prepare($newQuery);
        $this->SQLQuery->execute();
    }

    /**
     * Once a SQLstatement has been set and had it's values bound, execute the statement
     */
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

    /**
     * Execute the SQL statement and return the results as a 2D array
     * @return mixed
     */
    public function getAllResults()
    {
        $this->run();
        return $this->SQLQuery->fetchAll();
    }

    /**
     * Return a single row as an array from the results
     * @return mixed
     */
    public function getRow()
    {
        $this->run();
        return $this->SQLQuery->fetch();
    }

    /**
     * Get the number of rows the query would return
     * @return mixed
     */
    public function getRowCount()
    {
        $this->SQLQuery->execute();
        return $this->SQLQuery->rowCount();
    }

    /**
     * Return the ID of the last inserted value
     * @return mixed
     */
    public function getLastID()
    {
        return $this->db->lastInsertId();
    }


}