<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(isset($_REQUEST['action']))
   {
    switch($_REQUEST['action'])
     {
      case 'reorder':
       if(isset($_REQUEST['galleries']))
        {
         $table = Database::$db_settings['photo_table'];
         $list = $_REQUEST['galleries'];
        }
       elseif(isset($_REQUEST['menus']))
        {
         $table = Database::$db_settings['menu_table'];
         $list = $_REQUEST['menus'];
        }
       elseif(isset($_REQUEST['notes']))
        {
         $table = Database::$db_settings['notes_table'];
         $list = $_REQUEST['notes'];
        }
       if(isset($list) && isset($table))
        {
         $list_items = explode(',', $list);
         $sequence = 1;
         $dbr = Database::$content->prepare("UPDATE ".$table." SET sequence=:sequence WHERE id=:id");
         $dbr->bindParam(':sequence', $sequence, PDO::PARAM_INT);
         $dbr->bindParam(':id', $id, PDO::PARAM_INT);
         Database::$content->beginTransaction();
         foreach($list_items as $id)
          {
           $dbr->execute();
           ++$sequence;
          }
         Database::$content->commit();
         if(isset($cache) && $cache->autoClear) $cache->clear();
        } 
      break;
     }
   }
 }

exit;
?>
