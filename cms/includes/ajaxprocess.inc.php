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
           case 'get':
      if(isset($_REQUEST['page']))
        {
         $table = Database::$db_settings['pages_table'];
         $list = 'page';
        }
        elseif(isset($_REQUEST['category']))
        {
         $table = Database::$db_settings['pages_table'];
         $list = 'category';
        }
         elseif(isset($_REQUEST['sections']))
        {
         $table = Database::$db_settings['menu_table'];
         $list = 'section';
        }         
    $term = addCslashes($_REQUEST['term'],'\%_');

        if(isset($list) && isset($table))
        {
        $dbr = Database::$content->query('SELECT distinct '.$list.' FROM '.$table.' WHERE '.$list.' LIKE "%' .$term.'%"');
        $i=0;
        while($row=$dbr->fetch()){
          if (!$row[$list]=="") $res[] = array("id"=>$i, "label"=>$row[$list], "value"=>$row[$list]);  
        $i++;
        }
        
        $res_list = json_encode($res);
        echo $res_list;
         
        
        if(isset($cache) && $cache->autoClear) $cache->clear();
        } 
       
       break;
     }
   }
 }

exit;
?>
