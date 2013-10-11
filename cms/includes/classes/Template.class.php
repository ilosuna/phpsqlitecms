<?php
/**
 * A very simple template class
 *
 * @author Mark Alexander Hoschek <alex at mylittlehomepage dot net>
 * @copyright 2009 Mark Alexander Hoschek
 */

class Template
 {
  private $_templateVars = false;

  /**
  * assigns template vars
  *
  * @param string $name
  * @param string $value
  */
  public function assign($name,$value)
   {
    $this->_templateVars[$name] = $value;
   }

  /**
  * displays the template
  *
  * @param string $template
  */
  public function display($template)
   {
    if($this->_templateVars)
     {
      foreach($this->_templateVars as $__key => $__val)
       {
        $$__key = $__val;
       }
     }
    include($template);
   }

  /**
  * returns template content
  *
  * @param string $template
  * @return string
  */
  public function fetch($template)
   {
    if($this->_templateVars)
     {
      foreach($this->_templateVars as $__key => $__val)
       {
        $$__key = $__val;
       }
     }
    ob_start();
    include($template);
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
   }
 }
?>
