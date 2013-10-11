<?php
class Gallery
 {
  public $photos = false;
  public $number_of_photos = 0;
  public $photos_per_row = 4;
  private $_localization;

  public function __construct($gallery, $commentable=0)
   {
    $this->_localization = Localization::getInstance();

    $dbr = Database::$content->prepare('SELECT id, photo_thumbnail, photo_normal, title, subtitle, description, photos_per_row FROM '.Database::$db_settings['photo_table'].' WHERE gallery=:gallery ORDER BY sequence ASC');
    $dbr->bindParam(':gallery', $gallery, PDO::PARAM_STR);
    $dbr->execute();

    $i=0;
    while($photo_data = $dbr->fetch())
     {
      if($commentable==1)
       {
        $count_result = Database::$entries->prepare('SELECT COUNT(*) AS comments FROM '.Database::$db_settings['comment_table'].' WHERE comment_id=:id AND type=1');
        $count_result->bindValue(':id', $photo_data['id'], PDO::PARAM_INT);
        $count_result->execute();
        $count_data = $count_result->fetch();
        $this->photos[$i]['comments'] = $count_data['comments'];
        $this->_localization->bindId('number_of_comments', $photo_data['id']);
        switch($count_data['comments'])
         {
          case 0:
           $this->_localization->selectBoundVariant('number_of_comments', $photo_data['id'], 0);
           break;
          case 1:
           $this->_localization->selectBoundVariant('number_of_comments', $photo_data['id'], 1);
           break;
          default:
           $this->_localization->selectBoundVariant('number_of_comments', $photo_data['id'], 2);
           $this->_localization->replacePlaceholderBound('comments', $count_data['comments'], 'number_of_comments', $photo_data['id']);
         }
       }
      $this->photos[$i]['id'] = $photo_data['id'];
      $this->photos[$i]['photo_thumbnail'] = $photo_data['photo_thumbnail'];
      $this->photos[$i]['photo_normal'] = $photo_data['photo_normal'];
      $this->photos[$i]['title'] = htmlspecialchars($photo_data['title']);
      $this->photos[$i]['subtitle'] = htmlspecialchars($photo_data['subtitle']);
      $this->photos[$i]['description'] = htmlspecialchars($photo_data['description']);
      $thumbnail_info = getimagesize(MEDIA_DIR.$photo_data['photo_thumbnail']);
      $this->photos[$i]['width'] = $thumbnail_info[0];
      $this->photos[$i]['height'] = $thumbnail_info[1];
      $this->photos_per_row = $photo_data['photos_per_row'];
      $i++;
     }
    $this->number_of_photos = $i;
   }
 }
?>
