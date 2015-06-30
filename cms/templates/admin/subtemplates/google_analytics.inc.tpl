<h1><?php echo $lang['google_analytics']; ?></h1>

<?php include('errors.inc.tpl'); ?>

<?php if (isset($saved)): ?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="glyphicon glyphicon-ok"></span> <?php echo $lang['google_analytics_saved']; ?>
</div>
<?php endif; ?>

<form action="index.php" method="post" class="form-horizontal">
    <div>
        <input type="hidden" name="mode" value="google_analytics"/>
        <input type="hidden" name="google_analytics_submit" value="true"/>

        <div class="form-group">
            <span class="help-block"><?php echo $lang['google_analytics_desc']; ?></span>
            <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id"
                   placeholder="<?php echo $lang['google_analytics_id']; ?>"
                   value="<?php echo htmlspecialchars($google_analytics_id); ?>">
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input id="google_analytics_check" type="checkbox"
                           name="google_analytics_check"<?php if (isset($google_analytics_check) && $google_analytics_check == 1): ?> checked<?php endif; ?>> <?php echo $lang['google_analytics_check']; ?>
                </label><br/>
            </div>
        </div>

    <button class="btn btn-primary" type="submit"><?php echo $lang['google_analytics_submit']; ?></button>
</div>
</form>
