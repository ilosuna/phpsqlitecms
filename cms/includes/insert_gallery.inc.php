<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $dbr = Database::$content->query("SELECT DISTINCT gallery FROM ".Database::$db_settings['photo_table']." ORDER BY gallery ASC");
   while($data = $dbr->fetch())
    {
     $galleries[] = htmlspecialchars($data['gallery']);
    }
   if(isset($galleries))
    {
     $template->assign('galleries',$galleries);
    }
 }
$template_file = 'insert_gallery.tpl';
?>
