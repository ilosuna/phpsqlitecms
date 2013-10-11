<?php if(isset($edit_news)): ?>

<?php if(isset($errors)): ?>
<h2 class="caution"><?php echo $lang['error_headline']; ?></h2>
<ul class="errors">
 <?php foreach($errors as $error): ?>
 <li><?php if(isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
 <?php endforeach; ?>
</ul>
<?php endif; ?>

<form action="<?php echo BASE_URL . PAGE; ?>" method="post">
 <div id="edit-news">
  <input type="hidden" name="mode" value="news" />
  <?php if(isset($edit_news['id'])): ?>
  <input type="hidden" name="id" value="<?php echo $edit_news['id']; ?>" />
  <?php endif; ?>
  
  <p><label for="title"><?php echo $lang['simple_news_edit_title']; ?></label><br />
  <input id="title" type="text" name="title" value="<?php if(isset($edit_news['title'])) echo $edit_news['title']; ?>" size="40" /></p>

  <p><label for="teaser"><?php echo $lang['simple_news_edit_teaser']; ?></label><br />
  <textarea id="teaser" name="teaser" cols="60" rows="3"><?php if(isset($edit_news['teaser'])) echo $edit_news['teaser']; ?></textarea></p>

  <?php if(isset($wysiwyg)): ?>
  <p><label for="text"><?php echo $lang['simple_news_edit_text']; ?></label><br />
  <textarea id="text" name="text" cols="60" rows="15"><?php if(isset($edit_news['text'])) echo $edit_news['text']; ?></textarea><input type="hidden" name="text_formatting" value="0" /></p>
  <?php else: ?>
  <p><label for="text"><?php echo $lang['simple_news_edit_text']; ?></label><br />
  <textarea id="text" name="text" cols="60" rows="12"><?php if(isset($edit_news['text'])) echo $edit_news['text']; ?></textarea><br />
  <span class="small"><input id="simple_news_edit_text_formatting" type="checkbox" name="text_formatting" value="1"<?php if(isset($edit_news['text_formatting']) && $edit_news['text_formatting']==1): ?> checked="checked"<?php endif; ?> /><label for="simple_news_edit_text_formatting"><?php echo $lang['simple_news_edit_text_format']; ?></label></span></p>
  <?php endif; ?>

  <p><label for="linkname"><?php echo $lang['simple_news_edit_linkname']; ?></label><br />
  <input id="linkname" type="text" name="linkname" value="<?php if(isset($edit_news['linkname'])) echo $edit_news['linkname']; ?>" size="40" /></p>

  <p><label for="newstime"><?php echo $lang['simple_news_edit_time']; ?></label> <small><?php echo $lang['simple_news_edit_time_format']; ?></small><br />
  <input id="newstime" type="text" name="time" value="<?php if(isset($edit_news['time'])) echo $edit_news['time']; ?>" size="40" /></p>

  <p><input type="submit" name="edit_news_submit" value="<?php echo $lang['submit_button_ok']; ?>" /></p>

 </div>
</form>

<?php elseif(isset($delete_news)): ?>

<p><strong><?php echo $delete_news['title']; ?></strong></p>

<form action="<?php echo BASE_URL . PAGE; ?>" method="post">
<div>
<input type="hidden" name="delete" value="<?php echo $delete_news['id']; ?>" />
<p><input class="delete" type="submit" name="confirmed" value="<?php echo $lang['delete_news_confirm_submit']; ?>" /></p>
</div>
</form>

<?php elseif(isset($news_item)): ?>

<?php echo $news_item['text']; ?>

<?php if($authorized_to_edit): ?>
<p class="small"><a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>,edit"><img src="<?php echo BASE_URL; ?>templates/images/edit_link.png" width="15" height="10" alt="" /><?php echo $lang['edit']; ?></a> &nbsp;<a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>,delete" onclick="return confirm_link('<?php echo rawurlencode($lang['simple_news_delete_confirm']); ?>',this,1)"><img src="<?php echo BASE_URL; ?>templates/images/delete_link.png" width="13" height="9" alt="" /><?php echo $lang['delete']; ?></a></p>
<?php endif; ?>

<?php elseif(isset($news)): ?>

<?php if($authorized_to_edit): ?>
<p><a class="additem" href="<?php echo BASE_URL . PAGE; ?>,add_item"><?php echo $lang['simple_news_add_item']; ?></a></p>
<?php endif; ?>

<?php foreach($news as $news_item): ?>
<div class="news">
<p class="time"><?php echo $lang['simple_news_time'][$news_item['id']]; ?></p>
<h2><a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>"><?php echo $news_item['title']; ?></a></h2>

<?php if(empty($news_item['teaser'])): ?>
<?php echo $news_item['text']; ?>
<?php else: ?>
<p><?php echo $news_item['teaser']; ?><br />
<a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>"><?php echo $news_item['linkname']; ?></a></p>
<?php endif; ?>

</div>
<?php endforeach; ?>

<?php if($pagination): ?>
<p class="pagination"><?php echo $lang['pagination']; ?> [
<?php if($pagination['previous']): ?> <a href="<?php echo BASE_URL . PAGE; if($pagination['previous']>1): ?>,,<?php echo $pagination['previous']; endif; ?>">&laquo;</a> <?php endif; ?>
<?php foreach($pagination['items'] as $item): ?>
<?php if(empty($item)): ?> ..<?php elseif($item==$pagination['current']): ?> <span class="current"><?php echo $item; ?></span><?php else: ?> <a href="<?php echo BASE_URL . PAGE; if($item>1): ?>,,<?php echo $item; endif; ?>"><?php echo $item; ?></a><?php endif; ?>
<?php endforeach; ?>
<?php if($pagination['next']): ?> <a href="<?php echo BASE_URL . PAGE; ?>,,<?php echo $pagination['next']; ?>">&raquo;</a><?php endif; ?>
 ]</p>
<?php endif; ?>

<?php else: ?>

<p><?php echo $lang['no_news']; ?></p>

<?php if($authorized_to_edit): ?>
<p><a class="additem" href="<?php echo BASE_URL . PAGE; ?>,add_item"><?php echo $lang['simple_news_add_item']; ?></a></p>
<?php endif; ?>

<?php endif; ?>
