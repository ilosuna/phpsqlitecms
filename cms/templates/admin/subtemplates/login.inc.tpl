<h1><?php echo $lang['login']; ?></h1>

<?php if (isset($_GET['msg']) && ($_GET['msg']=='login_failed' || $_GET['msg']=='wrong_captcha')): ?>
    <div class="alert alert-danger">
        <strong><?php echo $lang[$_GET['msg']]; ?></strong>
    </div>
<?php endif; ?>

<form action="index.php" method="post">
    <fieldset>
        <div class="form-group login-form">
            <label for="login"><?php echo $lang['login_username']; ?></label>
            <input id="login" type="text" name="username" class="form-control" autofocus/></p>
        </div>

        <div class="form-group login-form">
            <label for="pw"><?php echo $lang['login_password']; ?></label>
            <input id="pw" type="password" name="userpw" class="form-control"/>
        </div>
        
        <?php if($settings['recaptcha_login_check']): ?>
        <div class="form-group login-form">
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($settings['recaptcha_public_key']); ?>"></div>
        </div>
        <?php endif; ?>
        
        <input type="submit" class="btn btn-lg btn-primary" value="<?php echo $lang['login_submit']; ?>"/>

    </fieldset>
</form>



