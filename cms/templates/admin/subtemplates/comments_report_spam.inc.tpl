<ul class="breadcrumb">
    <li><a href="index.php?mode=comments"><?php echo $lang['comments']; ?></a></li>
    <li class="active"><?php echo $lang['report_spam']; ?></li>
</ul>

<h1><?php echo $lang['report_spam']; ?></h1>

<p><?php echo $lang['report_spam_confirm']; ?></p>

<div class="panel panel-default">
    <div class="panel-heading"><strong><?php echo $comment['name']; ?>
            ,</strong> <?php echo strftime($lang['time_format'], $comment['time']); ?></div>
    <div class="panel-body"><?php echo $comment['comment']; ?></div>
</div>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="comments"/>
        <input type="hidden" name="type" value="<?php echo $type; ?>"/>
        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>"/>
        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"/>
        <input type="hidden" name="page" value="<?php echo $page; ?>"/>
        <input class="btn btn-danger" type="submit" name="report_as_spam"
               value="<?php echo $lang['report_as_spam_submit']; ?>"/> <input class="btn btn-danger" type="submit"
                                                                              name="report_as_spam_and_delete"
                                                                              value="<?php echo $lang['report_as_spam_delete_submit']; ?>"/>
    </div>
</form>

