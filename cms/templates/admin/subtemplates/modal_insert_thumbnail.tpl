<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo $lang['insert_thumbnail']; ?></h4>
</div>
<div class="modal-body">
    <?php if (isset($thumbnails)): ?>
        <div class="form-group">
            <select id="thumbnailselect" class="form-control" size="20">
                <?php foreach ($thumbnails as $thumbnail): ?>
                    <option value="<?php echo $thumbnail['id']; ?>"><?php echo $thumbnail['title']; ?>
                        (<?php echo $thumbnail['gallery']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image_class"><?php echo $lang['insert_image_class']; ?></label>
            <input id="image_class" class="form-control" type="text" name="image_class"
                   value="<?php echo $settings['default_thumbnail_class']; ?>">
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <p><?php echo $lang['no_images']; ?></p>
        </div>
    <?php endif; ?>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['cancel']; ?></button>
    <?php if (isset($thumbnails)): ?>
        <button id="insert-image" type="button"
                class="btn btn-primary"><?php echo $lang['insert_thumbnail_button']; ?></button>
    <?php endif; ?>
</div>
<script>
    $(function () {
        $("#thumbnailselect option").dblclick(function (e) {
            $("#insert-image").click();
        });
        $("#insert-image").click(function (e) {
            if (thumbnail = $("#thumbnailselect option:selected").val()) {
                if (imageClass = $("#image_class").val()) imageCode = "[thumbnail:" + thumbnail + "|" + imageClass + "]";
                else imageCode = "[image:" + thumbnail + "]";
                $($insertField).insertAtCaret(imageCode);
            }
            $('#modal_thumbnail').modal('hide');
        });
    });
</script>
