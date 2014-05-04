<ol class="breadcrumb">
    <li><a href="index.php?mode=notes"><?php echo $lang['notes']; ?></a></li>
    <li class="active"><?php echo $lang['create_note_section']; ?></li>
</ol>

<h1><?php echo $lang['create_note_section']; ?></h1>

<?php include('errors.inc.tpl'); ?>

<form action="index.php" method="post">
    <div>
        <input type="hidden" name="mode" value="notes"/>

        <label for="new_note_section"><?php echo $lang['note_section_name_m']; ?></label>

        <div class="input-group form-control-default">
            <input class="form-control" id="new_note_section" type="text" name="new_note_section"
                   value="<?php if (isset($new_note_section)) echo stripslashes($new_note_section); ?>" size="25"/>
            <span class="input-group-btn">
            <button class="btn btn-primary" type="submit"><?php echo $lang['submit_button_ok']; ?></button>
            </span>
        </div>
</form>

