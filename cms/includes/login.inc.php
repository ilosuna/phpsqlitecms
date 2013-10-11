<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']) && empty($action))
 {
  session_destroy();
  header("Location: ../");
 }
elseif(empty($_SESSION[$settings['session_prefix'].'user_id']) && isset($_POST['username']) && isset($_POST['userpw']))
 {
  $username = $_POST['username'];
  $userpw = $_POST['userpw'];
  if(isset($_POST['username']) && trim($_POST['username']) != '' && isset($_POST['userpw']) && trim($_POST['userpw']) != '')
   {
    $dbr = Database::$userdata->prepare('SELECT id, name, pw, type, wysiwyg FROM '.Database::$db_settings['userdata_table'].' WHERE lower(name)=lower(:name) LIMIT 1');
    #$dbr->bindValue(':name',mb_strtolower($_POST['username'],CHARSET), PDO::PARAM_STR);
    $dbr->bindValue(':name',$_POST['username'], PDO::PARAM_STR);
    $dbr->execute();
    $row = $dbr->fetch();
    if(isset($row['id']))
     {
      if(is_pw_correct($_POST['userpw'],$row['pw']))
       {
        $_SESSION[$settings['session_prefix'].'user_id'] = $row['id'];
        $_SESSION[$settings['session_prefix'].'user_name'] = $row['name'];
        $_SESSION[$settings['session_prefix'].'user_type'] = $row['type'];
        $_SESSION[$settings['session_prefix'].'wysiwyg'] = $row['wysiwyg'];
        
        $dbr = Database::$userdata->prepare('UPDATE '.Database::$db_settings['userdata_table'].' SET last_login=:now WHERE id=:id');
        $dbr->bindValue(':now', time(), PDO::PARAM_INT);
        $dbr->bindValue(':id', $row['id'], PDO::PARAM_INT);
        $dbr->execute();
        header('Location: ../');
        exit;
       }
      else
       {
        $login_failed = true;
       }
     }
    else
     {
      $login_failed = true;
     }
   }
  else
   {
    $login_failed = true;
   }
  if(isset($login_failed))
   {
    header('Location: index.php?msg=login_failed');
    exit;
   }
 }
elseif(empty($_SESSION[$settings['session_prefix'].'user_id']) && empty($action))
 {
  $action = "login";
 }

switch ($action)
 {
  case 'login':
   $template->assign('subtitle', Localization::$lang['login']);
   $template->assign('subtemplate', 'login.inc.tpl');
  break;
 }
?>
