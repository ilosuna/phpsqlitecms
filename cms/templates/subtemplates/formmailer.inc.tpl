<?php if (isset($mail_sent)): ?>

    <div class="alert alert-success"><span
            class="glyphicon glyphicon-ok"></span> <?php echo $lang['formmailer_mail_sent']; ?></div>

<?php else: ?>

    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <h3><span class="glyphicon glyphicon-warning-sign"></span> <?php echo $lang['error_headline']; ?></h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php if (isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo BASE_URL . PAGE; ?>" accept-charset="<?php echo CHARSET; ?>">
        <input type="hidden" name="send" value="true">

        <div>

            <div class="form-group">
                <label for="email"><?php echo $lang['formmailer_label_email']; ?></label>
                <input id="email" class="form-control" type="email" name="email">
            </div>

            <div class="form-group">
                <label for="subject"><?php echo $lang['formmailer_label_subject']; ?></label>
                <input id="subject" class="form-control" type="text" name="subject">
            </div>

            <div class="form-group">
                <label for="message"><?php echo $lang['formmailer_label_message']; ?></label>
                <textarea id="message" class="form-control" name="message"
                          rows="12"><?php if (isset($message)) echo $message; ?></textarea>
            </div>

            <p>
                <button class="btn btn-primary btn-lg" type="submit"><span
                        class="glyphicon glyphicon-envelope"></span> <?php echo $lang['formmailer_button_send']; ?>
                </button>
            </p>

        </div>
    </form>

<?php endif; ?>
