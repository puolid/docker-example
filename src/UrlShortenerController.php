<?php
// src/UrlShortenerController.php

require_once('Database.php');

class UrlShortenerController
{
    private $database;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * Index page
     */
    public function index()
    {
        require_once('AddUrlView.php');
    }

    /**
     * Addurl
     */
    public function addUrl($url)
    {
        $ishttpset = substr($url, 0, 7);
        $ishttpsset = substr($url, 0, 8);
        
        if ($ishttpset != 'http://')
        {
            if ($ishttpsset != 'https://')
                $url = 'http://' . $url;
        }
    
        $shorturl = hash("adler32", $url);
        
        if ($this->database->addUrl($url, $shorturl))
        {
            require_once('AddedUrlView.php');
        }
        else
        {
            echo 'Failed add url to database';
        }
        
    }

    /**
     * Geturl
     */
    public function getUrl($url)
    {
        $newurl = $this->database->getUrl($url);

        if ($newurl != null)
        {
            header('Location: ' . $newurl);
            exit();
        }
        else
        {
            echo 'URL not found!';
        }
    }
}

?>