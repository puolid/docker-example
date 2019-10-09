<?php
// src/index.php

require_once('UrlShortenerController.php');

$urlController = new urlShortenerController();


if ($_POST["url"] == null && $_GET["url"] == null)
{
    $urlController->index();
}
else if ($_POST['url'] != null)
{
    $url = htmlspecialchars($_POST['url']);
    if ($url != null)
    {
        $urlController->addUrl($url);
    }
    else
    {
        echo 'URL not found.';
    }
}
if ($_GET["url"] != null)
{
    $url = htmlspecialchars($_GET['url']);
    if ($url != null)
    {
        $urlController->getUrl($url);
    }
    else
    {
        echo 'URL not found.';
    }
}

?>