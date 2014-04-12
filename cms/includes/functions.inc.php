<?php
// autoload required classes:
function __autoload($class_name)
 {
  require_once(BASE_PATH.'cms/includes/classes/'.$class_name.'.class.php');
 }

if(get_magic_quotes_gpc())
 {
  function stripslashes_deep($value)
   {
    $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    return $value;
   }
  $_POST = array_map('stripslashes_deep', $_POST);
  $_GET = array_map('stripslashes_deep', $_GET);
  $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
  $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
 }

function showme($what)
 {
  echo '<pre>';
  print_r($what);
  exit;
 }

/**
 * fetches settings from database
 */
function get_settings()
 {
  #global $pdo, $db_settings;
  #$database = Database::getInstance();
  $result = Database::$content->query("SELECT name, value FROM ".Database::$db_settings['settings_table']);
  while($line = $result->fetch())
   {
    $settings[$line['name']] = $line['value'];
   }
  return $settings;
 }

function get_base_url($cut=false)
 {
  global $settings;
  if($settings['base_url']!='')
   {
    return $settings['base_url'];
   }
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')
   {
    $protocol = 'https://';
   }
  else
   {
    $protocol = 'http://';
   }
  $base_url = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
  if($cut)
   {
    $pos = strrpos($base_url, $cut);
    if($pos!==false)
     {
      $base_url = substr($base_url, 0, $pos);
     }
   }
  return $base_url;
 }

function get_base_path($cut=false)
 {
  global $settings;
  if($settings['base_path']!='')
   {
    return $settings['base_path'];
   }
  $base_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/';
  if($cut)
   {
    $pos = strrpos($base_path, $cut);
    if($pos!==false)
     {
      $base_path = substr($base_path, 0, $pos);
     }
   }
  return $base_path;
 }

/**
 * gets available languages
 *
 * @reurn array
 */
function get_languages($admin=false)
 {
  if($admin) $file_schema = '.admin.lang.php';
  else $file_schema = '.page.lang.php';
  $length = 0-strlen($file_schema);
  foreach (glob(BASE_PATH.'cms/lang/*'.$file_schema) as $filename)
   {
    $languages[] = substr(basename($filename), 0, $length); // filename without extension ".[admin|page].lang.php"
   }
  if(isset($languages))
   {
    natcasesort($languages);
    $i=0;
    foreach($languages as $language)
     {
      $languages_detailed[$i]['identifier'] = $language; 
      $languages_detailed[$i]['name'] = get_language_name($language);     
      ++$i;
     }
    return $languages_detailed;
   }
  return false;
 }

/**
 * helper function for get_languages()
 *
 * @reurn string
 */
function get_language_name($string)
 {
  $string_parts = explode('_', $string);
  if(isset($string_parts[1])) $name = ucfirst($string_parts[0]).' ('.$string_parts[1].')';
  else $name = ucfirst($string);
  return $name;     
 }

/**
 * fetches page content from database
 *
 * @param string $page
 * @return mixed
 */
function get_content($page)
 {
  #global $settings, $db_settings, $pdo;
  $content_query = "SELECT id, page, author, type, type_addition, time, last_modified, display_time, page_title, title, keywords, description, category, page_info, language, breadcrumbs, teaser_headline, teaser, content, sidebar_1, sidebar_2, sidebar_3, sections, menu_1, menu_2, menu_3, gcb_1, gcb_2, gcb_3, include_news, template, content_type, charset, edit_permission, edit_permission_general, tv, status FROM ".Database::$db_settings['pages_table']." WHERE lower(page)=lower(:page) AND status!=0 LIMIT 1";
  $dbr = Database::$content->prepare($content_query);
  $dbr->bindParam(':page', $page, PDO::PARAM_STR);
  $dbr->execute();
  $data = $dbr->fetch();
  if(isset($data['id'])) return $data;
  return false;
 }

function db_error()
 {
  global $error_503;
  header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
  header("Status: 503 Service Unavailable");
  echo $error_503;
  exit;
 }

/**
 * gets the menus
 *
 * @return array
 */
function get_menus()
 {
  #global $db_settings, $pdo;
  $menu_result = Database::$content->query("SELECT id, menu, name, title, link, section, accesskey FROM ".Database::$db_settings['menu_table']." ORDER BY menu ASC, sequence ASC");
  $i=0;
  while($row = $menu_result->fetch())
   {
    $menus[$row['menu']][$i]['name'] = $row['name'];
    $menus[$row['menu']][$i]['title'] = $row['title'];
    if(mb_substr($row['link'],0,7) != 'http://' && mb_substr($row['link'],0,8) != 'https://' && mb_substr($row['link'],0,6) != 'ftp://' && mb_substr($row['link'],0,9) != 'gopher://' && mb_substr($row['link'],0,7) != 'news://')
     {
      $menus[$row['menu']][$i]['link'] = BASE_URL.$row['link'];
     }
    else
     {
      $menus[$row['menu']][$i]['link'] = $row['link'];
     }
    $menus[$row['menu']][$i]['section'] = $row['section'];
    $menus[$row['menu']][$i]['accesskey'] = $row['accesskey'];
    ++$i;
   }
  if(isset($menus))
   {
    return $menus;
   }
  return false;
 }

/**
 * gets global content blocks
 *
 * @return array
 */
function get_global_content_blocks()
 {
  #global $db_settings, $pdo;
  $gcb_result = Database::$content->query("SELECT id, identifier, content FROM ".Database::$db_settings['gcb_table']." ORDER BY id ASC");
  while($row = $gcb_result->fetch())
   {
    $gcb[$row['identifier']] = $row['content'];
    #if($row['content_formatting']==1) $gcb[$row['id']] = auto_html($gcb[$row['id']]);
   }
  if(isset($gcb))
   {
    return $gcb;
   }
  return false;
 }

/**
 * gets page names and page titles of breadcrumbs
 *
 * @param string $breadcrumbs_id_list
 * @return array
 */
function get_breadcrumbs($breadcrumbs_id_list)
 {
  if(trim($breadcrumbs_id_list)!='')
   {
    $breadcrumb_ids = explode(',',$breadcrumbs_id_list);
    $breadcrumb_ids = array_map('intval', $breadcrumb_ids);
    #if(isset($breadcrumb_ids))
    # {
      $ids = implode(',', $breadcrumb_ids);
      $dbr = Database::$content->query("SELECT id, page, title FROM ".Database::$db_settings['pages_table']." WHERE id IN(".$ids.")");
      while($data = $dbr->fetch())
       {
        $unordered_breadcrumbs[$data['id']]['page'] = $data['page'];
        $unordered_breadcrumbs[$data['id']]['title'] = $data['title'];
       }
      // order:
      foreach($breadcrumb_ids as $id)
       {
        if(isset($unordered_breadcrumbs[$id])) $breadcrumbs[] = $unordered_breadcrumbs[$id];
       }
      /* // the same with several database requests (1 per breadcrumb):
      $dbr = Database::$content->prepare("SELECT page, title FROM ".Database::$db_settings['pages_table']." WHERE id=:id");
      $i=0;
      Database::$content->beginTransaction();
      foreach($breadcrumb_ids as $breadcrumb_id)
       {
        $dbr->bindValue(':id', $breadcrumb_id, PDO::PARAM_INT);
        $dbr->execute();
        $data = $dbr->fetch();
        if(isset($data['page']))
         {
          $breadcrumbs[$i]['page'] = $data['page'];
          $breadcrumbs[$i]['title'] = $data['title'];
          ++$i;
          unset($data);
         }
       }
      Database::$content->commit();
      */
     #}
    if(isset($breadcrumbs))
     {
      return $breadcrumbs;
     }
   }
  return false;
 }

function is_vailid_photo_page($content, $type, $type_addition, $gallery, $gallery_items)
 {
  if($type=='search')
   {
    return 1; // valid but not cacheable
   }
  if($type=='gallery' && $type_addition==$gallery)
   {
    return 2;
   }
  if(strpos($content, '[gallery:'.$gallery)!==false)
   {
    return 2;
   }
  foreach($gallery_items as $gallery_item)
   {
    if(strpos($content, '[thumbnail:'.$gallery_item)!==false)
     {
      return 2;
     }
   }
  return false;
 }

/*
 * formats a paragraph
 */
function format_paragraph($string)
 {
  $string = nl2br(preg_replace('/\[\[([^|\]]+?)(?:\|([^\]]+))?\]\]/e', "'<a href=\"\$1\">'.(('\$2')?'\$2':'\$1').'</a>'", $string));
  return $string;
 }

/**
 * filters control characters
 *
 * @param string $string
 * @return string
 */
function filter_control_characters($string)
 {
  $char = array(array(), array());
  $char['char'][0] = chr(0);
  $char['repl'][0] = '';
  $char['char'][1] = chr(1);
  $char['repl'][1] = '';
  $char['char'][2] = chr(2);
  $char['repl'][2] = '';
  $char['char'][3] = chr(3);
  $char['repl'][3] = '';
  $char['char'][4] = chr(4);
  $char['repl'][4] = '';
  $char['char'][5] = chr(5);
  $char['repl'][5] = '';
  $char['char'][6] = chr(6);
  $char['repl'][6] = '';
  $char['char'][7] = chr(7);
  $char['repl'][7] = '';
  $char['char'][8] = chr(8);
  $char['repl'][8] = '';
  $char['char'][9] = chr(9);
  $char['repl'][9] = ' ';
  $char['char'][10] = chr(10);
  $char['repl'][10] = chr(10);
  $char['char'][11] = chr(11);
  $char['repl'][11] = '';
  $char['char'][12] = chr(12);
  $char['repl'][12] = '';
  $char['char'][13] = chr(13);
  $char['repl'][13] = chr(13);
  $char['char'][14] = chr(14);
  $char['repl'][14] = '';
  $char['char'][15] = chr(15);
  $char['repl'][15] = '';
  $char['char'][16] = chr(16);
  $char['repl'][16] = '';
  $char['char'][17] = chr(17);
  $char['repl'][17] = '';
  $char['char'][18] = chr(18);
  $char['repl'][18] = '';
  $char['char'][19] = chr(19);
  $char['repl'][19] = '';
  $char['char'][20] = chr(20);
  $char['repl'][20] = '';
  $char['char'][21] = chr(21);
  $char['repl'][21] = '';
  $char['char'][22] = chr(22);
  $char['repl'][22] = '';
  $char['char'][23] = chr(23);
  $char['repl'][23] = '';
  $char['char'][24] = chr(24);
  $char['repl'][24] = '';
  $char['char'][25] = chr(25);
  $char['repl'][25] = '';
  $char['char'][26] = chr(26);
  $char['repl'][26] = '';
  $char['char'][27] = chr(27);
  $char['repl'][27] = '';
  $char['char'][28] = chr(28);
  $char['repl'][28] = '';
  $char['char'][29] = chr(29);
  $char['repl'][29] = '';
  $char['char'][30] = chr(30);
  $char['repl'][30] = '';
  $char['char'][31] = chr(31);
  $char['repl'][31] = '';
  $string = str_replace($char['char'], $char['repl'], $string);
  return $string;
}

function auto_html($text)
 {
  $text = trim($text);
  if($text!='')
   {
    #$text = preg_replace('/\[\[([^|\]]+?)(?:\|([^\]]+))?\]\]/e', "'<a href=\"\$1\">'.(('\$2')?'\$2':'\$1').'</a>'", $text);
    $text = '<p>' . $text . '</p>';
    $text = preg_replace("/(\015\012\015\012)|(\015\015)|(\012\012)/","</p><p>",$text);
    $text = nl2br($text);
   }
  return $text;
 }

function content_function($function)
 {
  return @eval('return '.$function[1].';');
 }

function create_image($string)
 {
  global $template, $settings;
  $string = explode('|',$string[1]);
  $file = $string[0];
  if(isset($string[1]) && $string[1]!='') $img_class = $string[1];
  if(isset($string[2])) $img_alt = $string[2];
  else $img_alt = '';
  if(isset($string[3]) && intval($string[3])>0) $width = intval($string[3]);
  if(isset($string[4]) && intval($string[4])>0) $height = intval($string[4]);
  if(file_exists(BASE_PATH.MEDIA_DIR.$file))
   {
    if(substr(strtolower($file), -4) == '.swf')
     {
      $image['type']='flash';
      if(isset($width) && isset($height))
       {
        $image['width'] = $width;
        $image['height'] = $height;
       }
      else
       {
        $image['width'] = $settings['flash_default_width'];
        $image['height'] = $settings['flash_default_height'];
       }
     }
    elseif(substr(strtolower($file), -4) == '.flv')
     {
      $image['type']='flv';
      if(isset($width) && isset($height))
       {
        $image['width'] = $width;
        $image['height'] = $height;
       }
      else
       {
        $image['width'] = $settings['flash_default_width'];
        $image['height'] = $settings['flash_default_height'];
       }
     }
    else
     {
      $image['type']='image';
      if(isset($width) && isset($height))
       {
        $image['width'] = $width;
        $image['height'] = $height;
       }
      else
       {
        $image_info = getimagesize(BASE_PATH.MEDIA_DIR.$file);
        $image['width'] = $image_info[0];
        $image['height'] = $image_info[1];
       }
     } 
    $image['image'] = $file;
    $image['alt'] = htmlspecialchars($img_alt);
    if(isset($img_class)) $image['class'] = htmlspecialchars($img_class);
    $template->assign('image', $image);
   }
  $image_code = $template->fetch(BASE_PATH.'cms/templates/subtemplates/image.inc.tpl');
  return $image_code;
 }

function create_thumbnail($string)
 {
  global $template;
  $page = isset($GLOBALS['parent_page']) && $GLOBALS['parent_page'] ? $GLOBALS['parent_page'] : PAGE;
  $template->assign('contains_thumbnails', true);
  $template->assign('page', $page);
  $string = explode('|',$string[1]);
  $id = intval($string[0]);
  if(isset($string[1])) $img_class = $string[1];
  $dbr = Database::$content->prepare("SELECT id, photo_thumbnail, photo_normal, title, subtitle, description FROM ".Database::$db_settings['photo_table']." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $id, PDO::PARAM_INT);
  $dbr->execute();
  $data = $dbr->fetch();
  if(isset($data['id']))
   {
    $thumbnail['id'] = $data['id'];
    $thumbnail['image'] = $data['photo_thumbnail'];
    $thumbnail['photo'] = $data['photo_normal'];
    $thumbnail_info = getimagesize(BASE_PATH.MEDIA_DIR.$data['photo_thumbnail']);
    $thumbnail['width'] = $thumbnail_info[0];
    $thumbnail['height'] = $thumbnail_info[1];
    if(isset($img_class))
     {
      $thumbnail['class'] = htmlspecialchars($img_class);
     }
    $thumbnail['title'] = htmlspecialchars(strip_tags($data['title']));
    $thumbnail['subtitle'] = htmlspecialchars(strip_tags($data['subtitle']));
    $thumbnail['description'] = htmlspecialchars(strip_tags($data['description']));
    #else $thumbnail = '<a href="'.$page.',photo,'.$id.'"><img src="images/'.$data['photo_thumbnail'].'" title="'.htmlspecialchars(strip_tags(stripslashes($data['title']))).'" alt="'.htmlspecialchars(strip_tags(stripslashes($data['title']))).'" width="'.$width.'" height="'.$height.'" /></a>';
    $template->assign('thumbnail', $thumbnail);
   }
  $thumbnail = $template->fetch(BASE_PATH.'cms/templates/subtemplates/thumbnail.inc.tpl');
  return $thumbnail;
 }

function create_thumbnail_rss($string)
 {
  global $template;
  $page = isset($GLOBALS['parent_page']) && $GLOBALS['parent_page'] ? $GLOBALS['parent_page'] : PAGE;
  $template->assign('contains_thumbnails', true);
  $template->assign('page', $page);
  $string = explode('|',$string[1]);
  $id = intval($string[0]);
  if(isset($string[1])) $img_class = $string[1];
  $dbr = Database::$content->prepare("SELECT id, photo_thumbnail, title FROM ".Database::$db_settings['photo_table']." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $id, PDO::PARAM_INT);
  $dbr->execute();
  $data = $dbr->fetch();
  if(isset($data['id']))
   {
    $thumbnail['id'] = $data['id'];
    $thumbnail['image'] = $data['photo_thumbnail'];
    $thumbnail_info = getimagesize(BASE_PATH.MEDIA_DIR.$data['photo_thumbnail']);
    $thumbnail['width'] = $thumbnail_info[0];
    $thumbnail['height'] = $thumbnail_info[1];
    if(isset($img_class))
     {
      $thumbnail['class'] = htmlspecialchars($img_class);
     }
    $thumbnail['title'] = htmlspecialchars(strip_tags($data['title']));
    #else $thumbnail = '<a href="'.$page.',photo,'.$id.'"><img src="images/'.$data['photo_thumbnail'].'" title="'.htmlspecialchars(strip_tags(stripslashes($data['title']))).'" alt="'.htmlspecialchars(strip_tags(stripslashes($data['title']))).'" width="'.$width.'" height="'.$height.'" /></a>';
    $template->assign('thumbnail', $thumbnail);
   }
  $thumbnail = $template->fetch(BASE_PATH.'cms/templates/subtemplates/thumbnail_rss.inc.tpl');
  return $thumbnail;
 }

function create_gallery($string)
 {
  global $settings, $template;
  $page = isset($GLOBALS['parent_page']) && $GLOBALS['parent_page'] ? $GLOBALS['parent_page'] : PAGE;
  $template->assign('contains_thumbnails', true);
  $template->assign('page', $page);
  $string = explode('|',$string[1]);
  $gallery = $string[0];
  #if(isset($string[1])) $img_class = $string[1];

  $gallery = new Gallery($gallery);
  if($gallery->photos)
   {
    $template->assign('number_of_photos', $gallery->number_of_photos);
    $template->assign('photos_per_row', $gallery->photos_per_row);
    $template->assign('photos', $gallery->photos);
   }
  #$template->assign('lang', Localization::$lang);
  $gallery = $template->fetch(BASE_PATH.'cms/templates/subtemplates/gallery.inc.tpl');
  return $gallery;
 }

function create_gallery_rss($string)
 {
  global $settings, $template;
  $page = isset($GLOBALS['parent_page']) && $GLOBALS['parent_page'] ? $GLOBALS['parent_page'] : PAGE;
  $template->assign('contains_thumbnails', true);
  $template->assign('page', $page);
  $string = explode('|',$string[1]);
  $gallery = $string[0];
  #if(isset($string[1])) $img_class = $string[1];

  $gallery = new Gallery($gallery);
  if($gallery->photos)
   {
    $template->assign('number_of_photos', $gallery->number_of_photos);
    $template->assign('photos_per_row', $gallery->photos_per_row);
    $template->assign('photos', $gallery->photos);
   }
  $gallery = $template->fetch(BASE_PATH.'cms/templates/subtemplates/gallery_rss.inc.tpl');
  return $gallery;
 }

/**
 * shortens links
 *
 * @param string $string
 * @return string
 */
function shorten_link($string)
 {
  global $settings;
  if(is_array($string))
   {
    if(count($string) == 2) { $pre = ""; $url = $string[1]; }
    else { $pre = $string[1]; $url = $string[2]; }
    $shortened_url = $url;
    if (strlen($url) > $settings['word_maxlength']) $shortened_url = mb_substr($url, 0, $settings['word_maxlength']-3, CHARSET) . '...';
    return $pre.'<a href="'.$url.'">'.$shortened_url.'</a>';
   }
 }

/**
 * replaces urls with links
 *
 * @param string $string
 * @return string
 */
function make_link($string)
 {
  $string = ' ' . $string;
  $string = preg_replace_callback("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "shorten_link", $string);
  $string = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "$1<a href=\"http://$2\">$2</a>", $string);
  #$string = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $string);
  $string = mb_substr($string, 1, mb_strlen($string, CHARSET), CHARSET);
  return $string;
 }

function create_link_callback($string)
 {
  if(isset($string[2])) $link = '<a href="'.$string[1].'">'.$string[2].'</a>';
  else $link = '<a href="'.$string[1].'">'.$string[1].'</a>';
  return $link;
 }

function parse_special_tags($string, $parent_page=false, $rss=false)
 {
  global $settings;
  $GLOBALS['parent_page'] = $parent_page;
  if($settings['content_functions']==1) $string = preg_replace_callback("#\[function:(.+?)\]#is", "content_function", $string);
  $string = preg_replace_callback("#\[image:(.+?)\]#is", "create_image", $string);
  if($rss)
   {
    $string = preg_replace_callback("#\[thumbnail:(.+?)\]#is", "create_thumbnail_rss", $string);
    $string = preg_replace_callback("#\[gallery:(.+?)\]#is", "create_gallery_rss", $string);
   }
  else
   {
    $string = preg_replace_callback("#\[thumbnail:(.+?)\]#is", "create_thumbnail", $string);
    $string = preg_replace_callback("#\[gallery:(.+?)\]#is", "create_gallery", $string);
   }
  $string = preg_replace_callback('/\[\[([^|\]]+?)(?:\|([^\]]+))?\]\]/', "create_link_callback", $string); 
  return $string;
 }

function smilies($string)
 {
  global $settings;
  require BASE_PATH.'cms/config/smilies.conf.php';
  foreach($smilies as $smiley)
   {
    $string = str_replace($smiley[0], '<img src="'.BASE_URL.SMILIES_DIR.$smiley[1].'" alt="'.$smiley[0].'" />', $string);
   }
  return $string;
 }

function format_time($format, $timestamp=0)
 {
  if($timestamp==0) $timestamp=time();
  #if($lang['locale_charset']!=$lang['charset'])
  # {
  #  $formated_time = iconv($lang['locale_charset'],$lang['charset'],strftime($format,$timestamp));
  # }
  #else
  # {
    $formated_time = strftime($format,$timestamp);
  # }
  return $formated_time;
 }

/**
 * generates a random string
 *
 * @param int $length
 * @param string $characters
 * @return string
 */
function random_string($length=8,$characters='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
 {
  $random_string = '';
  $characters_length = strlen($characters);
  for($i=0;$i<$length;$i++)
   {
    $random_string .= $characters[mt_rand(0, $characters_length - 1)];
   }
  return $random_string;
 }

function is_authorized_to_edit($editor,$editor_type,$author,$edit_permission,$edit_permission_general)
 {
  $authorized_users = explode(',',$edit_permission);
  foreach($authorized_users as $authorized_user)
   {
    if(intval($authorized_user)!=0) $cleared_authorized_users[] = $authorized_user;
   }
  if($editor_type>0 || $author==$editor || $edit_permission_general==1 || (isset($cleared_authorized_users) && in_array($editor,$cleared_authorized_users)))
   {
    return true;
   }
  else
   {
    return false;
   }
 }

function is_access_denied()
 {
  $dbr = Database::$content->query("SELECT name, list FROM ".Database::$db_settings['banlists_table']." WHERE name='ips' OR name='user_agents'");
  while($data = $dbr->fetch())
   {
    if($data['name'] == 'ips') $ips = $data['list'];
    if($data['name'] == 'user_agents') $user_agents = $data['list'];
   }
  if(isset($ips) && trim($ips) != '')
   {
    $banned_ips = explode("\n",$ips);
    if(is_ip_banned($_SERVER['REMOTE_ADDR'], $banned_ips)) return true;
   }
  if(isset($user_agents) && trim($user_agents) != '')
   {
    $banned_user_agents = explode("\n",$user_agents);
    if(is_user_agent_banned($_SERVER['HTTP_USER_AGENT'], $banned_user_agents)) return true;
   }
  return false;
 }

/**
 * checks if the IP of the user is banned
 *
 * @author Nico Hoffmann <oxensepp at gmx dot de>
 * @param string $ip
 * @param array $banned_ips
 * @reurn bool
 */
function is_ip_banned($ip, $banned_ips)
 {
  foreach($banned_ips as $banned_ip) // go through every $banned_ip
   {
    if(strpos($banned_ip,'*')!==false) // $banned_ip contains "*" = > IP range
     {
      $ip_range = substr($banned_ip, 0, strpos($banned_ip, '*')); // fetch part before "*"
      if(strpos($ip, $ip_range)===0) // check if IP begins with part before "*"
       {
        return true;
       }
     }
    elseif(strpos($banned_ip,'/')!==false && preg_match("/(([0-9]{1,3}\.){3}[0-9]{1,3})\/([0-9]{1,2})/", $banned_ip, $regs)) // $banned_ip contains "/" => CIDR notation (the regular expression is only used if $banned_ip contains "/")
     {
      // convert IP into bit pattern:
      $n_user_leiste = '00000000000000000000000000000000'; // 32 bits
      $n_user_ip = explode('.',trim($ip));
      for ($i = 0; $i <= 3; $i++) // go through every byte
       {
        for ($n_j = 0; $n_j < 8; $n_j++) // ... check every bit
         {
          if($n_user_ip[$i] >= pow(2, 7-$n_j)) // set to 1 if necessary
           {
            $n_user_ip[$i] = $n_user_ip[$i] - pow(2, 7-$n_j);
            $n_user_leiste[$n_j + $i*8] = '1';
           }
         }
       }
      // analyze prefix length:
      $n_byte_array = explode('.',trim($regs[1])); // IP -> 4 Byte
      $n_cidr_bereich = $regs[3]; // prefix length
      // bit pattern:
      $n_bitleiste = '00000000000000000000000000000000';
      for ($i = 0; $i <= 3; $i++) // go through every byte
       {
        if ($n_byte_array[$i] > 255) // invalid
         {
          $n_cidr_bereich = 0;
         }
        for ($n_j = 0; $n_j < 8; $n_j++) // ... check every bit
         {
          if($n_byte_array[$i] >= pow(2, 7-$n_j)) // set to 1 if necessary
           {
            $n_byte_array[$i] = $n_byte_array[$i] - pow(2, 7-$n_j);
            $n_bitleiste[$n_j + $i*8] = '1';
           }
         }
       }
      // check if bit patterns match on the first n chracters:
      if (strncmp($n_bitleiste, $n_user_leiste, $n_cidr_bereich) == 0 && $n_cidr_bereich > 0)
       {
        return true;
       }
     }
    else // neither "*" nor "/" => simple comparison:
     {
      if($ip == $banned_ip)
       {
        return true;
       }
     }
   }
  return false;
 }

/**
 * checks if the user agent is banned
 *
 * @param array $banned_user_agents
 * @reurn bool
 */
function is_user_agent_banned($user_agent, $banned_user_agents)
 {
  foreach($banned_user_agents as $banned_user_agent)
   {
    #if(strpos(strtolower($user_agent),strtolower($banned_user_agent))!==false)  // case insensitive
    #if($banned_user_agent!='' && (preg_match("/".$banned_user_agent."/i",$user_agent))) // case insensitive
    if(strpos($user_agent,$banned_user_agent)!==false) // case sensitive, faster
     {
      return true;
     }
   }
  return false;
 }

/**
 * searches for banned words
 *
 * @param string $string
 * @reurn mixed
 */
function get_not_accepted_words($string)
 {
  #global $db_settings, $pdo;
  // check for not accepted words:
  $dbr = Database::$content->query("SELECT list FROM ".Database::$db_settings['banlists_table']." WHERE name = 'words' LIMIT 1");
  $data = $dbr->fetch();
  if(isset($data['list']) && trim($data['list']) != '')
   {
    $not_accepted_words = explode("\n",$data['list']);
    foreach($not_accepted_words as $not_accepted_word)
     {
      #if($not_accepted_word!='' && (preg_match("/".$not_accepted_word."/i",$name) || preg_match("/".$not_accepted_word."/i",$text) || preg_match("/".$not_accepted_word."/i",$subject) || preg_match("/".$not_accepted_word."/i",$email) || preg_match("/".$not_accepted_word."/i",$hp) || preg_match("/".$not_accepted_word."/i",$location)))
      if($not_accepted_word!='' && mb_strpos($string, mb_strtolower($not_accepted_word, CHARSET), 0, CHARSET)!==false)
       {
        $found_not_accepted_words[] = $not_accepted_word;
       }
     }
   }
  if(isset($found_not_accepted_words))
   {
    return $found_not_accepted_words;
   }
  else
   {
    return false;
   }
 }

/**
 * add "http://" to url if given without protocol
 *
 * @param string $url
 * @return string
 */
function add_http_if_no_protocol($url)
 {
  if(mb_substr($url,0,7,CHARSET) != 'http://' && mb_substr($url,0,8,CHARSET) != 'https://' && mb_substr($url,0,6,CHARSET) != 'ftp://' && mb_substr($url,0,9,CHARSET) != 'gopher://' && mb_substr($url,0,7,CHARSET) != 'news://')
   {
    $url = 'http://'.$url;
   }
  return $url;
 }

/**
 * checks strings for too long words
 */
function too_long_words($text,$word_maxlength)
 {
  $text = preg_replace("/\015\012|\015|\012/", "\n", $text);
  $text = str_replace("\n", ' ', $text);
  $words = explode(' ',$text);
  foreach($words as $word)
   {
    $length = mb_strlen(trim($word), CHARSET);
    if($length > $word_maxlength)
     {
      $too_long_words[] = $word;
     }
   }
  if(isset($too_long_words))
   {
    return $too_long_words;
   }
  return false;
 }

/**
 * returns an array for the page navigation
 *
 * @param int $page_count : number of pages
 * @param int $page : current page
 * @param int $browse_range
 * @param int $page
 * @param int $show_last
 * @return array
 */
function pagination($page_count,$page,$browse_range=3,$show_last=true)
 {
  if($page_count>1)
   {
    $xpagination['current'] = $page;
    if($page_count > $page)
     {
      $xpagination['next'] = $page+1;
     }
    else
     {
      $xpagination['next'] = 0;
     }
    if($page > 1)
     {
      $xpagination['previous'] = $page-1;
     }
    else
     {
      $xpagination['previous'] = 0;
     }
    $xpagination['items'][] = 1;
    if ($page > $browse_range+1) $xpagination['items'][] = 0;
    $n_range = $page-($browse_range-1);
    $p_range = $page+$browse_range;
    for($page_browse=$n_range; $page_browse<$p_range; $page_browse++)
     {
      if($page_browse > 1 && $page_browse <= $page_count) $xpagination['items'][] = $page_browse;
     }
    if($show_last)
     {
      if($page < $page_count-($browse_range)) $xpagination['items'][] = 0;
      if(!in_array($page_count,$xpagination['items'])) $xpagination['items'][] = $page_count;
     }
    return $xpagination;
   }
  return false;
 }

function truncate($string, $maxlength, $cut_string='…')
 {
  if(mb_strlen($string) <= $maxlength) return $string;
  $space_pos = mb_strrpos($string, ' ', -(mb_strlen($string) - $maxlength));
  if($space_pos!==false)
   {
    return mb_substr($string, 0, $space_pos) . ' '.$cut_string;
   }
  else
   {
    return mb_substr($string, 0, $maxlength) . $cut_string;
   }
 }

function mailto($email, $alternative_text) 
 {
  #$string = 'document.write(\'<a href="mailto:'.$email.'">'.$email.'</a>\')';
  $uid = 'uid'.uniqid();
  $string = 'document.getElementById(\''.$uid.'\').innerHTML=\'<a href="mailto:'.$email.'">'.$email.'</a>\'';
  $ret = '';
  $arr = unpack("C*", $string);
  foreach ($arr as $char)
   {
    $ret .= sprintf("%%%X", $char);
   }
  return '<span id="'.$uid.'">'.$alternative_text.'</span><script type="text/javascript">eval(unescape(\''.$ret.'\'))</script>';
}

/**
 * sends a status code, displays an error message and halts the script
 *
 * @param string $status_code
 */
function raise_error($error,$error_message='')
 {
  global $settings, $localization;

  $website_title = isset($settings['website_title']) ? $settings['website_title'] : 'phpSQLiteCMS';
  $lang = isset($localization) ? Localization::$lang['lang'] : 'en';
  $charset = isset($localization) ? Localization::$lang['charset'] : 'utf-8';

  #if(empty($lang['language'])) $lang['language'] ='en';
  #if(empty($lang['charset'])) $lang['charset'] ='utf-8';
  if(empty($settings['website_title'])) $settings['website_title'] = 'phpSQLiteCMS';

  $title = 'Error';
  $message = '';
  switch($error)
   {
    case '403':
     header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden");
     header("Status: 403 Forbidden");
     $title = '403 Forbidden';
     $message = 'You don\'t have permission to access this page.';
     break;
    case '404':
     header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
     header("Status: 404 Not Found");
     $title = '404 Not Found';
     $message = 'The requested URL was not found on this server.';
     break;
    default:
     header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
     header("Status: 503 Service Unavailable");
     $title = '503 Service Temporarily Unavailable';
     $message = 'The server is currently unable to handle the request.';
     if($error_message!='') $message = $error_message;
     else $message = 'The server is currently unable to handle the request.';
     break;
   }
  ?><!DOCTYPE html>
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $website_title.' - '.$title; ?></title>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $charset; ?>" />
  <style type="text/css">
  body              { color:#000; background:#fff; margin:0; padding:0; font-family:sans-serif; }
  h1                { font-size:28px; }  
  p,ul              { font-size:13px; line-height:150%; }
  #top              { margin:0; padding:0 30px; color:#000; background:#f8f8f8; border-bottom: 1px solid #e7e7e7; line-height:50px; }
  #top h1           { font-size:20px; margin:0; padding:0; color:#777e7d; font-weight:normal; }
  #content          { padding:20px 30px; }
  </style>
  </head>
  <body>
  <div id="top"><h1><?php echo $website_title; ?></h1></div>
  <div id="content">
  <h1><?php echo $title; ?></h1>
  <p><?php echo $message; ?></p>
  </div>
  </body>
  </html><?php
  exit;
 }
?>
