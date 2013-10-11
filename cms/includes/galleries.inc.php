<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(isset($_GET['edit']))
   {
    $dbr = Database::$content->prepare("SELECT id, gallery, sequence, photo_normal, photo_thumbnail, title, subtitle, description, description_formatting FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery ORDER BY sequence ASC");
    $dbr->bindParam(':gallery', $_GET['edit'], PDO::PARAM_STR);
    $dbr->execute();
    $i=0;
    while($data = $dbr->fetch())
     {
      $items[$i]['id'] = $data['id'];
      $items[$i]['gallery'] = $data['gallery'];
      $items[$i]['sequence'] = $data['sequence'];
      $items[$i]['photo_normal'] = $data['photo_normal'];
      $items[$i]['photo_thumbnail'] = $data['photo_thumbnail'];
      #$items[$i]['photo_large'] = $data['photo_large'];
      $items[$i]['title'] = $data['title'];
      $items[$i]['subtitle'] = $data['subtitle'];
      $items[$i]['description'] = $data['description'];
      #$items[$i]['description_formatting'] = $data['description_formatting'];
      #if(mb_strlen($item['description'],CHARSET) > 300) $description = mb_substr($item['description'],0,297,CHARSET)."..."; else $description = $item['description'];
      if($data['description_formatting']==1)
       {
        $items[$i]['description'] = auto_html($data['description']);
       }
      else
       {
        $items[$i]['description'] = $data['description'];
       }
      ++$i;
     }
    if(isset($items))
     {
      $template->assign('items',$items);
     }
    $template->assign('gallery',htmlspecialchars($_GET['edit']));
    $action = 'edit';
   }

  if(isset($_GET['new_photo']))
   {
    $photo_data['gallery'] = htmlspecialchars($_GET['new_photo']);
    $photo_data['description_formatting'] = 1;
    $template->assign('photo_data',$photo_data);
    $action = 'edit_photo';
   }

  if(isset($_GET['edit_photo']))
   {
    $dbr = Database::$content->prepare("SELECT id, gallery, photo_thumbnail, photo_normal, width, height, large_width, large_height, title, subtitle, description, description_formatting FROM ".Database::$db_settings['photo_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['edit_photo'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['id']))
     {
      $photo_data['id'] = intval($data['id']);
      $photo_data['gallery'] = htmlspecialchars($data['gallery']);
      $photo_data['photo_thumbnail'] = htmlspecialchars($data['photo_thumbnail']);
      $photo_data['photo_normal'] = htmlspecialchars($data['photo_normal']);
      #$photo_data['photo_large'] = htmlspecialchars($data['photo_large']);
      $photo_data['width'] = $data['width']>0 ? $data['width'] : '';
      $photo_data['height'] = $data['height']>0 ? $data['height'] : '';
      $photo_data['large_width'] = $data['large_width']>0 ? $data['large_width'] : '';
      $photo_data['large_height'] = $data['large_height']>0 ? $data['large_height'] : '';
      $photo_data['title'] = htmlspecialchars($data['title']);
      $photo_data['subtitle'] = htmlspecialchars($data['subtitle']);
      $photo_data['description'] = htmlspecialchars($data['description']);
      $photo_data['description_formatting'] = intval($data['description_formatting']);
      $template->assign('photo_data', $photo_data);
     }
    else
     {
      $template->assign('invalid_photo', true);
     }
    $action = 'edit_photo';
   }

  if(isset($_REQUEST['delete_gallery']))
   {
    if(isset($_REQUEST['confirmed']))
     {
      // get photo ids:
      $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery");
      $dbr->bindValue(':gallery', trim($_REQUEST['delete_gallery']), PDO::PARAM_STR);
      $dbr->execute();
      // delete comments:
      $dbr2 = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE comment_id=:id AND type=1");
      $dbr2->bindParam(':id', $data['id'], PDO::PARAM_INT);
      Database::$entries->beginTransaction();
      while($data = $dbr->fetch())
       {
        $dbr2->execute();
       }
      Database::$entries->commit();
      // delete gallery:
      $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery");
      $dbr->bindParam(':gallery', $_REQUEST['delete_gallery'], PDO::PARAM_STR);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries');
      exit;
     }
    else
     {
      $template->assign('gallery',htmlspecialchars($_REQUEST['delete_gallery']));
      $action = 'delete_gallery';
     }
   }

  if(isset($_POST['new_gallery_name']))
   {
    $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['photo_table']." WHERE lower(gallery)=:gallery");
    $dbr->bindValue(':gallery', strtolower($_POST['new_gallery_name']), PDO::PARAM_STR);
    $dbr->execute();
    $gallery_count = $dbr-> fetchColumn();
    if($gallery_count > 0)
     {
      $errors[] = 'gallery_name_alr_exists';
     }
    elseif(!preg_match(VALID_URL_CHARACTERS, $_POST['new_gallery_name']))
     {
      $errors[] = 'error_gallery_spec_chars';
     }
    if(empty($errors))
     {
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries&edit='.trim($_POST['new_gallery_name']));
      exit;
     }
    else
     {
      $template->assign('errors', $errors);
      $template->assign('new_gallery_name', htmlspecialchars($_POST['new_gallery_name']));
      $action = 'new';
     }
   }

  if(isset($_GET['move_up_photo']))
   {
    $dbr = Database::$content->prepare("SELECT gallery, sequence FROM ".Database::$db_settings['photo_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['move_up_photo'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['sequence']) && $data['sequence'] > 1)
     {
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['photo_table']." SET sequence=:new_sequence WHERE gallery=:gallery AND sequence=:sequence");
      $dbr->bindParam(':gallery', $data['gallery'], PDO::PARAM_STR);
      $dbr->bindValue(':new_sequence', 0, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence']-1, PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence']-1, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->bindValue(':sequence', 0, PDO::PARAM_INT);
      $dbr->execute();
      Database::$content->commit();
     }
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries&edit='.$data['gallery']);
    exit;
   }

  if(isset($_GET['move_down_photo']))
   {
    $dbr = Database::$content->prepare("SELECT gallery, sequence FROM ".Database::$db_settings['photo_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['move_down_photo'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(isset($data['sequence']))
     {
      $dbr = Database::$content->prepare("SELECT sequence FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery ORDER BY sequence DESC LIMIT 1");
      $dbr->bindParam(':gallery', $data['gallery'], PDO::PARAM_STR);
      $dbr->execute();
      $last = $dbr->fetchColumn();
      if($data['sequence'] < $last)
       {
        Database::$content->beginTransaction();
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['photo_table']." SET sequence=:new_sequence WHERE gallery=:gallery AND sequence=:sequence");
        $dbr->bindParam(':gallery', $data['gallery'], PDO::PARAM_STR);
        $dbr->bindValue(':new_sequence', 0, PDO::PARAM_INT);
        $dbr->bindValue(':sequence', $data['sequence']+1, PDO::PARAM_INT);
        $dbr->execute();
        $dbr->bindValue(':new_sequence', $data['sequence']+1, PDO::PARAM_INT);
        $dbr->bindValue(':sequence', $data['sequence'], PDO::PARAM_INT);
        $dbr->execute();
        $dbr->bindValue(':new_sequence', $data['sequence'], PDO::PARAM_INT);
        $dbr->bindValue(':sequence', 0, PDO::PARAM_INT);
        $dbr->execute();
        Database::$content->commit();
       }
      if(isset($cache) && $cache->autoClear) $cache->clear();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries&edit='.$data['gallery']);
      exit;
     }
   }

  if(isset($_REQUEST['reorder_photos']) && isset($_REQUEST['item']))
   {
    $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['photo_table']." SET sequence=:sequence WHERE id=:id");
    $dbr->bindParam(':id', $id, PDO::PARAM_INT);
    $dbr->bindParam(':sequence', $sequence, PDO::PARAM_INT);
    Database::$content->beginTransaction();
    $sequence = 1;
    foreach($_REQUEST['item'] as $id)
     {
      $dbr->execute();
      ++$sequence;
     }
    Database::$content->commit();
    if(isset($cache) && $cache->autoClear) $cache->clear();
    exit;
   }

  if(isset($_POST['edit_photo_submitted']))
   {
    // get posted data:
    $gallery = isset($_POST['gallery']) ? trim($_POST['gallery']) : '';
    $photo_thumbnail = isset($_POST['photo_thumbnail']) ? trim($_POST['photo_thumbnail']) : '';
    $photo_normal = isset($_POST['photo_normal']) ? trim($_POST['photo_normal']) : '';
    #$photo_large = isset($_POST['photo_large']) ? trim($_POST['photo_large']) : '';
    $width = isset($_POST['width']) ? intval($_POST['width']) : 0;
    $height = isset($_POST['height']) ? intval($_POST['height']) : 0;
    $large_width = isset($_POST['large_width']) ? intval($_POST['large_width']) : 0;
    $large_height = isset($_POST['large_height']) ? intval($_POST['large_height']) : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $description_formatting = isset($_POST['description_formatting']) && $_POST['description_formatting']==1 ? 1 : 0;
    #showme($description_formatting);
    // check data:
    if(empty($gallery)) $errors[] = 'error_no_gallery';
    if(empty($photo_thumbnail)) $errors[] = 'error_no_thumbnail';
    if(empty($photo_normal)) $errors[] = 'error_no_photo';
    if(empty($title)) $errors[] = 'error_no_photo_title';

    if(empty($errors))
     {
      if(!file_exists(BASE_PATH.MEDIA_DIR.$photo_thumbnail))
       {
        $errors[] = 'err_photo_t_doesnt_exist';
       }
      if(substr(strtolower($photo_thumbnail), -4) != '.jpg' && substr(strtolower($photo_thumbnail), -5)!= '.jpeg' && substr(strtolower($photo_thumbnail), -4)!= '.gif' && substr(strtolower($photo_thumbnail), -4)!= '.png')
       {
        $errors[] = 'err_image_type';
       }
      if(!file_exists(BASE_PATH.MEDIA_DIR.$photo_normal))
       {
        $errors[] = 'err_photo_n_doesnt_exist';
       }
      #if(trim($_POST['photo_large']) !='' && !file_exists(BASE_PATH.MEDIA_DIR.$photo_large))
      # {
      #  $errors[] = 'err_photo_l_doesnt_exist';
      # }
     }

    if(empty($errors))
     {
      if(isset($_POST['id']))
       {
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['photo_table']." SET photo_thumbnail=:photo_thumbnail, photo_normal=:photo_normal, width=:width, height=:height, large_width=:large_width, large_height=:large_height, title=:title, subtitle=:subtitle, description=:description, description_formatting=:description_formatting WHERE id=:id");
        $dbr->bindParam(':photo_thumbnail', $photo_thumbnail, PDO::PARAM_STR);
        $dbr->bindParam(':photo_normal', $photo_normal, PDO::PARAM_STR);
        #$dbr->bindParam(':photo_large', $photo_large, PDO::PARAM_STR);
        $dbr->bindParam(':width', $width, PDO::PARAM_INT);
        $dbr->bindParam(':height', $height, PDO::PARAM_INT);
        $dbr->bindParam(':large_width', $large_width, PDO::PARAM_INT);
        $dbr->bindParam(':large_height', $large_height, PDO::PARAM_INT);
        $dbr->bindParam(':title', $title, PDO::PARAM_STR);
        $dbr->bindParam(':subtitle', $subtitle, PDO::PARAM_STR);
        $dbr->bindParam(':description', $description, PDO::PARAM_STR);
        $dbr->bindParam(':description_formatting', $description_formatting, PDO::PARAM_INT);
        $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $dbr->execute();
       }
      else
       {
        // get gallery info and latest order nr.:
        $dbr = Database::$content->prepare("SELECT sequence,template,photos_per_row FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery ORDER BY sequence DESC LIMIT 1");
        $dbr->bindParam(':gallery', $gallery, PDO::PARAM_STR);
        $dbr->execute();
        $data = $dbr->fetch();
        if(isset($data['sequence']))
         {
          $new_sequence = intval($data['sequence'])+1;
          $template = $data['template'];
          $photos_per_row = $data['photos_per_row'];
         }
        else
         {
          $new_sequence = 1;
          $template = $settings['default_photo_template'];
          $photos_per_row = $settings['default_photos_per_row'];
         }
        // insert photo:
        $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['photo_table']." (gallery,sequence,photo_thumbnail,photo_normal,width,height,large_width,large_height,title,subtitle,description,description_formatting,template,photos_per_row) VALUES (:gallery, :sequence, :photo_thumbnail, :photo_normal, :width, :height, :large_width, :large_height, :title, :subtitle, :description, :description_formatting, :template, :photos_per_row)");
        $dbr->bindParam(':gallery', $gallery, PDO::PARAM_STR);
        $dbr->bindParam(':sequence', $new_sequence, PDO::PARAM_INT);
        $dbr->bindParam(':photo_thumbnail', $photo_thumbnail, PDO::PARAM_STR);
        $dbr->bindParam(':photo_normal', $photo_normal, PDO::PARAM_STR);
        #$dbr->bindParam(':photo_large', $photo_large, PDO::PARAM_STR);
        $dbr->bindParam(':width', $width, PDO::PARAM_INT);
        $dbr->bindParam(':height', $height, PDO::PARAM_INT);
        $dbr->bindParam(':large_width', $large_width, PDO::PARAM_INT);
        $dbr->bindParam(':large_height', $large_height, PDO::PARAM_INT);
        $dbr->bindParam(':title', $title, PDO::PARAM_STR);
        $dbr->bindParam(':subtitle', $subtitle, PDO::PARAM_STR);
        $dbr->bindParam(':description', $description, PDO::PARAM_STR);
        $dbr->bindParam(':description_formatting', $description_formatting, PDO::PARAM_INT);
        $dbr->bindParam(':template', $template, PDO::PARAM_STR);
        $dbr->bindParam(':photos_per_row', $photos_per_row, PDO::PARAM_INT);
        $dbr->execute();
       }
      if(isset($cache) && $cache->autoClear) $cache->clear();
      $id = isset($_POST['id']) ? $_POST['id'] : Database::$content->lastInsertId();
      header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries&edit='.$gallery.'#id_'.$id);
      exit;
     }
    else
     {
      if(isset($_POST['id'])) $photo_data['id'] = intval($_POST['id']);
      $photo_data['gallery'] = isset($_POST['gallery']) ? htmlspecialchars($_POST['gallery']) : '';
      $photo_data['photo_thumbnail'] = isset($_POST['photo_thumbnail']) ? htmlspecialchars($_POST['photo_thumbnail']) : '';
      $photo_data['photo_normal'] = isset($_POST['photo_normal']) ? htmlspecialchars($_POST['photo_normal']) : '';
      #$photo_data['photo_large'] = isset($_POST['photo_large']) ? htmlspecialchars($_POST['photo_large']) : '';
      $photo_data['width'] = isset($_POST['width']) && $_POST['width'] > 0 ? intval($_POST['width']) : '';
      $photo_data['height'] = isset($_POST['height'])  && $_POST['height'] > 0 ? intval($_POST['height']) : '';
      $photo_data['large_width'] = isset($_POST['large_width'])  && $_POST['large_width'] > 0 ? intval($_POST['large_width']) : '';
      $photo_data['large_height'] = isset($_POST['large_height']) && $_POST['large_height'] > 0 ? intval($_POST['large_height']) : '';
      $photo_data['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
      $photo_data['subtitle'] = isset($_POST['subtitle']) ? htmlspecialchars($_POST['subtitle']) : '';
      $photo_data['description'] = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
      $photo_data['description_formatting'] = isset($_POST['description_formatting']) && $_POST['description_formatting']==1 ? 1 : 0;
      $template->assign('errors',$errors);
      $template->assign('photo_data',$photo_data);
      $action='edit_photo';
     }
   }

  if(isset($_GET['delete_photo']))
   {
    // get gallery:
    $dbr = Database::$content->prepare("SELECT gallery FROM ".Database::$db_settings['photo_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_GET['delete_photo'], PDO::PARAM_INT);
    $dbr->execute();
    $gallery = $dbr->fetchColumn();
    // delete photo:
    $dbr = Database::$content->prepare("DELETE FROM ".Database::$db_settings['photo_table']." WHERE id=:id");
    $dbr->bindParam(':id', $_GET['delete_photo'], PDO::PARAM_INT);
    $dbr->execute();
    // delete photo comments:
    $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE type=1 AND comment_id=:id");
    $dbr->bindParam(':id', $_GET['delete_photo'], PDO::PARAM_INT);
    $dbr->execute();
    // reorder photos:
    $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery ORDER BY sequence ASC");
    $dbr->bindParam(':gallery', $gallery, PDO::PARAM_STR);
    $dbr->execute();
    while($data = $dbr->fetch())
     {
      $ids[] = $data['id'];
     }
    if(isset($ids))
     {
      $new_sequence = 1;
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['photo_table']." SET sequence=:sequence where id=:id");
      $dbr->bindParam(':sequence', $new_sequence, PDO::PARAM_INT);
      $dbr->bindParam(':id', $id, PDO::PARAM_INT);
      foreach($ids as $id)
       {
        $dbr->execute();
        ++$new_sequence;
       }
      Database::$content->commit();
     }
    if(isset($cache) && $cache->autoClear) $cache->clear();
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries&edit='.$gallery);
    exit;
   }

  if(isset($_POST['gallery_properties_submit']))
   {
    $template = isset($_POST['template']) ? trim($_POST['template']) : $settings['default_photo_template'];
    $photos_per_row = isset($_POST['photos_per_row']) ? intval($_POST['photos_per_row']) : $settings['default_photos_per_row'];
    $gallery = isset($_POST['gallery']) ? trim($_POST['gallery']) : '';
    if(!empty($gallery))
     {
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['photo_table']." SET template=:template, photos_per_row=:photos_per_row WHERE gallery=:gallery");
      $dbr->bindParam(':template', $template, PDO::PARAM_STR);
      $dbr->bindParam(':photos_per_row', $photos_per_row, PDO::PARAM_INT);
      $dbr->bindParam(':gallery', $gallery, PDO::PARAM_STR);
      $dbr->execute();
      if(isset($cache) && $cache->autoClear) $cache->clear();
     }
    header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=galleries&edit='.htmlspecialchars($_POST['gallery']));
    exit;
   }

  if(isset($_GET['action'])) $action = $_GET['action'];
  if(isset($_POST['action'])) $action = $_POST['action'];
  if(empty($action)) $action='show_galleries';

  switch($action)
   {
    case 'show_galleries':
     $dbr = Database::$content->query("SELECT DISTINCT gallery FROM ".Database::$db_settings['photo_table']." ORDER BY gallery ASC");
     while($data = $dbr->fetch())
      {
       $galleries[] = htmlspecialchars($data['gallery']);
      }
     if(isset($galleries))
      {
       $template->assign('galleries',$galleries);
      }
     $template->assign('subtitle', Localization::$lang['photo_galleries']);
     $template->assign('subtemplate', 'galleries.inc.tpl');
     break;
    case 'edit':
     $template->assign('subtitle', Localization::$lang['photo_galleries']);
     $template->assign('subtemplate','galleries_edit.inc.tpl');
    break;
    case 'delete_gallery':
     $template->assign('subtitle', Localization::$lang['delete_gallery']);
     $template->assign('subtemplate','galleries_delete.inc.tpl');
     break;
    case 'new':
     $template->assign('subtitle', Localization::$lang['photo_galleries']);
     $template->assign('subtemplate','galleries_new.inc.tpl');
    break;
    case 'gallery_properties':
     $template->assign('subtitle', Localization::$lang['photo_galleries']);
     $template->assign('subtemplate','galleries_properties.inc.tpl');
     break;
    case 'edit_photo':
     $template->assign('subtitle', Localization::$lang['photo_galleries']);
     $template->assign('subtemplate','galleries_edit_photo.inc.tpl');
     break;
   }
 }
