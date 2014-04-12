<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(isset($_POST['new_user_submitted']) && $_SESSION[$settings['session_prefix'].'user_type']==1)
   {
    if(trim($_POST['name'])=='' || trim($_POST['pw'])=='' || trim($_POST['pw_r'])=='')
     {
      $errors[] = 'error_form_uncomplete';
     }
    if(empty($errors))
     {
      if(mb_strpos($_POST['name'],',',0,CHARSET)!==false)
       {
        $errors[] = 'error_username_special_chars';
       }
      if($_POST['pw']!==$_POST['pw_r'])
       {
        $errors[] = 'error_pw_doesnt_comply';
       }
     }
    if(empty($errors))
     {
      $dbr = Database::$userdata->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['userdata_table']." WHERE lower(name)=:name");
      $dbr->bindValue(':name', mb_strtolower(trim($_POST['name']),CHARSET), PDO::PARAM_STR);
      $dbr->execute();
      if($dbr->fetchColumn()!=0)
       {
        $errors[] = 'error_username_alr_exists';
       }
     }
    if(empty($errors))
     {
      $pw_hash = generate_pw_hash($_POST['pw']);
      $dbr = Database::$userdata->prepare("INSERT INTO ".Database::$db_settings['userdata_table']." (name, type, wysiwyg, pw, last_login) VALUES (:name, 0, :wysiwyg, :pw, 0)");
      $dbr->bindValue(':name', trim($_POST['name']), PDO::PARAM_STR);
      $dbr->bindParam(':wysiwyg', $settings['wysiwyg_editor'], PDO::PARAM_INT);
      $dbr->bindParam(':pw', $pw_hash, PDO::PARAM_STR);
      $dbr->execute();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=users');
      exit;
     }
    if(isset($errors))
     {
      $template->assign('errors',$errors);
     }
    $action='new';
   }

  if(isset($_REQUEST['delete']))
   {
    if($_SESSION[$settings['session_prefix'].'user_id']==intval($_REQUEST['delete']))
     {
      $errors[] = 'del_yourself_imposs';
      $template->assign('errors',$errors);
      $action = 'main';
     }
    if(empty($errors))
     {
      if(isset($_REQUEST['confirmed']))
       {
        $dbr = Database::$userdata->prepare("DELETE FROM ".Database::$db_settings['userdata_table']." WHERE id=:id");
        $dbr->bindParam(':id', $_REQUEST['delete'], PDO::PARAM_INT);
        $dbr->execute();
        header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=users');
        exit;
       }
      else
       {
        $dbr = Database::$userdata->prepare("SELECT id, name FROM ".Database::$db_settings['userdata_table']." WHERE id=:id LIMIT 1");
        $dbr->bindParam(':id', $_REQUEST['delete'], PDO::PARAM_INT);
        $dbr->execute();
        $data = $dbr->fetch();
        if(isset($data['id']))
         {
          $userdata['id'] = $data['id'];
          $userdata['name'] = htmlspecialchars($data['name']);
          $template->assign('userdata',$userdata);
         }
        $action = 'delete_user';
       }
     }
   }

  if(isset($_GET['edit']))
   {
    if($_SESSION[$settings['session_prefix'].'user_type']==1)
     {
      $dbr = Database::$userdata->prepare("SELECT id, type, name FROM ".Database::$db_settings['userdata_table']." WHERE id=:id LIMIT 1");
      #if($_SESSION[$settings['session_prefix'].'user_type']==0)
      # {
      #  $dbr->bindParam(':id', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
      # }
      #else
      # {
        $dbr->bindParam(':id', $_GET['edit'], PDO::PARAM_INT);
      # }
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['id']))
       {
        $userdata['id'] = $data['id'];
        $userdata['type'] = $data['type'];
        $userdata['name'] = htmlspecialchars($data['name']);
        $template->assign('userdata',$userdata);
       }
     }
    $action = 'edit_user';
   }

  if(isset($_POST['edit_user_submitted']))
   {
    if($_SESSION[$settings['session_prefix'].'user_type']==1)
     {
      $name=trim($_POST['name']);
      $new_pw = $_POST['new_pw'];
      $new_pw_r = $_POST['new_pw_r'];
      $type = intval($_POST['type']);
      if(empty($_POST['id']) || trim($_POST['name'])=='') $errors[] = 'error_form_uncomplete';
      if(empty($errors))
       {
        $dbr = Database::$userdata->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['userdata_table']." WHERE LOWER(name)=LOWER(:name) AND id!=:id LIMIT 1");
        $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $dbr->bindParam(':name', $name, PDO::PARAM_STR);
        $dbr->execute();
        list($name_count) = $dbr->fetch();
        if($name_count) $errors[] = 'error_username_alr_exists';
       }
      if(empty($errors))
       {
        if(!empty($_POST['new_pw']) && $_POST['new_pw'] != $_POST['new_pw_r'])
         {
          $errors[] = 'error_pw_doesnt_comply';
         }
        if(intval($_POST['type'])!=0 && intval($_POST['type'])!=1)
         {
          $errors[] = 'invalid_user_type';
         }
        if($_SESSION[$settings['session_prefix'].'user_id']==intval($_POST['id']) && intval($_POST['type'])==0)
         {
          $errors[] = 'rights_limitation_imposs';
         }
       }
      if(empty($errors))
       {
        if($_POST['new_pw']!='')
         {
          $pw_hash = generate_pw_hash($_POST['new_pw']);
          $dbr = Database::$userdata->prepare("UPDATE ".Database::$db_settings['userdata_table']." SET name=:name, type=:type, pw=:pw WHERE id=:id");
          $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
          $dbr->bindParam(':type', $_POST['type'], PDO::PARAM_INT);
          $dbr->bindValue(':name', trim($_POST['name']), PDO::PARAM_STR);
          $dbr->bindParam(':pw', $pw_hash, PDO::PARAM_STR);
          $dbr->execute();
         }
        else
         {
          $dbr = Database::$userdata->prepare("UPDATE ".Database::$db_settings['userdata_table']." SET name=:name, type=:type WHERE id=:id");
          $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
          $dbr->bindParam(':type', $_POST['type'], PDO::PARAM_INT);
          $dbr->bindValue(':name', trim($_POST['name']), PDO::PARAM_STR);
          $dbr->execute();
         }
       }
      if(empty($errors))
       {
        header('location: '.BASE_URL.ADMIN_DIR.'index.php?mode=users');
        exit;
       }
     }
    elseif($_SESSION[$settings['session_prefix'].'user_type']==0)
     {
      if(empty($_POST['old_pw']) || empty($_POST['new_pw']) || empty($_POST['new_pw_r']))
       {
        $errors[] = 'error_form_uncomplete';
       }
      if(empty($errors))
       {
        $dbr = Database::$userdata->prepare("SELECT pw FROM ".Database::$db_settings['userdata_table']." WHERE id=:id LIMIT 1");
        $dbr->bindParam(':id', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
        $dbr->execute();
        $data = $dbr->fetch();
        if(!is_pw_correct($_POST['old_pw'], $data['pw']))
         {
          $errors[] = 'error_pw_wrong';
         }
        if($_POST['new_pw']!==$_POST['new_pw_r'])
         {
          $errors[] = 'error_pw_doesnt_comply';
         }
       }
      if(empty($errors))
       {
        $pw_hash = generate_pw_hash($_POST['new_pw']);
        $dbr = Database::$userdata->prepare("UPDATE ".Database::$db_settings['userdata_table']." SET pw=:pw WHERE id=:id");
        $dbr->bindParam(':pw', $pw_hash, PDO::PARAM_STR);
        $dbr->bindParam(':id', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
        $dbr->execute();
       }
      if(empty($errors))
       {
        header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=users&edit='.$_SESSION[$settings['session_prefix'].'user_id'].'&saved=true');
        exit;
       }
     }
    if(isset($errors))
     {
      $template->assign('errors',$errors);
      if(isset($_POST['id'])) $userdata['id'] = intval($_POST['id']);
      if(isset($_POST['type'])) $userdata['type'] = intval($_POST['type']);
      if(isset($_POST['name'])) $userdata['name'] = htmlspecialchars($_POST['name']);
      if(isset($userdata)) $template->assign('userdata', $userdata);
      $action='edit_user';
     }
   }

  if(isset($_GET['action'])) $action = $_GET['action'];
  if(isset($_POST['action'])) $action = $_POST['action'];
  if(empty($action)) $action = 'main';

  if($_SESSION[$settings['session_prefix'].'user_type']==0 && $action == 'main')
   {
    header('location: '.BASE_URL.ADMIN_DIR.'index.php?mode=users&edit='.$_SESSION[$settings['session_prefix'].'user_id']);
    exit;
   }

  #if($action!='main' && $_SESSION[$settings['session_prefix'].'user_type']==1) $admin_sub_menu = '<a href="'.basename($_SERVER['PHP_SELF']).'?mode=user">&laquo; '.$lang['user_overview'].'</a>';

  switch($action)
   {
    case 'main':
     $dbr = Database::$userdata->query("SELECT id, name, type, last_login FROM ".Database::$db_settings['userdata_table']." ORDER BY id ASC");
     $dbr->execute();
     $i=0;
     while($data = $dbr->fetch())
      {
       $users[$i]['id'] = intval($data['id']);
       $users[$i]['name'] = htmlspecialchars($data['name']);
       $users[$i]['type'] = intval($data['type']);
       $users[$i]['last_login'] = intval($data['last_login']);
       ++$i;
      }
     if(isset($users))
      {
       $template->assign('users', $users);
      }
     $template->assign('subtitle', Localization::$lang['users']);
     $template->assign('subtemplate', 'users.inc.tpl');
     break;
    case 'new':
     $template->assign('subtitle', Localization::$lang['create_user_account']);
     $template->assign('subtemplate', 'users_new.inc.tpl');
     break;
    case 'delete_user':
     $template->assign('subtitle', Localization::$lang['delete_user']);
     $template->assign('subtemplate', 'users_delete.inc.tpl');
   break;
   case 'edit_user':
    if(isset($_GET['saved'])) $template->assign('saved', true);
    $template->assign('subtitle', Localization::$lang['edit_userdata']);
    $template->assign('subtemplate', 'users_edit.inc.tpl');
    break;
  }
 }
