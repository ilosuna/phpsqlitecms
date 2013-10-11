<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix'].'user_type']==1)
 {
  if(isset($_GET['edit']))
   {
    $menu = $_GET['edit'];
    $action = 'edit';
   }

  if(isset($_REQUEST['delete']))
   {
    if(isset($_REQUEST['confirmed']))
     {
      $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['menu_table']." WHERE menu=:menu");
      $dbr->bindParam(':menu', $_REQUEST['delete'], PDO::PARAM_STR);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus');
      exit;
     }
    else
     {
      $template->assign('menu', htmlspecialchars($_REQUEST['delete']));
      $action = 'delete';
     }
   }

  if(isset($_GET['set_default']))
   {
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['settings_table']." SET value=:value WHERE name='default_menu'");
    $dbr->bindValue(':value', trim($_GET['set_default']), PDO::PARAM_STR);
    $dbr->execute();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus');
    exit;
   }

  if(isset($_POST['new_menu_name']))
   {
    $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['menu_table']." WHERE lower(menu)=:menu");
    $dbr->bindValue(':menu', trim(strtolower($_POST['new_menu_name'])), PDO::PARAM_STR);
    $dbr->execute();
    if($dbr->fetchColumn() > 0)
     {
      $errors[] = 'menu_already_exists';
      $action = 'new';
     }
    elseif(!preg_match('/^[a-zA-Z0-9_\-]+$/', $_POST['new_menu_name']))
     {
      $errors[] = 'error_menu_spec_chars';
      $action = 'new';
     }
    else
     {
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus&edit='.$_POST['new_menu_name']);
      exit;
     }
   }

  if(isset($_POST['new_menu_item']))
   {
    $dbr = Database::$content->prepare("SELECT sequence FROM ".Database::$db_settings['menu_table']." WHERE menu=:menu ORDER BY sequence DESC LIMIT 1");
    $dbr->bindValue(':menu', trim($_POST['menu']), PDO::PARAM_STR);
    $dbr->execute();
    $data = $dbr->fetch();
    if(!isset($data['sequence']))
     {
      $new_sequence = 1;
     }
    else
     {
      $new_sequence = $data['sequence']+1;
     }
    $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['menu_table']." (menu,sequence,name,title,link,section,accesskey) VALUES (:menu,:sequence,:name,:title,:link,:section,:accesskey)");
    $dbr->bindValue(':menu', trim($_POST['menu']), PDO::PARAM_STR);
    $dbr->bindValue(':sequence', $new_sequence, PDO::PARAM_INT);
    $dbr->bindValue(':name', trim($_POST['name']), PDO::PARAM_STR);
    $dbr->bindValue(':title', trim($_POST['title']), PDO::PARAM_STR);
    $dbr->bindValue(':link', trim($_POST['link']), PDO::PARAM_STR);
    $dbr->bindValue(':section', trim($_POST['section']), PDO::PARAM_STR);
    $dbr->bindValue(':accesskey', trim($_POST['accesskey']), PDO::PARAM_STR);
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus&edit='.$_POST['menu']);
    exit;
   }

  if(isset($_POST['edit_item']))
   {
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['menu_table']." SET name=:name, title=:title, link=:link, section=:section, accesskey=:accesskey WHERE id=:id");
    $dbr->bindValue(':name', trim($_POST['name']), PDO::PARAM_STR);
    $dbr->bindValue(':title', trim($_POST['title']), PDO::PARAM_STR);
    $dbr->bindValue(':link', trim($_POST['link']), PDO::PARAM_STR);
    $dbr->bindValue(':section', trim($_POST['section']), PDO::PARAM_STR);
    $dbr->bindValue(':accesskey', trim($_POST['accesskey']), PDO::PARAM_STR);
    $dbr->bindParam(':id', $_POST['edit_item'], PDO::PARAM_INT);
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus&edit='.$_POST['menu']);
    exit;
   }

  if(isset($_GET['action'])) $action = $_GET['action'];
  if(isset($_POST['action'])) $action = $_POST['action'];

  if(empty($action)) $action='show_menus';

  if(isset($_GET['move_up']))
   {
    $dbr = Database::$content->prepare("SELECT menu, sequence FROM ".Database::$db_settings['menu_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['move_up'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['sequence']) && $data['sequence'] > 1)
     {
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['menu_table']." SET sequence=:new_sequence WHERE menu=:menu AND sequence=:sequence");
      $dbr->bindParam(':menu', $data['menu'], PDO::PARAM_STR);
      $dbr->bindValue(':new_sequence', 0, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence']-1, PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence']-1, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->bindValue(':sequence', 0, PDO::PARAM_INT);
      $dbr->execute();
      Database::$content->commit();
      }
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus&edit='.$data['menu']);
    exit;
   }

  if(isset($_GET['move_down']))
   {
    $dbr = Database::$content->prepare("SELECT menu, sequence FROM ".Database::$db_settings['menu_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['move_down'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['sequence']))
     {
      $dbr = Database::$content->prepare("SELECT sequence FROM ".Database::$db_settings['menu_table']." WHERE menu=:menu ORDER BY sequence DESC LIMIT 1");
      $dbr->bindParam(':menu', $data['menu'], PDO::PARAM_STR);
      $dbr->execute();
      $last = $dbr->fetchColumn();
      if($data['sequence'] < $last)
       {
        Database::$content->beginTransaction();
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['menu_table']." SET sequence=:new_sequence WHERE menu=:menu AND sequence=:sequence");
        $dbr->bindParam(':menu', $data['menu'], PDO::PARAM_STR);
        $dbr->bindValue(':new_sequence', 0, PDO::PARAM_INT);
        $dbr->bindValue(':sequence', $data['sequence']+1, PDO::PARAM_INT);
        $dbr->execute();
        $dbr->bindValue(':new_sequence', $data['sequence']+1, PDO::PARAM_INT);
        $dbr->bindValue(':sequence', $data['sequence'], PDO::PARAM_INT);
        $dbr->execute();
        $dbr->bindValue(':new_sequence', $data['sequence'], PDO::PARAM_INT);
        $dbr->bindValue(':sequence', 0, PDO::PARAM_INT);
        $dbr->execute();
        Database::$content->commit();
       }
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus&edit='.$data['menu']);
      exit;
     }
   }

  if(isset($_REQUEST['reorder_items']) && isset($_REQUEST['item']))
   {
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['menu_table']." SET sequence=:sequence WHERE id=:id");
    $dbr->bindParam(':id', $id, PDO::PARAM_INT);
    $dbr->bindParam(':sequence', $sequence, PDO::PARAM_INT);
    Database::$content->beginTransaction();
    $sequence = 1;
    foreach($_REQUEST['item'] as $id)
     {
      $dbr->execute();
      ++$sequence;
     }
    Database::$content->commit();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    exit;
   }

  // first actions:
  switch ($action)
   {
    case 'delete_menu_item':
     {
      // get menu:
      $dbr = Database::$content->prepare("SELECT menu FROM ".Database::$db_settings['menu_table']." WHERE id=:id LIMIT 1");
      $dbr->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
      $dbr->execute();
      $menu = $dbr->fetchColumn();
      // delete menu item:
      $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['menu_table']." WHERE id=:id");
      $dbr->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
      $dbr->execute();
      // reorder items:
      $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['menu_table']." WHERE menu=:menu ORDER BY sequence ASC");
      $dbr->bindParam(':menu', $menu, PDO::PARAM_STR);
      $dbr->execute();
      while($data = $dbr->fetch())
       {
        $ids[] = $data['id'];
       }
      if(isset($ids))
       {
        $new_sequence = 1;
        Database::$content->beginTransaction();
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['menu_table']." SET sequence=:sequence WHERE id=:id");
        $dbr->bindParam(':sequence', $new_sequence, PDO::PARAM_INT);
        $dbr->bindParam(':id', $id, PDO::PARAM_INT);
        foreach($ids as $id)
         {
          $dbr->execute();
          ++$new_sequence;
         }
        Database::$content->commit();
       }
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=menus&edit='.$menu);
      exit;
     }
    break;
   }

  // second actions:
  switch ($action)
   {
    case 'show_menus':
     $menu_result = Database::$content->query("SELECT DISTINCT menu FROM ".Database::$db_settings['menu_table']." ORDER BY menu ASC");
     while($menu_data = $menu_result->fetch())
      {
       $menus[] = $menu_data['menu'];
      }
     if(isset($menus))
      {
       $template->assign('menus', $menus);
      }
     $template->assign('subtitle', Localization::$lang['menus']);
     $template->assign('subtemplate', 'menus.inc.tpl');
     break;
    case 'edit':
     $template->assign('menu', htmlspecialchars($_GET['edit']));
     $dbr = Database::$content->prepare("SELECT id, name, sequence, title, link, section, accesskey FROM ".Database::$db_settings['menu_table']." WHERE menu=:menu ORDER BY sequence ASC");
     $dbr->bindValue(':menu', trim($_GET['edit']), PDO::PARAM_STR);
     $dbr->execute();
     $i=0;
     while($data = $dbr->fetch())
      {
       $items[$i]['id'] = intval($data['id']);
       $items[$i]['name'] = htmlspecialchars($data['name']);
       #$items[$i]['sequence'] = $data['sequence'];
       $items[$i]['title'] = htmlspecialchars($data['title']);
       $items[$i]['link'] = htmlspecialchars($data['link']);
       $items[$i]['section'] = htmlspecialchars($data['section']);
       $items[$i]['accesskey'] = htmlspecialchars($data['accesskey']);
       ++$i;
      }
     if(isset($items))
      {
       $template->assign('items', $items);
      }
     $template->assign('subtitle', Localization::$lang['menus']);
     $template->assign('subtemplate', 'menus_edit.inc.tpl');
     break;
    case 'edit_menu_item';
     $dbr = Database::$content->prepare("SELECT menu FROM ".Database::$db_settings['menu_table']." WHERE id=:id LIMIT 1");
     $dbr->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
     $dbr->execute();
     $menu_data = $dbr->fetch();
     if(isset($menu_data['menu']))
      {
       $dbr = Database::$content->prepare("SELECT id, name, sequence, title, link, section, accesskey FROM ".Database::$db_settings['menu_table']." WHERE menu=:menu ORDER BY sequence ASC");
       $dbr->bindParam(':menu', $menu_data['menu'], PDO::PARAM_STR);
       $dbr->execute();
       $i=0;
       while($data = $dbr->fetch())
        {
         $items[$i]['id'] = intval($data['id']);
         $items[$i]['name'] = htmlspecialchars($data['name']);
         $items[$i]['title'] = htmlspecialchars($data['title']);
         $items[$i]['link'] = htmlspecialchars($data['link']);
         $items[$i]['section'] = htmlspecialchars($data['section']);
         $items[$i]['accesskey'] = htmlspecialchars($data['accesskey']);
         ++$i;
        }
       if(isset($items))
        {
         $template->assign('items', $items);
        }
       $template->assign('menu', htmlspecialchars($menu_data['menu']));
       $template->assign('edit_item', intval($_GET['id']));
       $template->assign('subtitle', Localization::$lang['menus']);
       $template->assign('subtemplate', 'menus_edit.inc.tpl');
      }
     break;
    case 'delete':
     $template->assign('subtemplate', 'menus_delete.inc.tpl');
     break;
    case 'new':
     if(isset($errors))
      {
       $template->assign('errors', $errors);
      }
     if(isset($_POST['new_menu_name']))
      {
       $template->assign('new_menu_name', htmlspecialchars($_POST['new_menu_name']));
      }
     $template->assign('subtemplate', 'menus_new.inc.tpl');
     break;
   }
 }
