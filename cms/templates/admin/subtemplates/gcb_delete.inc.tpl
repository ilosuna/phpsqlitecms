<ol class="breadcrumb">
    <li><a href="index.php?mode=gcb"><?php echo $lang['gcb']; ?></a></li>
    <li class="active"><?php echo $lang['delete_gcb']; ?></li>
</ol>

<h1><?php echo $lang['delete_gcb']; ?></h1>

<p><?php echo str_replace('[identifier]', $gcb['identifier'], $lang['delete_gcb_confirm']); ?></p>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="gcb"/>
        <input type="hidden" name="delete" value="<?php echo $gcb['id']; ?>"/>
        <input type="submit" name="confirmed" value="<?php echo $lang['submit_button_delete']; ?>"
               class="btn btn-danger btn-strong"/>
    </div>
</form>

