<ol class="breadcrumb">
    <li><a href="index.php?mode=filemanager"><?php echo $lang['filemanager']; ?></a></li>
    <li class="active"><?php echo $lang['upload_file']; ?></li>
</ol>

<h1><?php echo $lang['upload_file']; ?></h1>
<?php include('errors.inc.tpl'); ?>

<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
    <div>
        <input type="hidden" name="mode" value="filemanager"/>
        <input type="hidden" name="upload_file_submit" value="true">

        <fieldset>
            <legend><?php echo $lang['file_legend']; ?></legend>

            <div class="form-group">
                <label for="file" class="sr-only"><?php echo $lang['upload_file_label']; ?></label>
                <input id="file" type="file" name="file">
            </div>

            <div class="form-group">
                <label for="directory"><?php echo $lang['upload_directory_label']; ?></label>
                <select id="directory" class="form-control form-control-default" name="directory" size="1">
                    <option
                        value="<?php echo $media_dir ?>"<?php if ($directory == $media_dir) { ?> selected="selected"<?php } ?>><?php echo $media_dir ?></option>
                    <option
                        value="<?php echo $file_dir ?>"<?php if ($directory == $file_dir) { ?> selected="selected"<?php } ?>><?php echo $file_dir ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="file_name"><?php echo $lang['filename_on_server']; ?></label>
                <input id="file_name" class="form-control form-control-default" type="text" name="file_name"
                       value="<?php if (isset($file_name)) echo htmlspecialchars(stripslashes($file_name)); ?>"
                       placeholder="<?php echo $lang['filename_server_same']; ?>">
            </div>

            <div class="checkbox">
                <label>
                    <input id="overwrite_file" type="checkbox" name="overwrite_file"
                           value="true"> <?php echo $lang['overwrite_file']; ?>
                </label>
            </div>

        </fieldset>

        <fieldset>
            <legend><?php echo $lang['image_options']; ?></legend>

            <div class="form-group">
                <div class="radio">
                    <label>
                        <input id="upload_mode_1" type="radio" name="upload_mode"
                               value="1"<?php if (isset($upload_mode) && $upload_mode == 1 || empty($upload_mode)) { ?> checked="checked"<?php } ?>>
                        <?php echo $lang['dont_manipulate_image']; ?>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input id="upload_mode_2" type="radio" name="upload_mode"
                               value="2"<?php if (isset($upload_mode) && $upload_mode == 2) { ?> checked="checked"<?php } ?>>
                        <?php echo $lang['manipulate_image']; ?>
                    </label><br/>
                    <input id="resize" class="form-control form-control-small form-control-inline" type="text"
                           name="resize"
                           value="<?php if (isset($resize)) echo intval($resize); else echo $settings['resize']; ?>"
                           size="3"/> px
                    <select class="form-control form-control-small form-control-inline" name="resize_xy" size="1">
                        <option
                            value="x"<?php if ((isset($resize_xy) && $resize_xy == 'x') || (empty($resize_xy) && $settings['resize_xy'] == 'x')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_width']; ?></option>
                        <option
                            value="y"<?php if ((isset($resize_xy) && $resize_xy == 'y') || (empty($resize_xy) && $settings['resize_xy'] == 'y')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_height']; ?></option>
                    </select>,
                    <input id="compression" class="form-control form-control-small form-control-inline" type="text"
                           name="compression"
                           value="<?php if (isset($compression)) echo intval($compression); else echo $settings['compression']; ?>"
                           size="3"/> % <?php echo $lang['compression']; ?> <?php echo $lang['compression_jpg_only']; ?>
                </div>
            </div>
            <div class="checkbox">
                <label>
                    <input id="create_thumbnail" type="checkbox" name="create_thumbnail"
                           value="1"<?php if (isset($create_thumbnail) && $create_thumbnail == 1) { ?> checked="checked"<?php } ?>> <?php echo $lang['create_thumbnail']; ?>
                </label><br/>
                <input id="thumbnail_resize" class="form-control form-control-small form-control-inline" type="text"
                       name="thumbnail_resize"
                       value="<?php if (isset($thumbnail_resize)) echo intval($thumbnail_resize); else echo $settings['thumbnail_resize']; ?>"
                       size="3"/> px
                <select class="form-control form-control-small form-control-inline" name="thumbnail_resize_xy" size="1">
                    <option
                        value="x"<?php if ((isset($thumbnail_resize_xy) && $thumbnail_resize_xy == 'x') || (empty($thumbnail_resize_xy) && $settings['thumbnail_resize_xy'] == 'x')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_width']; ?></option>
                    <option
                        value="y"<?php if ((isset($thumbnail_resize_xy) && $thumbnail_resize_xy == 'y') || (empty($thumbnail_resize_xy) && $settings['thumbnail_resize_xy'] == 'y')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_height']; ?></option>
                </select>,
                <input id="thumbnail_compression" class="form-control form-control-small form-control-inline"
                       type="text" name="thumbnail_compression"
                       value="<?php if (isset($thumbnail_compression)) echo intval($thumbnail_compression); else echo $settings['thumbnail_compression']; ?>"
                       size="3"/> % <?php echo $lang['compression']; ?> <?php echo $lang['compression_jpg_only']; ?>
            </div>

        </fieldset>

        <div class="form-group">
            <br/>
            <button class="btn btn-primary btn-lg" type="submit"><span
                    class="glyphicon glyphicon-upload"></span> <?php echo $lang['upload_file_submit']; ?></button>
        </div>

    </div>
</form>
