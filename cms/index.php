<?php
/**
 * phpSQLiteCMS - a simple and lightweight PHP web content management system
 * based on PHP and SQLite
 *
 * @author Mark Alexander Hoschek <alex at phpsqlitecms dot net>
 * @copyright 2006-2010 Mark Alexander Hoschek
 * @version 2.0.5
 * @link http://phpsqlitecms.net/
 * @package phpSQLiteCMS
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

try
 {
  session_start();
  define('IN_INDEX', TRUE);
  #include('./config/db_settings.conf.php');
  require('./includes/functions.inc.php');
  require('./includes/functions.admin.inc.php');

  // load replacement functions for the multibyte string functions
  // if they are not available:
  if(!defined('MB_CASE_LOWER')) require('./includes/functions.mb_replacements.inc.php');

  require('./includes/classes/Database.class.php');
  $database = new Database(Database::ADMIN);

  $settings = get_settings();

  // access permission check for not registered users:
  if($settings['check_access_permission']==1 && !isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    if(is_access_denied()) raise_error('403');
   }

  define('VALID_URL_CHARACTERS', '/^[a-zA-Z0-9._\-\/]+$/');
  #define('VALID_URL_CHARACTERS', '/.*/');
  #define('VALID_URL_CHARACTERS', '/^[\p{Cyrillic}a-zA-Z0-9._\-\/]+$/u');

  define('ADMIN_DIR', 'cms/');
  define('MEDIA_DIR', 'static/media/');
  define('CACHE_DIR', 'cms/cache/');
  define('IMAGE_IDENTIFIER', 'photo');
  define('BASE_URL',get_base_url(ADMIN_DIR));
  define('STATIC_URL', BASE_URL.'static/');
  define('BASE_PATH',get_base_path(ADMIN_DIR));

  define('WYSIWYG_EDITOR', 'cms/modules/tiny_mce/tiny_mce.js');
  define('WYSIWYG_EDITOR_INIT', 'js/wysiwyg_init.js');

  if($settings['caching'])
   {
    $cache = new Cache(BASE_PATH.CACHE_DIR, $settings);
    if(empty($settings['admin_auto_clear_cache'])) $cache->autoClear=false;
   }

  if(isset($cache) && isset($_GET['clear_cache']) && isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    $cache->clear();
    header('Location: index.php?msg=cache_cleared');
    exit;
   }

  // set timezone:
  if($settings['time_zone']) date_default_timezone_set($settings['time_zone']);

  #require('./lang/'.$settings['admin_language_file']);
  $localization = new Localization(BASE_PATH.'cms/lang/'.$settings['admin_language'].'.admin.lang.php');
  define('CHARSET', Localization::$lang['charset']);

  require('./includes/classes/Template.class.php');
  $template = new Template();
  $template->assign('settings', $settings);
  #$template->set_settings($settings);

  // set local language settings:
  setlocale(LC_ALL, Localization::$lang['locale']);

  $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'admin_index';

  // go to login if not logged in:
  if(empty($_SESSION[$settings['session_prefix'].'user_id']))
   {
    $mode = 'login';
    $template->assign('admin',false);
   }
  else
   {
    $template->assign('admin', true);
    $template->assign('user_id', $_SESSION[$settings['session_prefix'].'user_id']);
    $template->assign('user_type', $_SESSION[$settings['session_prefix'].'user_type']);
   }

  // include required file for mode:
  switch($mode)
   {
    #case 'index': include('./includes/admin_index.inc.php'); break;
    case 'login': include('./includes/login.inc.php'); break;
    case 'logout': include('./includes/login.inc.php'); break;
    case 'edit': include('./includes/edit.inc.php'); break;
    case 'pages': include('./includes/pages.inc.php'); break;
    case 'galleries': include('./includes/galleries.inc.php'); break;
    case 'gcb': include('./includes/gcb.inc.php'); break;
    case 'notes': include('./includes/notes.inc.php'); break;
    case 'comments': include('./includes/comments.inc.php'); break;
    case 'filemanager': include('./includes/filemanager.inc.php'); break;
    case 'spam_protection': include('./includes/spam_protection.inc.php'); break;
    case 'users': include('./includes/users.inc.php'); break;
    case 'settings': include('./includes/settings.inc.php'); break;
    case 'menus': include('./includes/menus.inc.php'); break;
    case 'image': include('./includes/insert_image.inc.php'); break;
    case 'modal': include('./includes/modal.inc.php'); break;
    case 'thumbnail': include('./includes/insert_thumbnail.inc.php'); break;
    case 'ajaxprocess': include('./includes/ajaxprocess.inc.php'); break;
    default: include('./includes/admin_index.inc.php');
   }

  $template->assign('mode',$mode);
  $template->assign('lang',Localization::$lang);
  #$template->set_lang($lang);

  header('Content-Type: text/html; charset='.Localization::$lang['charset']);
  if(empty($template_file))
   {
    $template_file = 'main.tpl';
   }
  $template->display(BASE_PATH.'cms/templates/admin/'.$template_file);
 } // end try

catch(Exception $exception)
 {
  include('./includes/exception.inc.php');
 }
?>
