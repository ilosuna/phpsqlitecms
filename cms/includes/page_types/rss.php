<?php
if(!defined('IN_INDEX')) exit;

$current_time = time();

$dbr = Database::$content->prepare("SELECT id, page, type, category, title, teaser, teaser_formatting, teaser_img, teaser_headline, content, content_formatting, time, last_modified FROM ".Database::$db_settings['pages_table']." WHERE include_rss=:include_rss AND time<=:time AND status!=0 ORDER BY time DESC LIMIT ".$settings['rss_maximum_items']);
$dbr->bindParam(':include_rss', $page_id, PDO::PARAM_INT);
$dbr->bindParam(':time', $current_time, PDO::PARAM_INT);
$dbr->execute();

if(isset($_GET['get_1']) && $_GET['get_1'] == 'fullfeed' && $settings['enable_fullfeeds']) $fullfeed=true;
else $fullfeed=false; 

$i=0;
while($rss_data = $dbr->fetch())
 {
  $rss_items[$i]['category'] = htmlspecialchars($rss_data['category']);
  $rss_items[$i]['title'] = htmlspecialchars($rss_data['title']);
  
  #if($rss_data['headline'] && $fullfeed || empty($rss_data['teaser_headline'])) $rss_items[$i]['title'] = htmlspecialchars($rss_data['headline']);
  if($rss_data['teaser_headline']) $rss_items[$i]['title'] = htmlspecialchars($rss_data['teaser_headline']);
  else $rss_items[$i]['title'] = htmlspecialchars($rss_data['title']);
  
  if($fullfeed || $rss_data['teaser']=='')
   {
    if($rss_data['content_formatting']==1)
     {
      $rss_items[$i]['content'] = auto_html($rss_data['content']);
     }
    else
     {
      $rss_items[$i]['content'] = $rss_data['content'];
     }
    $rss_items[$i]['content'] = parse_special_tags($rss_items[$i]['content'], $parent_page=$rss_data['page'], $rss=true);
    #$rss_items[$i]['content'] = preg_replace_callback("#\[image:(.+?)\]#is", "create_image", $rss_items[$i]['content']);    
    #$rss_items[$i]['content'] = preg_replace_callback("#\[thumbnail:(.+?)\]#is", "create_thumbnail_rss", $rss_items[$i]['content']);
    #$rss_items[$i]['content'] = preg_replace_callback("#\[gallery:(.+?)\]#is", "create_gallery_rss", $rss_items[$i]['content']);
    #$rss_items[$i]['content'] = preg_replace('/\[\[([^|\]]+?)(?:\|([^\]]+))?\]\]/e', "'<a href=\"\$1\">'.(('\$2')?'\$2':'\$1').'</a>'", $rss_items[$i]['content']);   
   }
  else
   {
    if($rss_data['teaser_formatting']==1)
     {
      $rss_items[$i]['content'] = auto_html($rss_data['teaser']);
     }
    else
     {
      $rss_items[$i]['content'] = $rss_data['teaser'];
     }
   }

  if(!$fullfeed && $rss_data['teaser_img']) 
   {
    $rss_items[$i]['teaser_img'] = $rss_data['teaser_img'];
    $teaser_img_info = getimagesize(BASE_PATH.MEDIA_DIR.$rss_data['teaser_img']);
    $rss_items[$i]['teaser_img_width'] = $teaser_img_info[0];
    $rss_items[$i]['teaser_img_height'] = $teaser_img_info[1];
   }

  $rss_items[$i]['link'] = BASE_URL.$rss_data['page'];
  $rss_items[$i]['pubdate'] = gmdate('r',$rss_data['time']);
  $wfw = false;
  if($rss_data['type']=='commentable_page')
   {
    $wfw = true;
    $rss_items[$i]['commentrss'] = BASE_URL.$rss_data['page'].',commentrss';
   }
  $i++;
 }

if(isset($wfw)) $template->assign('wfw', $wfw);
if(isset($rss_items)) $template->assign('rss_items', $rss_items);

$content_type = 'text/xml';
$template_file = 'rss.tpl';

if(isset($cache))
 {
  if($fullfeed)
   {
    $cache->cacheId = PAGE . ',full';
   }
  else
   {
    $cache->cacheId = PAGE;
   }
 }
?>
