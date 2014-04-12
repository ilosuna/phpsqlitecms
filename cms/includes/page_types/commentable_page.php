<?php
if(!defined('IN_INDEX')) exit;

if($settings['pingbacks_enabled']) $template->assign('pingback', BASE_URL.PAGE.',pingback');

$comment = new Comment(PAGE, $data['id']);

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
$comment->settings = $settings;

if(!empty($data['type_addition']))
 {
  $comment->comments_closed = true;
  $template->assign('comments_closed', true);
 }

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $comment->set_admin_mode();
 }

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

if(isset($_GET['get_1']) && $_GET['get_1']=='commentrss')
 {
  $comment->comments_per_page = $settings['rss_maximum_items'];
  $comments = $comment->get_comments(true);
  
  if($comments)
   {
    $i=0;
    foreach($comments as $comment)
     {
      $rss_items[$i]['title'] = $comment['name'];
      $rss_items[$i]['content'] = $comment['comment'];
      $rss_items[$i]['link'] = BASE_URL.PAGE.'#comment-'.$comment['id'];
      $rss_items[$i]['pubdate'] = gmdate('r',$comment['time']);
      $i++;
     } 
   }
  if(isset($rss_items)) $template->assign('rss_items', $rss_items);  
  
  $content_type = 'text/xml';
  $template_file = 'rss.tpl';
  $template_done = true;
 }
elseif(isset($_GET['get_1']) && $_GET['get_1']=='pingback' && $settings['pingbacks_enabled'] && empty($data['type_addition']))
 {
  // disable caching:
  if($settings['caching']) $cache->doCaching = false;
  $pingback = new Pingback();
  $pingback->pingback_title_maxlength = $settings['pingback_title_maxlength'];
  $pingback->settings = $settings;
  if($pingback->get_pingback($data['id']))
   {
    if(isset($cache))
     {
      $cache->clear(PAGE);
      $cache->clearRelated(PAGE);
     }
    exit;
   }
  else
   {
    exit;
   }
 }
elseif(isset($_POST['preview']))
 {
  if($preview = $comment->preview())
   {
    $template->assign('preview', $preview);
   }
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
    if(isset($cache))
     {
      $cache->clear(PAGE);
      $cache->clearRelated(PAGE);
     }
    if(!$settings['comment_order'] && $comment->total_pages>1) $comment_page_addition = ','.$comment->total_pages;
    else $comment_page_addition = '';
    header('Location: '.BASE_URL.PAGE.$comment_page_addition.'#comments');
    exit;
   }
 }
elseif(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_GET['get_2']) && $_GET['get_2']=='edit' && isset($_GET['get_3']))
 {
  $template->assign('edit_data', $comment->get_edit_data($_GET['get_3']));
  $action = 'edit';
 }
elseif(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_GET['get_1']) && $_GET['get_1']=='openclose')
 {
  if($data['type_addition']=='') $close = true;
  else $close = false;
  $comment->openclose($close);
  if(isset($cache))
   {
    $cache->clear(PAGE);
   }  
  header('Location: '.BASE_URL.PAGE.'#comments');
  exit;
 }
elseif(isset($_POST['edit_save']))
 {
  $comment->edit_save();
  if(isset($cache))
   {
    $cache->clear(PAGE);
   }
  header('Location: '.BASE_URL.PAGE.','.$comment->current_page.'#comments');
  exit;
 }
elseif(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_GET['get_2']) && $_GET['get_2']=='delete' && isset($_GET['get_3']))
 {
  $comment->delete($_GET['get_3']);
  if(isset($cache))
   {
    $cache->clear(PAGE);
    $cache->clearRelated(PAGE);
   }
  header('Location: '.BASE_URL.PAGE.','.$comment->current_page.'#comments');
  exit;
 }

if(empty($template_done))
 {
  $comments = $comment->get_comments();
  $pingbacks = $comment->get_pingbacks();

  $template->assign('comments', $comments);
  $template->assign('total_comments', $comment->total_comments);
  $template->assign('pingbacks', $pingbacks);
  $template->assign('pagination', pagination($comment->total_pages,$comment->current_page));
  $template->assign('current_page', $comment->current_page);
  $template->assign('errors', $comment->errors);
  $template->assign('form_values', $comment->form_values);
  $template->assign('form_session_data', $comment->form_session_data);
  $template->assign('form_session', $comment->form_session);

  $template->assign('subtemplate', 'comments.inc.tpl');
 }

if(isset($cache))
 {
  if(isset($_GET['get_1']) && $_GET['get_1']=='commentrss')
   {
    $cache->cacheId = PAGE . ',commentrss';
   }
  elseif($comment->current_page > 1)
   {
    $cache->cacheId = PAGE . ',' . $comment->current_page;
   }
  else
   {
    $cache->cacheId = PAGE;
   }
 }
?>
