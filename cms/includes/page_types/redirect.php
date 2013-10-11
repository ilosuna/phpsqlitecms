<?php
#unset($template_file);

if(isset($cache) && $cache->doCaching)
 {
  $cache->cacheId = PAGE;
  $cache_content = "<?php\nheader('".$_SERVER['SERVER_PROTOCOL']." 301 Moved Permanently');\nheader('Location: ".$data['type_addition']."');\n?>";
  $cache->createChacheFile($cache_content);
 }

header($_SERVER['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
header('Location: '.$data['type_addition']);
?>
