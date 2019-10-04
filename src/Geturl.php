<?php

if (isset($_GET["url"]))
{
    require_once('Database.php');
    // Create db connection
    $db = new Database();

    $url = htmlspecialchars($_GET['url']);
    $newurl = $db->getUrl($url);

    header('Location: '.$newurl);
    exit();
}

?>