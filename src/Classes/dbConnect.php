<?php

namespace EasyCMS\src\Classes;

/**
 * Class dbConnect
 *
 * This class manages the database connection via PDO.
 */
class dbConnect
{
    /**
     * @var \PDO Instance of the database connection.
     */
    public $db;

    /**
     * @var dbConnect|null Unique instance of the class.
     */
    private static $instance = null;


    /**
     * Constructor to initialize the database connection.
     *
     * @param string $dsn Data Source Name (DSN) for the database connection.
     * @param string $dblogin Database username.
     * @param string $dbpassword Database password.
     * @throws \Exception If an error occurs during the database connection.
     * @return void
     */
    public function __construct($dsn, $dblogin, $dbpassword){

        // Database connection
        try
        {
            $this->db = new \PDO($dsn, $dblogin, $dbpassword);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        }
        catch(\Exception $e)
        {
            // In case of error, display the error message and terminate the script.
            die('Erreur : '.$e->getMessage());
        }

        
    }

    /**
     * Retrieve the instance of the database connection.
     *
     * @param string $dsn Data Source Name (DSN) for the database connection.
     * @param string $dblogin Database username.
     * @param string $dbpassword Database password.
     * @return self Instance of the database connection.
     */
    public static function getDb($dsn, $dblogin, $dbpassword): self
    {
        if( is_null(self::$instance)){
            self::$instance = new dbConnect($dsn, $dblogin, $dbpassword);
        }
        return self::$instance;
    }

}