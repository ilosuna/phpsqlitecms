<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id'])) {

    $img_path = BASE_PATH.MEDIA_DIR;
    $fp=opendir($img_path);
    while($file = readdir($fp))
    {
        if(preg_match('/\.jpg$/i', $file) || preg_match('/\.jpeg$/i', $file) || preg_match('/\.png$/i', $file) || preg_match('/\.gif$/i', $file)) {
         $images[] = array("title"=>$file, "value"=>BASE_URL . MEDIA_DIR . $file);
        }
    }
    closedir($fp);

    header('Content-type: application/json');
    echo json_encode($images);
    exit;
}
?>
