<?php
class Localization
 {
  const FORMAT_TIME = true;
  private static $_instance = null;
  public static $lang;
  private static $_lang;
  private $replacement;

  public function __construct($language_file)
   {
    self::$_instance = $this;

    if($language_file)
     {
      require($language_file);
      self::$lang = $lang;
     }
    else
     {
      die('No language file specifed!');
     }
   }

  public function add_language_file($language_file)
   {
    require($language_file);
    self::$lang = array_merge(self::$lang, $lang);
   }

  #private function __clone() {}

  public static function getInstance()
   {
    #static $instance = null;
    #if(isset($new_instance) && is_object($new_instance))
    # {
    #  self::$instance = $new_instance;
    # }
    return self::$_instance;
   }


  #public static function getInstance($language_file=false)
  # {
  #  if(self::$instance === NULL)
  #   {
  #    self::$instance = new self($language_file);
  #   }
  #  return self::$instance;
  # }

  public function assign($key, $val)
   {
    self::$lang[$key] = $val;
   }

  public function replacePlaceholder($placeholder, $replacement, $index, $format_time=false)
   {
    if($format_time)
     {
      $this->replacement = $replacement;
      self::$lang[$index] = preg_replace_callback('/\['.$placeholder.'\|(.*?)\]/', array(&$this, '_callbackFormatTimeWrapper'), self::$lang[$index]);
     }
    else
     {
      self::$lang[$index] = str_replace('['.$placeholder.']', $replacement, self::$lang[$index]);
     }
   }

  public function replacePlaceholderBound($placeholder, $replacement, $index, $id, $format_time=false)
   {
    if($format_time)
     {
      $this->replacement = $replacement;
      self::$lang[$index][$id] = preg_replace_callback('/\['.$placeholder.'\|(.*?)\]/', array(&$this, '_callbackFormatTimeWrapper'), self::$lang[$index][$id]);
     }
    else
     {
      self::$lang[$index][$id] = str_replace('['.$placeholder.']', $replacement, self::$lang[$index][$id]);
     }
   }

  public function bindId($index, $id)
   {
    if(empty(self::$_lang[$index]))
     {
      self::$_lang[$index] = self::$lang[$index];
      unset(self::$lang[$index]);
     }
    self::$lang[$index][$id] = self::$_lang[$index];
   }

  public function bindReplacePlaceholder($id, $placeholder, $replacement, $index, $format_time=false)
   {
    $this->bindId($index, $id);
    $this->replacePlaceholderBound($placeholder, $replacement, $index, $id, $format_time);
   }

  public function selectVariant($index, $i)
   {
    self::$lang[$index] = self::$lang[$index][$i];
   }

  public function selectBoundVariant($index, $id, $i)
   {
    self::$lang[$index][$id] = self::$lang[$index][$id][$i];
   }

  public function replaceLink($link, $index)
   {
    self::$lang[$index] = str_replace('[[', '<a href="'.$link.'">', self::$lang[$index]);
    self::$lang[$index] = str_replace(']]', '</a>', self::$lang[$index]);
   }

  private function _callbackFormatTimeWrapper($matches)
   {
    return $this->_callbackFormatTime($matches[1], $this->replacement);
   }

  private function _callbackFormatTime($format, $timestamp)
   {
    return strftime($format, $timestamp);
   }
 }
?>
