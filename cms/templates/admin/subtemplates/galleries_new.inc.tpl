<ol class="breadcrumb">
    <li><a href="index.php?mode=galleries"><?php echo $lang['photo_galleries']; ?></a></li>
    <li class="active"><?php echo $lang['new_gallery']; ?></li>
</ol>

<h1><?php echo $lang['new_gallery']; ?></h1>

<?php include('errors.inc.tpl'); ?>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="galleries"/>

        <label for="new_gallery_name"><?php echo $lang['new_gallery_name']; ?></label>

        <div class="input-group form-control-default">
            <input class="form-control" id="new_gallery_name" type="text" name="new_gallery_name"
                   value="<?php if (isset($new_gallery_name)) echo $new_gallery_name; ?>" size="25"/>
  <span class="input-group-btn">
  <button class="btn btn-primary" type="submit"><?php echo $lang['submit_button_ok']; ?></button>
  </span>
        </div>

    </div>
</form>
