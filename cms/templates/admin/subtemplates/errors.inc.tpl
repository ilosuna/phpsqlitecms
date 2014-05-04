<?php if (isset($errors)): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h3><span class="glyphicon glyphicon-warning-sign"></span>
            <strong><?php echo $lang['error_headline']; ?></strong></h3>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php if (isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
