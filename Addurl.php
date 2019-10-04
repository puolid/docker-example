<?php

require_once('header.html');

// If url isset add it to database
if (isset($_POST["url"]))
{
    require_once('Database.php');
    // Create db connection
    $db = new Database();

    $uniqid = uniqid();
    $url = htmlspecialchars($_POST['url']);

    $ishttpset = substr($url, 0, 7);
    if ($ishttpset != 'http://')
    {
        $url = 'http://' . $url;
    }

    $shorturl = hash("adler32", $url . $uniqid);

    $db->addUrl($url, $shorturl);
}
echo '<div id="center"><input type="text" onClick="this.setSelectionRange(0, this.value.length)" value="' . $_SERVER['HTTP_HOST'] . '/Geturl.php?url=' . $shorturl . '"></div>';

require_once('footer.html');
?>
