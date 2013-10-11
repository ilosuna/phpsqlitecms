<?php if(isset($mail_sent)): ?>

<p class="ok"><?php echo $lang['formmailer_mail_sent']; ?></p>

<?php else: ?>

<?php if(isset($errors)): ?>
<p id="errors" class="caution"><?php echo $lang['error_headline']; ?></p>
<ul>
 <?php foreach($errors as $error): ?>
 <li><?php if(isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
 <?php endforeach; ?>
</ul>
<script type="text/javascript">/* <![CDATA[ */ location.hash='errors'; /* ]]> */</script>
<?php endif; ?>

<form method="post" action="<?php echo BASE_URL.PAGE; ?>" accept-charset="<?php echo CHARSET; ?>">
<div>
<p><label for="email"><?php echo $lang['formmailer_label_email']; ?></label><br />
<input id="email" type="text" name="email" value="<?php if(isset($email)) echo $email; ?>" size="35" /></p>
<p><label for="subject"><?php echo $lang['formmailer_label_subject']; ?></label><br />
<input id="subject" type="text" name="subject" value="<?php if(isset($subject)) echo $subject; ?>" size="35" /></p>
<p><label for="message"><?php echo $lang['formmailer_label_message']; ?></label><br />
<textarea id="message" name="message" cols="55" rows="12"><?php if(isset($message)) echo $message; ?></textarea></p>
<p><input type="submit" name="send" value="<?php echo $lang['formmailer_button_send']; ?>" /></p>
</div>
</form>

<?php endif; ?>
