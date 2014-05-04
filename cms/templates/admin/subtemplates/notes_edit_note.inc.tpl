<ol class="breadcrumb">
    <li><a href="index.php?mode=notes"><?php echo $lang['notes']; ?></a></li>
    <li><a href="index.php?mode=notes&amp;edit=<?php echo $note['note_section']; ?>"><?php echo $lang['notes']; ?>
            : <?php echo $note['note_section']; ?></a></li>
    <li class="active">
        <?php if (isset($note['id'])): ?>
            <?php echo $lang['edit_note']; ?>
        <?php else: ?>
            <?php echo $lang['add_note']; ?>
        <?php endif; ?></li>
</ol>

<h1>
    <?php if (isset($note['id'])): ?>
        <?php echo $lang['edit_note']; ?>
    <?php else: ?>
        <?php echo $lang['add_note']; ?>
    <?php endif; ?>
</h1>

<?php include('errors.inc.tpl'); ?>

<form action="index.php" method="post" name="notesform">
    <div>
        <input type="hidden" name="mode" value="notes">
        <input type="hidden" name="text_formatting" value="0">
        <input type="hidden" name="edit_note_submit" value="true">
        <?php if (isset($note['id'])): ?>
            <input type="hidden" name="id" value="<?php echo $note['id']; ?>"/>
        <?php endif; ?>
        <input type="hidden" name="note_section" value="<?php echo $note['note_section']; ?>"/>

        <div class="form-group">
            <label for="title"><?php echo $lang['edit_note_title']; ?></label>
            <input id="title" class="form-control" type="text" name="title"
                   value="<?php if (isset($note['title'])) echo $note['title']; ?>">
        </div>

        <div class="form-group">
            <label for="text"><?php echo $lang['edit_note_text']; ?></label>
            <textarea id="text" class="form-control" name="text"
                      rows="10"><?php if (isset($note['text'])) echo $note['text']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="link"><?php echo $lang['edit_note_link']; ?></label>
            <input id="link" class="form-control" type="text" name="link"
                   value="<?php if (isset($note['link'])) echo $note['link']; ?>">
        </div>

        <div class="form-group">
            <label for="linkname"><?php echo $lang['edit_note_linkname']; ?></label>
            <input id="linkname" class="form-control" type="text" name="linkname"
                   value="<?php if (isset($note['linkname'])) echo $note['linkname']; ?>">
        </div>

        <div class="form-group">
            <label for="time"><?php echo $lang['edit_note_date_marking']; ?></label>
            <input id="time" class="form-control" type="text" name="time"
                   value="<?php if (isset($note['time'])) echo $note['time']; ?>"
                   placeholder="<?php echo $lang['edit_time_format']; ?>">
        </div>

        <button class="btn btn-primary" type="submit"><?php echo $lang['submit_button_ok']; ?></button>

    </div>
</form>
