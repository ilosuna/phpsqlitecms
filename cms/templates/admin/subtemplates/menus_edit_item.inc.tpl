<?php if (isset($menu_data)): ?>

    <h1><a href="index.php"><?php echo $lang['administration']; ?></a> &raquo; <a
            href="index.php?mode=menus"><?php echo $lang['menus']; ?></a> &raquo; <a
            href="index.php?mode=menus&amp;edit=<?php echo $menu_data['menu']; ?>"><?php echo str_replace('[menu]', $menu_data['menu'], $lang['edit_menu_hl']); ?></a> &raquo; <?php echo $lang['edit_menu_item']; ?>
    </h1>

    <form action="index.php" method="post">
        <div>
            <input type="hidden" name="mode" value="menus"/>
            <input type="hidden" name="menu" value="<?php echo $menu_data['menu']; ?>"/>
            <input type="hidden" name="id" value="<?php echo $menu_data['id']; ?>"/>
            <table class="admin-table" cellspacing="1" cellpadding="5" border="0">
                <tr>
                    <th><?php echo $lang['menu_item_name']; ?></th>
                    <th><?php echo $lang['menu_item_title']; ?></th>
                    <th><?php echo $lang['menu_item_link']; ?></th>
                    <th><?php echo $lang['menu_item_section']; ?></th>
                    <th><?php echo $lang['menu_item_accesskey']; ?></th>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <td class="a"><input type="text" name="name" value="<?php echo $menu_data['name']; ?>" size="10"
                                         style="width:100%;"/></td>
                    <td><input type="text" name="title" value="<?php echo $menu_data['title']; ?>" size="10"
                               style="width:100%;"/></td>
                    <td><input type="text" name="link" value="<?php echo $menu_data['link']; ?>" size="10"
                               style="width:100%;"/></td>
                    <td><input type="text" name="section" value="<?php echo $menu_data['section']; ?>" size="10"
                               style="width:100%;"/></td>
                    <td><input type="text" name="accesskey" value="<?php echo $menu_data['accesskey']; ?>" size="3"
                               style="width:100%;"/></td>
                    <td><input type="submit" name="edit_menu_item_submitted"
                               value="<?php echo $lang['submit_button_ok']; ?>"/></td>
                </tr>
            </table>
        </div>
    </form>

<?php else: ?>

    <p><?php echo $lang['menu_item_doesnt_exist']; ?></p>

<?php endif; ?>
