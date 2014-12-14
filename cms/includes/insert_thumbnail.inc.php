<?php
if(!defined('IN_INDEX')) exit;

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

  #if(isset($_GET['form'])) $form = $_GET['form'];
  #if(isset($_GET['field'])) $field = $_GET['field'];
  #if(isset($_GET['insert_mode'])) $insert_mode = intval($_GET['insert_mode']);
  #if(isset($_POST['form'])) $form = $_POST['form'];
  #if(isset($_POST['field'])) $field = $_POST['field'];
  #if(isset($_POST['insert_mode'])) $insert_mode = intval($_POST['insert_mode']);
  #if(empty($insert_mode)) $insert_mode = $insert_mode = 0;

   if(isset($_POST['gallery']))
    {
     $dbr = Database::$content->prepare("SELECT id, title, photo_thumbnail FROM ".Database::$db_settings['photo_table']." WHERE gallery=:gallery ORDER BY gallery ASC, sequence ASC");
     $dbr->bindParam(':gallery', $_POST['gallery'], PDO::PARAM_STR);
     $dbr->execute();
     $i=0;
     while($data = $dbr->fetch())
      {
       $items[$i]['id'] = $data['id'];
       $items[$i]['title'] = $data['title'];
       $items[$i]['photo_thumbnail'] = $data['photo_thumbnail'];
       ++$i;
      }
     if(isset($items))
      {
       $template->assign('items',$items);
      }

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

  if(empty($action)) $action = 'main';

  switch ($action)
   {
    case 'main':
     $dbr = Database::$content->query("SELECT DISTINCT gallery FROM ".Database::$db_settings['photo_table']." ORDER BY gallery ASC");
     while($data = $dbr->fetch())
      {
       $galleries[] = htmlspecialchars($data['gallery']);
      }
     if(isset($galleries))
      {
       $template->assign('galleries',$galleries);
      }
     break;
   }

  $template_file = 'insert_thumbnail.tpl';
 }
?>
