<?php
class News
 {
  #var $news = false;
  public $total_pages;
  public $current_page = 1;
  public $news_per_page;
  public $category='';
  public $category_urlencoded='';
  public $wfw=false;
  private $id;
  #private $pdo;
  #private $db_settings;
  private $current_time;
  private $_localization;

  public function __construct($id, $news_per_page)
   {
    $this->id = $id;
    $this->news_per_page = $news_per_page;
    $this->current_time = time();
    $this->_localization = Localization::getInstance();

    $category_identifier_length = strlen(CATEGORY_IDENTIFIER);
    if(isset($_GET['get_1']) && substr($_GET['get_1'], 0, $category_identifier_length)==CATEGORY_IDENTIFIER) 
     {
      $this->category = str_replace(AMPERSAND_REPLACEMENT,'&',substr($_GET['get_1'],$category_identifier_length));
      $this->category_urlencoded = str_replace('%26',AMPERSAND_REPLACEMENT,urlencode($this->category));
     }

    if(isset($_GET['get_2'])) $this->current_page = intval($_GET['get_2']); else $this->current_page = 1;
    if($this->current_page==0) $this->current_page = 1;
   }

  public function get_news()
   {
    if($this->category)
     {
      $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['pages_table']." WHERE include_page=:include_page AND category=:category AND time<=:time AND status!=0");
      $dbr->bindParam(':category', $this->category, PDO::PARAM_STR);
     }
    else
     {
      $dbr = Database::$content->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['pages_table']." WHERE include_page=:include_page AND time<=:time AND status!=0");
     }
    $dbr->bindParam(':include_page', $this->id, PDO::PARAM_INT);
    $dbr->bindParam(':time', $this->current_time, PDO::PARAM_INT);
    $dbr->execute();
    $news_count = $dbr->fetchColumn();
    
    if($this->category && $news_count==0)
     {
      header('Location: '.BASE_URL.PAGE);
      exit;
     }

    $this->total_pages = ceil($news_count / $this->news_per_page);
    if($this->current_page>$this->total_pages) $this->current_page = $this->total_pages;

    $this->_localization->replacePlaceholder('current_page', $this->current_page, 'pagination');
    $this->_localization->replacePlaceholder('total_pages', $this->total_pages, 'pagination');
    
    if($this->category)
     {
      $dbr = Database::$content->prepare("SELECT id, page, title, page_title, category, type, time, teaser_headline, teaser, teaser_img, link_name, headline, content FROM ".Database::$db_settings['pages_table']." WHERE include_page=:include_page AND time<=:time AND category=:category AND status!=0 ORDER BY time DESC LIMIT ".(($this->current_page-1)*$this->news_per_page).", ".$this->news_per_page);
      $dbr->bindParam(':category', $this->category, PDO::PARAM_STR);
     }
    else
     {
      $dbr = Database::$content->prepare("SELECT id, page, title, page_title, category, type, time, teaser_headline, teaser, teaser_img, link_name, headline, content FROM ".Database::$db_settings['pages_table']." WHERE include_page=:include_page AND time<=:time AND status!=0 ORDER BY time DESC LIMIT ".(($this->current_page-1)*$this->news_per_page).", ".$this->news_per_page);
     } 
    $dbr->bindParam(':include_page', $this->id, PDO::PARAM_INT);
    $dbr->bindParam(':time', $this->current_time, PDO::PARAM_INT);
    $dbr->execute();
    $i=0;
    while($news_data = $dbr->fetch())
     {
      if($news_data['type']=='commentable_page')
       {
        $dbr2 = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE type=0 AND comment_id=:comment_id");
        $dbr2->bindParam(':comment_id', $news_data['id'], PDO::PARAM_INT);
        $dbr2->execute();
        #$comment_count = $dbr2->fetchColumn();
        $news[$i]['comments'] = $dbr2->fetchColumn();
        #$this->lang_replacements[$news_data['id']]['comments'] = $news[$i]['comments'];
        $this->_localization->bindId('number_of_comments', $news_data['id']);
        switch($news[$i]['comments'])
         {
          case 0:
           $this->_localization->selectBoundVariant('number_of_comments', $news_data['id'], 0);
           break;
          case 1:
           $this->_localization->selectBoundVariant('number_of_comments', $news_data['id'], 1);
           break;
          default:
           $this->_localization->selectBoundVariant('number_of_comments', $news_data['id'], 2);
           $this->_localization->replacePlaceholderBound('comments', $news[$i]['comments'], 'number_of_comments', $news_data['id']);
         }
       }

      $news[$i]['id'] = $news_data['id'];
      $news[$i]['category'] = $news_data['category'];
      $news[$i]['category_urlencoded'] = str_replace('%26',AMPERSAND_REPLACEMENT,urlencode($news_data['category']));

      $news[$i]['title'] = $news_data['title'];
      if($news_data['teaser_headline']!='')
       {
        $news[$i]['teaser_headline'] = $news_data['teaser_headline'];
       }
      elseif($news_data['headline']!='')
       {
        $news[$i]['teaser_headline'] = $news_data['headline'];
       }
      elseif($news_data['title']!='')
       {
        $news[$i]['teaser_headline'] = $news_data['title'];
       }
      elseif($news_data['page_title']!='')
       {
        $news[$i]['teaser_headline'] = $news_data['page_title'];
       }
      else
       {
        $news[$i]['teaser_headline'] = $news_data['page'];
       }
      if($news_data['teaser']!='')
       {
        $news[$i]['teaser'] = $news_data['teaser'];
        $news[$i]['more'] = true;
       }
      else
       {
        #if($news_data['content_formatting']==1)
        # {
        #  $news[$i]['teaser'] = auto_html($news_data['content']);
        # }
        #else
        # {
          $news[$i]['teaser'] = $news_data['content'];
        # }
        $news[$i]['teaser'] = parse_special_tags($news[$i]['teaser'], $news_data['page']);
        $news[$i]['more'] = false;
       }

      #$this -> news[$i]['teaser'] = stripslashes($teaser);
      $news[$i]['page'] = $news_data['page'];
      $news[$i]['timestamp'] = $news_data['time'];
      #$news[$i]['time'] = $news_data['time'];
      #$news[$i]['formated_time'] = format_time(TIME_FORMAT_FULL, $news_data['time']);

      #$this->lang_replacements[$news_data['id']]['time'] = $news_data['time'];

      $this->_localization->bindReplacePlaceholder($news_data['id'], 'time', $news_data['time'], 'news_time', Localization::FORMAT_TIME);

      #$loc->bind_id('news_time', $key);
      #$loc->replace_placeholder_bound('time', $val['time'], 'news_time', $key, Localization::FORMAT_TIME);

      if(trim($news_data['teaser_img']!=''))
       {
        $news[$i]['teaser_img'] = $news_data['teaser_img'];
        $teaser_img_info = getimagesize(BASE_PATH.MEDIA_DIR.$news_data['teaser_img']);
        $news[$i]['teaser_img_width'] = $teaser_img_info[0];
        $news[$i]['teaser_img_height'] = $teaser_img_info[1];
       }
      $news[$i]['link_name'] = stripslashes($news_data['link_name']);
      $i++;
     }
    if(isset($news)) return $news;
    return false;
   }
  
  public function get_feed($rss_maximum_items=20, $fullfeed=false)
   {
    $dbr = Database::$content->prepare("SELECT id, page, type, category, title, teaser, teaser_img, headline, content, time, last_modified FROM ".Database::$db_settings['pages_table']." WHERE include_page=:include_page AND time<=:time AND status!=0 ORDER BY time DESC LIMIT ".$rss_maximum_items);
    $dbr->bindParam(':include_page', $this->id, PDO::PARAM_INT);
    $dbr->bindParam(':time', $this->current_time, PDO::PARAM_INT);
    $dbr->execute();
   
    $i=0;
    while($rss_data = $dbr->fetch())
     {
      $rss_items[$i]['category'] = htmlspecialchars($rss_data['category']);
      $rss_items[$i]['title'] = htmlspecialchars($rss_data['title']);
  
      if($rss_data['headline'] && $fullfeed || empty($rss_data['teaser_headline'])) $rss_items[$i]['title'] = htmlspecialchars($rss_data['headline']);
      elseif($rss_data['teaser_headline']) $rss_items[$i]['title'] = htmlspecialchars($rss_data['teaser_headline']);
      else $rss_items[$i]['title'] = htmlspecialchars($rss_data['title']);
  
      if($fullfeed || $rss_data['teaser']=='')
       {
        #if($rss_data['content_formatting']==1)
        # {
        #  $rss_items[$i]['content'] = auto_html($rss_data['content']);
        # }
        #else
        # {
          $rss_items[$i]['content'] = $rss_data['content'];
        # }
        $rss_items[$i]['content'] = parse_special_tags($rss_items[$i]['content'], $parent_page=$rss_data['page'], $rss=true);
       }
      else
       {
        #if($rss_data['teaser_formatting']==1)
        # {
          $rss_items[$i]['content'] = auto_html($rss_data['teaser']);
        # }
        #else
        # {
          $rss_items[$i]['content'] = $rss_data['teaser'];
        # }
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
      if($rss_data['type']=='commentable_page')
       {
        $this->wfw = true;
        $rss_items[$i]['commentrss'] = BASE_URL.$rss_data['page'].',commentrss';
       }
      $i++;
     }
    if(isset($rss_items)) return $rss_items;
    return false;    
   }
 }
?>
