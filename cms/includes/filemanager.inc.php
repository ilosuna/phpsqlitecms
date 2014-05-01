<?php
if(!defined('IN_INDEX')) exit;

$media_dir = 'media';
$file_dir = 'files';

$template->assign('media_dir', $media_dir);
$template->assign('file_dir', $file_dir);

$directory = isset($_REQUEST['directory']) && $_REQUEST['directory']==$file_dir ? $file_dir : $media_dir;
$template->assign('directory', $directory);

$path = BASE_PATH.'static/'.$directory.'/';

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {

 // delete:
 if(isset($_REQUEST['delete']))
  {
   if(isset($_REQUEST['confirmed']))
    {
     @chmod($path.$_REQUEST['delete'], 0777);
     if(!@unlink($path.$_REQUEST['delete'])) $errors[] = Localization::$lang['delete_file_error'];
     header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=filemanager&directory='.$directory);
     exit;
    }
   else
    {
     $template->assign('file', htmlspecialchars($_REQUEST['delete']));
     $action = 'delete';
    }
  }

 if(isset($_POST['upload_file_submit']))
  {
   $file_name = isset($_POST['file_name']) ? trim($_POST['file_name']) : '';
   $upload_mode = isset($_POST['upload_mode']) && $_POST['upload_mode']==2 ? 2 : 1;
   $compression = isset($_POST['compression']) ? intval($_POST['compression']) : $settings['compression'];
   $resize_xy = isset($_POST['resize_xy']) && $_POST['resize_xy']=='x' ? 'x' : 'y';
   $resize = isset($_POST['resize']) ? intval($_POST['resize']) : $settings['resize'];
   $thumbnail_compression = isset($_POST['thumbnail_compression']) ? intval($_POST['thumbnail_compression']) : $settings['thumbnail_compression'];
   $thumbnail_resize_xy = isset($_POST['thumbnail_resize_xy']) && $_POST['thumbnail_resize_xy']=='x' ? 'x' : 'y';
   $thumbnail_resize = isset($_POST['thumbnail_resize']) ? intval($_POST['thumbnail_resize']) : $settings['thumbnail_resize'];
   
   if(empty($_FILES['file']['name']) || $_FILES['file']['size'] == 0 || $_FILES['file']['error']) $errors[] = Localization::$lang['error_no_file'];
   if($compression < 1 || $compression > 100 || $thumbnail_compression < 1 || $thumbnail_compression > 100) $errors[] = 'invalid_compression_value';

   if(empty($errors))
    {
     // filename already exists?
     if($file_name=='') $file_name = basename($_FILES['file']['name']);
     if(file_exists($path.$file_name) && empty($_POST['overwrite_file']))
      {
       #$file_name = '';
       $errors[] = 'upload_file_exists';
      }
    }
   if(empty($errors))
    {
     $upload = new FileUpload($_FILES['file'], $path);
          
     if($upload_mode==2 && $upload->isImage)
      {
       // its an image and it should be manipulated
       //$upload = new FileUpload($_FILES['file'], BASE_PATH.$directory.'/');
       if($resize_xy=='x')
         {
          $x = $resize;
          $y = intval($upload->imageHeight*$x/$upload->imageWidth);
         }
       else
         {
          $y = $resize;
          $x = intval($upload->imageWidth*$y/$upload->imageHeight);
         }
       if(!$upload->saveModifiedImage($x, $y, $compression, $file_name))
        {
         $errors[] = 'upload_error';
        }
      }
     else
      {
       #move_uploaded_file($_FILES['file']['tmp_name'], BASE_PATH.$directory.'/'.$file_name); // or $errors[] = 'upload_error';
       $upload->saveFile($file_name);
      }
     // create thumbnail:
     if(isset($_POST['create_thumbnail']) && $upload->isImage)
      {
       if($thumbnail_resize_xy=='x')
        {
         $thumbnail_x = $thumbnail_resize;
         $thumbnail_y = intval($upload->imageHeight*$thumbnail_x/$upload->imageWidth);
        }
       else
        {
         $thumbnail_y = $thumbnail_resize;
         $thumbnail_x = intval($upload->imageWidth*$thumbnail_y/$upload->imageHeight);
        }
       
       
       // set thumbnail name:
       if($settings['thumbnail_prefix'])
        {
         $thumbnail_filename = $settings['thumbnail_prefix'].$file_name;
        }
       elseif($settings['thumbnail_postfix'])
        {
         $ext_pos = strrpos($file_name, '.');
         $name = substr($file_name, 0, $ext_pos);
         $ext = substr($file_name, $ext_pos);
         $thumbnail_filename = $name.$settings['thumbnail_postfix'].$ext;
        }
       
       if(!$upload->saveModifiedImage($thumbnail_x, $thumbnail_y, $thumbnail_compression, $thumbnail_filename))
        {
         // error...
        }
      }               
    }
   if(empty($errors))
    {
     @chmod($path.$file_name, 0644);
     // save upload defaults:
     Database::$content->beginTransaction();
     $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['settings_table']." SET value=:value WHERE name=:name");
     $dbr->bindValue(':name', 'resize', PDO::PARAM_STR);
     $dbr->bindParam(':value', $resize, PDO::PARAM_STR);
     $dbr->execute();
     $dbr->bindValue(':name', 'resize_xy', PDO::PARAM_STR);
     $dbr->bindParam(':value', $resize_xy, PDO::PARAM_STR);
     $dbr->execute();
     $dbr->bindValue(':name', 'compression', PDO::PARAM_STR);
     $dbr->bindParam(':value', $compression, PDO::PARAM_STR);
     $dbr->execute();
     $dbr->bindValue(':name', 'thumbnail_resize', PDO::PARAM_STR);
     $dbr->bindParam(':value', $thumbnail_resize, PDO::PARAM_STR);
     $dbr->execute();
     $dbr->bindValue(':name', 'thumbnail_resize_xy', PDO::PARAM_STR);
     $dbr->bindParam(':value', $thumbnail_resize_xy, PDO::PARAM_STR);
     $dbr->execute();
     $dbr->bindValue(':name', 'thumbnail_compression', PDO::PARAM_STR);
     $dbr->bindParam(':value', $thumbnail_compression, PDO::PARAM_STR);
     $dbr->execute();

     Database::$content->commit();
     header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=filemanager&directory='.$directory.'&uploaded=true');
     exit();
    }
   else
    {
     $template->assign('errors', $errors);
     $action='upload';
    }
  }

  if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
  if(empty($action)) $action = 'main';

  switch($action)
   {
    case 'main':
     $fp=opendir($path);
     while($file = readdir($fp))
      {
       #if($file!='.' && $file!='..')
       if(is_file($path.$file))
        {
         $file_array[] = $file;
        }
      }
     closedir($fp);

     if(isset($file_array))
      {
       natcasesort($file_array);

       if(function_exists('mime_content_type'))
        {
         $mime_content_type=true;
         $template->assign('mime_content_type', $mime_content_type);
        }

       $i=0;
       foreach($file_array as $file)
        {
         $files[$i]['filename'] = htmlspecialchars($file);
         $files[$i]['size'] = number_format(filesize($path.$file)/1000,1,",",".");
         $files[$i]['last_modified'] = strftime(Localization::$lang['time_format'], filectime($path.$file));
         if(isset($mime_content_type))
          {
           $files[$i]['mime_content_type'] = mime_content_type($path.$file);
          }
         ++$i;
        }
       if(isset($files))
        {
         $template->assign('files', $files);
        }
      }
     if(isset($_GET['uploaded'])) $template->assign('uploaded', true);
     $template->assign('subtitle', Localization::$lang['filemanager']);
     $template->assign('subtemplate', 'filemanager.inc.tpl');
    break;
    case 'upload';
     $template->assign('subtitle', Localization::$lang['upload_file']);
     $template->assign('subtemplate', 'filemanager_upload.inc.tpl');

     break;
    case 'delete':
     $template->assign('subtitle', Localization::$lang['delete_file']);
     $template->assign('subtemplate', 'filemanager_delete.inc.tpl');
     break;
   }
 }
