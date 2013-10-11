<?php
class Pingback
 {
  public $pingback_title_maxlength = 100;
  public $settings;
  private $url;
  private $_localization;

  public function __construct()
   {
    $this->_localization = Localization::getInstance();
   }
   
  public function get_pingback($id)
   {
    $postdata = file_get_contents("php://input");
    if($postdata)
     {
      $xml = new SimpleXMLElement($postdata);
      $pingback_sender_url = strval($xml->params->param[0]->value->string);
      $pingback_receiver_url = strval($xml->params->param[1]->value->string);
      
      // get content:
      if($pingback_sender_url)
       {       
        if($url_content = $this->_get_url_content($pingback_sender_url))
         { 

          if(strpos($url_content[1], BASE_URL.PAGE)!==false) // link found
           {
            
            // get title:
            preg_match("/<title>(.*)<\/title>/i", $url_content[1], $matches);
            if(isset($matches[1]) && trim($matches[1])!='')
             {
              $pingback_title = trim(filter_control_characters($matches[1]));
              if(mb_strlen($pingback_title) > $this->pingback_title_maxlength) $pingback_title = truncate($pingback_title, $this->pingback_title_maxlength);
             }
            else $pingback_error = true;

            // get body:
            preg_match("/<body[^>]*>(.*)<\/body>/smi", $url_content[1], $b_matches);
            if(isset($b_matches[1]) && trim($b_matches[1])!='')
             {
              $body = strip_tags($b_matches[1]);
              $body = preg_replace("/\015\012|\015|\012/", "\n", $body);
              $body_lines = explode("\n", $body);
              $cleared_body = '';
              foreach($body_lines as $body_line)
               {
                if(trim($body_line)!='') $cleared_body .= trim($body_line).' ';
               }
              $cleared_body = trim(filter_control_characters($cleared_body));
             }
            else $pingback_error = true;

            if(empty($pingback_error))
             {
              // not accepted words check:
              $joined_message = mb_strtolower($pingback_title.' '.$pingback_sender_url.' '.$cleared_body);
              $not_accepted_words = get_not_accepted_words($joined_message);
              if($not_accepted_words) $pingback_error = true;
             }             
            
            if(empty($pingback_error))
             {
              // Akismet spam check:
              if($this->settings['akismet_key']!='' && $this->settings['akismet_entry_check']==1)
               {
                $check_posting['author'] = $pingback_title;
                $check_posting['website'] = $pingback_sender_url;
                $check_posting['body'] = truncate($cleared_body, 3000);

                $akismet = new Akismet(BASE_URL, $this->settings['akismet_key'], $check_posting);

                // test for errors
                if($akismet->errorsExist()) // returns true if any errors exist
                 {
                  //$pingback_error = true;
                  if($akismet->isError(AKISMET_INVALID_KEY))
                   {
                    $akismet_errors[] = 'akismet_error_api_key';
                   }
                  elseif($akismet->isError(AKISMET_RESPONSE_FAILED))
                   {
                    $akismet_errors[] = 'akismet_error_connection';
                   }
                  elseif($akismet->isError(AKISMET_SERVER_NOT_FOUND))
                   {
                    $akismet_errors[] = 'akismet_error_connection';
                   }
                 }
                else
                 {
                  // No errors, check for spam
                  if($akismet->isSpam())
                   {
                    // TODO:
                    #$pingback_error = true;
                    $akismet_spam = true;
                   
                    #$mail = new Mail();
                    #$mail->send($this->settings['email'], $this->settings['email'], 'Pingback-Spam?', $check_posting['author']."\n".$check_posting['website']."\n".$check_posting['body'], $this->settings['mail_parameter']);                   
                   
                   }
                 }
               }             
             }
             
            if(empty($pingback_error))            
             {
              // check if url was already posted: 
              $dbr = Database::$entries->prepare("SELECT COUNT(*) FROM ".Database::$db_settings['comment_table']." WHERE comment_id=:comment_id AND type=0 AND comment='' AND email_hp=:email_hp");
              $dbr->bindParam(':comment_id', $id, PDO::PARAM_INT);
              $dbr->bindParam(':email_hp', $pingback_sender_url, PDO::PARAM_STR);
              $dbr->execute();
              $comment_count = $dbr->fetchColumn();
              if($comment_count>0) $pingback_error = true;
             }
             
            if(empty($pingback_error))
             {
              $dbr = Database::$entries->prepare("INSERT INTO ".Database::$db_settings['comment_table']." (type, comment_id, time, ip, name, email_hp, comment) VALUES (0, :comment_id, :time, :ip, :name, :email_hp, '')");
              $dbr->bindParam(':comment_id', $id, PDO::PARAM_INT);
              $dbr->bindValue(':time', time(), PDO::PARAM_INT);
              $dbr->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
              $dbr->bindParam(':name', $pingback_title, PDO::PARAM_STR);
              $dbr->bindParam(':email_hp', $pingback_sender_url, PDO::PARAM_STR);
              $dbr->execute();
              
              // E-mail notification to admin:
              if($this->settings['comment_notification'] && $this->settings['email'])
               {
                $this->_localization->replacePlaceholder('page', PAGE, 'pingback_notification_subject');
                $this->_localization->replacePlaceholder('title', $pingback_title, 'pingback_notification_message');
                $this->_localization->replacePlaceholder('url', $pingback_sender_url, 'pingback_notification_message');
                $this->_localization->replacePlaceholder('link', BASE_URL.PAGE, 'pingback_notification_message');
                
                // TODO:
                if(isset($akismet_spam)) $add = "\n\nAkismet: SPAM!";
                else $add = '';
                
                $mail = new Mail();
                $mail->set_charset(CHARSET);
                $mail->send($this->settings['email'], $this->settings['email'], Localization::$lang['pingback_notification_subject'], Localization::$lang['pingback_notification_message'].$add, $this->settings['mail_parameter']);
               }
              
              $response = '<?xml version="1.0"?><methodResponse><params><param><value><string>OK</string></value></param></params></methodResponse>';
              header('Content-Type: text/xml');
              echo $response;
              return true;
             }
            
           }
         }
       }
     }
    
    $response = '<?xml version="1.0"?><methodResponse><fault><value><struct><member><name>faultCode</name><value><int>0</int></value></member><member><name>faultString</name><value><string>FAIL</string></value></member></struct></value></fault></methodResponse>';
    header('Content-Type: text/xml');
    echo $response;
    return false;
   }

  public function ping($url, $content)
   {
    $this->url = $url;
    if($links = $this->_get_links($content))
     {
      foreach($links as $link)
       {
        if($pingback_url = $this->_get_pingback_url($link))
         {
          $this->_send_pingback($pingback_url, $link);
         }
       }
     }
   }

  private function _get_links($content)
   {
    preg_match_all('#<a[^>]+href\s*=\s*("([^"]+)"|\'([^\']+)\')[^>]*>(.+)</a>#Ui', $content, $matches);
    $links = array();
    $links = array_unique(array_merge($matches[2], $matches[3]));
    $count = count($links);
    for($i = 0; $count > $i; $i++)
     {
      if(substr($links[$i], 0, 4) == "http" && strpos($links[$i], BASE_URL)===false)
      if(strpos($links[$i], BASE_URL)===false)
       {
        $cleared_links[] = $links[$i];
       }
     }
    if(isset($cleared_links)) return $cleared_links;
    return false;
   }

  private function _get_pingback_url($link)
   {
    if($url_content = $this->_get_url_content($link))
     {
      if($header = $this->_import_header($url_content[0]))
       {
        if(isset($header['x-pingback'])) return $header['x-pingback'];
        preg_match('<link rel="pingback" href="([^"]+)" ?/?>', $url_content[1], $matches);
        if($matches[1]) return $matches[1];
       }
     }
    return false;
   }

  private function _send_pingback($pingback_url, $link)
   {
    $url_parts = parse_url($pingback_url);
    if(empty($url_parts['path'])) $url_parts['path'] = '/';
    if(isset($url_parts['query'])) $url_parts['path'] .= '?'.$url_parts['query'];
    if(isset($url_parts['fragment'])) $url_parts['path'] .= '#'.$url_parts['fragment'];
    
    $request = '<?xml version="1.0"?><methodCall><methodName>pingback.ping</methodName><params><param><value><string>'.$this->url.'</string></value></param><param><value><string>'.$link.'</string></value></param></params></methodCall>';
    if($fp = @fsockopen($url_parts['host'], 80, $error_nr, $error, 3))
     {
      $http_request  = "POST " . $url_parts['path'] . " HTTP/1.0\r\n";
      $http_request .= "Host: " . $url_parts['host'] . "\r\n";
      #$http_request .= "Content-Type: text/xml; charset=utf-8\r\n";
      $http_request .= "Content-Type: text/xml\r\n";
      $http_request .= "User-Agent: phpSQLiteCMS\r\n";
      $http_request .= "Content-Length: " . strlen($request) . "\r\n";
      $http_request .= "\r\n";
      $http_request .= $request;
      $response = '';
      fwrite($fp, $http_request);  
      while(!feof($fp))
       {
        $response .= fgets($fp, 4096);
       }
      fclose($fp);
      #echo '<pre>'.$response;
      #exit;
     }
   }

  private function _get_url_content($url)
   { 
    $url_parts = parse_url($url);
    if(empty($url_parts['path'])) $url_parts['path'] = '/';
    if(isset($url_parts['query'])) $url_parts['path'] .= '?'.$url_parts['query'];
    if(isset($url_parts['fragment'])) $url_parts['path'] .= '#'.$url_parts['fragment'];
      
    if($fp = @fsockopen($url_parts['host'], 80, $error_nr, $error, 3))
     {
      $http_request  = "GET " . $url_parts['path'] . " HTTP/1.0\r\n";
      $http_request .= "Host: " . $url_parts['host'] . "\r\n";
      $http_request .= "User-Agent: phpSQLiteCMS\r\n";
      #$http_request .= "Content-Type: text/plain; charset=utf-8\r\n";
      #$http_request .= "Content-Length: " . strlen($request) . "\r\n";
      $http_request .= "\r\n";
      #$http_request .= $request;
      $response = '';
      fwrite($fp, $http_request);  
      while(!feof($fp))
       {
        $response .= fgets($fp, 4096);
       }
      fclose($fp); 
     }

    if($response)
     {      
      // divide header/body:
      $response = $response;
      $response_parts = explode("\r\n\r\n", $response, 2);
      if(isset($response_parts[0]) && isset($response_parts[1]))
       {      
        return $response_parts;
       }      
      else
       {
        return false;
       } 
     }
    return false;
   }
   
  private function _import_header($header)
   {
    $header = preg_replace("/\015\012|\015|\012/", "\n", $header);
    $lines = explode("\n", $header);
    foreach($lines as $line)
     {
      if(trim($line)!='')
       {
        unset($separator_pos);
        #$parts = explode(': ', $line);
        $separator_pos = strpos($line, ':');
        if($separator_pos!==false)
         {
          $key = strtolower(trim(substr($line, 0,$separator_pos)));
          $val = trim(substr($line, $separator_pos+1));
          if($key && $val) $header_parts[$key] = $val;
         }
       }
     }   
    if(isset($header_parts)) return $header_parts;
    else return false;
   }
  
 }
?>
