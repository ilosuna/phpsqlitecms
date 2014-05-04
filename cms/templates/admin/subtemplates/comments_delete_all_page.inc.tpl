<ol class="breadcrumb">
    <li><a href="index.php?mode=comments"><?php echo $lang['comments']; ?></a></li>
    <li class="active"><?php echo $lang['delete_comments']; ?></li>
</ol>

<h1><?php echo $lang['delete_comments']; ?></h1>

<p><?php echo str_replace('[page]', $page, $lang['delete_all_comm_page_conf']); ?></p>

<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
    <div>
        <input type="hidden" name="mode" value="comments"/>
        <input type="hidden" name="type" value="<?php echo $type; ?>"/>
        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"/>
        <input class="btn btn-danger btn-lg" type="submit" name="delete_all_comments_page_confirmed"
               value="<?php echo $lang['delete_all_comments_subm']; ?>"/>
    </div>
</form>
