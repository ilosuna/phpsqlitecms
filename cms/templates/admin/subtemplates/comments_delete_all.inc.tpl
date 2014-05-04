<ol class="breadcrumb">
    <li><a href="index.php?mode=comments"><?php echo $lang['comments']; ?></a></li>
    <li class="active"><?php echo $lang['delete_comments']; ?></li>
</ol>

<h1><?php echo $lang['delete_comments']; ?></h1>

<?php if ($type == 0): ?>
    <p><?php echo $lang['delete_all_page_comments']; ?></p>
<?php else: ?>
    <p><?php echo $lang['delete_all_photo_comments']; ?></p>
<?php endif ?>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="comments"/>
        <input type="hidden" name="type" value="<?php echo $type; ?>"/>
        <input class="btn btn-danger btn-lg" type="submit" name="delete_all_comments_confirmed"
               value="<?php echo $lang['delete_all_comments_subm']; ?>"/>
    </div>
</form>
