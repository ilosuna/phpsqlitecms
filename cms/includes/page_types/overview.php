<?php
if(!defined('IN_INDEX')) exit;

$dbr = Database::$content->prepare("SELECT id, page, headline, content, content_formatting, teaser_headline, teaser, teaser_formatting, teaser_img, link_name FROM ".Database::$db_settings['pages_table']." WHERE include_page=:include_page ORDER BY include_order ASC");
$dbr->bindParam(':include_page', $data['id'], PDO::PARAM_INT);
$dbr->execute();
$i=0;
while($included_pages_data = $dbr->fetch())
 {
  if($included_pages_data['teaser_headline']=='')
   {
    $included_pages[$i]['teaser_headline'] = stripslashes($included_pages_data['headline']);
   }
  else
   {
    $included_pages[$i]['teaser_headline'] = stripslashes($included_pages_data['teaser_headline']);
   }
  if($included_pages_data['teaser']=='')
   {
    if($included_pages_data['content_formatting']==1)
     {
      $included_pages[$i]['teaser'] = nl2br(stripslashes($included_pages_data['content']));
     }
    else
     {
      $included_pages[$i]['teaser'] = stripslashes($included_pages_data['content']);
     }
   }
  else
   {
    if($included_pages_data['teaser_formatting']==1)
     {
      $included_pages[$i]['teaser'] = nl2br(stripslashes($included_pages_data['teaser']));
     }
    else
     {
      $included_pages[$i]['teaser'] = stripslashes($included_pages_data['teaser']);
     }
   }
  $included_pages[$i]['page'] = $included_pages_data['page'];
  $included_pages[$i]['teaser_img'] = $included_pages_data['teaser_img'];
  if(trim($included_pages_data['teaser_img']!=''))
   {
    $teaser_img_info = getimagesize(BASE_PATH.MEDIA_DIR.$included_pages_data['teaser_img']);
    $included_pages[$i]['teaser_img_width'] = $teaser_img_info[0];
    $included_pages[$i]['teaser_img_height'] = $teaser_img_info[1];
   }
  $included_pages[$i]['link_name'] = stripslashes($included_pages_data['link_name']);
  $i++;
 }
if(isset($included_pages))
 {
  $template->assign('included_pages_number', count($included_pages));
  $template->assign('included_pages', $included_pages);
 }
$template->assign('subtemplate', 'overview.inc.tpl');

if(isset($cache))
 {
  $cache->cacheId = PAGE;
 }
?>
