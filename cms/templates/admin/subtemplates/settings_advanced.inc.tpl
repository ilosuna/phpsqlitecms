<ol class="breadcrumb">
    <li><a href="index.php?mode=settings"><?php echo $lang['settings']; ?></a></li>
    <li class="active"><?php echo $lang['advanced_settings']; ?></li>
</ol>

<h1><?php echo $lang['advanced_settings']; ?></h1>

<?php include('errors.inc.tpl'); ?>

<form class="form-horizontal" action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="settings"/>
        <input type="hidden" name="settings_submitted" value="true"/>
        <?php while (list($key, $val) = each($settings_sorted)): ?>

            <div class="form-group">
                <label for="<?php echo $key; ?>" class="col-md-2 control-label"><?php echo $key; ?></label>

                <div class="col-md-5">
                    <input type="text" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>"
                           value="<?php echo $val; ?>">
                </div>

                <div class="col-md-1">
                    <a class="btn btn-danger btn-xs" href="index.php?mode=settings&amp;delete=<?php echo $key; ?>"
                       title="<?php echo $lang['delete']; ?>"
                       data-delete-confirm="<?php echo rawurlencode($lang['delete_setting_confirm']); ?>"><span
                            class="glyphicon glyphicon-remove"></span></a>
                </div>

            </div>

        <?php endwhile; ?>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-5">
                <button type="submit" class="btn btn-primary"><?php echo $lang['submit_button_ok']; ?></button>
            </div>
        </div>

    </div>
</form>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $lang['add_new_setting_var']; ?></h3>
    </div>
    <div class="panel-body">
        <form class="form-inline" action="index.php" method="post">
            <div class="form-group">
                <input type="hidden" name="mode" value="settings">
                <input type="hidden" name="new_var_submitted" value="true">
                <label class="sr-only" for="name"><?php echo $lang['settings_name']; ?></label>
                <input type="text" class="form-control" id="name" name="name"
                       placeholder="<?php echo $lang['settings_name']; ?>">
            </div>
            <div class="form-group">
                <label class="sr-only" for="value"><?php echo $lang['settings_value']; ?></label>
                <input type="text" class="form-control" id="value" name="value"
                       placeholder="<?php echo $lang['settings_value']; ?>">
            </div>
            <button type="submit" class="btn btn-default"><?php echo $lang['submit_button_ok']; ?></button>
        </form>
    </div>
</div>
