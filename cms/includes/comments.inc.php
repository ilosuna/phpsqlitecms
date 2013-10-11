<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

  $type = isset($_REQUEST['type']) && $_REQUEST['type']==1 ? 1 : 0; // 0 = page comments, 1 = photo comments
  $template->assign('type', $type);

  $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
  $template->assign('page', $page);

  $comment_id = isset($_REQUEST['comment_id']) ? $_REQUEST['comment_id'] : 0;
  $template->assign('comment_id', $comment_id);

  if(isset($_GET['photos_commentable']))
   {
    $photos_commentable = $_GET['photos_commentable']==1 ? 1 : 0;
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['settings_table']." SET value=:value WHERE name='photos_commentable'");
    $dbr->bindParam(':value', $photos_commentable, PDO::PARAM_INT);
    $dbr->execute();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type=1');
    exit;
   }

  if(isset($_GET['edit']))
   {
    $dbr = Database::$entries->prepare("SELECT id, name, email_hp, comment FROM ".Database::$db_settings['comment_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['edit'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['id']))
     {
      $comment['id'] = $data['id'];
      $comment['name'] = htmlspecialchars($data['name']);
      $comment['email_hp'] = htmlspecialchars($data['email_hp']);
      $comment['comment'] = htmlspecialchars($data['comment']);
      $template->assign('comment', $comment);
      $action = 'edit';
     }
    else
     {
      $action = 'invalid_request';
     }
   }

  if(isset($_POST['edit_submit']))
   {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email_hp = isset($_POST['email_hp']) ? trim($_POST['email_hp']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $dbr = Database::$entries->prepare("UPDATE ".Database::$db_settings['comment_table']." SET name=:name, email_hp=:email_hp, comment=:comment WHERE id=:id");
    $dbr->bindParam(':id', $id, PDO::PARAM_INT);
    $dbr->bindParam(':name', $name, PDO::PARAM_STR);
    $dbr->bindParam(':email_hp', $email_hp, PDO::PARAM_STR);
    $dbr->bindParam(':comment', $comment, PDO::PARAM_STR);
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type='.$type.'&comment_id='.$comment_id.'&page='.$page);
    exit;
   }

  if(isset($_GET['delete']))
   {
    $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE id=:id");
    $dbr->bindParam(':id', $_GET['delete'], PDO::PARAM_INT);
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type='.$type.'&comment_id='.$comment_id.'&page='.$page);
    exit;
   }

  if(isset($_GET['report_spam']))
   {
    $dbr = Database::$entries->prepare("SELECT id, time, name, comment FROM ".Database::$db_settings['comment_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['report_spam'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['id']))
     {
      $comment['id'] = $data['id'];
      $comment['name'] = htmlspecialchars($data['name']);
      $comment['time'] = $data['time'];
      $comment['comment'] = htmlspecialchars($data['comment']);
      $template->assign('comment', $comment);
     }
    $action = 'report_spam';
   }

  if(isset($_POST['report_as_spam']) || isset($_POST['report_as_spam_and_delete']))
   {
    if($settings['akismet_key']!='' && $settings['akismet_entry_check']==1)
     {
      $dbr = Database::$entries->prepare("SELECT id, name, email_hp, comment FROM ".Database::$db_settings['comment_table']." WHERE id=:id LIMIT 1");
      $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['id']))
       {
        #$comment['id'] = $data['id'];
        $comment['author'] = $data['name'];
        if($data['email_hp'] != '')
         {
          if(preg_match("/^[^@]+@.+\.\D{2,5}$/", $data['email_hp']))
           {
            $comment['email'] = $data['email_hp'];
           }
          else
           {
            $comment['website'] = $data['email_hp'];
           }
         }
        $comment['body'] = $data['comment'];
        $akismet = new Akismet(BASE_URL, $settings['akismet_key'], $comment);
        if(!$akismet->errorsExist())
         {
          $akismet->submitSpam();
         }
        if(isset($_POST['report_as_spam_and_delete']))
         {
          $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE id=:id");
          $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
          $dbr->execute();
          if(isset($cache) && $cache->autoClear) $cache->clear();
         }
       }
     }
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type='.$type.'&comment_id='.$comment_id.'&page='.$page);
    exit;
   }

  if(isset($_POST['delete_checked']))
   {
    if(isset($_POST['checked']) && is_array($_POST['checked']))
     {
      $dbr = Database::$entries->prepare("SELECT id, name, comment FROM ".Database::$db_settings['comment_table']." WHERE id=:id ORDER BY comment_id ASC");
      $dbr->bindParam(':id', $checked_id, PDO::PARAM_INT);
      $i=0;
      #Database::$entries->beginTransaction();
      foreach($_POST['checked'] as $checked_id)
       {
        $dbr->execute();
        $data = $dbr->fetch();
        $comments[$i]['id'] = $data['id'];
        $comments[$i]['name'] = htmlspecialchars($data['name']);
        $comments[$i]['comment'] = htmlspecialchars($data['comment']);
        if(mb_strlen($comments[$i]['comment'],CHARSET) > 50) $comments[$i]['comment'] = mb_substr($comments[$i]['comment'],0,47,CHARSET).'...';
        ++$i;
       }
      #Database::$entries->commit();

      if(isset($comments))
       {
        $template->assign('comments',$comments);
        $action = 'delete_checked';
       }
     }
   }

  if(isset($_POST['delete_all_comments']))
   {
    $action = 'delete_all_comments';
   }

  if(isset($_POST['delete_all_comments_page']))
   {
    if($comment_id>0)
     {
      $dbr = Database::$content->query("SELECT title FROM ".Database::$db_settings['pages_table']." WHERE id=:id");
      $dbr->bindParam(':id', $comment_id, PDO::PARAM_INT);
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['title']))
       { 
        $template->assign('page', htmlspecialchars($data['title']));
        $action = 'delete_all_comments_page';
       }      
     }
   }

  if(isset($_POST['delete_checked_confirmed']))
   {
    if(isset($_POST['checked_ids_confirmed']) && is_array($_POST['checked_ids_confirmed']))
     {
      $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE id=:id");
      $dbr->bindParam(':id', $delete_id, PDO::PARAM_INT);
      Database::$entries->beginTransaction();
      foreach($_POST['checked_ids_confirmed'] as $delete_id)
       {
        $dbr->execute();
       }
      Database::$entries->commit();
      if(isset($cache) && $cache->autoClear) $cache->clear();
     }
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type='.$type.'&page='.$page);
    exit;
   }

  if(isset($_POST['delete_all_comments_confirmed']))
   {
    $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE type=:type");
    $dbr->bindParam(':type', $type, PDO::PARAM_INT);
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type='.$type);
    exit;
   }

  if(isset($_POST['delete_all_comments_page_confirmed']))
   {
    $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE type=:type AND comment_id=:comment_id");
    $dbr->bindParam(':type', $type, PDO::PARAM_INT);
    $dbr->bindParam(':comment_id', $_POST['comment_id'], PDO::PARAM_INT);
    Database::$entries->beginTransaction();
    $dbr->execute();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=comments&type='.$type);
    exit;
   }


  switch($action)
   {
    case 'main':
     // count comments:
     if($comment_id==0)
      {
       $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE type=:type");
       $dbr->bindParam(':type', $type, PDO::PARAM_INT);
       $dbr->execute();
       $comment_count = $dbr->fetchColumn();
      }
     else
      {
       $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE type=:type AND comment_id=:comment_id");
       $dbr->bindParam(':type', $type, PDO::PARAM_INT);
       $dbr->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
       $dbr->execute();
       $comment_count = $dbr->fetchColumn();
       // no comments to item, switch to all items:
       if($comment_count==0)
        {
         $comment_id=0;
         $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE type=:type");
         $dbr->bindParam(':type', $type, PDO::PARAM_INT);
         $dbr->execute();
         $comment_count = $dbr->fetchColumn();
        }
      }

     // pages:
     $pages = ceil($comment_count / $settings['admin_entries_per_page']);
     if($page < 1) $page=1;
     if($page > $pages && $page != 1) $page = $pages;
     $template->assign('page', $page);

     #$pagination = pagination($pages,$page,3,true);
     $template->assign('pagination',pagination($pages,$page,3,true));

     // get $comment_ids of all comments:
     $dbr = Database::$entries->prepare("SELECT DISTINCT comment_id FROM ".Database::$db_settings['comment_table']." WHERE type=:type ORDER BY comment_id ASC");
     $dbr->bindParam(':type', $type, PDO::PARAM_INT);
     $dbr->execute();
     while($data = $dbr->fetch())
      {
       $comment_ids[] = $data['comment_id'];
      }

     // get ids, pages, titles etc. of commented items:
     if(isset($comment_ids))
      {
       $comment_ids_list = implode(',',$comment_ids);
       if($type==0)
        {
         $dbr = Database::$content->query("SELECT id, page, title FROM ".Database::$db_settings['pages_table']." WHERE id IN (".$comment_ids_list.")");
         while($data = $dbr->fetch())
          {
           $items[$data['id']]['page'] = htmlspecialchars($data['page']);
           $items[$data['id']]['title'] = htmlspecialchars($data['title']);
          }
        }
       else
        {
         $dbr = Database::$content->query("SELECT id, photo_thumbnail, photo_normal, title FROM ".Database::$db_settings['photo_table']." WHERE id IN (".$comment_ids_list.")");
         while($data = $dbr->fetch())
          {
           $items[$data['id']]['page'] = htmlspecialchars($data['title']);
           $items[$data['id']]['title'] = htmlspecialchars($data['title']);
           $items[$data['id']]['photo_thumbnail'] = htmlspecialchars($data['photo_thumbnail']);
           $items[$data['id']]['photo_normal'] = htmlspecialchars($data['photo_normal']);
          }
        }
      }

     if(isset($items))
      {
       asort($items);
       $template->assign('items', $items);
      }

     // get comments:
     if($comment_id==0)
      {
       $dbr = Database::$entries->prepare("SELECT id, comment_id, time, name, email_hp, comment, ip FROM ".Database::$db_settings['comment_table']." WHERE type=:type ORDER BY id DESC LIMIT ".$settings['admin_entries_per_page']." OFFSET ".(($page-1)*$settings['admin_entries_per_page']));
       $dbr->bindParam(':type', $type, PDO::PARAM_INT);
       $dbr->execute();
      }
     else
      {
       $dbr = Database::$entries->prepare("SELECT id, comment_id, time, name, email_hp, comment, ip FROM ".Database::$db_settings['comment_table']." WHERE type=:type AND comment_id=:comment_id ORDER BY id DESC LIMIT ".$settings['admin_entries_per_page']." OFFSET ".(($page-1)*$settings['admin_entries_per_page']));
       $dbr->bindParam(':type', $type, PDO::PARAM_INT);
       $dbr->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
       $dbr->execute();
      }
     $i=0;
     while($data = $dbr->fetch())
      {
       #$item_ids[] = $data['comment_id'];
       $comments[$i]['id'] = $data['id'];
       $comments[$i]['comment_id'] = $data['comment_id'];
       $comments[$i]['time'] = $data['time'];
       $comments[$i]['name'] = htmlspecialchars($data['name']);
       
       if($data['email_hp'])
        {
         if(preg_match("/^[^@]+@.+\.\D{2,5}$/", $data['email_hp']))
          {
           $comments[$i]['email_hp'] = 'mailto:'.htmlspecialchars($data['email_hp']);
          }
         else
          {
           $comments[$i]['email_hp'] = add_http_if_no_protocol(htmlspecialchars($data['email_hp']));
          }
        }
       
       $comments[$i]['comment'] = htmlspecialchars($data['comment']);
       if($settings['comment_remove_blank_lines']==1)
        {
         $entry_array = explode("\n", $comments[$i]['comment']);
         $comment = '';
         foreach($entry_array as $entry_line)
          {
           $entry_line = trim($entry_line);
           if($entry_line!='') $comment .= $entry_line."\n";
          }
         $comments[$i]['comment'] = $comment;
        }
       $comments[$i]['comment'] = nl2br($comments[$i]['comment']);
       $comments[$i]['ip'] = htmlspecialchars($data['ip']);
       ++$i;
      }

     if(isset($comments))
      {
       $template->assign('comments', $comments);
      }

     if(isset($item_titles))
      {
       asort($item_titles);
       $template->assign('item_titles', $item_titles);
      }

     if($comment_id!=0)
      {
       if($type==0) $localization->replacePlaceholder('page', $items[$comment_id]['title'], 'delete_all_comments_page');
       else $localization->replacePlaceholder('photo', $items[$comment_id]['title'], 'delete_all_comments_photo');
      }
     if($type==1)
      {
       if($settings['photos_commentable']==1) $localization->replaceLink('index.php?mode=comments&amp;type=1&amp;photos_commentable=0', 'photo_comments_enabled');
       if($settings['photos_commentable']==0) $localization->replaceLink('index.php?mode=comments&amp;type=1&amp;photos_commentable=1', 'photo_comments_disabled');
      }

     $template->assign('subtitle', Localization::$lang['comments']);
     $template->assign('subtemplate', 'comments.inc.tpl');
    break;
    case 'edit':
     $template->assign('subtitle', Localization::$lang['edit_comment']);
     $template->assign('subtemplate', 'comments_edit.inc.tpl');
     break;
    case 'delete_checked':
     $template->assign('subtitle', Localization::$lang['delete_comments']);
     $template->assign('subtemplate', 'comments_delete.inc.tpl');
     break;
    case 'delete_all_comments':
     $template->assign('subtitle', Localization::$lang['delete_comments']);
     $template->assign('subtemplate', 'comments_delete_all.inc.tpl');
     break;
    case 'delete_all_comments_page':
     $template->assign('subtitle', Localization::$lang['delete_comments']);
     $template->assign('subtemplate', 'comments_delete_all_page.inc.tpl');
    break;
    case 'report_spam':
     $template->assign('subtitle', Localization::$lang['report_spam']);
     $template->assign('subtemplate', 'comments_report_spam.inc.tpl');
     break;
   }
 }
?>
