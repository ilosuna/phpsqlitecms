<ol class="breadcrumb">
    <li><a href="index.php?mode=menus"><?php echo $lang['menus']; ?></a></a></li>
    <li class="active"><?php echo $lang['new_menu_hl']; ?></li>
</ol>

<h1><?php echo $lang['new_menu_hl']; ?></h1>

<?php include('errors.inc.tpl'); ?>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="menus"/>
        <label for="new_menu_name"><?php echo $lang['new_menu_name']; ?></label>

        <div class="input-group form-control-default">
            <input class="form-control" id="new_menu_name" type="text" name="new_menu_name"
                   value="<?php if (isset($new_menu_name)) echo $new_menu_name; ?>" size="25"/>
            <span class="input-group-btn">
            <button class="btn btn-primary" type="submit"><?php echo $lang['submit_button_ok']; ?></button>
            </span>
        </div>
    </div>
</form>

