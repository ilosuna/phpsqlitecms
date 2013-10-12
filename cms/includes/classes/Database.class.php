<?php
class Database
 {
  const ADMIN = 1;
  private static $_instance = null;
  public static $db_settings;
  public static $complete;
  public static $content;
  public static $entries;
  public static $userdata;

  public function __construct($mode=0)
   {
    self::$_instance = $this;
    if($mode==0)
     {
      require('./cms/config/db_settings.conf.php');
     }
    else
     {
      require('./config/db_settings.conf.php');
     }
    self::$db_settings = $db_settings;

    switch(self::$db_settings['type'])
     {
      case 'sqlite':
       if($mode==0)
        {
         self::$content = new PDO('sqlite:'.self::$db_settings['db_content_file']);
         self::$entries = new PDO('sqlite:'.self::$db_settings['db_entry_file']);
         #self::$content = new PDO('sqlite:'.self::$db_settings['db_content_file'], NULL, NULL, array(PDO::ATTR_PERSISTENT => TRUE));
         #self::$entries = new PDO('sqlite:'.self::$db_settings['db_entry_file'], NULL, NULL, array(PDO::ATTR_PERSISTENT => TRUE));
         self::$content->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         self::$entries->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
       if($mode==1)
        {
         self::$content = new PDO('sqlite:../'.self::$db_settings['db_content_file']);
         self::$entries = new PDO('sqlite:../'.self::$db_settings['db_entry_file']);
         self::$userdata = new PDO('sqlite:../'.self::$db_settings['db_userdata_file']);
         self::$content->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         self::$entries->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         self::$userdata->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
       break;
      case 'sqlite2':
       if($mode==0)
        {
         self::$content = new PDO('sqlite2:'.self::$db_settings['db_content_file']);
         self::$entries = new PDO('sqlite2:'.self::$db_settings['db_entry_file']);
        }
       if($mode==1)
        {
         self::$content = new PDO('sqlite2:../'.self::$db_settings['db_content_file']);
         self::$entries = new PDO('sqlite2:../'.self::$db_settings['db_entry_file']);
         self::$userdata = new PDO('sqlite2:../'.self::$db_settings['db_userdata_file']);
        }
       break;
      case 'mysql':
       self::$complete = new PDO('mysql:host='.self::$db_settings['host'].';port='.self::$db_settings['port'].';dbname='.self::$db_settings['database'], self::$db_settings['user'], self::$db_settings['password']);
       self::$complete->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       self::$complete->query("set names utf8");
       self::$content =& self::$complete;
       self::$entries =& self::$complete;
       if($mode==1) self::$userdata =& self::$complete;
       break;
      case 'postgresql':
       self::$complete = new PDO('pgsql:dbname='.self::$db_settings['database'].';host='.self::$db_settings['host'].';user='.self::$db_settings['user'].';password='.self::$db_settings['password']);
       self::$complete->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       #self::$complete->query("set names utf8");
       self::$content =& self::$complete;
       self::$entries =& self::$complete;
       if($mode==1) self::$userdata =& self::$complete;
       break;
     default:
      ?><p>Database type not supported.</p><?php
      exit;
     }
   }

  public static function getInstance()
   {
    return self::$_instance;
   }
 }
?>
