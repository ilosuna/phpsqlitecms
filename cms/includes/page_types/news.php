<?php
if(!defined('IN_INDEX')) exit;

$news = new News($data['id'], $settings['news_per_page']);

if(isset($_GET['get_1']) && ($_GET['get_1']=='rss' || $_GET['get_1']=='rss-fullfeed')) 
 {
  if($settings['enable_fullfeeds'] && $_GET['get_1']=='rss-fullfeed')
   {
    $template->assign('rss_items', $news->get_feed($settings['rss_maximum_items'], true));
    if(isset($cache)) $cache->cacheId = PAGE . ',rss-fullfeed';
   }
  else
   {
    $template->assign('rss_items', $news->get_feed($settings['rss_maximum_items'], false));
    if(isset($cache)) $cache->cacheId = PAGE . ',rss';    
   }
  $template->assign('wfw', $news->wfw);
  $content_type = 'text/xml';
  $template_file = 'rss.tpl';   
 }
else
 {
  $template->assign('news', $news->get_news());
  $template->assign('current_category', htmlspecialchars($news->category));
  $template->assign('current_category_urlencoded', $news->category_urlencoded);

  $template->assign('subtemplate', 'news.inc.tpl');
  $template->assign('pagination', pagination($news->total_pages,$news->current_page));

  if(isset($cache))
   {
    if($news->category && $news->current_page == 1)
     {
      $cache->cacheId = PAGE . ',' . CATEGORY_IDENTIFIER . str_replace('&',AMPERSAND_REPLACEMENT,$news->category);
     }
    elseif($news->current_page > 1)
     {
      if($news->category) $category = CATEGORY_IDENTIFIER . str_replace('&',AMPERSAND_REPLACEMENT,$news->category);
      else $category = '';
      $cache->cacheId = PAGE . ',' . $category . ',' . $news->current_page;
     }
    else
     {
      $cache->cacheId = PAGE;
    }
   }
 }
?>
