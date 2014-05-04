<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>"><?php echo $settings['website_title']; ?></a>
        </div>
        <div class="navbar-collapse collapse">
            <?php if ($admin): ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="<?php echo BASE_URL; ?>cms/" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-cog"></span> <?php echo $lang['admin_menu_admin']; ?> <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=pages"><span
                                        class="glyphicon glyphicon-file"></span> <?php echo $lang['admin_menu_page_overview']; ?>
                                </a></li>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=edit"><span
                                        class="glyphicon glyphicon-plus-sign"></span> <?php echo $lang['admin_menu_new_page']; ?>
                                </a></li>
                            <li class="divider"></li>
                            <?php if ($user_type == 1): ?>
                                <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=settings"><span
                                        class="glyphicon glyphicon-wrench"></span> <?php echo $lang['admin_menu_settings']; ?>
                                </a></li><?php endif; ?>
                            <?php if ($user_type == 1): ?>
                                <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=menus"><span
                                        class="glyphicon glyphicon-list-alt"></span> <?php echo $lang['admin_menu_edit_menus']; ?>
                                </a></li><?php endif; ?>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=galleries"><span
                                        class="glyphicon glyphicon-picture"></span> <?php echo $lang['admin_menu_edit_galleries']; ?>
                                </a></li>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=comments"><span
                                        class="glyphicon glyphicon-comment"></span> <?php echo $lang['admin_menu_edit_comments']; ?>
                                </a></li>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=notes"><span
                                        class="glyphicon glyphicon-edit"></span> <?php echo $lang['admin_menu_edit_notes']; ?>
                                </a></li>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=gcb"><span
                                        class="glyphicon glyphicon-th-large"></span> <?php echo $lang['admin_menu_edit_gcb']; ?>
                                </a></li>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=filemanager"><span
                                        class="glyphicon glyphicon-folder-open"></span> <?php echo $lang['admin_menu_filemanager']; ?>
                                </a></li>
                            <?php if ($user_type == 1): ?>
                                <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=spam_protection"><span
                                        class="glyphicon glyphicon-ban-circle"></span> <?php echo $lang['admin_menu_spam_protection']; ?>
                                </a></li><?php endif; ?>
                            <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=users"><span
                                        class="glyphicon glyphicon-user"></span> <?php if ($user_type == 1) echo $lang['admin_menu_user_administr']; else echo $lang['admin_menu_edit_userdata']; ?>
                                </a></li>
                            <?php if ($settings['caching']): ?>
                                <li class="divider"></li>
                                <li><a href="<?php echo BASE_URL; ?>cms/index.php?clear_cache=true"><span
                                            class="glyphicon glyphicon-remove"></span> <?php echo $lang['admin_menu_clear_cache']; ?>
                                    </a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
            <?php if ($admin): ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (defined('PAGE') && $authorized_to_edit): ?>
                        <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=edit&amp;id=<?php echo $id; ?>"><span
                                    class="glyphicon glyphicon-pencil"></span> <?php echo $lang['admin_menu_edit_page']; ?>
                            </a></li>
                        <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=pages&amp;delete_page=<?php echo $id; ?>"
                               onclick="return confirm_link('<?php echo rawurlencode($lang['admin_menu_delete_page_conf']); ?>',this)"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $lang['admin_menu_delete_page']; ?>
                            </a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo BASE_URL; ?>cms/index.php?mode=logout"><span
                                class="glyphicon glyphicon-off"></span> <?php echo $lang['admin_menu_logout']; ?></a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
