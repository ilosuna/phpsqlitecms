<?php if ($user_type == 1): ?>
    <ol class="breadcrumb">
        <li><a href="#"><a href="index.php?mode=users"><?php echo $lang['users']; ?></a></a></li>
        <li class="active"><?php echo $lang['edit_userdata']; ?></li>
    </ol>
<?php endif; ?>

<h1><?php echo $lang['edit_userdata']; ?></h1>

<?php if (isset($saved)): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span
            class="glyphicon glyphicon-ok"></span> <?php echo $lang['userdata_saved_message']; ?><?php if (isset($cache_cleared)): ?> / <?php echo $lang['cache_cleared']; ?><?php endif; ?>
    </div>
<?php endif; ?>

<?php include('errors.inc.tpl'); ?>

<?php if (isset($userdata) || $user_type == 0): ?>

    <form class="form-horizontal" action="index.php" method="post">
        <div>
            <input type="hidden" name="mode" value="users"/>
            <input type="hidden" name="edit_user_submitted" value="true"/>
            <?php if ($user_type == 1): ?>
                <input type="hidden" name="id" value="<?php echo $userdata['id']; ?>"/>
            <?php endif; ?>

            <?php if ($user_type == 1): ?>

                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label"><?php echo $lang['edit_userdata_name']; ?></label>

                    <div class="col-lg-6">
                        <input id="name" class="form-control" type="text" name="name"
                               value="<?php echo $userdata['name']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_pw" class="col-lg-2 control-label"><?php echo $lang['change_pw_new']; ?></label>

                    <div class="col-lg-6">
                        <input id="new_pw" class="form-control" type="password" name="new_pw" autocomplete="off">
                        <span class="help-block"><?php echo $lang['change_pw_note']; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_pw_r"
                           class="col-lg-2 control-label"><?php echo $lang['change_pw_new_conf']; ?></label>

                    <div class="col-lg-6">
                        <input id="new_pw_r" class="form-control" type="password" name="new_pw_r" autocomplete="off">
                        <span class="help-block"><?php echo $lang['change_pw_note']; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <span
                        class="col-lg-2 control-label"><strong><?php echo $lang['edit_userdata_type']; ?></strong></span>

                    <div class="col-lg-6">
                        <div class="radio">
                            <input id="type_0" type="radio" name="type"
                                   value="0"<?php if ($userdata['type'] == 0): ?> checked="checked"<?php endif; ?> /><label
                                for="type_0"><?php echo $lang['type_0']; ?></label><br/>
                            <input id="type_1" type="radio" name="type"
                                   value="1"<?php if ($userdata['type'] == 1): ?> checked="checked"<?php endif; ?> /><label
                                for="type_1"><?php echo $lang['type_1']; ?></label>
                        </div>
                    </div>
                </div>

            <?php else: ?>

                <div class="form-group">
                    <label for="old_pw" class="col-lg-2 control-label"><?php echo $lang['change_pw_old']; ?></label>

                    <div class="col-lg-6">
                        <input id="old_pw" class="form-control" type="password" name="old_pw" autocomplete="off"
                               autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_pw" class="col-lg-2 control-label"><?php echo $lang['change_pw_new']; ?></label>

                    <div class="col-lg-6">
                        <input id="new_pw" class="form-control" type="password" name="new_pw" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_pw_r"
                           class="col-lg-2 control-label"><?php echo $lang['change_pw_new_conf']; ?></label>

                    <div class="col-lg-6">
                        <input id="new_pw_r" class="form-control" type="password" name="new_pw_r" autocomplete="off">
                    </div>
                </div>

            <?php endif; ?>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="btn btn-primary"><?php echo $lang['submit_button_ok']; ?></button>
                </div>
            </div>

        </div>
    </form>

<?php else: ?>
    <p class="caution"><?php echo $lang['invalid_request']; ?></p>
<?php endif; ?>
