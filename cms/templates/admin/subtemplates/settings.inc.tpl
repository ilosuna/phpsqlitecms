<h1><?php echo $lang['settings']; ?></h1>

<?php if (isset($saved)): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span
            class="glyphicon glyphicon-ok"></span> <?php echo $lang['settings_saved']; ?><?php if (isset($cache_cleared)): ?> / <?php echo $lang['cache_cleared']; ?><?php endif; ?>
    </div>
<?php endif; ?>

<form action="<?php echo BASE_URL; ?>cms/index.php" method="post" class="form-horizontal">
    <input type="hidden" name="mode" value="settings"/>
    <input type="hidden" name="settings_submitted"/>

    <div class="form-group">
        <label for="website_title" class="col-md-2 control-label"><?php echo $lang['settings_website_title']; ?></label>

        <div class="col-md-6">
            <input type="text" class="form-control" id="website_title" name="website_title"
                   value="<?php echo htmlspecialchars($settings['website_title']); ?>" size="35">
        </div>
    </div>

    <div class="form-group">
        <label for="website_subtitle"
               class="col-md-2 control-label"><?php echo $lang['settings_website_subtitle']; ?></label>

        <div class="col-md-6">
            <input type="text" class="form-control" id="website_subtitle" name="website_subtitle"
                   value="<?php echo htmlspecialchars($settings['website_subtitle']); ?>" size="35">
        </div>
    </div>

    <div class="form-group">
        <label for="author" class="col-md-2 control-label"><?php echo $lang['settings_author']; ?></label>

        <div class="col-md-6">
            <input type="text" class="form-control" id="author" name="author"
                   value="<?php echo htmlspecialchars($settings['author']); ?>" size="35">
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-md-2 control-label"><?php echo $lang['settings_email']; ?></label>

        <div class="col-md-6">
            <input type="text" class="form-control" id="email" name="email"
                   value="<?php echo htmlspecialchars($settings['email']); ?>" size="35">
        </div>
    </div>

    <div class="form-group">
        <label for="index_page" class="col-md-2 control-label"><?php echo $lang['settings_index_page']; ?></label>

        <div class="col-md-6">
            <select id="index_page" name="index_page" size="1" class="form-control">
                <?php foreach ($pages as $current_page): ?>
                    <option
                        value="<?php echo $current_page['page']; ?>"<?php if ($settings['index_page'] == $current_page['page']): ?> selected="selected"<?php endif; ?>><?php echo $current_page['page']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="error_page" class="col-md-2 control-label"><?php echo $lang['settings_error_page']; ?></label>

        <div class="col-md-6">
            <select id="error_page" name="error_page" size="1" class="form-control">
                <?php foreach ($pages as $current_page): ?>
                    <option
                        value="<?php echo $current_page['page']; ?>"<?php if ($settings['error_page'] == $current_page['page']): ?> selected="selected"<?php endif; ?>><?php echo $current_page['page']; ?></option>
                <?php endforeach; ?>
            </select></div>
    </div>

    <div class="form-group">
        <label for="admin_language" class="col-md-2 control-label"><?php echo $lang['admin_language']; ?></label>

        <div class="col-md-6">
            <select id="admin_language" name="admin_language" size="1" class="form-control">
                <?php foreach ($admin_languages as $admin_language): ?>
                    <option
                        value="<?php echo $admin_language['identifier']; ?>"<?php if ($settings['admin_language'] == $admin_language['identifier']): ?> selected<?php endif ?>><?php echo $admin_language['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="default_page_language"
               class="col-md-2 control-label"><?php echo $lang['default_page_language']; ?></label>

        <div class="col-md-6">
            <select id="default_page_language" name="default_page_language" size="1" class="form-control">
                <?php foreach ($page_languages as $page_language): ?>
                    <option
                        value="<?php echo $page_language['identifier']; ?>"<?php if ($settings['default_page_language'] == $page_language['identifier']): ?> selected<?php endif ?>><?php echo $page_language['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-6">

            <div class="checkbox">
                <label for="caching">
                    <input id="caching" type="checkbox" name="caching"
                           value="1"<?php if ($settings['caching'] == 1): ?> checked<?php endif; ?>> <?php echo $lang['settings_caching_enabled']; ?>
                </label>
            </div>

            <?php if ($settings['caching'] && empty($settings['admin_auto_clear_cache'])): ?>
                <div class="checkbox">
                    <label for="clear_cache">
                        <input id="clear_cache" type="checkbox" name="clear_cache"
                               value="1"> <?php echo $lang['admin_menu_clear_cache']; ?>
                    </label>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
            <button type="submit" class="btn btn-primary btn-strong"><?php echo $lang['submit_button_ok']; ?></button>
            <a class="btn btn-default"
               href="index.php?mode=settings&amp;action=advanced_settings"><?php echo $lang['advanced_settings']; ?></a>
        </div>
    </div>

</form>
