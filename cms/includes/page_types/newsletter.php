<?php
if(!defined('IN_INDEX')) exit;

// clean up:
$one_hour_ago = time()-3600;

$dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['newsletter_table']." WHERE time < :one_hour_ago AND confirmed = 0");
$dbr->bindParam(':one_hour_ago', $one_hour_ago, PDO::PARAM_INT);
$dbr->execute();

if(isset($_GET['get_1']) && $_GET['get_1']=='subscribe')
 {
  $no_cache = true;
  if(empty($_GET['get_2']) || empty($_GET['get_3'])) $error = true;
  if(empty($error))
   {
    if(trim($_GET['get_2'])=='' || trim($_GET['get_3'])=='') $error = true;
   }
  if(empty($error))
   {
    $dbr = Database::$entries->prepare("SELECT confirmation_code FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['get_2'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['confirmation_code']) && $_GET['get_3'] == $data['confirmation_code'])
     {
      $dbr = Database::$entries->prepare("UPDATE ".Database::$db_settings['newsletter_table']." SET confirmed=1, confirmation_code='' WHERE id=:id");
      $dbr->bindParam(':id', $_GET['get_2'], PDO::PARAM_INT);
      $dbr->execute();
      $action = 'confirmation_ok';
     }
    else
     {
      $error = true;
     }
   }
  if(isset($error)) $action = 'confirmation_failed';
 }

if(isset($_GET['get_1']) && $_GET['get_1']=='unsubscribe')
 {
  $no_cache = true;
  if(empty($_GET['get_2']) || empty($_GET['get_3'])) $error = true;
  if(empty($error))
   {
    if(trim($_GET['get_2'])=='' || trim($_GET['get_3'])=='') $error = true;
   }
  if(empty($error))
   {
    $dbr = Database::$entries->prepare("SELECT confirmation_code FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['get_2'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['confirmation_code']) && $_GET['get_3'] == $data['confirmation_code'])
     {
      $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id");
      $dbr->bindParam(':id', $_GET['get_2'], PDO::PARAM_INT);
      $dbr->execute();
      $action = 'delete_ok';
     }
    else $error = true;
   }
  if(isset($error)) $action = 'confirmation_failed';
 }

if((isset($_POST['delete_checked']) || isset($_GET['get_1']) && $_GET['get_1']=='delete') && isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(isset($_POST['checked'])) $checked_emails = $_POST['checked'];
  elseif(isset($_GET['get_2'])) $checked_emails[] = $_GET['get_2'];

  if(isset($checked_emails) && is_array($checked_emails))
   {
    $dbr = Database::$entries->prepare("SELECT id, email FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id ORDER BY email ASC LIMIT 1");
    $dbr->bindParam(':id', $checked, PDO::PARAM_INT);
    $i=0;
    #Database::$entries->beginTransaction();
    foreach($checked_emails as $checked)
     {
      $dbr->execute();
      $data = $dbr->fetch();
      $emails2delete[$i]['id'] = $data['id'];
      $emails2delete[$i]['email'] = htmlspecialchars($data['email']);
      ++$i;
     }
    #Database::$entries->commit();
    if(isset($emails2delete))
     {
      $template->assign('emails2delete',$emails2delete);
      $action = 'delete_checked';
     }
   }
 }

if(isset($_POST['delete_confirm']))
 {
  if(isset($_POST['checked']) && is_array($_POST['checked']))
   {
    $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id");
    $dbr->bindParam(':id', $delete_id, PDO::PARAM_INT);
    Database::$entries->beginTransaction();
    foreach($_POST['checked'] as $delete_id)
     {
      $dbr->execute();
     }
    Database::$entries->commit();
   }
  header('Location: '.BASE_URL.PAGE);
  exit;
 }

/*
if(isset($_POST['delete_email']) && isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id");
  $dbr->bindParam(':id', $_POST['email_id'], PDO::PARAM_INT);
  $dbr->execute();
  header('Location: '.BASE_URL.PAGE);
  exit;
 }
*/

if(isset($_POST['add_email']) && isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $mail = new Mail();
  $mail->set_charset(CHARSET);
  if(!$mail->is_valid_email($_POST['add_email']))
  #if(trim($_POST['add_email'])=='' || !preg_match("/^[^@]+@.+\.\D{2,5}$/", $_POST['add_email']))
   {
    $template->assign('email', htmlspecialchars($_POST['add_email']));
    $errors[] = 'newsletter_error_invalid_email';
   }
  if(empty($errors))
   {
    $dbr = Database::$entries->prepare("SELECT email FROM ".Database::$db_settings['newsletter_table']." WHERE lower(email)=:email LIMIT 1");
    $dbr->bindValue(':email', mb_strtolower(trim($_POST['add_email']),CHARSET), PDO::PARAM_STR);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['email']))
     {
      $errors[] = 'newsletter_error_email_exists';
     }
   }
  if(empty($errors))
   {
    $dbr = Database::$entries->prepare("INSERT INTO ".Database::$db_settings['newsletter_table']." (newsletter_id, time, ip, email, confirmed, confirmation_code) VALUES (:newsletter_id, :time, :ip, :email, 1, '')");
    $dbr->bindParam(':newsletter_id', $page_id, PDO::PARAM_INT);
    $dbr->bindValue(':time', time(), PDO::PARAM_INT);
    $dbr->bindParam(':ip', $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
    $dbr->bindParam(':email', $_POST['add_email'], PDO::PARAM_STR);
    $dbr->execute();
    header('Location: '.BASE_URL.PAGE);
    exit;
   }

 }

if(isset($_POST['email']) && trim($_POST['email'])!='' && isset($_POST['subscribe']))
 {
  $mail = new Mail();
  $mail->set_charset(CHARSET);
  $mail->set_sender_name($settings['website_title']);
  if($settings['mail_parameter']) $mail->set_mail_parameter($settings['mail_parameter']);
  if($_POST['subscribe']=='subscribe')
   {
    if(!$mail->is_valid_email($_POST['email']))
    #if(trim($_POST['email'])=='' || !preg_match("/^[^@]+@.+\.\D{2,5}$/", $_POST['email']))
     {
      $template->assign('email', htmlspecialchars($_POST['email']));
      $errors[] = 'newsletter_error_invalid_email';
     }
    if(empty($errors))
     {
      $dbr = Database::$entries->prepare("SELECT email FROM ".Database::$db_settings['newsletter_table']." WHERE lower(email)=:email LIMIT 1");
      $dbr->bindValue(':email', mb_strtolower(trim($_POST['email']),CHARSET), PDO::PARAM_STR);
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['email']))
       {
        $template->assign('email', htmlspecialchars($_POST['email']));
        $errors[] = 'newsletter_error_email_exists';
       }
     }
    if(empty($errors))
     {
      $confirmation_code = md5(uniqid(rand()));
      $dbr = Database::$entries->prepare("INSERT INTO ".Database::$db_settings['newsletter_table']." (newsletter_id, time, ip, email, confirmed, confirmation_code) VALUES (:newsletter_id, :time, :ip, :email, 0, :confirmation_code)");
      $dbr->bindParam(':newsletter_id', $page_id, PDO::PARAM_INT);
      $dbr->bindValue(':time', time(), PDO::PARAM_INT);
      $dbr->bindParam(':ip', $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
      $dbr->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
      $dbr->bindParam(':confirmation_code', $confirmation_code, PDO::PARAM_STR);
      $dbr->execute();
      // get ID:
      $dbr = Database::$entries->prepare("SELECT id FROM ".Database::$db_settings['newsletter_table']." WHERE email=:email LIMIT 1");
      $dbr->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
      $dbr->execute();
      $data = $dbr->fetch();

      $confirm_link = BASE_URL.PAGE.',subscribe,'.$data['id'].','.$confirmation_code;

      $email_text = str_replace("[link]",$confirm_link,Localization::$lang['newsletter_subscribe_text']);

      if($mail->send($_POST['email'], $settings['email'], Localization::$lang['newsletter_subscribe_subj'], $email_text))
       {
        $action = 'confirm_mail_sent';
       }
      else
       {
        $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['newsletter_table']." WHERE id=:id");
        $dbr->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $dbr->execute();
        $errors[] = 'newsletter_error_mail';
       }
     }
    if(isset($errors)) $action = 'main';
   }
  elseif($_POST['subscribe']=='unsubscribe')
   {
    $dbr = Database::$entries->prepare("SELECT id, email FROM ".Database::$db_settings['newsletter_table']." WHERE lower(email)=:email");
    $dbr->bindValue(':email', mb_strtolower(trim($_POST['email']),CHARSET), PDO::PARAM_STR);
    $dbr->execute();
    $data = $dbr->fetch();
    if(empty($data['email']))
     {
      $errors[] = 'newsletter_error_email_not_exist';
     }
    if(empty($errors))
     {
      $confirmation_code = md5(uniqid(rand()));
      $dbr = Database::$entries->prepare("UPDATE ".Database::$db_settings['newsletter_table']." SET confirmation_code=:confirmation_code WHERE id=:id");
      $dbr->bindParam(':id', $data['id'], PDO::PARAM_INT);
      $dbr->bindParam(':confirmation_code', $confirmation_code, PDO::PARAM_STR);
      $dbr->execute();

      $confirm_link = BASE_URL.PAGE.',unsubscribe,'.$data['id'].','.$confirmation_code;

      $email_text = str_replace("[link]",$confirm_link,Localization::$lang['newsletter_unsubscribe_text']);

      if($mail->send($_POST['email'], $settings['email'], Localization::$lang['newsletter_unsubscribe_subj'], $email_text))
       {
        $action = 'confirm_mail_sent';
       }
      else
       {
        $errors[] = 'newsletter_error_mail';
       }
     }
    if(isset($errors)) $action = 'main';
   }

 }

if(isset($_SESSION[$settings['session_prefix'].'user_id'])) $action = 'admin';
if(empty($action)) $action = 'main';

switch($action)
 {
  case 'main':
   $form['email'] = '';
   #$template->assign('newsletterform', true);
   $template->assign('form', $form);
  break;
  case 'confirm_mail_sent':
   $template->assign('confirm_mail_sent', true);
  break;
  case 'confirmation_ok':
   $template->assign('confirmation_ok', true);
  break;
  case 'delete_ok':
   $template->assign('delete_ok', true);
  break;
  case 'confirmation_failed':
   $template->assign('confirmation_failed', true);
  break;
  case 'admin':

   $order = 'email ASC';
   $order_qs = 'email-asc';
   if(isset($_GET['get_1']))
    {
     switch($_GET['get_1'])
      {
       case 'email-asc':
        $order = 'email ASC';
        $order_qs = 'email-asc';
       break;
       case 'email-desc':
        $order = 'email DESC';
        $order_qs = 'email-desc';
       break;
       case 'time-asc':
        $order = 'time ASC';
        $order_qs = 'time-asc';
       break;
       case 'time-desc':
        $order = 'time DESC';
        $order_qs = 'time-desc';
       break;
       #default:
       # $order = 'email ASC';
      }
    }

   $dbr = Database::$entries->prepare("SELECT id, time, email FROM ".Database::$db_settings['newsletter_table']." WHERE newsletter_id=:page_id AND confirmed=1 ORDER BY ".$order);
   $dbr->bindParam(':page_id', $page_id, PDO::PARAM_INT);
   $dbr->execute();
   $i=0;
   while($data = $dbr->fetch())
    {
     $email_list[] = htmlspecialchars($data['email']);
     $newsletter_data[$i]['id'] = $data['id'];
     $newsletter_data[$i]['email'] = htmlspecialchars($data['email']);
     $newsletter_data[$i]['domain'] = htmlspecialchars(mb_substr(mb_strstr($data['email'], '@'),1));
     $localization->bindId('newsletter_subscribe_time_format', $data['id']);
     $localization->replacePlaceholderBound('time', $data['time'], 'newsletter_subscribe_time_format', $data['id'], Localization::FORMAT_TIME);
     ++$i;
    }
   if(isset($newsletter_data))
    {
     sort($email_list);
     $template->assign('order', $order_qs);
     $template->assign('email_count', $i);
     $template->assign('email_list', implode(', ',$email_list));
     $template->assign('newsletter_data', $newsletter_data);
    }
   $template->assign('admin', true);
  break;
 }
if(isset($errors)) $template->assign('errors', $errors);
$template->assign('subtemplate', 'newsletter.inc.tpl');

if(isset($cache) && empty($no_cache))
 {
  $cache->cacheId = PAGE;
 }
?>
