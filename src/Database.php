<?php
// src/Database.php

class Database
{
    private $connection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->getConnection();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->connection = null;
    }

    /**
     * Get connection
     */
    public function getConnection()
    {
        if($this->connect() == true)
        {
            $this->connect();
        }
        else
        {
            echo "Connection to database failed";
        }
    }

    /**
     * Database connection
     */
    private function connect()
    {
        // Get mysql conf data from env
        $host = getenv('MYSQL_HOST');
        $db = getenv('MYSQL_DATABASE');
        $username = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');

        // try to connect database
        try 
        {
            $this->connection = new PDO("mysql:host=$host;dbname=$db", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return true;
        }
        
        // if connection fails: exit and give error msg
        catch(PDOException $connectionError)
        {
            return false;
        }
    }

    /**
     * Add url to database
     */
    public function addUrl($url, $shorturl)
    {
        $sql = "INSERT INTO test (url, shorturl) VALUES (:url, :shorturl)";
        $sqlentry = $this->connection->prepare($sql);
        $sqlentry->bindParam(':url', $url, PDO::PARAM_STR);
        $sqlentry->bindParam(':shorturl', $shorturl, PDO::PARAM_STR);
        $sqlentry->execute();
    }

    /**
     * Add url to database
     */
    public function getUrl($shorturl)
    {
        $sql = "SELECT url AS 'url' FROM test WHERE shorturl = :shorturl";
        $geturl = $this->connection->prepare($sql);
        $geturl->bindParam(':shorturl', $shorturl, PDO::PARAM_STR);
        $geturl->execute();
        $shorturl = $geturl->fetch(PDO::FETCH_BOTH);
        
        return $shorturl['url'];
    }
}
?>