<?php
if(!defined('IN_INDEX')) exit;

$dbr = Database::$content->prepare("SELECT time, title, text, text_formatting, link FROM ".Database::$db_settings['notes_table']." WHERE note_section=:note_section ORDER BY time DESC LIMIT ".$settings['rss_maximum_items']);
$dbr->bindParam(':note_section', $data['type_addition'], PDO::PARAM_STR);
$dbr->execute();

$i=0;
while($rss_data = $dbr->fetch())
 {
  $rss_items[$i]['title'] = htmlspecialchars($rss_data['title']);
  if($rss_data['text_formatting']==1) $rss_items[$i]['content'] = auto_html($rss_data['text']);
  else $rss_items[$i]['content'] = $rss_data['text'];
  if(mb_substr($rss_data['link'],0,7) != 'http://' && mb_substr($rss_data['link'],0,8) != 'https://' && mb_substr($rss_data['link'],0,6) != 'ftp://' && mb_substr($rss_data['link'],0,9) != 'gopher://' && mb_substr($rss_data['link'],0,7) != 'news://')
   {
    $rss_items[$i]['link'] = BASE_URL.$rss_data['link'];
   }
  else
   {
    $rss_items[$i]['link'] = $rss_data['link'];
   }
  $rss_items[$i]['pubdate'] = gmdate('r',$rss_data['time']);
  $i++;
 }

if(isset($rss_items))
 {
  $template->assign('rss_items',$rss_items);
 }

$content_type = 'text/xml';
$template_file = 'rss.tpl';

if(isset($cache))
 {
  $cache->cacheId = PAGE;
 }
?>
