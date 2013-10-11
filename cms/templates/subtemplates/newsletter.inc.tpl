<?php if(isset($errors)): ?>
<p id="errors" class="caution"><?php echo $lang['error_headline']; ?></p>
<ul>
 <?php foreach($errors as $error): ?>
 <li><?php if(isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
 <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if($admin): ?>

<?php if(isset($emails2delete)): ?>

<p class="caution"><?php echo $lang['newsletter_delete_confirm']; ?></p>
<ul>
 <?php foreach($emails2delete as $email2delete): ?>
 <li><?php echo $email2delete['email']; ?></li>
 <?php endforeach; ?>
</ul>

<form action="<?php echo BASE_URL.PAGE; ?>" method="post">
 <div>
  <?php foreach($emails2delete as $email2delete): ?>
  <input type="hidden" name="checked[]" value="<?php echo $email2delete['id']; ?>" />
  <?php endforeach; ?>
  <input type="submit" name="delete_confirm" value="<?php echo $lang['newsletter_delete_confirm_submit']; ?>" />
 </div>
</form>

<?php else: ?>

<?php if(isset($newsletter_data)): ?>
<h2><?php echo $lang['newsletter_email_list']; ?></h2>
<p><textarea onfocus="this.select()" readonly="readonly" cols="70" rows="7" style="width:100%;" /><?php echo $email_list; ?></textarea><br />
<span class="small"><?php echo str_replace('[number]', $email_count, $lang['newsletter_email_count']); ?></span></p>

<h2><?php echo $lang['newsletter_edit_emails']; ?></h2>

<form id="emailform" action="<?php echo BASE_URL.PAGE; ?>" method="post">
<table class="normaltab" cellspacing="1" cellpadding="5" border="0">
<tr>
<th>&nbsp;</th>
<th><a href="<?php echo BASE_URL.PAGE; ?>,<?php if($order=='email-asc'): ?>email-desc<?php else: ?>email-asc<?php endif; ?>"><?php echo $lang['newsletter_email']; ?></a></th>
<th><a href="<?php echo BASE_URL.PAGE; ?>,<?php if($order=='time-asc'): ?>time-desc<?php else: ?>time-asc<?php endif; ?>"><?php echo $lang['newsletter_subscribe_time']; ?></a></th>
<th>&nbsp;</th>
</tr>
<?php $i=0; foreach($newsletter_data as $item): ?>
<tr class="<?php if($i % 2 == 0) echo "odd"; else echo "even"; ?>">
<td><input type="checkbox" name="checked[]" value="<?php echo $item['id']; ?>" /></td>
<td><a href="mailto:<?php echo $item['email']; ?>"><?php echo $item['email']; ?></a> <small>(<a href="http://<?php echo $item['domain']; ?>"><?php echo $item['domain']; ?></a>)</small></td>
<td><?php echo $lang['newsletter_subscribe_time_format'][$item['id']]; ?></a></td>
<td><a href="<?php echo BASE_URL.PAGE; ?>,delete,<?php echo $item['id']; ?>"><img src="<?php echo BASE_URL; ?>templates/images/delete.png" alt="<?php echo $lang['delete']; ?>" title="<?php echo $lang['delete']; ?>" width="16" height="16" /></a>
<!--
<td><form action="<?php echo BASE_URL.PAGE; ?>" method="post"><input type="hidden" name="email_id" value="<?php echo $item['id']; ?>" /><input type="submit" name="delete_email" value="<?php echo $lang['newsletter_email_delete']; ?>"></form>
</td>-->
</tr>
<?php ++$i; endforeach; ?>

<tr class="<?php if($i % 2 == 0) echo "odd"; else echo "even"; ?>">
<td colspan="2"><small><img style="margin-left:7px;" src="<?php echo BASE_URL; ?>templates/images/checkall.png" alt="" width="24" height="20" /> <a href="#" onclick="checkall('emailform', true); return false;"><?php echo $lang['newsletter_checkall']; ?></a> / <a href="#" onclick="checkall('emailform', false); return false;"><?php echo $lang['newsletter_uncheckall']; ?></a></small></td>
<td colspan="2" style="text-align:right;"><input type="submit" name="delete_checked" value="<?php echo $lang['newsletter_delete_checked']; ?>" /></td>
</tr> 

</table>
</form>

<?php else: ?>
<p><em><?php echo $lang['newsletter_no_emails']; ?></em></p>
<?php endif; ?>

<form action="<?php echo BASE_URL.PAGE; ?>" method="post">
<div style="margin-top:20px;">
<p><label for="add_email"><?php echo $lang['newsletter_add_email']; ?></label><br /><input id="add_email" type="text" name="add_email" value="" size="35" /> <input type="submit" name="" value="<?php echo $lang['submit_button_ok']; ?>" /></p>
</div>
</form>

<?php endif; ?>

<?php else: ?>

<?php if(isset($confirm_mail_sent)): ?>
<p><?php echo $lang['newsletter_conf_mail_sent']; ?></p>
<?php elseif(isset($confirmation_ok)): ?>
<p><?php echo $lang['newsletter_conf_ok']; ?></p>
<?php elseif(isset($delete_ok)): ?>
<p><?php echo $lang['newsletter_delete_ok']; ?></p>
<?php elseif(isset($confirmation_failed)): ?>
<p><?php echo $lang['newsletter_conf_failed']; ?></p>

<?php else: ?>
<form action="<?php echo BASE_URL.PAGE; ?>" method="post">
<p><label for="email"><?php echo $lang['newsletter_subscr_email']; ?></label><br />
<input id="email" type="text" name="email" value="<?php if(isset($email)) echo $email; ?>" size="25" maxlength="200" /> <input type="submit" name="" value="<?php echo $lang['submit_button_ok']; ?>" /></p>
<p class="small"><input id="subscribe" type="radio" name="subscribe" value="subscribe" checked="checked" /><label for="subscribe"><?php echo $lang['newsletter_subscribe']; ?></label><br />
<input id="unsubscribe" type="radio" name="subscribe" value="unsubscribe" /><label for="unsubscribe"><?php echo $lang['newsletter_unsubscribe']; ?></label></p>
</form>
<?php endif; ?>

<?php endif; ?>
