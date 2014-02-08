<!DOCTYPE html>
<html lang="<?php echo $lang['lang']; ?>" dir="<?php echo $lang['dir']; ?>">
<head>
<meta charset="<?php echo $lang['charset']; ?>" />
<title><?php echo $settings['website_title']; ?> - <?php echo $lang['administration']; if(isset($subtitle)) echo ' - ' . $subtitle; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo STATIC_URL; ?>css/style_admin.css" rel="stylesheet">

<link rel="shortcut icon" href="<?php echo STATIC_URL; ?>img/favicon.png">
</head>

<body>

<?php include(BASE_PATH.'cms/templates/admin/subtemplates/admin_menu.inc.tpl'); ?>

<div class="container">

<div class="row">
<div class="col-lg-12">

<?php if(isset($subtemplate)): ?>

<?php include(BASE_PATH.'cms/templates/admin/subtemplates/'.$subtemplate); ?>

<?php elseif(isset($content)): ?>

<?php echo $content; ?>

<?php elseif(isset($error_message)): ?>

<p class="caution"><?php echo $error_message; ?></p>

<?php else: ?>

<p class="caution"><?php echo $lang['invalid_request']; ?></p>

<?php endif; ?>

</div>
</div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="<?php echo STATIC_URL; ?>js/admin_backend.js"></script>
<?php if($mode=='galleries'): ?>
<script src="<?php echo STATIC_URL; ?>js/mylightbox.js" type="text/javascript"></script>   
<?php endif; ?>
</body>
</html>

