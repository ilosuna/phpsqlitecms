<h1><?php echo $lang['administration']; ?></h1>

<?php if (isset($msg)): ?>
    <p class="ok"><?php if (isset($lang[$msg])) echo $lang[$msg]; else echo $msg; ?></p>
<?php endif; ?>

<ul class="list-unstyled">
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=pages"><span
                class="glyphicon glyphicon-file"></span> <?php echo $lang['admin_menu_page_overview']; ?></a></li>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=edit"><span
                class="glyphicon glyphicon-plus-sign"></span> <?php echo $lang['admin_menu_new_page']; ?></a></li>
</ul>
<ul class="list-unstyled">
    <?php if ($user_type == 1): ?>
        <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=settings"><span
                class="glyphicon glyphicon-wrench"></span> <?php echo $lang['admin_menu_settings']; ?></a>
        </li><?php endif; ?>
    <?php if ($user_type == 1): ?>
        <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=menus"><span
                class="glyphicon glyphicon-list-alt"></span> <?php echo $lang['admin_menu_edit_menus']; ?></a>
        </li><?php endif; ?>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=galleries"><span
                class="glyphicon glyphicon-picture"></span> <?php echo $lang['admin_menu_edit_galleries']; ?></a></li>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=comments"><span
                class="glyphicon glyphicon-comment"></span> <?php echo $lang['admin_menu_edit_comments']; ?></a></li>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=notes"><span
                class="glyphicon glyphicon-edit"></span> <?php echo $lang['admin_menu_edit_notes']; ?></a></li>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=gcb"><span
                class="glyphicon glyphicon-th-large"></span> <?php echo $lang['admin_menu_edit_gcb']; ?></a></li>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=filemanager"><span
                class="glyphicon glyphicon-folder-open"></span> <?php echo $lang['admin_menu_filemanager']; ?></a></li>
    <?php if ($user_type == 1): ?>
        <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=spam_protection"><span
                class="glyphicon glyphicon-ban-circle"></span> <?php echo $lang['admin_menu_spam_protection']; ?></a>
        </li><?php endif; ?>
    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=users"><span
                class="glyphicon glyphicon-user"></span> <?php if ($user_type == 1) echo $lang['admin_menu_user_administr']; else echo $lang['admin_menu_edit_userdata']; ?>
        </a></li>
</ul>

<?php if ($settings['caching']): ?>
    <ul class="list-unstyled">
        <li><a href="index.php?clear_cache=true"><span
                    class="glyphicon glyphicon-remove"></span> <?php echo $lang['admin_menu_clear_cache']; ?></a></li>
    </ul>
<?php endif; ?>


