<?php 
// src/AdddedUrlView.php
require_once('header.html');
echo '<div id="center"><input type="text" onClick="this.setSelectionRange(0, this.value.length)" value="' . $_SERVER['HTTP_HOST'] . '/' . $shorturl . '"></div>';
require_once('footer.html');
?>