<?php require_once('header.html'); ?>
<div id="center">
    <h1>URL Shortener</h1>
    <div id="center-form">
    <form method="POST" ACTION="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '?do=add'; ?>">
        <input name="url" type="text" id="center-form-input" value="http:&#47;&#47;..." onfocus="if(this.value  == 'http:&#47;&#47;...') { this.value = ''; } " onblur="if(this.value == '') { this.value = 'http:&#47;&#47;...'; } ">
        <input type="submit" name="submit" value="Shorten" id="center-form-submit">
    </form>
    </div>
</div>
<?php require_once('footer.html'); ?>