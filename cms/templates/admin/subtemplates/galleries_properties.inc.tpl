<h1><a href="index.php"><?php echo $lang['administration']; ?></a> &raquo; <a
        href="index.php?mode=galleries"><?php echo $lang['photo_galleries']; ?></a> &raquo; <a
        href="index.php?mode=galleries&amp;edit=<?php echo $gallery; ?>"><?php echo str_replace('[gallery]', $gallery, $lang['edit_gallery']); ?></a> &raquo; <?php echo $lang['gallery_properties']; ?>
</h1>

<form action="index.php" method="post">
    <div>
        <div>
            <input type="hidden" name="mode" value="galleries"/>
            <input type="hidden" name="gallery" value="<?php echo $gallery_data['gallery']; ?>"/>
            <table class="admin-table" cellspacing="1" cellpadding="5" border="0">
                <tr>
                    <td class="c"><label for="template"><?php echo $lang['specify_photo_tpl_m']; ?></label></td>
                    <td class="b">
                        <select id="template" name="template" size="1">
                            <?php foreach ($available_photo_templates as $photo_template): ?>
                                <option
                                    value="<?php echo $photo_template; ?>"<?php if (isset($gallery_data['template']) && $gallery_data['template'] == $photo_template): ?> selected="selected"<?php endif; ?>><?php echo $photo_template; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="c"><label for="photos_per_row"><?php echo $lang['photos_per_row']; ?></label></td>
                    <td class="b"><input type="text" id="photos_per_row" name="photos_per_row"
                                         value="<?php echo $gallery_data['photos_per_row']; ?>" size="5"/></td>
                </tr>
                <tr>
                    <td class="c">&nbsp;</td>
                    <td class="b" style="text-align:right;"><input type="submit" name="gallery_properties_submit"
                                                                   value="<?php echo $lang['submit_button_ok']; ?>"/>
                    </td>
                </tr>
            </table>
        </div>
</form>
