<h1><a href="index.php"><?php echo $lang['administration']; ?></a> &raquo; <a href="index.php?mode=menus"><?php echo $lang['menus']; ?></a> &raquo; <?php echo $lang['new_menu_hl']; ?></h1>

<?php if(isset($errors)): ?>
<p class="caution"><?php echo $lang['error_headline']; ?></p>
<ul>
 <?php foreach($errors as $error): ?>
 <li><?php if(isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
 <?php endforeach; ?>
</ul>
<?php endif; ?>

<form action="index.php" method="post">
 <div>
  <input type="hidden" name="mode" value="menus" />
  <p><label for="new_menu_name"><?php echo $lang['new_menu_name']; ?></label><br />
  <input id="new_menu_name" type="text" name="new_menu_name" value="<?php if(isset($new_menu_name)) echo $new_menu_name; ?>" size="25" /> <input type="submit" value="<?php echo $lang['submit_button_ok']; ?>" /></p>
 </div>
</form>

