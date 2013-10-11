<?php
if(!defined('IN_INDEX') || empty($_SESSION[$settings['session_prefix'].'user_id'])) exit;

if(isset($_GET['msg']))
 {
  $template->assign('msg',htmlspecialchars($_GET['msg']));
 }

$template->assign('subtemplate', 'admin_index.inc.tpl');
?>
