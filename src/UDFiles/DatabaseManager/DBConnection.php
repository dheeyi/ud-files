<?php

namespace UDFiles\DatabaseManager;


class DBConnection
{
    /**
     * Credentials to access the MySQL database
     * @var
     */
    private $_connection;
    private static $_instance;

    /**
     * DBConnection constructor.
     * @param $host
     * @param $username
     * @param $password
     * @param $database
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->_connection = new  \mysqli($host, $username, $password, $database);

        if (mysqli_connect_error()) {
            trigger_error("Failed to conenc to to MySQL: ", E_USER_ERROR);
        }
    }

    /**
     * Get an instance of the Database
     * @param $host
     * @param $username
     * @param $password
     * @param $database
     * @return DBConnection
     */
    public static function getInstance($host, $username, $password, $database)
    {
        if (!self::$_instance) {
            self::$_instance = new self($host, $username, $password, $database);
        }
        return self::$_instance;
    }

    /**
     * Get mysqli connection
     * @return \mysqli
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * Magic method clone is empty to prevent duplication of connection
     */
    private function __clone()
    {
    }
}