<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo $lang['insert_gallery_label']; ?></h4>
</div>
<div class="modal-body">

    <?php if (isset($galleries)): ?>
        <div class="form-group">
            <select id="galleryselect" class="form-control" name="gallery" size="20">
        </div>
        <?php foreach ($galleries as $gallery): ?>
            <option
                value="<?php echo $gallery; ?>"<?php if (isset($selected_gallery) && $selected_gallery == $gallery): ?> selected="selected"<?php endif; ?>><?php echo $gallery; ?></option>
        <?php endforeach; ?>
        </select>
    <?php endif; ?>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['cancel']; ?></button>
    <button id="insert-gallery" type="button"
            class="btn btn-primary"><?php echo $lang['insert_gallery_label']; ?></button>
</div>
<script>
    $(function () {
        $("#galleryselect option").dblclick(function (e) {
            $("#insert-gallery").click();
        });
        $("#insert-gallery").click(function (e) {
            if (gallery = $("#galleryselect option:selected").val()) {
                $($insertField).insertAtCaret("[gallery:" + gallery + "]");
            }
            $('#modal_gallery').modal('hide');
        });
    });
</script>
