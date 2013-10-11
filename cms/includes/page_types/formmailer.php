<?php
if(!defined('IN_INDEX')) exit;


$recipients_raw = explode(',',$data['type_addition']);
foreach($recipients_raw as $item)
 {
  $recipients[] = trim($item);
 }

if(isset($_POST['send']))
 {
  // get posted data:
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
  //$subject = isset($_POST['subject']) && trim($_POST['subject'])!='' ? trim($_POST['subject']) : Localization::$lang['formmailer_no_subject'];
  $message = isset($_POST['message']) ? trim($_POST['message']) : '';
  // instantiate $mail object:
  $mail = new Mail();
  // check data:
  if(!$mail->is_valid_email($email))
   {
    $errors[] = 'formmail_error_email_invalid';
   }
  if(empty($message))
   {
    $errors[] = 'formmail_error_no_message';
   }
  if(mb_strlen($message, CHARSET) > $settings['email_text_maxlength'])
   {
    $errors[] = 'formmail_error_text_too_long';
   }
  if(mb_strlen($subject, CHARSET) > $settings['email_subject_maxlength'])
   {
    $errors[] = 'formmail_error_subj_too_long';
   }
  if(empty($errors))
   {
        // Akismet spam check:
        if($settings['akismet_key']!='' && $settings['akismet_mail_check']==1)
         {
          #require('./cms/modules/akismet/akismet.class.php');
          $mail_parts = explode("@", $email);
          $check_mail['author'] = $mail_parts[0];
          $check_mail['email'] = $email;
          $check_mail['body'] = $message;
          $akismet = new Akismet(BASE_URL, $settings['akismet_key'], $check_mail);
          // test for errors
          if($akismet->errorsExist()) // returns true if any errors exist
           {
            if($akismet->isError(AKISMET_INVALID_KEY))
             {
              $errors[] = 'akismet_error_api_key';
             }
            elseif($akismet->isError(AKISMET_RESPONSE_FAILED))
             {
              $errors[] = 'akismet_error_connection';
             }
            elseif($akismet->isError(AKISMET_SERVER_NOT_FOUND))
             {
              $errors[] = 'akismet_error_connection';
             }
           }
          else
           {
            // No errors, check for spam
            if($akismet->isSpam())
             {
              $errors[] = 'akismet_spam_suspicion';
             }
           }
         }
       // End Akismet spam check:
   }
  if(empty($errors))
   {
    $mail->set_charset(CHARSET);
    if(empty($subject)) $subject = Localization::$lang['formmailer_no_subject'];
    foreach($recipients as $recipient)
     {
      if($mail->send($recipient, $email, $subject, $message, $settings['mail_parameter']))
       {
        $template->assign('mail_sent', true);
        $template->assign('hide_content', true);
       }
      else
       {
        $errors[] = 'formmail_error_mailserver';
        break;
       }
     }  
   }
 }

if(isset($errors))
 {
  $template->assign('email', htmlspecialchars($email));
  $template->assign('subject', htmlspecialchars($subject));
  $template->assign('message', htmlspecialchars($message));
  $template->assign('errors', $errors);
 }

$template->assign('subtemplate', 'formmailer.inc.tpl');

if(isset($cache))
 {
  $cache->cacheId = PAGE;
 }
?>
