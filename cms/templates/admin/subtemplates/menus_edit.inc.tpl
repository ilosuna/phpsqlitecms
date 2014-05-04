<ol class="breadcrumb">
    <li><a href="index.php?mode=menus"><?php echo $lang['menus']; ?></a></li>
    <li class="active"><?php echo str_replace('[menu]', $menu, $lang['edit_menu_hl']); ?></li>
</ol>

<h1><?php echo str_replace('[menu]', $menu, $lang['edit_menu_hl']); ?></h1>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="menus"/>
        <input type="hidden" name="menu" value="<?php echo $menu; ?>"/>
        <?php if (isset($edit_item)): ?>
            <input type="hidden" name="edit_item" value="<?php echo $edit_item; ?>"/>
        <?php else: ?>
            <input type="hidden" name="new_menu_item" value="true"/>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th><?php echo $lang['menu_item_name']; ?></th>
                    <th><?php echo $lang['menu_item_title']; ?></th>
                    <th><?php echo $lang['menu_item_link']; ?></th>
                    <th><?php echo $lang['menu_item_section']; ?></th>
                    <th><?php echo $lang['menu_item_accesskey']; ?></th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody<?php if (empty($edit_item)): ?> data-sortable="<?php echo BASE_URL; ?>cms/?mode=menus&amp;reorder_items=true"<?php endif; ?>>

                <?php if (isset($edit_item)): ?>
                    <?php $i = 0;
                    if (isset($items)): foreach ($items as $item): ?>
                        <tr id="row_<?php echo $item['id']; ?>"
                            class="<?php if ($i % 2 == 0): ?>a<?php else: ?>b<?php endif; ?>">
                            <td><?php if ($item['id'] == $edit_item): ?>
                                    <input class="form-control" type="text"
                                           name="name"
                                           value="<?php echo $item['name']; ?>"
                                           size="10"
                                           style="width:100%;" /><?php else: ?>
                                    <span class="label label-default label-block"><?php echo $item['name']; ?></span><?php endif; ?>
                            </td>
                            <td><?php if ($item['id'] == $edit_item): ?>
                                    <input class="form-control" type="text"
                                           name="title"
                                           value="<?php echo $item['title']; ?>"
                                           size="10"
                                           style="width:100%;" /><?php else: ?><?php echo $item['title']; ?><?php endif; ?>
                            </td>
                            <td><?php if ($item['id'] == $edit_item): ?>
                                    <input class="form-control" type="text"
                                           name="link"
                                           value="<?php echo $item['link']; ?>"
                                           size="10"
                                           style="width:100%;" /><?php else: ?><?php echo $item['link']; ?><?php endif; ?>
                            </td>
                            <td><?php if ($item['id'] == $edit_item): ?>
                                    <input class="form-control" type="text"
                                           name="section"
                                           value="<?php echo $item['section']; ?>"
                                           size="10"
                                           style="width:100%;" /><?php else: ?><?php echo $item['section']; ?><?php endif; ?>
                            </td>
                            <td><?php if ($item['id'] == $edit_item): ?>
                                    <input class="form-control" type="text"
                                           name="accesskey"
                                           value="<?php echo $item['accesskey']; ?>"
                                           size="10"
                                           style="width:100%;" /><?php else: ?><?php echo $item['accesskey']; ?><?php endif; ?>
                            </td>
                            <td><?php if ($item['id'] == $edit_item): ?>
                                    <input class="btn btn-primary" type="submit"
                                           name="edit_menu_item_submitted"
                                           value="<?php echo $lang['submit_button_ok']; ?>" /><?php else: ?>&nbsp;<?php endif; ?>
                            </td>
                        </tr>
                        <?php ++$i; endforeach; endif; ?>

                <?php else: ?>

                <?php $i = 0;
                if (isset($items)): foreach ($items as $item): ?>
                    <tr id="item_<?php echo $item['id']; ?>">
                        <td><span class="label label-default label-block"><?php echo $item['name']; ?></span></td>
                        <td><?php echo $item['title']; ?></td>
                        <td><?php echo $item['link']; ?></td>
                        <td><?php echo $item['section']; ?></td>
                        <td><?php echo $item['accesskey']; ?></td>
                        <td class="options nowrap">
                            <a class="btn btn-primary btn-xs"
                               href="index.php?mode=menus&amp;action=edit_menu_item&amp;id=<?php echo $item['id']; ?>"
                               title="<?php echo $lang['edit']; ?>">
                               <span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="btn btn-danger btn-xs"
                               href="index.php?mode=menus&amp;action=delete_menu_item&amp;id=<?php echo $item['id']; ?>"
                               title="<?php echo $lang['delete']; ?>">
                               <span class="glyphicon glyphicon-remove"></span></a>
                            <span class="btn btn-success btn-xs sortable-handle"
                                  title="<?php echo $lang['drag_and_drop']; ?>">
                                <span class="glyphicon glyphicon-sort"></span></span>
                            <!--<a href="index.php?mode=menus&amp;move_up=<?php echo $item['id']; ?>" title="<?php echo $lang['move_up']; ?>"><?php echo $lang['move_up']; ?></a><a href="index.php?mode=menus&amp;move_down=<?php echo $item['id']; ?>" title="<?php echo $lang['move_down']; ?>"><?php echo $lang['move_down']; ?></a>-->
                        </td>
                    </tr>
                    <?php ++$i; endforeach; endif; ?>
                </tbody>
                <tr>
                    <td><input class="form-control" type="text" name="name" value="" size="10"/></td>
                    <td><input class="form-control" type="text" name="title" value="" size="10"/></td>
                    <td><input class="form-control" type="text" name="link" value="" size="10"/></td>
                    <td><input class="form-control" type="text" name="section" value="" size="10"/></td>
                    <td><input class="form-control" type="text" name="accesskey" value="" size="3"/></td>
                    <td class="options">
                        <button class="btn btn-success"><span
                                class="glyphicon glyphicon-plus"></span> <?php echo $lang['add_menu_item_submit']; ?>
                        </button>
                    </td>
                </tr>

                <?php endif; ?>


            </table>
        </div>
    </div>
</form>
