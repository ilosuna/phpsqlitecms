<ol class="breadcrumb">
    <li><a href="index.php?mode=gcb"><?php echo $lang['gcb']; ?></a></li>
    <li class="active"><?php if (isset($gcb['id'])): echo $lang['edit_gcb'];
        else: echo $lang['add_gcb']; endif; ?></li>
</ol>

<h1><?php if (isset($gcb['id'])): echo $lang['edit_gcb'];
    else: echo $lang['add_gcb']; endif; ?></h1>

<?php include('errors.inc.tpl'); ?>

<form action="index.php" method="post">
    <input type="hidden" name="mode" value="gcb"/>
    <?php if (isset($gcb['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $gcb['id']; ?>"/>
    <?php endif; ?>

    <div class="form-group">
        <label for="identifier" class="control-label"><?php echo $lang['edit_gcb_identifier']; ?></label>
        <input type="text" name="identifier" value="<?php if (isset($gcb['identifier'])) echo $gcb['identifier']; ?>"
               size="40" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="content" class="control-label"><?php echo $lang['edit_gcb_content']; ?></label>
        <textarea name="content" cols="70" rows="20"
                  class="form-control"><?php if (isset($gcb['content'])) echo $gcb['content']; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" name="edit_gcb_submit" value="<?php echo $lang['submit_button_ok']; ?>"
               class="btn btn-primary btn-strong"/>
    </div>

</form>
