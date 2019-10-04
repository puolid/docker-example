<?php

require_once('header.html');

// If url isset add it to database
if (isset($_POST["url"]))
{
    require_once('Database.php');
    // Create db connection
    $db = new Database();

    $shorturl = uniqid();

    $url = htmlspecialchars($_POST['url']);
    $db->addUrl($url, $shorturl);
}
echo '<div id="center"><p>http://' . $_SERVER['HTTP_HOST'] . '/Geturl.php?url=' . $shorturl . '</p></div>';

require_once('footer.html');
?>
