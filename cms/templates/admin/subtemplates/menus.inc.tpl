<div class="row">
    <div class="col-sm-11">
        <h1><?php echo $lang['menus']; ?></h1>
    </div>
    <div class="col-sm-1">
        <a class="btn btn-success btn-top pull-right" href="index.php?mode=menus&amp;action=new"><span
                class="glyphicon glyphicon-plus"></span> <?php echo $lang['create_menu']; ?></a>
    </div>
</div>

<?php if (isset($menus)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo $lang['menu']; ?></th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            foreach ($menus as $menu): ?>
                <tr>
                    <td><?php echo $menu; ?></td>
                    <td class="options nowrap"><a class="btn btn-primary btn-xs"
                                                  href="index.php?mode=menus&amp;edit=<?php echo $menu; ?>"
                                                  title="<?php echo $lang['edit']; ?>"><span
                                class="glyphicon glyphicon-pencil"></a>
                        <a class="btn btn-danger btn-xs" href="index.php?mode=menus&amp;delete=<?php echo $menu; ?>"
                           title="<?php echo $lang['delete']; ?>"
                           data-delete-confirm="<?php echo rawurlencode($lang['delete_menu_confirm']); ?>"><span
                                class="glyphicon glyphicon-remove"></a>
                        <?php if ($menu == $settings['default_menu']): ?><span class="btn btn-success btn-xs"
                                                                               title="<?php echo $lang['default_menu']; ?>">
                                <span class="glyphicon glyphicon-check"></span></span><?php else: ?><a
                            class="btn btn-default btn-xs"
                            href="index.php?mode=menus&amp;set_default=<?php echo $menu; ?>"
                            title="<?php echo $lang['set_default_menu']; ?>"><span
                                    class="glyphicon glyphicon-unchecked"></span></a><?php endif; ?></td>
                </tr>
                <?php ++$i; endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    <p><?php echo $lang['no_menu']; ?></p>

<?php endif; ?>
