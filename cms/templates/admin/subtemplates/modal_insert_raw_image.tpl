<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title"><?php echo $lang['insert_image']; ?></h4>
</div>
<div class="modal-body">

<?php if(isset($images)): ?>


  <select id="imageselect" size="20" style="width:100%;">
  <?php foreach($images as $image): ?>
  <option value="<?php echo $image; ?>" ondblclick="image_popup('<?php echo BASE_URL.MEDIA_DIR.$image; ?>')"><?php echo $image; ?></option>
  <?php endforeach; ?>
  </select>


<?php else: ?>
<p><em><?php echo $lang['no_images']; ?></em></p>
<?php endif; ?>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['cancel']; ?></button>
<button id="insert-image" type="button" class="btn btn-primary"><?php echo $lang['insert_image_button']; ?></button>
</div>
</div>
</div>
<script>
$(function() {
$("#insert-image").click(function(e) { if(val = $("#imageselect option:selected").val()) $("#"+insertTarget).val(val);
                                       $('#modal_raw_image').modal('hide');
                                     });
});
</script>
