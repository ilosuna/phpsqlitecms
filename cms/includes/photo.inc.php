<?php
if(!defined('IN_INDEX')) exit;

$content_query = 'SELECT id, page, title, type, type_addition, language, content FROM '.Database::$db_settings['pages_table'].' WHERE lower(page)=:page AND status!=0 LIMIT 1';
$dbr = Database::$content->prepare($content_query);
$dbr->bindValue(':page', PAGE, PDO::PARAM_STR);
$dbr->execute();
$data = $dbr->fetch();
if(empty($data['id']))
 {
  $no_cache = true;
  if($data=get_content($settings['error_page']))
   {
    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
    header("Status: 404 Not Found");
    include(BASE_PATH.'cms/includes/content.inc.php');
   }
  else
   {
    raise_error('404');
   }
 }
else
 {
  $photo = new ShowPhoto($_GET['get_2']);
  $photo_data = $photo->get_photo_data();
  if(isset($photo_data['id']) && $photo_page_check = is_vailid_photo_page($data['content'], $data['type'], $data['type_addition'], $photo_data['gallery'], $photo_data['gallery_items']))
   {
    if(empty($data['language'])) $language_file = $settings['default_page_language'].'.page.lang.php';
    else $language_file = $data['language'].'.page.lang.php';

    #require('./cms/includes/classes/Localization.class.php');
    #$loc = new Localization('./cms/lang/'.$language_file);
    $localization = new Localization(BASE_PATH.'cms/lang/'.$language_file);

    mb_internal_encoding(Localization::$lang['charset']);

    #require('./cms/lang/'.$language_file);
    #$template->set_lang($lang);

    setlocale(LC_ALL, Localization::$lang['locale']);
    define('CHARSET', Localization::$lang['charset']);
    #define('TIME_FORMAT', Localization::$lang['time_format']);
    #define('TIME_FORMAT_FULL', Localization::$lang['time_format_full']);
    $localization->replacePlaceholder('page', $data['title'], 'back_title');

    $template->assign('website_title', $settings['website_title']);
    $template->assign('photo_data', $photo_data);
    $template->assign('page', $data['page']);
    $template->assign('title', $data['title']);

    $template->assign('settings', $settings);
    if(isset($_SESSION[$settings['session_prefix'].'user_id'])) $template->assign('admin', true);

    // photo comments:
    if($settings['photos_commentable'] == 1)
     {
      $show_comments = $photo -> show_comments();
      $template->assign('show_comments', $show_comments);
      include(BASE_PATH.'cms/includes/photo_comment.inc.php');
     }
    #header('Content-Type: text/html; charset='.$lang['charset']);
    #$template->display('./templates/'.$photo_data['template']);

    $content_type = 'text/html';
    $charset = Localization::$lang['charset'];
    $template_file = $photo_data['template'];

    if($photo_page_check==1)
     {
      if(isset($_COOKIE[$settings['session_prefix'].'search']))
       {
        $cookie_parts = explode(' ', $_COOKIE[$settings['session_prefix'].'search']);
        $page_addition = ',,'.htmlspecialchars($cookie_parts[0]);
        if(isset($cookie_parts[1]) && intval($cookie_parts[1])>1)
         {
          $page_addition .= ','.intval($cookie_parts[1]);
         }
        $template->assign('page_addition', $page_addition);
       }
     }
    elseif($photo_page_check==2 && isset($cache))
     {
      $page_addition = ','.IMAGE_IDENTIFIER.','.$photo->photo_data['id'];
      if($photo->photo_data['photo_size'] > 0) $page_addition .= ',1';
      elseif($photo->show_comments > 0) $page_addition .= ',0,1';
      if(isset($photo_comment->comment_page) && $photo_comment->comment_page > 1) $page_addition .= ','.$photo_comment->comment_page;
      $cache->cacheId = PAGE . $page_addition;
     }
   }
  else
   {
    $no_cache = true;
    if($data=get_content($settings['error_page']))
     {
      header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
      header("Status: 404 Not Found");
      include('./cms/includes/content.inc.php');
     }
    else
     {
      raise_error('404');
     }
   }
 }
?>
