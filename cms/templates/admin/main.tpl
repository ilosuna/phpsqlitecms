<!DOCTYPE html>
<html lang="<?php echo $lang['lang']; ?>" dir="<?php echo $lang['dir']; ?>">
<head>
    <meta charset="<?php echo $lang['charset']; ?>"/>
    <title><?php echo $settings['website_title']; ?> - <?php echo $lang['administration'];
        if (isset($subtitle)) echo ' - ' . $subtitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo STATIC_URL; ?>img/favicon.png">
</head>

<body>

<?php include(BASE_PATH . 'cms/templates/admin/subtemplates/admin_menu.inc.tpl'); ?>

<div class="container">

    <div class="row">
        <div class="col-lg-12">

            <?php if (isset($subtemplate)): ?>

                <?php include(BASE_PATH . 'cms/templates/admin/subtemplates/' . $subtemplate); ?>

            <?php elseif (isset($content)): ?>

                <?php echo $content; ?>

            <?php
            elseif (isset($error_message)): ?>

                <p class="caution"><?php echo $error_message; ?></p>

            <?php
            else: ?>

                <p class="caution"><?php echo $lang['invalid_request']; ?></p>

            <?php endif; ?>

        </div>
    </div>

</div>

<script async src="<?php echo JQUERY; ?>"></script>
<script async src="<?php echo JQUERY_UI; ?>"></script>
<script async src="<?php echo BOOTSTRAP; ?>"></script>
<?php if (isset($wysiwyg)): ?>
<script async src="<?php echo WYSIWYG_EDITOR; ?>"></script>
<script async src="<?php echo WYSIWYG_EDITOR_INIT; ?>"></script>
<?php endif; ?>
<script async src="<?php echo STATIC_URL; ?>js/admin_backend.js"></script>
<?php if ($mode == 'galleries'): ?>
<script async src="<?php echo STATIC_URL; ?>js/mylightbox.js" type="text/javascript"></script>
<?php endif; ?>
<?php if ($settings['recaptcha_login_check']): ?>
<script async src='<?php echo RECAPTCHA_SCRIPT; ?>'></script>
<?php endif; ?>
<link href="<?php echo BOOTSTRAP_CSS; ?>" rel="stylesheet">
<link href="<?php echo STATIC_URL; ?>css/style_admin.css" rel="stylesheet">
</body>
</html>
