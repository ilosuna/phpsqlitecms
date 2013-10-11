<ol class="breadcrumb">
<li><a href="index.php?mode=gcb"><?php echo $lang['gcb']; ?></a></li>
<li class="active"><?php if(isset($gcb['id'])): echo $lang['edit_gcb']; else: echo $lang['add_gcb']; endif; ?></li>
</ol>

<h1><?php if(isset($gcb['id'])): echo $lang['edit_gcb']; else: echo $lang['add_gcb']; endif; ?></h1>

<?php include('errors.inc.tpl'); ?>

<form action="index.php" method="post" class="form-horizontal">
<input type="hidden" name="mode" value="gcb" />
<?php if(isset($gcb['id'])): ?>
<input type="hidden" name="id" value="<?php echo $gcb['id']; ?>" />
<?php endif; ?>

<div class="form-group">
<label for="identifier" class="col-lg-1 control-label control-label-left"><?php echo $lang['edit_gcb_identifier']; ?></label>
<div class="col-lg-11">
<input type="text" name="identifier" value="<?php if(isset($gcb['identifier'])) echo $gcb['identifier']; ?>" size="40" class="form-control" />
</div>
</div>

<div class="form-group">
<label for="content" class="col-lg-1 control-label control-label-left"><?php echo $lang['edit_gcb_content']; ?></label>
<div class="col-lg-11">
<textarea name="content" cols="70" rows="20" class="form-control"><?php if(isset($gcb['content'])) echo $gcb['content']; ?></textarea>
<!--<div class="checkbox">
<label for="content_formatting">
<input id="content_formatting" type="checkbox" name="content_formatting" value="1"<?php if(isset($gcb['content_formatting']) && $gcb['content_formatting']==1): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['edit_gcb_formatting']; ?>
</label>
</div>-->
</div>
</div>

<div class="form-group">
<div class="col-lg-offset-1 col-lg-11">
<input type="submit" name="edit_gcb_submit" value="<?php echo $lang['submit_button_ok']; ?>"  class="btn btn-primary btn-strong" />
</div>

</form>
