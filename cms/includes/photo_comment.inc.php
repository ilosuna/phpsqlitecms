<?php
$comment = new Comment(PAGE, $photo_data['id'], 1);

// settings:
$comment->comments_per_page = $settings['comments_per_page'];
$comment->comment_order = $settings['comment_order'];
$comment->name_maxlength = $settings['name_maxlength'];
$comment->email_hp_maxlength = $settings['email_hp_maxlength'];
$comment->word_maxlength = $settings['word_maxlength'];
$comment->comment_maxlength = $settings['comment_maxlength'];
$comment->prevent_repeated_posts_minutes = $settings['prevent_repeated_posts_minutes'];
$comment->akismet_key = $settings['akismet_key'];
$comment->akismet_entry_check = $settings['akismet_entry_check'];
$comment->remove_blank_lines = $settings['comment_remove_blank_lines'];
$comment->auto_link = $settings['comment_auto_link'];
$comment->smilies = $settings['comment_smilies'];

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $comment->set_admin_mode();
 }

#$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

if(isset($_POST['preview']))
 {
  if($preview = $comment->preview())
    {
     $template->assign('preview', $preview);
    }
  #$action = 'preview';
 }
elseif(isset($_POST['save']))
 {
  if($comment->form_session==false)
   {
    if($preview = $comment->preview())
     {
      $template->assign('preview', $preview);
     }
   }
  elseif($comment->save())
   {
    if(isset($cache)) $cache->clearPhoto($photo_data['id']);
    header('Location: '.BASE_URL.PAGE.','.IMAGE_IDENTIFIER.','.$photo_data['id'].',0,1#comments');
    exit;
   }
 }
elseif(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_GET['get_3']) && $_GET['get_3']=='edit' && isset($_GET['get_4']))
 {
  $template->assign('edit_data', $comment->get_edit_data($_GET['get_4']));
  #$action = 'edit';
 }
elseif(isset($_POST['edit_save']))
 {
  $comment->edit_save();
  if(isset($cache)) $cache->clearPhoto($photo_data['id']);
  header('Location: '.BASE_URL.PAGE.','.IMAGE_IDENTIFIER.','.$photo_data['id'].',0,1,'.$comment->current_page.'#comments');
 }
elseif(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_GET['get_3']) && $_GET['get_3']=='delete' && isset($_GET['get_4']))
 {
  $comment->delete($_GET['get_4']);
  if(isset($cache)) $cache->clearPhoto($photo_data['id']);
  header('Location: '.BASE_URL.PAGE.','.IMAGE_IDENTIFIER.','.$photo_data['id'].',0,1,'.$comment->current_page.'#comments');
 }

$template->assign('comments', $comment->get_comments());
$template->assign('total_comments', $comment->total_comments);

switch($comment->total_comments)
 {
  case 0:
   $localization->selectVariant('number_of_comments', 0);
   break;
  case 1:
   $localization->selectVariant('number_of_comments', 1);
   break;
  default:
   $localization->selectVariant('number_of_comments', 2);
   $localization->replacePlaceholder('comments', $comment->total_comments, 'number_of_comments');
 }


$template->assign('pagination', pagination($comment->total_pages,$comment->current_page));
$template->assign('current_page', $comment->current_page);
$template->assign('errors', $comment->errors);

#if($comment->errors) showme($comment->errors);

#$template->assign('pagination', $comment->get_pagination());
$template->assign('form_values', $comment->form_values);
$template->assign('form_session_data', $comment->form_session_data);
$template->assign('form_session', $comment->form_session);

?>
