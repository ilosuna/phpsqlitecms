<div class="row">
    <div class="col-md-10">
        <h1><h1><?php echo $lang['page_overview']; ?></h1></h1>
    </div>
    <div class="col-md-2">
        <?php if ($user_type == 1): ?>
        <a href="<?php echo BASE_URL; ?>cms/index.php?mode=edit" class="btn btn-success btn-top pull-right">
            <span class="glyphicon glyphicon-plus"></span> <?php echo $lang['admin_menu_new_page']; ?>
            </a><?php endif; ?>
    </div>
</div>

<?php if (isset($pages)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                    <a href="index.php?mode=pages&amp;order=page&amp;descasc=<?php if ($descasc == "ASC" && $order == "page"): ?>DESC<?php else: ?>ASC<?php endif; ?>"><?php echo $lang['page_name_marking']; ?><?php if ($order == "page" && $descasc == "ASC"): ?>
                            <span
                                class="glyphicon glyphicon-chevron-down"></span><?php elseif ($order == "page" && $descasc == "DESC"): ?>
                            <span class="glyphicon glyphicon-chevron-up"></span><?php endif; ?></a></th>
                <th>
                    <a href="index.php?mode=pages&amp;order=title&amp;descasc=<?php if ($descasc == "ASC" && $order == "title"): ?>DESC<?php else: ?>ASC<?php endif; ?>"><?php echo $lang['title_marking']; ?><?php if ($order == "title" && $descasc == "ASC"): ?>
                            <span
                                class="glyphicon glyphicon-chevron-down"></span><?php elseif ($order == "title" && $descasc == "DESC"): ?>
                            <span class="glyphicon glyphicon-chevron-up"></span><?php endif; ?></a></th>
                <th>
                    <a href="index.php?mode=pages&amp;order=time&amp;descasc=<?php if ($descasc == "ASC" && $order == "time"): ?>DESC<?php else: ?>ASC<?php endif; ?>"><?php echo $lang['created_marking']; ?><?php if ($order == "time" && $descasc == "ASC"): ?>
                            <span
                                class="glyphicon glyphicon-chevron-down"></span><?php elseif ($order == "time" && $descasc == "DESC"): ?>
                            <span class="glyphicon glyphicon-chevron-up"></span><?php endif; ?></a></th>
                <th>
                    <a href="index.php?mode=pages&amp;order=last_modified&amp;descasc=<?php if ($descasc == "ASC" && $order == "last_modified"): ?>DESC<?php else: ?>ASC<?php endif; ?>"><?php echo $lang['last_modified_marking']; ?><?php if ($order == "last_modified" && $descasc == "ASC"): ?>
                            <span
                                class="glyphicon glyphicon-chevron-down"></span><?php elseif ($order == "last_modified" && $descasc == "DESC"): ?>
                            <span class="glyphicon glyphicon-chevron-up"></span><?php endif; ?></a></th>
                <?php if ($settings['count_views']): ?>
                    <th>
                        <a href="index.php?mode=pages&amp;order=views&amp;descasc=<?php if ($descasc == "ASC" && $order == "views"): ?>DESC<?php else: ?>ASC<?php endif; ?>"><?php echo $lang['views_marking']; ?><?php if ($order == "views" && $descasc == "ASC"): ?>
                                <span
                                    class="glyphicon glyphicon-chevron-down"></span><?php elseif ($order == "views" && $descasc == "DESC"): ?>
                                <span class="glyphicon glyphicon-chevron-up"></span><?php endif; ?></a></th>
                <?php endif; ?>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            $total_views = 0;
            foreach ($pages as $page): ?>
                <tr>
                    <td><?php if ($page['status'] > 0) { ?>
                            <a
                            href="<?php echo BASE_URL . $page['page']; ?>"><?php if ($settings['index_page'] == $page['page']) { ?>
                            <b><?php
                        }
                            echo $page['page'];
                        if ($settings['index_page'] == $page['page']) {
                            ?></b><?php } ?>
                            </a><?php } else echo $page['page']; ?></td>
                    <td><?php echo $page['title']; ?></td>
                    <td class="nowrap"><?php echo strftime($lang['time_format'], $page['time']);
                        if (isset($users[$page['author']])) {
                            ?> <span class="smallx">
                            (<?php echo $users[$page['author']]; ?>)</span><?php } ?></td>
                    <td class="nowrap"><?php echo strftime($lang['time_format'], $page['last_modified']);
                        if (isset($users[$page['last_modified_by']])) {
                            ?> <span class="smallx">
                            (<?php echo $users[$page['last_modified_by']]; ?>)</span><?php } ?></td>
                    <?php if ($settings['count_views']): ?>
                        <td><?php echo $page['views'];
                            $total_views = $total_views + $page['views']; ?></td>
                    <?php endif; ?>
                    <?php if ($page['edit_permission']): ?>
                        <td class="options nowrap"><a href="index.php?mode=edit&amp;id=<?php echo $page['id']; ?>"
                                                      title="<?php echo $lang['edit']; ?>"
                                                      class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                            <a href="index.php?mode=pages&amp;delete_page=<?php echo $page['id']; ?>"
                               title="<?php echo $lang['delete']; ?>" class="btn btn-danger btn-xs"
                               onclick="str='<?php echo rawurlencode($lang['delete_page_confirm']); ?>'; return confirm_link(str.replace('<?php echo rawurlencode('[page]'); ?>','<?php echo rawurlencode($page['page']); ?>'),this)"><span
                                    class="glyphicon glyphicon-remove"></span></a></td>
                    <?php else: ?>
                        <td>&nbsp;</td>
                    <?php endif; ?>
                </tr>
                <?php $i++; endforeach; ?>
            <?php if ($settings['count_views']): ?>
                <tr>
                    <td colspan="4"
                        style="text-align:right;"><?php echo str_replace('[time]', strftime($lang['time_format'], $settings['counter_last_resetted']), $lang['total_views']); ?></td>
                    <td><b><?php echo $total_views; ?></b></td>
                    <td colspan="2"><?php if ($_SESSION[$settings['session_prefix'] . 'user_type'] == 1) { ?><span
                            class="small">
                            <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?mode=pages&amp;reset_views=true"><?php echo $lang['reset_views']; ?></a>
                            </span><?php } else { ?>&nbsp;<?php } ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info"><?php echo $lang['no_pages']; ?></div>
<?php endif; ?>
