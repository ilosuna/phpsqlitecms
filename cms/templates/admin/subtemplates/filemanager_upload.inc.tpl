<ol class="breadcrumb">
<li><a href="index.php?mode=filemanager"><?php echo $lang['filemanager']; ?></a></li>
<li class="active"><?php echo $lang['upload_file']; ?></li>
</ol>

<h1><?php echo $lang['upload_file']; ?></h1>
<?php include('errors.inc.tpl'); ?>

<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
 <div>
  <input type="hidden" name="mode" value="filemanager" />
  <input type="hidden" name="upload_file_submit" value="true"> 
   <fieldset style="width:400px; border:1px solid #c0c0c0;"><legend style="font-size:11px;"><?php echo $lang['file_legend']; ?></legend>
    <p style="margin-top:20px;"><?php echo $lang['upload_file_label']; ?><br />
     <input type="file" name="file" size="25" /></p>
     <p><?php echo $lang['upload_directory_label']; ?><br />
     <select size="1" name="directory">
     <option value="<?php echo $media_dir ?>"<?php if($directory==$media_dir) { ?> selected="selected"<?php } ?>><?php echo $media_dir ?></option>
     <option value="<?php echo $file_dir ?>"<?php if($directory==$file_dir) { ?> selected="selected"<?php } ?>><?php echo $file_dir ?></option>
     </select></p>
     <p><?php echo $lang['filename_on_server']; ?><br />
     <input type="text" name="file_name" value="<?php if(isset($file_name)) echo htmlspecialchars(stripslashes($file_name)); ?>" size="25" /> <span class="smallx"><?php echo $lang['filename_server_same']; ?></span></p>
     <p><input id="overwrite_file" type="checkbox" name="overwrite_file" value="true"><label for="overwrite_file"><?php echo $lang['overwrite_file']; ?></label></p>
     </fieldset>
     <fieldset style="width:400px; margin-top:20px; border:1px solid #c0c0c0;"><legend style="font-size:11px;"><?php echo $lang['image_options']; ?></legend>
     <table border="0">
     <tr>
     <td><input id="upload_mode_1" type="radio" name="upload_mode" value="1"<?php if(isset($upload_mode) && $upload_mode==1 || empty($upload_mode)) { ?> checked="checked"<?php } ?>></td>
     <td><label for="upload_mode_1"><?php echo $lang['dont_manipulate_image']; ?></label></td>
     </tr>
     <tr>
     <td><input id="upload_mode_2" type="radio" name="upload_mode" value="2"<?php if(isset($upload_mode) && $upload_mode==2) { ?> checked="checked"<?php } ?>></td>
     <td><label for="upload_mode_2"><?php echo $lang['manipulate_image']; ?></label></td>
     </tr>
     <tr>
     <td>&nbsp;</td>
     <td><?php echo $lang['resize']; ?> <select name="resize_xy" size="1"><option value="x"<?php if((isset($resize_xy) && $resize_xy=='x') || (empty($resize_xy) && $settings['resize_xy']=='x')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_width']; ?></option>
     <option value="y"<?php if((isset($resize_xy) && $resize_xy=='y') || (empty($resize_xy) && $settings['resize_xy']=='y')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_height']; ?></option></select> <input type="text" name="resize" value="<?php if(isset($resize)) echo intval($resize); else echo $settings['resize']; ?>" size="3" /> px</td>
     <tr>
     <tr>
     <td>&nbsp;</td>
     <td><?php echo $lang['compression']; ?> <input type="text" name="compression" value="<?php if(isset($compression)) echo intval($compression); else echo $settings['compression']; ?>" size="3" /> % <span class="smallx"><?php echo $lang['compression_jpg_only']; ?></span></td>
     </tr>
     <tr>
     <td colspan="2">&nbsp;</td>
     </tr>
     <tr>
     <td><input id="create_thumbnail" type="checkbox" name="create_thumbnail" value="1"<?php if(isset($create_thumbnail) && $create_thumbnail==1) { ?> checked="checked"<?php } ?>></td>
     <td><label for="create_thumbnail"><?php echo $lang['create_thumbnail']; ?></label></td>
     </tr>     
     <tr>
     <td>&nbsp;</td>
     <td><?php echo $lang['resize']; ?> <select name="thumbnail_resize_xy" size="1"><option value="x"<?php if((isset($thumbnail_resize_xy) && $thumbnail_resize_xy=='x') || (empty($thumbnail_resize_xy) && $settings['thumbnail_resize_xy']=='x')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_width']; ?></option>
     <option value="y"<?php if((isset($thumbnail_resize_xy) && $thumbnail_resize_xy=='y') || (empty($thumbnail_resize_xy) && $settings['thumbnail_resize_xy']=='y')) { ?> selected="selected"<?php } ?>><?php echo $lang['resize_height']; ?></option></select> <input type="text" name="thumbnail_resize" value="<?php if(isset($thumbnail_resize)) echo intval($thumbnail_resize); else echo $settings['thumbnail_resize']; ?>" size="3" /> px</td>
     <tr>
     <tr>
     <td>&nbsp;</td>
     <td><?php echo $lang['compression']; ?> <input type="text" name="thumbnail_compression" value="<?php if(isset($thumbnail_compression)) echo intval($thumbnail_compression); else echo $settings['thumbnail_compression']; ?>" size="3" /> % <span class="smallx"><?php echo $lang['compression_jpg_only']; ?></span></td>
     </tr>     
     </table>
     </fieldset>
     
     <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-upload"></span> <?php echo $lang['upload_file_submit']; ?></button>
     
     </div>
     </form>
