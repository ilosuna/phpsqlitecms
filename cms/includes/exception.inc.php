<?php
if(!defined('IN_INDEX')) exit;

$debug_mode = true;

$website_title = isset($settings['website_title']) ? $settings['website_title'] : 'phpSQLiteCMS';
$lang = isset($localization) ? Localization::$lang['lang'] : 'en';
$charset = isset($localization) && isset(Localization::$lang['charset']) ? Localization::$lang['charset'] : 'utf-8';
$exception_title = isset($localization) && isset(Localization::$lang['exception_title']) ? Localization::$lang['exception_title'] : 'Error';
$exception_message = isset($localization) && isset(Localization::$lang['exception_message']) ? Localization::$lang['exception_message'] : 'An error occurred while processing this directive.';

header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
header("Status: 503 Service Unavailable");
header('Content-Type: text/html; charset='.$charset);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $website_title; ?> - <?php echo $exception_title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset; ?>" />
<style type="text/css">
<!--
body              { color:#000; background:#fff; margin:0; padding:0; font-family:verdana,arial,sans-serif; font-size:100.1%; }
h1                { font-size:1.5em; }
p,ul              { font-size:0.9em; line-height:1.5em; }
#top              { margin:0; padding:0 20px 0 20px; height:4em; color:#000000; background:#d2ddea; border-bottom: 1px solid #bacbdf; line-height:4em; }
#top h1           { font-size:2em; margin:0; padding:0; color:#000080; }
#content          { padding:20px; }
-->
</style>
</head>
<body>
<div id="top"><h1><?php echo $website_title; ?></h1></div>
<div id="content">
<h1><?php echo $exception_title; ?></h1>
<p><?php echo $exception_message; ?></p>

<?php if($debug_mode && isset($exception)): ?>
<p>
<strong>Message:</strong> <?php echo $exception->getMessage(); ?><br />
<strong>Code:</strong> <?php echo $exception->getCode(); ?><br />
<strong>File:</strong> <?php echo $exception->getFile(); ?><br />
<strong>Line:</strong> <?php echo $exception->getLine(); ?><!--<br />
<strong>Trace:</strong> <?php echo $exception->getTraceAsString(); ?>-->
</p>

<?php
/*
echo '<p>'.$exception->__toString().'</p>';
echo '<pre>';
print_r($exception);
echo '</pre>';

echo '<pre>';
print_r($GLOBALS);
echo '</pre>';
*/
?>

<?php endif; ?>
</p>

</div>
</body>
</html>
