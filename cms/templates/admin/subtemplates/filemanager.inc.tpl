<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['filemanager']; ?></h1>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success btn-top pull-right"
           href="index.php?mode=filemanager&amp;action=upload&amp;directory=<?php echo $directory; ?>"><span
                class="glyphicon glyphicon-upload"></span> <?php echo $lang['upload_file_link']; ?></a>
    </div>
</div>


<h1></h1>

<form class="form-inline" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="get">
    <div class="form-group">
        <input type="hidden" name="mode" value="filemanager"/>
        <label for="directory"><?php echo $lang['directory']; ?></label> <select id="directory" class="form-control"
                                                                                 size="1" name="directory"
                                                                                 onchange="this.form.submit();">
            <option
                value="<?php echo $file_dir ?>"<?php if ($directory == $file_dir): ?> selected="selected"<?php endif; ?>><?php echo $file_dir ?></option>
            <option
                value="<?php echo $media_dir ?>"<?php if ($directory == $media_dir): ?> selected="selected"<?php endif; ?>><?php echo $media_dir ?></option>
        </select>
    </div>
</form>

<?php if (isset($files)): ?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th><?php echo $lang['file']; ?></th>
            <?php if (isset($mime_content_type)): ?>
                <th><?php echo $lang['file_type']; ?></th><?php endif; ?>
            <th><?php echo $lang['file_size']; ?></th>
            <th><?php echo $lang['file_date']; ?></th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0;
        foreach ($files as $file): ?>

            <tr>
                <td>
                    <a href="<?php echo BASE_URL . 'static/' . $directory . '/' . $file['filename']; ?>"><?php echo $file['filename']; ?></a>
                </td>
                <?php if (isset($mime_content_type)): ?>
                    <td><?php echo $file['mime_content_type']; ?></td><?php endif; ?>
                <td><?php echo $file['size']; ?></td>
                <td><?php echo $file['last_modified']; ?></td>
                <td class="options"><a class="btn btn-danger btn-xs"
                                       href="index.php?mode=filemanager&amp;directory=<?php echo $directory; ?>&amp;delete=<?php echo $file['filename']; ?>"
                                       title="<?php echo $lang['delete']; ?>"
                                       data-delete-confirm="<?php echo rawurlencode($lang['delete_file_confirm']); ?>"><span
                            class="glyphicon glyphicon-remove"></span></a></td>
            </tr>

            <?php ++$i; endforeach ?>
        </tbody>
    </table>

    <?php else: ?>

        <p><i><?php echo $lang['no_files']; ?></i></p>

    <?php
    endif; ?>
