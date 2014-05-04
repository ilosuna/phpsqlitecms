<h1><?php echo $lang['delete_page_headline']; ?></h1>

<div class="alert alert-danger">
    <p><span class="glyphicon glyphicon-warning-sign"></span> <strong><?php echo $lang['caution']; ?></strong></p>
</div>
<p><?php echo str_replace('[page]', stripslashes($page['page']), $lang['delete_page_confirm']); ?></p>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="pages"/>
        <input type="hidden" name="delete_page" value="<?php echo $page['id']; ?>"/>
        <input type="hidden" name="confirmed" value="true"/>
        <button class="btn btn-danger btn-lg"><?php echo $lang['delete_page_submit']; ?></button>
    </div>
</form>

