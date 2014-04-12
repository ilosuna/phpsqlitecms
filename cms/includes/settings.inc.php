<?php
if(!defined('IN_INDEX') || empty($_SESSION[$settings['session_prefix'].'user_id'])) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==1)
 {
  if(isset($_POST['settings_submitted']))
   {
    if(empty($_POST['caching'])) $_POST['caching'] = 0;
    if(empty($_POST['wysiwyg_editor'])) $_POST['wysiwyg_editor'] = 0;
    Database::$content->beginTransaction();
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['settings_table']." SET value=:value WHERE name=:name");
    $dbr->bindParam(':value', $val, PDO::PARAM_STR);
    $dbr->bindParam(':name', $key, PDO::PARAM_STR);
    while(list($key, $val) = each($_POST))
     {
      if($key!='settings_submitted' && $key!='clear_cache')
       {
        $dbr->execute();
       }
     }
    Database::$content->commit();
    if(isset($cache) && ($cache->autoClear || isset($_POST['clear_cache'])))
     {
      $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=settings&saved=true&cache_cleared=true');
     }
    else  
     {
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=settings&saved=true');
     }
    #header('Location: '.BASE_URL.ADMIN_DIR.'index.php?msg=settings_saved');
    exit;
   }

  if(isset($_GET['delete']))
   {
    $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['settings_table']." WHERE name=:name");
    $dbr->bindParam(':name', $_GET['delete'], PDO::PARAM_STR);
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=settings&action=advanced_settings');
    exit;
   }

  if(isset($_POST['new_var_submitted']))
   {
    if(!preg_match('/^[a-zA-Z0-9_\-]+$/', $_POST['name']))
     {
      $errors[] = 'error_settings_spec_chars';
      $action = 'advanced_settings';
     }
    if(empty($errors))
     {
      $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['settings_table']." (name,value) VALUES (:name, :value)");
      $dbr->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
      $dbr->bindParam(':value', $_POST['value'], PDO::PARAM_STR);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=settings&action=advanced_settings');
      exit;
     }
    else
     {
      $template->assign('errors', $errors);
     }
   }

  if(isset($_GET['action'])) $action = $_GET['action'];
  if(empty($action)) $action = 'main_settings';

  if(isset($_GET['saved'])) $template->assign('saved', true);
  if(isset($_GET['cache_cleared'])) $template->assign('cache_cleared', true);
   

  switch($action)
   {
    case 'main_settings':
     // get available pages:
     $dbr = Database::$content->query("SELECT id, page FROM ".Database::$db_settings['pages_table']." ORDER BY page ASC");
     $i=0;
     while($pages_data = $dbr->fetch())
      {
       $pages[$i]['id'] = $pages_data['id'];
       $pages[$i]['page'] = $pages_data['page'];
       ++$i;
      }
     if(isset($pages))
      {
       $template->assign('pages',$pages);
      }

     $template->assign('page_languages', get_languages());
     $template->assign('admin_languages', get_languages(true));

     $template->assign('subtitle', Localization::$lang['settings']);
     $template->assign('subtemplate', 'settings.inc.tpl');

     // WYSIWYG editor available?
     #if(file_exists(BASE_PATH.WYSIWYG_EDITOR))
     # {
     #  $template->assign('wysiwyg_editor_available', true);
     # }

    break;
    case 'advanced_settings';
     $settings_sorted = array_map('htmlspecialchars', $settings);
     ksort($settings_sorted);
     $template->assign('settings_sorted', $settings_sorted);
     $template->assign('subtitle', Localization::$lang['advanced_settings']);
     $template->assign('subtemplate', 'settings_advanced.inc.tpl');
    break;
   }
 }
?>
