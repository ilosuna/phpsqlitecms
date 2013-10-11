<?php
if(!defined('IN_INDEX')) exit;

$img_path = BASE_PATH.MEDIA_DIR;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(isset($_REQUEST['form']))
   {
    $template->assign('form',htmlspecialchars($_REQUEST['form']));
   }
  if(isset($_REQUEST['field']))
   {
    $template->assign('field',htmlspecialchars($_REQUEST['field']));
   }

  $insert_mode = isset($_REQUEST['insert_mode']) && $_REQUEST['insert_mode']==1 ? 1 : 0;
  $template->assign('insert_mode',$insert_mode);

  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

  switch($action)
   {
    case 'main':
     $fp=opendir($img_path);
     while($file = readdir($fp))
      {
       if(preg_match('/\.jpg$/i', $file) || preg_match('/\.jpeg$/i', $file) || preg_match('/\.png$/i', $file) || preg_match('/\.gif$/i', $file) || ($insert_mode==1 && preg_match('/\.swf$/i', $file)) || ($insert_mode==1 && preg_match('/\.flv$/i', $file)))
        {
         $images[] = $file;
        }
      }
     closedir($fp);

     if(isset($images))
      {
       // Sort filenames
       natcasesort($images);
       $template->assign('images', $images);

       $image_classes_untrimmed = explode(',',$settings['image_classes']);
       foreach($image_classes_untrimmed as $image_class)
        {
         $image_classes[] = trim($image_class);
        }
       if(isset($image_classes))
        {
         $template->assign('image_classes',$image_classes);
        }
      }
   }

  $template_file = 'insert_image.tpl';
 }
?>
