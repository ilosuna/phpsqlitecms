<h1><a href="index.php"><?php echo $lang['administration']; ?></a> &raquo; <a href="index.php?mode=notes"><?php echo $lang['notes']; ?></a> &raquo; <?php echo $lang['delete_note_section']; ?></h1>

<p><?php echo str_replace('[note_section]', $note_section, $lang['delete_note_section_confirm']); ?></p>

<form action="index.php" method="post">
 <div>
  <input type="hidden" name="mode" value="notes" />
  <input type="hidden" name="delete" value="<?php echo $note_section; ?>" />
  <input type="submit" name="confirmed" value="<?php echo $lang['delete_note_section_submit']; ?>" />
 </div>
</form>
