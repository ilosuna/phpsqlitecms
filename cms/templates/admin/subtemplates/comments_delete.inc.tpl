<ol class="breadcrumb">
    <li><a href="index.php?mode=comments"><?php echo $lang['comments']; ?></a></li>
    <li class="active"><?php echo $lang['delete_comments']; ?></li>
</ol>

<h1><?php echo $lang['delete_comments']; ?></h1>

<p><?php echo $lang['delete_checked_confirm']; ?></p>

<ul>
    <?php foreach ($comments as $comment): ?>
        <li><strong><?php echo $comment['name']; ?>:</strong> <?php echo $comment['comment']; ?></li>
    <?php endforeach; ?>
</ul>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="comments"/>
        <input type="hidden" name="type" value="<?php echo $type; ?>"/>
        <input type="hidden" name="page" value="<?php echo $page; ?>"/>
        <?php foreach ($comments as $comment): ?>
            <input type="hidden" name="checked_ids_confirmed[]" value="<?php echo $comment['id']; ?>"/>
        <?php endforeach; ?>
        <input class="btn btn-danger btn-lg" type="submit" name="delete_checked_confirmed"
               value="<?php echo $lang['delete_checked_confirm_subm']; ?>"/>
    </div>
</form>
