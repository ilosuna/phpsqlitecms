<!DOCTYPE html>
<html lang="<?php echo $lang['lang']; ?>" dir="<?php echo $lang['dir']; ?>">
<head>
    <meta charset="<?php echo $lang['charset']; ?>"/>
    <title><?php echo $settings['website_title']; ?> - <?php echo $lang['administration'];
        if (isset($subtitle)) echo ' - ' . $subtitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo BOOTSTRAP_CSS; ?>" rel="stylesheet">
    <link href="<?php echo STATIC_URL; ?>css/style_admin.css" rel="stylesheet">

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

<script src="<?php echo JQUERY; ?>"></script>
<script src="<?php echo JQUERY_UI; ?>"></script>
<script src="<?php echo BOOTSTRAP; ?>"></script>

<?php if (!isset($wysiwyg)): ?>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js"></script>
    <script src="http://nightwing.github.io/emmet-core/emmet.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ext-emmet.js"></script>

    <script>
        var textarea = $('#content');
        textarea.before('<div id="ace-editor"></div>').hide();
        $('#ace-editor').height(textarea.height()).width(textarea.width());

        $(window).resize(function() {
            $('#ace-editor').height(textarea.height()).width(textarea.width());
        });

        var editor = ace.edit("ace-editor");
        // Settings
        editor.getSession().setMode("ace/mode/html");
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setUseSoftTabs(true);
        editor.getSession().setUseWrapMode(true);
        editor.setShowPrintMargin(false);
        editor.setOption("enableEmmet", true);

        editor.getSession().setValue(textarea.val());

        $('form:first').submit(function() {
            textarea.val(editor.getSession().getValue());
        });

    </script>

<?php else: ?>

    <script src="<?php echo WYSIWYG_EDITOR; ?>"></script>
    <script src="<?php echo WYSIWYG_EDITOR_INIT; ?>"></script>
<?php endif; ?>
<script src="<?php echo STATIC_URL; ?>js/admin_backend.js"></script>
<?php if ($mode == 'galleries'): ?>
    <script src="<?php echo STATIC_URL; ?>js/mylightbox.js" type="text/javascript"></script>
<?php endif; ?>
</body>
</html>
