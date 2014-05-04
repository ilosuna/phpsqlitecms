<ol class="breadcrumb">
    <li><a href="index.php?mode=galleries"><?php echo $lang['photo_galleries']; ?></a></li>
    <li class="active"><?php echo $lang['delete_gallery']; ?></li>
</ol>

<h1><?php echo $lang['delete_gallery']; ?></h1>

<p><?php echo str_replace('[gallery]', $gallery, $lang['delete_gallery_confirm']); ?></p>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="galleries"/>
        <input type="hidden" name="delete_gallery" value="<?php echo $gallery; ?>"/>
        <input class="btn btn-danger btn-lg" type="submit" name="confirmed"
               value="<?php echo $lang['delete_gallery_submit']; ?>"/>
    </div>
</form>

