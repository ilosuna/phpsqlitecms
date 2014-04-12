<?php
class Comment
 {
  public $comments_per_page = 10;
  public $comment_order = 0;
  public $name_maxlength = 100;
  public $email_hp_maxlength = 100;
  public $word_maxlength = 50;
  public $comment_maxlength = 1000;
  public $prevent_repeated_posts_minutes = 2;
  public $akismet_key = '';
  public $akismet_entry_check = 0;
  public $remove_blank_lines = 1;
  public $auto_link = 1;
  public $smilies = 1;
  public $comments_closed = false;

  public $total_comments;
  public $total_pages;
  public $current_page = 1;
  public $errors = false;
  public $comments_info;
  public $form_values;
  public $edit_form = false;
  public $type = 0;
  public $page;
  public $comment_id;
  public $form_session = false;
  public $form_session_data = false;
  public $setings;
  public $admin_mode = false;
  private $_localization;
  private $_form_session = 'comment_form_session';

  public function __construct($page, $comment_id, $type=0)
   {
    $this->_localization = Localization::getInstance();
    $this->type = $type;
    $this->page = $page;
    $this->comment_id = $comment_id;
    $this->form_values['comment_text'] = isset($_POST['comment_text']) ? htmlspecialchars($_POST['comment_text']) : '';
    $this->form_values['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $this->form_values['email_hp'] = isset($_POST['email_hp']) ? htmlspecialchars($_POST['email_hp']) : '';
    $this->_form_session = 'comment_form_session_'.$this->comment_id.'_'.$this->type;

    if($this->type==1)
     {
      if(isset($_GET['get_5'])) $this->current_page = intval($_GET['get_5']); else $this->current_page = 1;
     }
    else
     {
      if(isset($_GET['get_1'])) $this->current_page = intval($_GET['get_1']); else $this->current_page = 1;
     }

    if($this->current_page==0) $this->current_page = 1;


    if(isset($_SESSION[$this->_form_session]))
     {
      $this->form_session = $_SESSION[$this->_form_session];
      $form_session_data['name'] = session_name();
      $form_session_data['id'] = session_id();
      $this->form_session_data = $form_session_data;
     }
   }

  public function set_admin_mode()
   {
    $this->admin_mode = true;
   }

  public function get_comments($rss=false)
   {
    // count:
    $this->total_comments = $this->count_comments($this->comment_id);

    $this->total_pages = ceil($this->total_comments / $this->comments_per_page);
    if($this->current_page>$this->total_pages) $this->current_page = $this->total_pages;

    #$this->comment_page = $current_page;

     if($this->total_comments > 0)
      {
       if($this->comment_order) $order = 'DESC';
       else $order = 'ASC';
       if($rss) $dbr = Database::$entries->prepare("SELECT id, time, name, email_hp, comment, ip FROM ".Database::$db_settings['comment_table']." WHERE type=:type AND comment_id=:comment_id AND comment!='' ORDER BY id ASC LIMIT ".$this->comments_per_page);
       else $dbr = Database::$entries->prepare("SELECT id, time, name, email_hp, comment, ip FROM ".Database::$db_settings['comment_table']." WHERE type=:type AND comment_id=:comment_id AND comment!='' ORDER BY id ".$order." LIMIT ".$this->comments_per_page." OFFSET ".(intval($this->current_page)-1)*$this->comments_per_page);
       $dbr->bindParam(':type', $this->type, PDO::PARAM_INT);
       $dbr->bindParam(':comment_id', $this->comment_id, PDO::PARAM_INT);
       $dbr->execute();

       $nr = 1;
       $i = 0;
       while($data = $dbr->fetch())
        {
         #if ($data['name'] != "") $name = htmlspecialchars(stripslashes($data['name'])); else $name = $this->settings['anonym'];
         if($data['email_hp']!='')
          {
           $email_hp = htmlspecialchars($data['email_hp']);
           if(preg_match("/^[^@]+@.+\.\D{2,5}$/", $email_hp))
            {
             if($this->admin_mode)
              {
               $comments[$i]['email'] = $email_hp;
              }
            }
           else
            {
             $comments[$i]['hp'] = add_http_if_no_protocol($email_hp);
            }
          }
         $comments[$i]['id'] = $data['id'];
         if($this->comment_order) $comments[$i]['nr'] = $this->total_comments + 1 - ($nr + ($this->current_page-1) * $this->comments_per_page);
         else $comments[$i]['nr'] = ($nr + ($this->current_page-1) * $this->comments_per_page);
         $comments[$i]['name'] = htmlspecialchars($data['name']);
         $comments[$i]['time'] = $data['time'];
         #$comments[$i]['formated_time'] = format_time(TIME_FORMAT_FULL,$data['time']);
         $comments[$i]['comment'] = $this->format_comment($data['comment']);
         $comments[$i]['ip'] = $data['ip'];

         $this->_localization->bindId('comment_time', $data['id']);
         $this->_localization->replacePlaceholderBound('time', $data['time'], 'comment_time', $data['id'], Localization::FORMAT_TIME);

         ++$nr;
         ++$i;
        } // end foreach

       // reverse array for ascending order:
       #if($this->comment_order == 1) $comments = array_reverse($comments);

       $this->_localization->replacePlaceholder('total_comments', $this->total_comments, 'comments_pagination_info');
       $this->_localization->replacePlaceholder('current_page', $this->current_page, 'comments_pagination_info');
       $this->_localization->replacePlaceholder('total_pages', $this->total_pages, 'comments_pagination_info');

       #$this->assign_lang_placeholder('total_comments', $this->total_comments, 'comments_pagination_info');
       #$this->assign_lang_placeholder('current_page', $this->current_page, 'comments_pagination_info');
       #$this->assign_lang_placeholder('total_pages', $this->total_pages, 'comments_pagination_info');

      } // end if ($comment_count > 0)

    $this->form_values = $this->get_form_values();

    if(isset($comments))
     {
      return $comments;
     }
    return false;
   }

  public function get_pingbacks()
   {
    $dbr = Database::$entries->prepare("SELECT id, time, name, email_hp, comment, ip FROM ".Database::$db_settings['comment_table']." WHERE type=:type AND comment_id=:comment_id AND comment='' ORDER BY id DESC");
    $dbr->bindParam(':type', $this->type, PDO::PARAM_INT);
    $dbr->bindParam(':comment_id', $this->comment_id, PDO::PARAM_INT);
    $dbr->execute();

       $nr = 1;
       $i = 0;
       while($data = $dbr->fetch())
        {
         $pingbacks[$i]['hp'] = $data['email_hp'];
         $pingbacks[$i]['id'] = $data['id'];
         $pingbacks[$i]['nr'] = $this->total_comments + 1 - ($nr + ($this->current_page-1) * $this->comments_per_page);
         $pingbacks[$i]['name'] = htmlspecialchars($data['name']);
         $pingbacks[$i]['time'] = $data['time'];
         #$pingbacks[$i]['formated_time'] = format_time(TIME_FORMAT_FULL,$data['time']);
         #$pingbacks[$i]['comment'] = $this->format_comment($data['comment']);
         $pingbacks[$i]['ip'] = $data['ip'];

         $this->_localization->bindId('comment_time', $data['id']);
         $this->_localization->replacePlaceholderBound('time', $data['time'], 'comment_time', $data['id'], Localization::FORMAT_TIME);

         ++$nr;
         ++$i;
        } // end foreach

       // reverse array for ascending order:
       #if($this->comment_order == 1 && isset($pingbacks)) $pingbacks = array_reverse($pingbacks);


    #$this->form_values = $this->get_form_values();

    if(isset($pingbacks))
     {
      return $pingbacks;
     }
    return false;
   }

  public function save()
   {
    if(empty($_SESSION[$this->_form_session]))
     {
      #$this->preview();
     }
    else
     {
      // if comment entered::
      $data['comment_text'] = isset($_POST['comment_text']) ? trim(filter_control_characters($_POST['comment_text'])) : '';
      $data['name'] = isset($_POST['name']) ? trim(filter_control_characters($_POST['name'])) : '';
      $data['email_hp'] = isset($_POST['email_hp']) ? trim(filter_control_characters($_POST['email_hp'])) : '';

      // check posted data:
      $this->check_data($data, true);

      // save if no errors:
      if($this->errors==false)
       {
        $dbr = Database::$entries->prepare("INSERT INTO ".Database::$db_settings['comment_table']." (type, comment_id, time, ip, name, email_hp, comment) VALUES (:type, :comment_id, :time, :ip, :name, :email_hp, :comment)");
        $dbr->bindParam(':type', $this->type, PDO::PARAM_INT);
        $dbr->bindParam(':comment_id', $this->comment_id, PDO::PARAM_INT);
        $dbr->bindValue(':time', time(), PDO::PARAM_INT);
        $dbr->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
        $dbr->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $dbr->bindParam(':email_hp', $data['email_hp'], PDO::PARAM_STR);
        $dbr->bindParam(':comment', $data['comment_text'], PDO::PARAM_STR);
        $dbr->execute();
        #$this->clear_cache();
        #showme(Database::$entries->errorInfo());
        #$this->form_values = array();

        unset($_SESSION[$this->_form_session]);
        $this->form_session=false;
        $this->form_session_data=false;

        // E-mail notification to admin:
        if($this->settings['comment_notification'] && $this->settings['email'] != '')
         {
          $this->_localization->replacePlaceholder('page', PAGE, 'comment_notification_subject');
          $name = $data['name'];
          if($data['email_hp']) $name .= ' '.$data['email_hp'];
          $this->_localization->replacePlaceholder('name', $name, 'comment_notification_message');
          $this->_localization->replacePlaceholder('comment', $data['comment_text'], 'comment_notification_message');
          $this->_localization->replacePlaceholder('link', BASE_URL.PAGE, 'comment_notification_message');
          $mail = new Mail();
          $mail->set_charset(CHARSET);
          $mail->send($this->settings['email'], $this->settings['email'], Localization::$lang['comment_notification_subject'], Localization::$lang['comment_notification_message'], $this->settings['mail_parameter']);
         }
        
        // count comments:
        $this->total_comments = $this->count_comments($this->comment_id);

        $this->total_pages = ceil($this->total_comments / $this->comments_per_page);
        if($this->current_page>$this->total_pages) $this->current_page = $this->total_pages;        
        
        return true;
      }
     }
    $_SESSION[$this->_form_session] = time();
    $this->form_session = $_SESSION[$this->_form_session];
    return false;
   }

  public function preview()
   {
    $data['comment_text'] = isset($_POST['comment_text']) ? trim($_POST['comment_text']) : '';
    $data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
    $data['email_hp'] = isset($_POST['email_hp']) ? trim($_POST['email_hp']) : '';

    // check posted data:
    $this->check_data($data);

    $preview['name'] = htmlspecialchars($data['name']);
    $preview['timestamp'] = time();
    $preview['time'] = time();
    #$preview['formated_time'] = format_time(TIME_FORMAT_FULL,time());
    $preview['comment_text'] = $this->format_comment($data['comment_text']);
    $email_hp = htmlspecialchars($data['email_hp']);
    if(preg_match("/^[^@]+@.+\.\D{2,5}$/", $email_hp))
     {
      if($this->admin_mode)
       {
        $preview['email'] = $email_hp;
       }
     }
    elseif($email_hp!='')
     {
      $preview['hp'] = add_http_if_no_protocol($email_hp);
     }

    $this->_localization->bindId('comment_time', 'preview');
    $this->_localization->replacePlaceholderBound('time', $preview['time'], 'comment_time', 'preview', Localization::FORMAT_TIME);

    $_SESSION[$this->_form_session] = time();
    $this->form_session = $_SESSION[$this->_form_session];

    if(isset($preview))
     {
      return $preview;
     }
    return false;
   }

  private function check_data($data, $save=false)
   {
    if($this->comments_closed!=false)
     {
      $this->errors[] = 'comment_error_closed';
     }

    if(empty($this->errors) && $save) // only if submitted in order to save
     {
      if(empty($_SESSION[$this->_form_session]))
       {
        $this->errors[] = 'comment_error_invalid_request';
       }
      else
       {
        if(time()-$_SESSION[$this->_form_session]<2)
         {
          $this->errors[] = 'comment_error_too_fast';
         }
       }
     }

    if(empty($this->errors))
     {
      // check for not accepted words:
      $joined_message = mb_strtolower($data['name'].' '.$data['email_hp'].' '.$data['comment_text']);
      $not_accepted_words = get_not_accepted_words($joined_message);
      if($not_accepted_words!=false)
       {
        $not_accepted_words_listing = htmlspecialchars(implode(', ',$not_accepted_words));
        if(count($not_accepted_words)==1)
         {
          $this->errors[] = 'error_not_accepted_word';
          #$this->assign_lang_placeholder('not_accepted_word', $not_accepted_words_listing, 'error_not_accepted_word');
          $this->_localization->replacePlaceholder('not_accepted_word', $not_accepted_words_listing, 'error_not_accepted_word');
         }
        else
         {
          $this->errors[] = 'error_not_accepted_words';
          #$this->assign_lang_placeholder('not_accepted_words', $not_accepted_words_listing, 'error_not_accepted_words');
          $this->_localization->replacePlaceholder('not_accepted_words', $not_accepted_words_listing, 'error_not_accepted_words');
         }
       }
      if(empty($data['name']))
       {
        $this->errors[] = 'comment_error_no_name';
       }
      if(empty($data['comment_text']))
       {
        $this->errors[] = 'comment_error_no_text';
       }
      if(mb_strlen($data['name']) > $this->name_maxlength)
       {
        $this->errors[] = 'comment_error_name_too_long';
       }
      if(mb_strlen($data['email_hp']) > $this->email_hp_maxlength)
       {
        $this->errors[] = 'comment_error_email_hp_too_long';
       }
      if(!empty($data['email_hp']))
       {
        if(strpos($data['email_hp'], ' ')!==false || strpos($data['email_hp'], '.')===false) $this->errors[] = 'comment_error_email_hp_invalid';
       }
      if(mb_strlen($data['comment_text']) > $this->comment_maxlength)
       {
        $text_length = mb_strlen($data['comment_text']);
        $this->errors[] = 'comment_error_text_too_long';
        $this->_localization->replacePlaceholder('characters', $text_length, 'comment_error_text_too_long');
        $this->_localization->replacePlaceholder('max_characters', $this->comment_maxlength, 'comment_error_text_too_long');
       }
     }

    if(empty($this->errors))
     {
      if($too_long_words = too_long_words(strip_tags($this->format_comment($data['comment_text'])),$this->word_maxlength))
       {
        foreach($too_long_words as $too_long_word)
         {
          $stripped_too_long_words[] = htmlspecialchars(mb_substr($too_long_word,0,$this->word_maxlength)).'...';
         }
        $too_long_words_listing = implode(', ',$stripped_too_long_words);

        if(count($too_long_words)==1)
         {
          $this->errors[] = 'comment_error_too_long_word';
          #$this->assign_lang_placeholder('word', $too_long_words_listing, 'comment_error_too_long_word');
          $this->_localization->replacePlaceholder('word', $too_long_words_listing, 'comment_error_too_long_word');
         }
        else
         {
          $this->errors[] = 'comment_error_too_long_words';
          #$this->assign_lang_placeholder('words', $too_long_words_listing, 'comment_error_too_long_words');
          $this->_localization->replacePlaceholder('words', $too_long_words_listing, 'comment_error_too_long_words');
         }
       }

      // check for double and repeated entries:
      $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE time>:time AND comment_id=:comment_id AND name=:name AND email_hp=:email_hp AND comment=:comment");
      $time = time()-300; // last 5 minutes
      $dbr->bindParam(':time', $time, PDO::PARAM_INT);
      $dbr->bindParam(':comment_id', $this->comment_id, PDO::PARAM_INT);
      $dbr->bindParam(':name', $data['name'], PDO::PARAM_STR);
      $dbr->bindParam(':email_hp', $data['email_hp'], PDO::PARAM_STR);
      $dbr->bindParam(':comment', $data['comment_text'], PDO::PARAM_STR);
      $dbr->execute();
      if($dbr->fetchColumn()>0)
       {
        $this->errors[] = 'comment_error_entry_exists';
       }
      if($this->prevent_repeated_posts_minutes > 0)
       {
        $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE time>:time AND comment_id=:comment_id AND ip=:ip");
        $time = time() - $this->prevent_repeated_posts_minutes * 60;
        $dbr->bindParam(':time', $time, PDO::PARAM_INT);
        $dbr->bindParam(':comment_id', $this->comment_id, PDO::PARAM_INT);
        $dbr->bindParam(':ip', $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
        $dbr->execute();
        if($dbr->fetchColumn()>0)
         {
          $this->errors[] = 'comment_error_repeated_post';
         }
       }

      if($save)
       {
        // Akismet spam check:
        if($this->akismet_key!='' && $this->akismet_entry_check==1)
         {
          #require('./cms/modules/akismet/akismet.class.php');
          $check_posting['author'] = $data['name'];
          if($data['email_hp']!='')
           {
            if(preg_match("/^[^@]+@.+\.\D{2,5}$/", $email_hp))
             {
              $check_posting['email'] = $data['email_hp'];
             }
            else
             {
              $check_posting['website'] = $data['email_hp'];
             }
           }
          $check_posting['body'] = $data['comment_text'];

          $akismet = new Akismet(BASE_URL, $this->akismet_key, $check_posting);

          // test for errors
          if($akismet->errorsExist()) // returns true if any errors exist
           {
            if($akismet->isError(AKISMET_INVALID_KEY))
             {
              $this->errors[] = 'akismet_error_api_key';
             }
            elseif($akismet->isError(AKISMET_RESPONSE_FAILED))
             {
              $this->errors[] = 'akismet_error_connection';
             }
            elseif($akismet->isError(AKISMET_SERVER_NOT_FOUND))
             {
              $this->errors[] = 'akismet_error_connection';
             }
           }
          else
           {
            // No errors, check for spam
            if($akismet->isSpam())
             {
              $this->errors[] = 'akismet_spam_suspicion';
             }
           }
         }
       } // end if($save)
     }
   }

  public function get_edit_data($id)
   {
    if($this->admin_mode)
     {
      $dbr = Database::$entries->prepare("SELECT id, name, email_hp, comment FROM ".Database::$db_settings['comment_table']." WHERE id=:id LIMIT 1");
      $dbr->bindParam(':id', $id, PDO::PARAM_INT);
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['id']))
       {
        $this->edit_form['id'] = $data['id'];
        $this->edit_form['name'] = htmlspecialchars($data['name']);
        $this->edit_form['email_hp'] = htmlspecialchars($data['email_hp']);
        $this->edit_form['comment'] = htmlspecialchars($data['comment']);
        $this->edit_form['current_page'] = $this->current_page;
        return $this->edit_form;
       }
      return false;
     }
   }

  public function edit_save()
   {
    if($this->admin_mode)
     {
      $dbr = Database::$entries->prepare("UPDATE ".Database::$db_settings['comment_table']." SET name=:name, email_hp=:email_hp, comment=:comment WHERE id=:id");
      $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
      $dbr->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
      $dbr->bindParam(':email_hp', $_POST['email_hp'], PDO::PARAM_STR);
      $dbr->bindParam(':comment', $_POST['comment_text'], PDO::PARAM_STR);
      $dbr->execute();
      if(isset($_POST['current_page']))
       {
        $this->current_page = intval($_POST['current_page']);
       }
     }
   }

  public function openclose($close=true)
   {
    if($this->admin_mode)
     {
      if($close) $new_type_addition = 'closed';
      else $new_type_addition = '';
      
      $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['pages_table']." SET type_addition=:type_addition WHERE page=:page");
      $dbr->bindParam(':type_addition', $new_type_addition, PDO::PARAM_STR);
      $dbr->bindValue(':page', PAGE, PDO::PARAM_STR);
      $dbr->execute();
     }
   }


  public function delete($id)
   {
    if($this->admin_mode)
     {
      $dbr = Database::$entries->prepare("DELETE FROM ".Database::$db_settings['comment_table']." WHERE id=:id");
      $dbr->bindParam(':id', $id, PDO::PARAM_INT);
      $dbr->execute();
      #$this->clear_cache();
     }
   }

  /*
  private function clear_cache()
   {
    if($this->settings['caching']==1)
     {
      if($this->type==1)
       {
        $cachefile = "../cache/".$this->page.".cache";
        if(file_exists($cachefile)) @unlink($cachefile);
        unset($cachefile);
        $cachefile = "../cache/".$this->page.",photo,".$this->comment_id.".cache";
        if(file_exists($cachefile)) @unlink($cachefile);
        unset($cachefile);
        foreach(glob("../cache/".$this->page.",photo,".$this->comment_id.",*.cache") as $cachefile)
         {
          @unlink($cachefile);
         }
       }
      else
       {
        $cachefile = "../cache/".$this->page.".cache";
        if(file_exists($cachefile)) @unlink($cachefile);
        unset($cachefile);
        foreach(glob("../cache/".$this->page.",*.cache") as $cachefile)
         {
          @unlink($cachefile);
         }
       }
     }
   }
  */

  private function format_comment($string)
   {
    $string = htmlspecialchars($string);
    if($this->remove_blank_lines==1)
     {
      $string = preg_replace("/\015\012|\015|\012/", "\n", $string);
      $string_array = explode("\n", $string);
      $string = '';
      foreach($string_array as $string_line)
       {
        $string_line = trim($string_line);
        if($string_line!='')
         {
          $string .= $string_line."\n";
         }
       }
     }
    $string = nl2br($string);
    if($this->auto_link==1)
     {
      $string = make_link($string);
     }
    if($this->smilies==1)
     {
      $string = smilies($string);
     }
    return $string;
   }

  /*
  function make_link($string)
   {
    $string = ' ' . $string;
    $string = preg_replace("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "\\1<a href=\"\\2\">\\2</a>", $string);
    $string = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "\\1<a href=\"http://\\2\">\\2</a>", $string);
    $string = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $string);
    $string = substr($string, 1);
    return $string;
   }

  function smilies($string)
   {
    global $this->settings;
    require 'config/smilies.conf.php';
    foreach($smilies as $smiley)
     {
      $string = str_replace($smiley[0], "<img src=\"".$this->settings['smiley_directory']."/".$smiley[1]."\" alt=\"".$smiley[0]."\" />", $string);
     }
    return $string;
   }
   */

  public function count_comments($comment_id)
   {
    $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE comment_id=:comment_id AND type=:type AND comment!=''");
    $dbr->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $dbr->bindParam(':type', $this->type, PDO::PARAM_INT);
    $dbr->execute();
    $comment_count = $dbr->fetchColumn();
    return $comment_count;
   }

  public function get_form_values()
   {
    $this->form_values['comment_text'] = isset($_POST['comment_text']) ? htmlspecialchars($_POST['comment_text']) : '';
    $this->form_values['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $this->form_values['email_hp'] = isset($_POST['email_hp']) ? htmlspecialchars($_POST['email_hp']) : '';
    return $this->form_values;
   }
 }
?>
