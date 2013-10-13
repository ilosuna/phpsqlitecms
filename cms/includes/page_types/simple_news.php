<?php
if($authorized_to_edit && isset($_GET['get_1']) && isset($_GET['get_2']) && $_GET['get_2']=='delete' && isset($_REQUEST['confirmed']))
 {
  $delete_id = $_GET['get_1'];
 }
elseif($authorized_to_edit && isset($_POST['delete']) && isset($_POST['confirmed']))
 {
  $delete_id = $_POST['delete'];
 }
if($authorized_to_edit && isset($delete_id))
 {  
  $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['news_table']." WHERE id=:id");
  $dbr->bindParam(':id', $delete_id, PDO::PARAM_INT);
  $dbr->execute();
  #if(isset($cache)) $cache->clear(PAGE);
  if(isset($cache)) $cache->clear();
  header('Location: '.BASE_URL.PAGE);
  exit;
 }

if($authorized_to_edit && isset($_POST['text']))
 {
  $title = isset($_POST['title']) ? trim($_POST['title']) : '';
  $teaser = isset($_POST['teaser']) ? trim($_POST['teaser']) : '';
  $text = isset($_POST['text']) ? trim($_POST['text']) : '';
  #$text_formatting = isset($_POST['text_formatting']) && $_POST['text_formatting']==1 ? 1 : 0;
  $linkname = isset($_POST['linkname']) ? trim($_POST['linkname']) : '';
  $time = isset($_POST['time']) && trim($_POST['time'])!='' ? trim($_POST['time']) : date("Y-m-d H:i:s");

  if(empty($title))
   {
    $errors[] = 'error_news_no_title';
   }
  if(empty($text))
   {
    $errors[] = 'error_news_no_text';
   }
  if(($time = strtotime($time))===false)
   {
    $errors[] = 'error_news_time_invalid';
   }

  if(empty($errors))
   {
    if(isset($_POST['id']))
     {
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['news_table']." SET time=:time, title=:title, teaser=:teaser, text=:text, linkname=:linkname WHERE id=:id");
      $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
      $dbr->bindParam(':time', $time, PDO::PARAM_INT);
      $dbr->bindParam(':title', $title, PDO::PARAM_STR);
      $dbr->bindParam(':teaser', $teaser, PDO::PARAM_STR);
      $dbr->bindParam(':text', $text, PDO::PARAM_STR);
      #$dbr->bindParam(':text_formatting', $text_formatting, PDO::PARAM_INT);
      $dbr->bindParam(':linkname', $linkname, PDO::PARAM_STR);
      $dbr->execute();
      $id = $_POST['id'];
     }
    else
     {
      $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['news_table']." (page_id,time,title,teaser,text,text_formatting,linkname) VALUES (:page_id,:time,:title,:teaser,:text,:text_formatting,:linkname)");
      $dbr->bindParam(':page_id', $data['id'], PDO::PARAM_INT);
      $dbr->bindParam(':time', $time, PDO::PARAM_INT);
      $dbr->bindParam(':title', $title, PDO::PARAM_STR);
      $dbr->bindParam(':teaser', $teaser, PDO::PARAM_STR);
      $dbr->bindParam(':text', $text, PDO::PARAM_STR);
      #$dbr->bindParam(':text_formatting', $text_formatting, PDO::PARAM_INT);
      $dbr->bindParam(':linkname', $linkname, PDO::PARAM_STR);
      $dbr->execute();
      #$id = $dbr->lastInsertId(); 
      // get last insert ID:
      $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['news_table']." ORDER BY id DESC LIMIT 1");
      $dbr->execute();
      $last_insert_data = $dbr->fetch();
      if(isset($last_insert_data['id'])) $id = $last_insert_data['id'];
     }
    #if(isset($cache)) $cache->clear(PAGE);
    if(isset($cache)) $cache->clear();
    if(isset($id)) header('Location: '.BASE_URL.PAGE.','.$id);
    else header('Location: '.BASE_URL.PAGE);
    exit;
   }
  else
   {
    if(isset($_POST['id']))
     {
      $edit_news['id'] = intval($_POST['id']);
      $breadcrumbs = get_breadcrumbs($data['breadcrumbs']);
      $breadcrumbs[] = array('page'=>PAGE, 'title'=>$data['title']);
      if(!empty($_POST['title'])) $breadcrumbs[] = array('page'=>PAGE.','.$edit_news['id'], 'title'=>htmlspecialchars($_POST['title']));
      else $breadcrumbs[] = array('page'=>PAGE.','.$edit_news['id'], 'title'=>'???');
      $template->assign('breadcrumbs', $breadcrumbs);    
      $template->assign('title', Localization::$lang['simple_news_edit_item']);
      $template->assign('headline', '');
     }
    else
     {
      $breadcrumbs = get_breadcrumbs($data['breadcrumbs']);
      $breadcrumbs[] = array('page'=>PAGE, 'title'=>$data['title']);
      $template->assign('breadcrumbs', $breadcrumbs);    
      $template->assign('title', Localization::$lang['simple_news_add_item']);
      #$template->assign('headline', Localization::$lang['simple_news_add_item']);
      $template->assign('headline', '');
     }
    $edit_news['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $edit_news['teaser'] = isset($_POST['teaser']) ? htmlspecialchars($_POST['teaser']) : '';
    $edit_news['text'] = isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '';
    #$edit_news['text_formatting'] = isset($_POST['text_formatting']) && $_POST['text_formatting']==1 ? 1 : 0;
    $edit_news['link'] = isset($_POST['link']) ? htmlspecialchars($_POST['link']) : '';
    $edit_news['linkname'] = isset($_POST['linkname']) ? htmlspecialchars($_POST['linkname']) : '';
    $edit_news['time'] = isset($_POST['time']) ? htmlspecialchars($_POST['time']) : date("Y-m-d H:i:s");
    $edit_news['note_section'] = isset($_POST['note_section']) ? htmlspecialchars($_POST['note_section']) : '';
    $template->assign('edit_news', $edit_news);
    $template->assign('errors', $errors);
    $template->assign('edit_news', $edit_news);
    if($settings['wysiwyg_editor'] && isset($_SESSION[$settings['session_prefix'].'wysiwyg']) && $_SESSION[$settings['session_prefix'].'wysiwyg']==1) $template->assign('wysiwyg', true);
    $template->assign('hide_content', true);
   }
 }

if($authorized_to_edit && isset($_GET['get_1']) && $_GET['get_1']=='add_item')
 {
  #$edit_news['text_formatting'] = $settings['default_formatting'];
  #$edit_news['text_formatting'] = 1;
  $edit_news['linkname'] = Localization::$lang['simple_news_default_linkname'];
  $edit_news['time'] = date("Y-m-d H:i:s", time());   
  if($settings['wysiwyg_editor'] && isset($_SESSION[$settings['session_prefix'].'wysiwyg']) && $_SESSION[$settings['session_prefix'].'wysiwyg']==1) $template->assign('wysiwyg', true);

  $template->assign('hide_content', true);
  $template->assign('title', Localization::$lang['simple_news_add_item']);

  $breadcrumbs = get_breadcrumbs($data['breadcrumbs']);
  $breadcrumbs[] = array('page'=>PAGE, 'title'=>$data['title']);
  #$breadcrumbs[] = array('page'=>PAGE.','.$edit_news_item_data['id'], 'title'=>htmlspecialchars($edit_news_item_data['title']));
  $template->assign('breadcrumbs', $breadcrumbs);    

  #$template->assign('headline', Localization::$lang['simple_news_add_item']);
  $template->assign('headline', '');
  $template->assign('edit_news', $edit_news);
 }
elseif($authorized_to_edit && isset($_GET['get_1']) && isset($_GET['get_2']) && $_GET['get_2']=='edit')
 {
  $dbr = Database::$content->prepare("SELECT id, time, title, teaser, text, linkname FROM ".Database::$db_settings['news_table']." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $_GET['get_1'], PDO::PARAM_STR);
  $dbr->execute();
  $edit_news_item_data = $dbr->fetch();
  if(isset($edit_news_item_data['id']))
   {
    $edit_news['id'] = $edit_news_item_data['id'];
    $edit_news['title'] = htmlspecialchars($edit_news_item_data['title']);
    $edit_news['teaser'] = htmlspecialchars($edit_news_item_data['teaser']);
    $edit_news['text'] = htmlspecialchars($edit_news_item_data['text']);
    #$edit_news['text_formatting'] = $edit_news_item_data['text_formatting'];
    $edit_news['linkname'] = htmlspecialchars($edit_news_item_data['linkname']);
    $edit_news['time'] = date("Y-m-d H:i:s", $edit_news_item_data['time']);   
    $template->assign('edit_news', $edit_news);
    if($settings['wysiwyg_editor'] && isset($_SESSION[$settings['session_prefix'].'wysiwyg']) && $_SESSION[$settings['session_prefix'].'wysiwyg']==1) $template->assign('wysiwyg', true);

    $template->assign('hide_content', true);
    $template->assign('title', Localization::$lang['simple_news_edit_item']);

    $breadcrumbs = get_breadcrumbs($data['breadcrumbs']);
    $breadcrumbs[] = array('page'=>PAGE, 'title'=>$data['title']);
    $breadcrumbs[] = array('page'=>PAGE.','.$edit_news_item_data['id'], 'title'=>htmlspecialchars($edit_news_item_data['title']));
    $template->assign('breadcrumbs', $breadcrumbs);    

    #$template->assign('headline', Localization::$lang['simple_news_edit_item']);
    $template->assign('headline', '');
   }
  else
   {
    #$no_cache = true;
    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
    header("Status: 404 Not Found");
    header('Location: '.BASE_URL.PAGE);
    exit;
   }
 }
elseif($authorized_to_edit && isset($_GET['get_1']) && isset($_GET['get_2']) && $_GET['get_2']=='delete')
 {
  $dbr = Database::$content->prepare("SELECT id, time, title, teaser, text, linkname FROM ".Database::$db_settings['news_table']." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $_GET['get_1'], PDO::PARAM_STR);
  $dbr->execute();
  $delete_news_item_data = $dbr->fetch();
  if(isset($delete_news_item_data['id']))
   {
    $delete_news['id'] = $delete_news_item_data['id'];
    $delete_news['title'] = htmlspecialchars($delete_news_item_data['title']);

    $breadcrumbs = get_breadcrumbs($data['breadcrumbs']);
    $breadcrumbs[] = array('page'=>PAGE, 'title'=>$data['title']);
    $template->assign('breadcrumbs', $breadcrumbs);    

    $template->assign('title', Localization::$lang['delete_news_title']);
    $template->assign('headline', Localization::$lang['delete_news_title']);
    $template->assign('delete_news', $delete_news);
    $template->assign('hide_content', true);
   }
 }
elseif(isset($_GET['get_1']) && $_GET['get_1']=='rss')
 {
  $rss = true;
  $dbr = Database::$content->prepare("SELECT id, time, title, teaser, text, linkname FROM ".Database::$db_settings['news_table']." WHERE page_id=:page_id AND time<=:now ORDER BY time DESC LIMIT ".$settings['rss_maximum_items']);
  $dbr->bindParam(':page_id', $data['id'], PDO::PARAM_STR);
  $dbr->bindValue(':now', time(), PDO::PARAM_STR);
  $dbr->execute();
  $i=0;
  while($rss_data = $dbr->fetch())
   {
    $rss_items[$i]['title'] = htmlspecialchars($rss_data['title']);
    if($rss_data['teaser'] && $settings['enable_fullfeeds']==0)
     {
      $rss_items[$i]['content'] = $rss_data['teaser'];
     }
    else
     {
      #if($rss_data['text_formatting']==1) $rss_items[$i]['content'] = auto_html($rss_data['text']);
      $rss_items[$i]['content'] = $rss_data['text'];
     }
    $rss_items[$i]['linkname'] = htmlspecialchars($rss_data['linkname']);
    $rss_items[$i]['link'] = BASE_URL.PAGE.','.$rss_data['id'];
    $rss_items[$i]['pubdate'] = gmdate('r',$rss_data['time']);
    $i++;
   }
  if(isset($rss_items)) $template->assign('rss_items', $rss_items);
  $content_type = 'text/xml';
  $template_file = 'rss.tpl';

 }
elseif(isset($_GET['get_1']) && intval($_GET['get_1'])>0) // item opened
 {
  $dbr = Database::$content->prepare("SELECT id, time, title, teaser, text FROM ".Database::$db_settings['news_table']." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $_GET['get_1'], PDO::PARAM_STR);
  $dbr->execute();
  $note_data = $dbr->fetch();
  if(isset($note_data['id']))
   {
    $news_item['id'] = $note_data['id'];
    $news_item['title'] = htmlspecialchars($note_data['title']);
    $news_item['teaser'] = htmlspecialchars($note_data['teaser']);
    #if($note_data['text_formatting']==1) $news_item['text'] = auto_html($note_data['text']);
    $news_item['text'] = $note_data['text'];
    $news_item['time'] = date("Y-m-d H:i:s", $note_data['time']);
    $template->assign('display_time', true);
    $localization->replacePlaceholder('time', $note_data['time'], 'page_time', Localization::FORMAT_TIME);

    $template->assign('hide_content', true);
    $template->assign('title', $note_data['title']);
    $template->assign('headline', $note_data['title']);
    $template->assign('news_item',$news_item);

    $breadcrumbs = get_breadcrumbs($data['breadcrumbs']);
    $breadcrumbs[] = array('page'=>PAGE, 'title'=>$data['title']);
    $template->assign('breadcrumbs', $breadcrumbs);    

    $template->assign('keywords', '');
    $template->assign('description', '');

    $news_item_id = $note_data['id'];
   }
  else
   {
    #$no_cache = true;
    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
    header("Status: 404 Not Found");
    header('Location: '.BASE_URL.PAGE);
    exit;
   }
 }
else // overview
 {
  $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['news_table']." WHERE page_id=:page_id"); // AND time<=:now
  $dbr->bindParam(':page_id', $data['id'], PDO::PARAM_STR);
  //$dbr->bindValue(':now', time(), PDO::PARAM_STR);
  $dbr->execute();
  $total_items = $dbr->fetchColumn();

  $total_pages = ceil($total_items / $settings['simple_news_per_page']);

  if(isset($_GET['get_2'])) $current_page = intval($_GET['get_2']); else $current_page = 1;
  if($current_page<1) $current_page = 1;
  if($current_page>$total_pages) $current_page = $total_pages;

  $dbr = Database::$content->prepare("SELECT id, time, title, teaser, text, linkname FROM ".Database::$db_settings['news_table']." WHERE page_id=:page_id ORDER BY time DESC LIMIT ".(($current_page-1)*$settings['simple_news_per_page']).", ".$settings['simple_news_per_page']); // AND time<=:now
  $dbr->bindParam(':page_id', $data['id'], PDO::PARAM_STR);
  //$dbr->bindValue(':now', time(), PDO::PARAM_STR);
  $dbr->execute();
  $i=0;
  while($news_data = $dbr->fetch())
   {
    $news[$i]['id'] = $news_data['id'];
    $news[$i]['time'] = $news_data['time'];
    $news[$i]['title'] = $news_data['title'];
    $news[$i]['teaser'] = $news_data['teaser'];
    #if($news_data['text_formatting']==1) $news[$i]['text'] = auto_html($news_data['text']);
    $news[$i]['text'] = $news_data['text'];
    $news[$i]['linkname'] = $news_data['linkname'];
    $localization->bindReplacePlaceholder($news_data['id'], 'time', $news_data['time'], 'simple_news_time', Localization::FORMAT_TIME);
    $i++;
   }
  if(isset($news))
   {
    $template->assign('news', $news);
   }

  $localization->replacePlaceholder('current_page', $current_page, 'pagination');
  $localization->replacePlaceholder('total_pages', $total_pages, 'pagination');

  $template->assign('pagination', pagination($total_pages,$current_page));
 }

if(empty($rss)) $template->assign('subtemplate', 'simple_news.inc.tpl');

if(isset($cache))
 {
  if(isset($rss))
   {
    $cache->cacheId = PAGE . ',rss';
   }
  elseif(isset($news_item_id))
   {
    $cache->cacheId = PAGE . ',' . $news_item_id;
   }
  elseif(isset($current_page) && $current_page > 1)
   {
    $cache->cacheId = PAGE . ',,' . $current_page;
   }
  else
   {
    $cache->cacheId = PAGE;
   }
 }
?>
