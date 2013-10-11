<?php
if(!defined('IN_INDEX')) exit;

$gallery = new Gallery($data['type_addition']);

if($gallery->photos)
 {
  $template->assign('number_of_photos', $gallery->number_of_photos);
  $template->assign('photos_per_row', $gallery->photos_per_row);
  $template->assign('photos', $gallery->photos);
 }

$template->assign('contains_thumbnails', true);
$template->assign('subtemplate', 'gallery.inc.tpl');

if(isset($cache) && empty($no_cache))
 {
  $cache->cacheId = PAGE;
 }
?>
