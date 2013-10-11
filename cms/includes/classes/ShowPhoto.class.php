<?php
class ShowPhoto
 {
  var $photo_data;
  var $show_comments = 0;
  var $photo_nr;
  var $photo_size = 0;

  function ShowPhoto($photo_id)
   {
    #global $settings, $db_settings, $pdo;
    #if(empty($qsp[2])) $qsp[2]=0;
    if(isset($_GET['get_3']) && $_GET['get_3']!=0) $photo_size = 1;
    else $photo_size = 0;

    if(isset($_GET['get_4'])) $this->show_comments = 1;
    else $this->show_comments = 0;

    $photo_id = intval($photo_id);

    $photo_result = Database::$content->prepare('SELECT id, gallery, sequence, photo_thumbnail, photo_normal, photo_large, width, height, large_height, large_width, title, subtitle, description, description_formatting, template FROM '.Database::$db_settings['photo_table'].' WHERE id=:id LIMIT 1');
    $photo_result->bindValue(':id', $photo_id, PDO::PARAM_INT);
    $photo_result->execute();
    $photo_data = $photo_result->fetch();

    if(isset($photo_data['id']))
     {
      // get ids of photos of current gallery:
      $gallery_result = Database::$content->prepare('SELECT id FROM '.Database::$db_settings['photo_table'].' WHERE gallery=:gallery ORDER BY sequence ASC');
      $gallery_result->bindValue(':gallery', $photo_data['gallery'], PDO::PARAM_STR);
      $gallery_result->execute();
      while($gallery_data = $gallery_result->fetch())
       {
        $gallery_items[] = $gallery_data['id'];
       }
      $total_photos = count($gallery_items);
      $current_photo_key = array_search($photo_data['id'], $gallery_items);
      // get id of first, last, next and previous photo:
      $first_photo = $gallery_items[0];
      $last_photo = $gallery_items[$total_photos-1];
      if(isset($gallery_items[$current_photo_key+1]))
       {
        $next_photo = $gallery_items[$current_photo_key+1];
       }
      else
       {
        $next_photo = $first_photo;
       }
      if(isset($gallery_items[$current_photo_key-1]))
       {
        $previous_photo = $gallery_items[$current_photo_key-1];
       }
      else
       {
        $previous_photo = $last_photo;
       }
      if($previous_photo==$photo_id)
       {
        $previous_photo = 0;
        $next_photo = 0;
       }

      $this->photo_data['id'] = $photo_id;
      $this->photo_data['gallery'] = $photo_data['gallery'];
      $this->photo_data['gallery_items'] = $gallery_items;
      $this->photo_data['previous_photo'] = $previous_photo;
      $this->photo_data['next_photo'] = $next_photo;
      $this->photo_data['total_photos'] = $total_photos;
      $this->photo_data['photo_number'] = $current_photo_key+1;

      $this->photo_data['photo_size'] = $photo_size;
      if($photo_data['photo_large']!='') $this->photo_data['photo_large_available'] = 1;

      if($photo_size==1 && $photo_data['photo_large']!='') $this->photo_data['photo'] = $photo_data['photo_large'];
      else $this->photo_data['photo'] = $photo_data['photo_normal'];
      $this->photo_data['photo_large'] = $photo_data['photo_large'];
      $this->photo_data['thumbnail'] = $photo_data['photo_thumbnail'];

      $this->photo_data['title'] = $photo_data['title'];
      $this->photo_data['subtitle'] = $photo_data['subtitle'];
      if($photo_data['description_formatting']==1)
       {
        $this->photo_data['description'] = auto_html($photo_data['description']);
       }
      else
       {
        $this->photo_data['description'] = $photo_data['description'];
       }


      if(substr(strtolower($this->photo_data['photo']), -4) == '.swf')
       {
        $this->photo_data['type'] = 'flash';
        if($this->photo_data['photo_size']==1)
         {
          $this->photo_data['width'] = intval($photo_data['large_width']);
          $this->photo_data['height'] = intval($photo_data['large_height']);
         }
        else
         {
          $this->photo_data['width'] = intval($photo_data['width']);
          $this->photo_data['height'] = intval($photo_data['height']);
         }
       }
      elseif(substr(strtolower($this->photo_data['photo']), -4) == '.flv')
       {
        $this->photo_data['type'] = 'flv';
        if($this->photo_data['photo_size']==1)
         {
          $this->photo_data['width'] = intval($photo_data['large_width']);
          $this->photo_data['height'] = intval($photo_data['large_height']);
         }
        else
         {
          $this->photo_data['width'] = intval($photo_data['width']);
          $this->photo_data['height'] = intval($photo_data['height']);
         }
       }
      else
       {
        $this->photo_data['type'] = 'image';
        $photo_info = getimagesize(BASE_PATH.MEDIA_DIR.$this -> photo_data['photo']);
        $this->photo_data['width'] = $photo_info[0];
        $this->photo_data['height'] = $photo_info[1];
       }
      $this->photo_data['template'] = $photo_data['template'];
      #$this -> photo_data['language_file'] = $photo_data['language_file'];
      #$this -> photo_data['language_file'] = $language_file;
     }
    #return $this->photo_data;
   }

  function get_photo_data()
   {
    return $this->photo_data;
   }

  function show_comments()
  {
   return $this->show_comments;
  }
 }
?>
