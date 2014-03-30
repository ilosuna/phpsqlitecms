<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

  if(isset($_GET['edit']))
   {
    $dbr = Database::$content->prepare("SELECT id, title, text, text_formatting, link, linkname FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section ORDER BY sequence ASC");
    $dbr->bindParam(':note_section', $_GET['edit'], PDO::PARAM_STR);
    $dbr->execute();
    $i=0;
    while($data = $dbr->fetch())
     {
      $notes[$i]['id'] = $data['id'];
      $notes[$i]['title'] = $data['title'];
      #$notes[$i]['teaser'] = $data['teaser'];
      if($data['text_formatting']==1)
       {
        $notes[$i]['text'] = auto_html($data['text']);
       }
      else
       {
        $notes[$i]['text'] = $data['text'];
       }

      if(substr($data['link'],0,7) != 'http://' && substr($data['link'],0,8) != 'https://')
       {
        $notes[$i]['link'] = '../'.$data['link'];
       }
      else
       {
        $notes[$i]['link'] = $data['link'];
       }
      #$notes[$i]['link'] = htmlspecialchars(stripslashes($data['link']));
      $notes[$i]['linkname'] = $data['linkname'];
      ++$i;
     }
    if(isset($notes))
     {
      $template->assign('notes', $notes);
     }
    #$note_section = htmlspecialchars(stripslashes($_GET['edit']));
    $template->assign('note_section', htmlspecialchars($_GET['edit']));
    $action = 'edit';
   }

  if(isset($_REQUEST['delete']))
   {
    if(isset($_REQUEST['confirmed']))
     {
      $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section");
      $dbr->bindParam(':note_section', $_REQUEST['delete'], PDO::PARAM_STR);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=notes');
      exit;
     }
    else
     {
      $template->assign('note_section', htmlspecialchars($_REQUEST['delete']));
      $action = 'delete';
     }
   }


  if(isset($_GET['add_note']))
   {
    $note['note_section'] = htmlspecialchars($_GET['add_note']);
    $note['time'] = date("Y-m-d H:i:s");
    #$note['text_formatting'] = $settings['default_formatting'];
    $note['text_formatting'] = 1;
    $template->assign('note',$note);
    $action = 'edit_note';
   }

  if(isset($_POST['new_note_section']))
   {
    $new_note_section = isset($_POST['new_note_section']) ? trim($_POST['new_note_section']) : '';

    if(!preg_match('/^[a-zA-Z0-9_\-]+$/', $new_note_section))
     {
      $errors[] = 'error_note_sect_name_invalid';
     }
    if(empty($errors))
     {
      $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['notes_table']." WHERE lower(note_section)=:note_section");
      $dbr->bindValue(':note_section', mb_strtolower($new_note_section,CHARSET), PDO::PARAM_STR);
      $dbr->execute();
      if($dbr->fetchColumn()!=0)
       {
        $errors[] = 'note_section_already_ex';
       }
     }
    if(empty($errors))
     {
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=notes&edit='.$new_note_section);
     }
    else
     {
      $template->assign('errors',$errors);
      $template->assign('new_note_section',htmlspecialchars($new_note_section));
      $action = 'new';
     }
   }

  if(isset($_GET['edit_note']))
   {
    $dbr = Database::$content->prepare("SELECT id, note_section, time, title, text, text_formatting, link, linkname FROM ".Database::$db_settings['notes_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['edit_note'], PDO::PARAM_STR);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['id']))
     {
      $note['note_section'] = htmlspecialchars($data['note_section']);
      $note['id'] = $data['id'];
      $note['title'] = htmlspecialchars($data['title']);
      #$note['teaser'] = htmlspecialchars($data['teaser']);
      $note['text'] = $data['text'];
      $note['text_formatting'] = $data['text_formatting'];
      $note['link'] = htmlspecialchars($data['link']);
      $note['linkname'] = htmlspecialchars($data['linkname']);
      $note['time'] = date("Y-m-d H:i:s", $data['time']);

      $headline = $note['title'];

      $template->assign('note',$note);
      $action = 'edit_note';
     }
    else
     {
      $action = 'invalid_request';
     }
   }

  if(isset($_GET['move_up']))
   {
    if($note_section = move_up($_GET['move_up'], 'note_section', Database::$db_settings['notes_table']))
     {
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=notes&edit='.$note_section);
      exit;
     }
    else
     {
      $action = 'invalid_request';
     }
   }

  if(isset($_GET['move_down']))
   {
    if($note_section = move_down($_GET['move_down'], 'note_section', Database::$db_settings['notes_table']))
     {
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=notes&edit='.$note_section);
      exit;
     }
    else
     {
      $action = 'invalid_request';
     }
   }

  if(isset($_REQUEST['reorder_notes']) && isset($_REQUEST['item']))
   {
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['notes_table']." SET sequence=:sequence WHERE id=:id");
    $dbr->bindParam(':id', $id, PDO::PARAM_INT);
    $dbr->bindParam(':sequence', $sequence, PDO::PARAM_INT);
    Database::$content->beginTransaction();
    $sequence = 1;
    foreach($_REQUEST['item'] as $id)
     {
      $dbr->execute();
      ++$sequence;
     }
    Database::$content->commit();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    exit;
   }

  if(isset($_POST['edit_note_submit']))
   {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    #$teaser = isset($_POST['teaser']) ? trim($_POST['teaser']) : '';
    $text = isset($_POST['text']) ? trim($_POST['text']) : '';
    $text_formatting = isset($_POST['text_formatting']) && $_POST['text_formatting']==1 ? 1 : 0;
    $link = isset($_POST['link']) ? trim($_POST['link']) : '';
    $linkname = isset($_POST['linkname']) ? trim($_POST['linkname']) : '';
    $time = isset($_POST['time']) ? trim($_POST['time']) : date("Y-m-d H:i:s");
    $note_section = isset($_POST['note_section']) ? trim($_POST['note_section']) : '';

    if(empty($title))
     {
      $errors[] = 'error_notes_no_title';
     }
    if(empty($text))
     {
      $errors[] = 'error_notes_no_text';
     }
    if(($time = strtotime($time))===false)
     {
      $errors[] = 'error_notes_time_invalid';
     }
    if(!preg_match('/^[a-zA-Z0-9_\-]+$/', $note_section))
     {
      $errors[] = 'error_note_sect_name_invalid';
     }

    if(empty($errors))
     {
      if(isset($_POST['id']))
       {
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['notes_table']." SET time=:time, title=:title, text=:text, text_formatting=:text_formatting, link=:link, linkname=:linkname WHERE id=:id");
        $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $dbr->bindParam(':time', $time, PDO::PARAM_INT);
        $dbr->bindParam(':title', $title, PDO::PARAM_STR);
        #$dbr->bindParam(':teaser', $teaser, PDO::PARAM_STR);
        $dbr->bindParam(':text', $text, PDO::PARAM_STR);
        $dbr->bindParam(':text_formatting', $text_formatting, PDO::PARAM_INT);
        $dbr->bindParam(':link', $link, PDO::PARAM_STR);
        $dbr->bindParam(':linkname', $linkname, PDO::PARAM_STR);
        $dbr->execute();
       }
      else
       {
        $dbr = Database::$content->prepare("SELECT sequence FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section ORDER BY sequence DESC LIMIT 1");
        $dbr->bindParam(':note_section', $note_section, PDO::PARAM_STR);
        $dbr->execute();
        $sequence = intval($dbr->fetchColumn())+1;
        $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['notes_table']." (note_section,sequence,time,title,text,text_formatting,link,linkname) VALUES (:note_section,:sequence,:time,:title,:text,:text_formatting,:link,:linkname)");
        $dbr->bindParam(':note_section', $note_section, PDO::PARAM_STR);
        $dbr->bindParam(':sequence', $sequence, PDO::PARAM_INT);
        $dbr->bindParam(':time', $time, PDO::PARAM_INT);
        $dbr->bindParam(':title', $title, PDO::PARAM_STR);
        #$dbr->bindParam(':teaser', $teaser, PDO::PARAM_STR);
        $dbr->bindParam(':text', $text, PDO::PARAM_STR);
        $dbr->bindParam(':text_formatting', $text_formatting, PDO::PARAM_INT);
        $dbr->bindParam(':link', $link, PDO::PARAM_STR);
        $dbr->bindParam(':linkname', $linkname, PDO::PARAM_STR);
        $dbr->execute();
       }
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=notes&edit='.$note_section);
      exit;
     }
    else
     {
      if(isset($_POST['id'])) $note['id'] = intval($_POST['id']);
      $note['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
      #$note['teaser'] = isset($_POST['teaser']) ? htmlspecialchars($_POST['teaser']) : '';
      $note['text'] = isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '';
      $note['text_formatting'] = isset($_POST['text_formatting']) && $_POST['text_formatting']==1 ? 1 : 0;
      $note['link'] = isset($_POST['link']) ? htmlspecialchars($_POST['link']) : '';
      $note['linkname'] = isset($_POST['linkname']) ? htmlspecialchars($_POST['linkname']) : '';
      $note['time'] = isset($_POST['time']) ? htmlspecialchars($_POST['time']) : date("Y-m-d H:i:s");
      $note['note_section'] = isset($_POST['note_section']) ? htmlspecialchars($_POST['note_section']) : '';
      $template->assign('note', $note);
      $template->assign('errors', $errors);
      $action = 'edit_note';
     }
   }

  if(isset($_GET['delete_note']))
   {
    // get note section:
    $dbr = Database::$content->prepare("SELECT note_section FROM ".Database::$db_settings['notes_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['delete_note'], PDO::PARAM_INT);
    $dbr->execute();
    $note_section = $dbr->fetchColumn();
    // delete note:
    $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['notes_table']." WHERE id=:id");
    $dbr->bindParam(':id', $_GET['delete_note'], PDO::PARAM_INT);
    $dbr->execute();
    // reorder items:
    $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section ORDER BY sequence ASC");
    $dbr->bindParam(':note_section', $note_section, PDO::PARAM_STR);
    $dbr->execute();
    while($data = $dbr->fetch())
     {
      $ids[] = $data['id'];
     }
    if(isset($ids))
     {
      $new_sequence = 1;
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['notes_table']." SET sequence=:sequence WHERE id=:id");
      $dbr->bindParam(':sequence', $new_sequence, PDO::PARAM_INT);
      $dbr->bindParam(':id', $id, PDO::PARAM_INT);
      foreach($ids as $id)
       {
        $dbr->execute();
        ++$new_sequence;
       }
      Database::$content->commit();
     }
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=notes&edit='.$note_section);
    exit;
   }

  switch($action)
   {
    case 'main':
     $dbr = Database::$content->query("SELECT DISTINCT note_section FROM ".Database::$db_settings['notes_table']." ORDER BY note_section ASC");
     while($notes_data = $dbr->fetch())
      {
       $note_sections[] = htmlspecialchars($notes_data['note_section']);
      }
     if(isset($note_sections))
      {
       $template->assign('note_sections', $note_sections);
      }
     $template->assign('subtitle', Localization::$lang['notes']);
     $template->assign('subtemplate', 'notes.inc.tpl');
     break;
    case 'edit':
     $template->assign('subtitle', htmlspecialchars($_GET['edit']));
     $template->assign('subtemplate', 'notes_edit_section.inc.tpl');
     break;
    case 'edit_note':
     if(isset($note['id']))
      {
       $template->assign('subtitle', Localization::$lang['edit_note']);
      }
     else
      {
       $template->assign('subtitle', Localization::$lang['add_note']);
      }
     $template->assign('subtemplate', 'notes_edit_note.inc.tpl');
     break;
    case 'delete':
     $template->assign('subtitle', Localization::$lang['delete_note_section']);
     $template->assign('subtemplate', 'notes_delete_section.inc.tpl');
     break;
    case 'new':
     $template->assign('subtitle', Localization::$lang['create_note_section']);
     $template->assign('subtemplate', 'notes_new_section.inc.tpl');
     break;
   }
 }
