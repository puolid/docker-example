<?php
// src/index.php

require_once('UrlShortenerController.php');

$urlController = new urlShortenerController();
$getPage = htmlspecialchars($_GET['do']);

if ($getPage == null)
{
    $urlController->index();
}
else if ($getPage == 'add')
{
    $url = htmlspecialchars($_POST['url']);
    if ($url != null)
    {
        $urlController->addUrl($url);
    }
    else
    {
        echo 'url not found';
    }
}
else if ($getPage == 'get')
{
    $url = htmlspecialchars($_GET['url']);
    if ($url != null)
    {
        $urlController->getUrl($url);
    }
    else
    {
        echo 'url not found';
    }
}

?>