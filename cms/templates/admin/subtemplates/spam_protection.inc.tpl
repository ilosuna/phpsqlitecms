<h1><?php echo $lang['spam_protection']; ?></h1>

<?php include('errors.inc.tpl'); ?>

<?php if (isset($saved)): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span class="glyphicon glyphicon-ok"></span> <?php echo $lang['spam_protection_saved']; ?>
    </div>
<?php endif; ?>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="spam_protection"/>
        <input type="hidden" name="spam_protection_submit" value="true"/>

        <div class="form-group">
            <label for="not_accepted_words"><?php echo $lang['not_accepted_words']; ?></label>
            <span class="help-block"><?php echo $lang['not_accepted_words_desc']; ?></span>
            <textarea id="not_accepted_words" class="form-control" name="not_accepted_words"
                      rows="7"><?php if (isset($not_accepted_words)) echo stripslashes($not_accepted_words); ?></textarea>
        </div>

        <div class="form-group">
            <label for="banned_ips"><?php echo $lang['banned_ips']; ?></label>
            <span class="help-block"><?php echo $lang['banned_ips_desc']; ?></span>
            <textarea id="banned_ips" class="form-control" name="banned_ips"
                      rows="7"><?php if (isset($banned_ips)) echo stripslashes($banned_ips); ?></textarea>
        </div>

        <div class="form-group">
            <label for="banned_user_agents"><?php echo $lang['banned_user_agents']; ?></label>
            <span class="help-block"><?php echo $lang['banned_user_agents_desc']; ?></span>
            <textarea id="banned_user_agents" class="form-control" name="banned_user_agents"
                      rows="7"><?php if (isset($banned_user_agents)) echo stripslashes($banned_user_agents); ?></textarea>
        </div>

        <div class="form-group">
            <label for="akismet_key"><?php echo $lang['akismet']; ?></label>
            <span class="help-block"><?php echo $lang['akismet_desc']; ?></span>
            <input id="akismet_key" class="form-control" type="text" name="akismet_key"
                   value="<?php echo $akismet_key; ?>">
        </div>

        <div class="checkbox">
            <label>
                <input id="akismet_entry_check" type="checkbox"
                       name="akismet_entry_check"<?php if (isset($akismet_entry_check) && $akismet_entry_check == 1): ?> checked<?php endif; ?>> <?php echo $lang['akismet_entry_check']; ?>
            </label><br/>
            <label>
                <input id="akismet_mail_check" type="checkbox"
                       name="akismet_mail_check"<?php if (isset($akismet_mail_check) && $akismet_mail_check == 1): ?> checked<?php endif; ?>> <?php echo $lang['akismet_mail_check']; ?>
            </label>
        </div>

        <button class="btn btn-primary" type="submit"><?php echo $lang['spam_protection_submit']; ?></button>

    </div>
</form>
