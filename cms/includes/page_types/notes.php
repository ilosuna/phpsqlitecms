<?php
if(isset($_GET['get_1'])) // note opened
 {
  $dbr = Database::$content->prepare("SELECT id, note_section, time, title, text, text_formatting FROM ".Database::$db_settings['notes_table']." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $_GET['get_1'], PDO::PARAM_STR);
  $dbr->execute();
  $note_data = $dbr->fetch();
  if(isset($note_data['id']) && $note_data['note_section']==$data['type_addition'])
   {
    $note['note_section'] = htmlspecialchars($note_data['note_section']);
    $note['id'] = $note_data['id'];
    $note['title'] = htmlspecialchars($note_data['title']);
    $note['text'] = htmlspecialchars($note_data['text']);
    $note['text_formatting'] = $note_data['text_formatting'];
    #$note['link'] = htmlspecialchars($note_data['link']);
    #$note['linkname'] = htmlspecialchars($note_data['linkname']);
    $note['time'] = date("Y-m-d H:i:s", $note_data['time']);

    #echo $data['title'];

  $template->assign('display_time', true);
  $localization->replacePlaceholder('time', $note_data['time'], 'page_time', Localization::FORMAT_TIME);


    $template->assign('headline', $note_data['title']);
    #$template->assign('title', $note_data['title']);
    
    $template->assign('note',$note);
    
   }
  else
   {
    $no_cache = true;
    echo '404';
    exit;
   }
 }
else // overview
 {
  $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section");
  $dbr->bindParam(':note_section', $data['type_addition'], PDO::PARAM_STR);
  $dbr->execute();
  $total_items = $dbr->fetchColumn();

  $total_pages = ceil($total_items / $settings['notes_per_page']);

  if(isset($_GET['get_2'])) $current_page = intval($_GET['get_2']); else $current_page = 1;
  if($current_page<1) $current_page = 1;
  if($current_page>$total_pages) $current_page = $total_pages;

  $dbr = Database::$content->prepare("SELECT id, time, title, text, text_formatting, link, linkname FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section ORDER BY sequence ASC LIMIT ".(($current_page-1)*$settings['notes_per_page']).", ".$settings['notes_per_page']);
  $dbr->bindParam(':note_section', $data['type_addition'], PDO::PARAM_STR);
  $dbr->execute();
  $i=0;
  while($notes_data = $dbr->fetch())
   {
    $notes[$i]['id'] = $notes_data['id'];
    $notes[$i]['time'] = $notes_data['time'];
    $notes[$i]['title'] = $notes_data['title'];
    if($notes_data['text_formatting']==1) $notes[$i]['text'] = auto_html($notes_data['text']);
    else $notes[$i]['text'] = $notes_data['text'];
    #$notes[$i]['text'] = format_paragraph($notes_data['text']);
    if($notes_data['link']=='')
     {
      $notes[$i]['link'] = BASE_URL.PAGE.','.$notes_data['id'];
     }
    elseif(mb_substr($notes_data['link'],0,7) != 'http://' && mb_substr($notes_data['link'],0,8) != 'https://' && mb_substr($notes_data['link'],0,6) != 'ftp://' && mb_substr($notes_data['link'],0,9) != 'gopher://' && mb_substr($notes_data['link'],0,7) != 'news://')
     {
      $notes[$i]['link'] = BASE_URL.$notes_data['link'];
     }
    else
     {
      $notes[$i]['link'] = $notes_data['link'];
     }
    $notes[$i]['linkname'] = $notes_data['linkname'];
    $localization->bindReplacePlaceholder($notes_data['id'], 'time', $notes_data['time'], 'note_time', Localization::FORMAT_TIME);
    $i++;
   }
  if(isset($notes))
   {
    $template->assign('notes', $notes);
   }

  $localization->replacePlaceholder('current_page', $current_page, 'pagination');
  $localization->replacePlaceholder('total_pages', $total_pages, 'pagination');

  $template->assign('pagination', pagination($total_pages,$current_page));
 }

$template->assign('subtemplate', 'notes.inc.tpl');

if(isset($cache))
 {
  if($current_page > 1)
   {
    $cache->cacheId = PAGE . ',' . $current_page;
   }
  else
   {
    $cache->cacheId = PAGE;
   }
 }
?>
