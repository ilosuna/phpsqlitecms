<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix'].'user_type']==1)
 {
  if(isset($_POST['spam_protection_submit']))
   {
    // banists:
    if(isset($_POST['banned_ips']) && trim($_POST['banned_ips']) != '')
     {
      $banned_ips_array = preg_split('/\015\012|\015|\012/',$_POST['banned_ips']);
      foreach($banned_ips_array as $banned_ip)
       {
        if(trim($banned_ip)!='') $banned_ips_array_checked[] = trim($banned_ip);
       }
      natcasesort($banned_ips_array_checked);
      $banned_ips = implode("\n", $banned_ips_array_checked);
      if(is_ip_banned($_SERVER['REMOTE_ADDR'], $banned_ips_array_checked)) $errors[] = 'error_own_ip_banned';
     }
    else $banned_ips = '';

    if(isset($_POST['banned_user_agents']) && trim($_POST['banned_user_agents']) != '')
     {
      $banned_user_agents_array = preg_split('/\015\012|\015|\012/',$_POST['banned_user_agents']);
      foreach($banned_user_agents_array as $banned_user_agent)
       {
        if(trim($banned_user_agent)!='') $banned_user_agents_array_checked[] = trim($banned_user_agent);
       }
      natcasesort($banned_user_agents_array_checked);
      $banned_user_agents = implode("\n", $banned_user_agents_array_checked);
      if(is_user_agent_banned($_SERVER['HTTP_USER_AGENT'], $banned_user_agents_array_checked)) $errors[] = 'error_own_user_agent_banned';
     }
    else $banned_user_agents = '';

    if(isset($_POST['not_accepted_words']) && trim($_POST['not_accepted_words']) != '')
     {
      $not_accepted_words_array = preg_split('/\015\012|\015|\012/',$_POST['not_accepted_words']);
      foreach($not_accepted_words_array as $not_accepted_word)
       {
        if(trim($not_accepted_word)!='') $not_accepted_words_array_checked[] = trim($not_accepted_word);
       }
      natcasesort($not_accepted_words_array_checked);
      $not_accepted_words = implode("\n", $not_accepted_words_array_checked);
     }
    else $not_accepted_words = '';

    $akismet_key = !empty($_POST['akismet_key']) ? $_POST['akismet_key'] : '';
    $akismet_entry_check = isset($_POST['akismet_entry_check']) ? 1 : 0;
    $akismet_mail_check = isset($_POST['akismet_mail_check']) ? 1 : 0;

    if(trim($banned_ips=='') && trim($banned_user_agents=='')) $check_access_permission = 0;
    else $check_access_permission = 1;

    if(empty($errors))
     {
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['banlists_table']." SET list=:list WHERE name=:name");
      $dbr->bindValue(':name', 'ips', PDO::PARAM_STR);
      $dbr->bindParam(':list', $banned_ips, PDO::PARAM_STR);
      $dbr->execute();
      $dbr->bindValue(':name', 'user_agents', PDO::PARAM_STR);
      $dbr->bindParam(':list', $banned_user_agents, PDO::PARAM_STR);
      $dbr->execute();
      $dbr->bindValue(':name', 'words', PDO::PARAM_STR);
      $dbr->bindParam(':list', $not_accepted_words, PDO::PARAM_STR);
      $dbr->execute();
      Database::$content->commit();

      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['settings_table']." SET value=:value WHERE name=:name");
      $dbr->bindValue(':name', 'akismet_key', PDO::PARAM_STR);
      $dbr->bindParam(':value', $akismet_key, PDO::PARAM_STR);
      $dbr->execute();
      $dbr->bindValue(':name', 'akismet_entry_check', PDO::PARAM_STR);
      $dbr->bindParam(':value', $akismet_entry_check, PDO::PARAM_STR);
      $dbr->execute();
      $dbr->bindValue(':name', 'akismet_mail_check', PDO::PARAM_STR);
      $dbr->bindParam(':value', $akismet_mail_check, PDO::PARAM_STR);
      $dbr->execute();
      $dbr->bindValue(':name', 'check_access_permission', PDO::PARAM_STR);
      $dbr->bindParam(':value', $check_access_permission, PDO::PARAM_STR);
      $dbr->execute();
      Database::$content->commit();

      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=spam_protection&saved=true');
      exit;
     }

    if(isset($errors))
     {
      $template->assign('errors',$errors);
      if(isset($_POST['banned_ips'])) $template->assign('banned_ips',htmlspecialchars(stripslashes($_POST['banned_ips'])));
      if(isset($_POST['banned_user_agents'])) $template->assign('banned_user_agents',htmlspecialchars(stripslashes($_POST['banned_user_agents'])));
      if(isset($_POST['not_accepted_words'])) $template->assign('not_accepted_words',htmlspecialchars(stripslashes($_POST['not_accepted_words'])));
      if(isset($_POST['akismet_key'])) $template->assign('akismet_key',htmlspecialchars(stripslashes($_POST['akismet_key'])));
      if(isset($_POST['akismet_entry_check'])) $template->assign('akismet_entry_check',intval($_POST['akismet_entry_check']));
      if(isset($_POST['akismet_mail_check'])) $template->assign('akismet_mail_check',intval($_POST['akismet_mail_check']));

     }

   }
  else
   {
    $dbr = Database::$content->query("SELECT name, list FROM ".Database::$db_settings['banlists_table']);
    while($data = $dbr->fetch())
     {
      switch($data['name'])
       {
        case 'ips':
         $template->assign('banned_ips',htmlspecialchars(stripslashes($data['list'])));
         break;
        case 'user_agents':
         $template->assign('banned_user_agents',htmlspecialchars(stripslashes($data['list'])));
         break;
        case 'words':
         $template->assign('not_accepted_words',htmlspecialchars(stripslashes($data['list'])));
         break;
       }
     }
    $template->assign('akismet_key',htmlspecialchars(stripslashes($settings['akismet_key'])));
    $template->assign('akismet_entry_check',intval($settings['akismet_entry_check']));
    $template->assign('akismet_mail_check',intval($settings['akismet_mail_check']));
   }
  if(isset($_GET['saved']))
   {
    $template->assign('saved',true);
   }
  $template->assign('subtitle',Localization::$lang['spam_protection']);
  $template->assign('subtemplate','spam_protection.inc.tpl');
 }
