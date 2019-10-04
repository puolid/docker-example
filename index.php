<?php require_once('header.html'); ?>
<div id="center">
    <form method="POST" ACTION="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/Addurl.php'; ?>">
        <input name="url" type="ttext">
        <input type="submit" name="submit">
    </form>
</div>
<?php require_once('footer.html'); ?>