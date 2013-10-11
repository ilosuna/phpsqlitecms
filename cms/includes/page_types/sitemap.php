<?php
if(!defined('IN_INDEX')) exit;

$current_time = time();

$dbr = Database::$content->prepare("SELECT id, page, title, teaser, time, last_modified FROM ".Database::$db_settings['pages_table']." WHERE include_sitemap=:include_sitemap AND time<=:time AND status!=0 ORDER BY last_modified DESC");
$dbr->bindParam(':include_sitemap', $page_id, PDO::PARAM_INT);
$dbr->bindParam(':time', $current_time, PDO::PARAM_INT);
$dbr->execute();
$i=0;
while($data = $dbr->fetch())
 {
  if($data['page']==$settings['index_page']) $sitemap_items[$i]['loc'] = addslashes(BASE_URL);
  else $sitemap_items[$i]['loc'] = addslashes(BASE_URL.$data['page']);
  $sitemap_items[$i]['lastmod'] = date('Y-m-d',$data['last_modified']);
  $i++;
 }

if(isset($sitemap_items))
 {
  $template->assign('sitemap_items',$sitemap_items);
 }

#$localization->assign('charset', 'utf-8');
$content_type = 'text/xml';
$template_file = 'sitemap.tpl';

if(isset($cache))
 {
  $cache->cacheId = PAGE;
 }
?>
