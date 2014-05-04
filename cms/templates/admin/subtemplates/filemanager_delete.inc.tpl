<h1><a href="index.php"><?php echo $lang['administration']; ?></a> &raquo; <a
        href="index.php?mode=filemanager"><?php echo $lang['filemanager']; ?></a> &raquo; <?php echo $lang['delete_file']; ?>
</h1>

<p><?php echo str_replace('[file]', $file, $lang['delete_file_confirm']); ?></p>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="filemanager"/>
        <input type="hidden" name="delete" value="<?php echo $file ?>"/>
        <input type="hidden" name="dir" value="<?php echo $directory; ?>"/>
        <input type="submit" name="confirmed" value="<?php echo $lang['delete_file_submit']; ?>">
    </div>
</form>

