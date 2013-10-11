<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(isset($_GET['add_gcb']))
   {
    $content_auto_html = 1;
    $action = 'edit_gcb';
   }

  if(isset($_POST['edit_gcb_submit']))
   {
    $identifier = isset($_POST['identifier']) ? trim($_POST['identifier']) : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    if(empty($identifier)) $errors[] = 'gcb_error_no_identifier';
    elseif(!preg_match('/^[a-z0-9_]+$/', $identifier)) $errors[] = 'gcb_error_invalid_identifier';

    if(isset($_POST['id']))
     {
      $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['gcb_table']." WHERE lower(identifier)=:identifier AND id!=:id");
      $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
     }
    else
     {
      $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['gcb_table']." WHERE lower(identifier)=:identifier");
     }
    $dbr->bindValue(':identifier', mb_strtolower($identifier, CHARSET), PDO::PARAM_STR);
    $dbr->execute();
    if($dbr->fetchColumn()!=0)
     {
      $errors[] = 'gcb_identifier_exists_error';
     }

    if(empty($errors))
     {
      if(isset($_POST['id']))
       {
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['gcb_table']." SET identifier=:identifier, content=:content WHERE id=:id");
        $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
       }
      else
       {
        $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['gcb_table']." (identifier,content) VALUES (:identifier,:content)");
       }
      $dbr->bindParam(':identifier', $identifier, PDO::PARAM_STR);
      $dbr->bindParam(':content', $content, PDO::PARAM_STR);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=gcb');
      exit;
     }
    else
     {
      if(isset($_POST['id'])) $gcb['id'] = $_POST['id'];
      $gcb['identifier'] = isset($_POST['identifier']) ? htmlspecialchars($_POST['identifier']) : '';
      $gcb['content'] = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
      $template->assign('gcb', $gcb);
      $template->assign('errors', $errors);
      $action = 'edit_gcb';
     }
   }

  if(isset($_GET['edit']))
   {
    $dbr = Database::$content->prepare("SELECT id, identifier, content FROM ".Database::$db_settings['gcb_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['edit'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['id']))
     {
      $gcb['id'] = $data['id'];
      $gcb['identifier'] = htmlspecialchars($data['identifier']);
      $gcb['content'] = htmlspecialchars($data['content']);
      $template->assign('gcb', $gcb);
      $action = 'edit_gcb';
     }
    else
     {
      $action = 'invalid_request';
     }
   }

  if(isset($_REQUEST['delete']))
   {
    if(isset($_REQUEST['confirmed']))
     {
      $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['gcb_table']." WHERE id=:id");
      $dbr->bindParam(':id', $_REQUEST['delete'], PDO::PARAM_INT);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=gcb');
      exit;
     }
    else
     {
      $dbr = Database::$content->prepare("SELECT id, identifier FROM ".Database::$db_settings['gcb_table']." WHERE id=:id LIMIT 1");
      $dbr->bindParam(':id', $_GET['delete'], PDO::PARAM_INT);
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['id']))
       {
        $gcb['id'] = $data['id'];
        $gcb['identifier'] = htmlspecialchars($data['identifier']);
        $template->assign('gcb', $gcb);
        $action = 'delete_gcb';
       }
      else
       {
        $action = 'invalid_request';
       }
     }
   }

  if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
  if(empty($action)) $action='main';

  switch ($action)
   {
    case 'main':
     $dbr = Database::$content->query("SELECT id, identifier, content FROM ".Database::$db_settings['gcb_table']." ORDER BY id ASC");
     $i=0;
     while($data = $dbr->fetch())
      {
       $gcbs[$i]['id'] = $data['id'];
       $gcbs[$i]['identifier'] = htmlspecialchars($data['identifier']);
       $gcbs[$i]['content'] = $data['content'];
       ++$i;
      }
     if(isset($gcbs))
      {
       $template->assign('gcbs', $gcbs);
      }
     $template->assign('subtitle', Localization::$lang['gcb']);
     $template->assign('subtemplate', 'gcb.inc.tpl');
     break;
    case 'edit_gcb':
     if(isset($gcb['id']))
      {
       $template->assign('subtitle', Localization::$lang['edit_gcb']);
      }
     else
      {
       $template->assign('subtitle', Localization::$lang['add_gcb']);
      }
     $template->assign('subtemplate', 'gcb_edit.inc.tpl');
     break;
    case 'delete_gcb':
     $template->assign('subtitle', Localization::$lang['delete_gcb']);
     $template->assign('subtemplate', 'gcb_delete.inc.tpl');
    break;
   }
 }
