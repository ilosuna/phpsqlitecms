<ol class="breadcrumb">
    <li><a href="#"><a href="index.php?mode=users"><?php echo $lang['users']; ?></a></a></li>
    <li class="active"><?php echo $lang['create_user_account']; ?></li>
</ol>

<?php include('errors.inc.tpl'); ?>

<form class="form-horizontal" action="index.php" method="post"/>
<div>
    <input type="hidden" name="mode" value="users"/>
    <input type="hidden" name="new_user_submitted" value="true"/>

    <div class="form-group">
        <label for="name" class="col-lg-2 control-label"><?php echo $lang['user_name_m']; ?></label>

        <div class="col-lg-6">
            <input id="name" class="form-control" type="text" name="name">
        </div>
    </div>

    <div class="form-group">
        <label for="pw" class="col-lg-2 control-label"><?php echo $lang['pw_m']; ?></label>

        <div class="col-lg-6">
            <input id="pw" class="form-control" type="password" name="pw" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label for="pw_r" class="col-lg-2 control-label"><?php echo $lang['pw_conf_m']; ?></label>

        <div class="col-lg-6">
            <input id="pw_r" class="form-control" type="password" name="pw_r" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" class="btn btn-primary"><?php echo $lang['submit_button_ok']; ?></button>
        </div>
    </div>

</div>
</form>
