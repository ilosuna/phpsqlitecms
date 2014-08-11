<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo $lang['insert_image']; ?></h4>
</div>
<div class="modal-body">

    <?php if (isset($images)): ?>
        <div class="form-group">
            <select id="imageselect" class="form-control" size="20">
                <?php foreach ($images as $image): ?>
                    <option value="<?php echo $image; ?>"><?php echo $image; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image_class"><?php echo $lang['insert_image_class']; ?></label>
            <input id="image_class" class="form-control" type="text" name="image_class"
                   value="<?php echo $settings['default_image_class']; ?>">
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <p><?php echo $lang['no_images']; ?></p>
        </div>
    <?php endif; ?>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['cancel']; ?></button>
    <?php if (isset($images)): ?>
        <button id="insert-image" type="button"
                class="btn btn-primary"><?php echo $lang['insert_image_button']; ?></button>
    <?php endif; ?>
</div>
<script>
    $(function () {
        $("#imageselect option").dblclick(function (e) {
            $("#insert-image").click();
        });
        $("#insert-image").click(function (e) {
            if (gallery = $("#imageselect option:selected").val()) {
                if (image_class = $("#image_class").val()) imageCode = "[image:" + gallery + "|" + image_class + "]";
                else imageCode = "[image:" + gallery + "]";
                $($insertField).insertAtCaret(imageCode);
            }
            $('#modal_image').modal('hide');
        });
    });
</script>
