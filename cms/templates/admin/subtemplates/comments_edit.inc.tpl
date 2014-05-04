<ol class="breadcrumb">
    <li><a href="index.php?mode=comments"><?php echo $lang['comments']; ?></a></li>
    <li class="active"><?php echo $lang['edit_comment']; ?></li>
</ol>


<h1><?php echo $lang['edit_comment']; ?></h1>

<form method="post" action="index.php">
    <div>
        <input type="hidden" name="mode" value="comments"/>
        <input type="hidden" name="type" value="<?php echo $type; ?>"/>
        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>"/>
        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"/>
        <input type="hidden" name="page" value="<?php echo $page; ?>"/>
        <input type="hidden" name="edit_submit" value="true"/>

        <div class="form-group">
            <textarea class="form-control" name="comment" cols="60"
                      rows="10"><?php echo $comment['comment']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="name"><?php echo $lang['comments_name_m']; ?></label>
            <input id="name" class="form-control" type="text" name="name" value="<?php echo $comment['name']; ?>"/>
        </div>

        <div class="form-group">
            <label for="email_hp"><?php echo $lang['comments_email_hp_m']; ?></label>
            <input id="email_hp" class="form-control" type="text" name="email_hp"
                   value="<?php echo $comment['email_hp']; ?>"/>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $lang['submit_button_ok']; ?></button>

    </div>
</form>

