<?php
/**
 * phpSQLiteCMS - a simple and lightweight PHP web content management system
 * based on PHP and SQLite
 *
 * @author Mark Hoschek < mail at mark-hoschek dot de >
 * @copyright Mark Hoschek 2014
 * @version 3.x
 * @link http://phpsqlitecms.net/
 * @package phpSQLiteCMS
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Mark Hoschek
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

session_start();

define('CACHE_DIR', 'cms/cache/');

// get query string passed by mod_rewrite:
if(isset($_GET['qs']))
 {
  if(get_magic_quotes_gpc()) $_GET['qs'] = stripslashes($_GET['qs']);
  $qs = $_GET['qs'];
 }
else
 {
  $qs = '';
 }

// check if requested page is cached and if so displays it:
if(empty($_POST) && file_exists('./'.CACHE_DIR.'settings.php'))
 {
  include('./'.CACHE_DIR.'settings.php');
  if(empty($_SESSION[$settings['session_prefix'].'user_id']))
   {
    if($qs=='') $cache_file = rawurlencode(strtolower($settings['index_page'])).'.cache';
    else $cache_file = rawurlencode(strtolower($qs)).'.cache';
    if(file_exists('./'.CACHE_DIR.$cache_file))
     {
      include('./'.CACHE_DIR.$cache_file);
      exit; // that's it if cached page is available.
     }
   }
 }

define('IN_INDEX', TRUE);

try
 {
  #throw new Exception('Error message...');
  #require('./cms/config/db_settings.conf.php');
  require('./cms/includes/functions.inc.php');

  // load replacement functions for the multibyte string functions
  // if they are not available:
  #if(!defined('MB_CASE_LOWER')) require('./cms/includes/functions.mb_replacements.inc.php');

  require('./cms/includes/classes/Database.class.php');
  $database = new Database();

  $settings = get_settings();

  // access permission check for not registered users:
  if($settings['check_access_permission']==1 && !isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    if(is_access_denied()) raise_error('403');
   }

  // set timezone:
  if($settings['time_zone']) date_default_timezone_set($settings['time_zone']);

  define('BASE_URL', get_base_url());
  define('STATIC_URL', BASE_URL.'static/');
  define('BASE_PATH', get_base_path());
  
  require(BASE_PATH.'cms/config/definitions.conf.php');
  
  if($settings['content_functions']==1) require(BASE_PATH.'cms/includes/functions.content.inc.php');

  require('./cms/includes/classes/Template.class.php');
  $template = new Template();
  #$template->set_settings($settings);

  if($settings['caching'])
   {
    $cache = new Cache(BASE_PATH.CACHE_DIR, $settings);
    if(!empty($_POST) || isset($_SESSION[$settings['session_prefix'].'user_id']))
     {
      $cache->doCaching = false;
     }
   }

  if(isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    $template->assign('admin', true);
    $template->assign('user_id', $_SESSION[$settings['session_prefix'].'user_id']);
    $template->assign('user_type', $_SESSION[$settings['session_prefix'].'user_type']);
    
   }
  else
   {
    $template->assign('admin', false);
   }

  $template->assign('settings', $settings);

  $template->assign('BASE_URL', BASE_URL);

  $qsp = explode(',',$qs);
  if($qsp[0] == '')
   {
    define('PAGE', strtolower($settings['index_page']));
   }
  else
   {
    define('PAGE',strtolower($qsp[0]));
   }

  // append comma separated parameters to $_GET ($_GET['get_1'], $_GET['get_2'] etc.):
  if(isset($qsp[1]))
   {
    $items = count($qsp);
    for($i=1;$i<$items;++$i)
     {
      $_GET['get_'.$i] = $qsp[$i];
     }
   }

  #if(isset($_GET['get_1']) && $_GET['get_1']==IMAGE_IDENTIFIER && isset($_GET['get_2']))
  # {
  #  // photo:
  #  include(BASE_PATH.'cms/includes/photo.inc.php');
  # }
  #else
  # {
    // regular content:
    include(BASE_PATH.'cms/includes/content.inc.php');
  # }

  if(isset($_SESSION[$settings['session_prefix'].'user_id'])) $localization->add_language_file(BASE_PATH.'cms/lang/'.$settings['admin_language'].'.admin.lang.php');
  
  // display template:
  if(isset($template_file))
   {
    $template->assign('lang', Localization::$lang);
    $template->assign('content_type', $content_type);
    $template->assign('charset', Localization::$lang['charset']);
    header('Content-Type: '.$content_type.'; charset='.Localization::$lang['charset']);
    $template->display(BASE_PATH.'cms/templates/'.$template_file);
    // create cache file:
    if(isset($cache))
     {
      if($cache->cacheId && $cache->doCaching)
       {
        $cache_content = $cache->createCacheContent($template->fetch(BASE_PATH.'cms/templates/'.$template_file), $content_type, CHARSET);
        $cache->createChacheFile($cache_content);
       }
     }
   }
 } // end try
catch(Exception $exception)
 {
  include('./cms/includes/exception.inc.php');
 }
?>
