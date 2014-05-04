<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['notes']; ?></h1>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success btn-top pull-right" href="index.php?mode=notes&amp;action=new"><span
                class="glyphicon glyphicon-plus"></span> <?php echo $lang['create_note_section']; ?></a>
    </div>
</div>

<?php if (isset($note_sections)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo $lang['note_section']; ?></th>
                <th colspan="2">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            foreach ($note_sections as $note_section): ?>
                <tr>
                    <td><?php echo $note_section; ?></td>
                    <td class="nobreak options">
                        <a class="btn btn-primary btn-xs"
                           href="index.php?mode=notes&amp;edit=<?php echo $note_section; ?>"
                           title="<?php echo $lang['edit']; ?>">
                           <span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-danger btn-xs"
                           href="index.php?mode=notes&amp;delete=<?php echo $note_section; ?>"
                           title="<?php echo $lang['delete']; ?>"
                           data-delete-confirm="<?php echo rawurlencode($lang['delete_this_note_section']); ?>">
                           <span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php $i++; endforeach; ?>
            <tbody>
        </table>
    </div>

<?php else: ?>

    <div class="alert alert-warning">
        <?php echo $lang['no_note_sections']; ?></em></p>
    </div>

<?php endif; ?>
