<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_REQUEST['action']))
 {
  switch($_REQUEST['action'])
   {
    case 'insert_gallery':
     $dbr = Database::$content->query("SELECT DISTINCT gallery FROM ".Database::$db_settings['photo_table']." ORDER BY gallery ASC");
     while($data = $dbr->fetch())
      {
       $galleries[] = htmlspecialchars($data['gallery']);
      }
     if(isset($galleries))
      {
       $template->assign('galleries', $galleries);
      }
     
     $template_file = 'subtemplates/modal_insert_gallery.tpl';
     break;

    case 'insert_thumbnail':
     $dbr = Database::$content->query("SELECT id, title, gallery FROM ".Database::$db_settings['photo_table']." ORDER BY gallery ASC, sequence ASC");
     $i=0;
     while($data = $dbr->fetch())
      {
       $thumbnails[$i]['id'] = $data['id'];
       $thumbnails[$i]['gallery'] = htmlspecialchars($data['gallery']);
       $thumbnails[$i]['title'] = htmlspecialchars($data['title']);
       ++$i;
      }
     if(isset($thumbnails))
      {
       $template->assign('thumbnails', $thumbnails);
      }
     
     $template_file = 'subtemplates/modal_insert_thumbnail.tpl';
     break;
     
    case 'insert_image':
     $fp=opendir(BASE_PATH.MEDIA_DIR);
     while($file = readdir($fp))
      {
       if(preg_match('/\.jpg$/i', $file) || preg_match('/\.jpeg$/i', $file) || preg_match('/\.png$/i', $file))
        {
         $images[] = $file;
        }
      }
     closedir($fp);

     if(isset($images))
      {
       natcasesort($images);
       $template->assign('images', $images);
      }   
     $template_file = 'subtemplates/modal_insert_image.tpl';
     break;
    
    case 'insert_raw_image':
     $fp=opendir(BASE_PATH.MEDIA_DIR);
     while($file = readdir($fp))
      {
       if(preg_match('/\.jpg$/i', $file) || preg_match('/\.jpeg$/i', $file) || preg_match('/\.png$/i', $file))
        {
         $images[] = $file;
        }
      }
     closedir($fp);

     if(isset($images))
      {
       natcasesort($images);
       $template->assign('images', $images);
      }   
     $template_file = 'subtemplates/modal_insert_raw_image.tpl';
     break;
   }  
 }
?>
