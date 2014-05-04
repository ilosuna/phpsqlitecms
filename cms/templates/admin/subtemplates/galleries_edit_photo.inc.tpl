<?php if (isset($invalid_photo)): ?>
    <p class="caution"><?php echo $lang['invalid_photo']; ?></p>
<?php else: ?>

    <ol class="breadcrumb">
        <li><a href="index.php?mode=galleries"><?php echo $lang['photo_galleries']; ?></a></li>
        <li>
            <a href="index.php?mode=galleries&amp;edit=<?php echo $photo_data['gallery']; ?>"><?php echo str_replace('[gallery]', $photo_data['gallery'], $lang['edit_gallery']); ?></a>
        </li>
        <li class="active"><?php if (isset($photo_data['id'])) echo $lang['edit_photo']; else echo $lang['new_photo']; ?></li>
    </ol>

    <h1><?php if (isset($photo_data['id'])) echo $lang['edit_photo']; else echo $lang['new_photo']; ?></h1>

    <?php include('errors.inc.tpl'); ?>


    <form class="form-horizontal" role="form" action="index.php" method="post">
        <div>
            <input type="hidden" name="mode" value="galleries">
            <input type="hidden" name="description_formatting" value="1">
            <?php if (isset($photo_data['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $photo_data['id']; ?>"/>
            <?php endif; ?>
            <?php if (isset($photo_data['gallery'])): ?>
                <input type="hidden" name="gallery" value="<?php echo $photo_data['gallery']; ?>"/>
            <?php endif; ?>

            <div class="form-group">
                <label for="photo_thumbnail"
                       class="col-md-2 control-label"><?php echo $lang['edit_photo_thumbnail']; ?></label>

                <div class="col-md-8">
                    <div class="input-group">
                        <input id="photo_thumbnail" class="form-control form-control" type="text" name="photo_thumbnail"
                               value="<?php if (isset($photo_data['photo_thumbnail'])) echo $photo_data['photo_thumbnail']; ?>">
<span class="input-group-btn">
<a class="btn btn-default" href="index.php?mode=modal&action=insert_raw_image" data-toggle="modal"
   data-target="#modal_raw_image" data-insert="#photo_thumbnail" data-keyboard="true"
   title="<?php echo $lang['select_image']; ?>"><span class="glyphicon glyphicon-search"></a>
</span>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label for="photo_normal"
                       class="col-md-2 control-label"><?php echo $lang['edit_photo_normal']; ?></label>

                <div class="col-md-8">
                    <div class="input-group">
                        <input id="photo_normal" class="form-control" type="text" name="photo_normal"
                               value="<?php if (isset($photo_data['photo_normal'])) echo $photo_data['photo_normal']; ?>">
<span class="input-group-btn">
<a class="btn btn-default modal-invoker" href="index.php?mode=modal&action=insert_raw_image" data-toggle="modal"
   data-target="#modal_raw_image" data-insert="#photo_normal" data-keyboard="true"
   title="<?php echo $lang['select_image']; ?>"><span class="glyphicon glyphicon-search"></a>
</span>
                    </div>
                </div>
            </div>

            <!--
<div class="form-group">
<label for="photo_large" class="col-md-2 control-label"><?php echo $lang['edit_photo_large']; ?></label>
<div class="col-md-8">
<input id="photo_large" class="form-control form-control-inline form-control-default" type="text" name="photo_large" value="<?php if (isset($photo_data['photo_large'])) echo $photo_data['photo_large']; ?>"> <a class="btn btn-default btn-xs modal-invoker" href="index.php?mode=modal&action=insert_gallery_image" data-toggle="modal" data-target="#image_modal" data-input="photo_large" data-keyboard="true" title="<?php echo $lang['select_image']; ?>"><span class="glyphicon glyphicon-search"></a>
</div>
</div>
-->

            <div class="form-group">
                <label for="title" class="col-md-2 control-label"><?php echo $lang['edit_photo_title']; ?></label>

                <div class="col-md-8">
                    <input id="title" class="form-control" type="text" name="title"
                           value="<?php if (isset($photo_data['title'])) echo $photo_data['title']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="subtitle" class="col-md-2 control-label"><?php echo $lang['edit_photo_subtitle']; ?></label>

                <div class="col-md-8">
                    <input id="subtitle" class="form-control" type="text" name="subtitle"
                           value="<?php if (isset($photo_data['subtitle'])) echo $photo_data['subtitle']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description"
                       class="col-md-2 control-label"><?php echo $lang['edit_photo_description']; ?></label>

                <div class="col-md-8">
                    <textarea id="description" class="form-control" name="description" cols="55"
                              rows="13"><?php if (isset($photo_data['description'])) echo $photo_data['description']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <input type="submit" class="btn btn-primary" name="edit_photo_submitted"
                           value="<?php echo $lang['submit_button_ok']; ?>">
                </div>
            </div>

        </div>
    </form>

<?php endif; ?>

<div class="modal fade" id="modal_raw_image" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
