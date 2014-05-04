<h1><?php echo $lang['delete_menu_headline']; ?></h1>

<p><?php echo $lang['delete_menu_confirm']; ?></p>
<p><?php echo $lang['delete_menu_name']; ?><b> <?php echo $menu; ?></b></p>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="menus"/>
        <input type="hidden" name="delete" value="<?php echo $menu; ?>"/>
        <input type="submit" name="confirmed" value="<?php echo $lang['delete_menu_submit']; ?>"/>
    </div>
</form>

