<ol class="breadcrumb">
    <li><a href="index.php?mode=notes"><?php echo $lang['notes']; ?></a></li>
    <li class="active"><?php echo $lang['notes']; ?>: <?php echo $note_section; ?></li>
</ol>

<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['notes']; ?>: <?php echo $note_section; ?></h1>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success btn-top pull-right"
           href="index.php?mode=notes&amp;add_note=<?php echo $note_section; ?>">
            <span class="glyphicon glyphicon-plus"></span> <?php echo $lang['add_note']; ?></a>
    </div>
</div>

<?php if (isset($notes)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tbody data-sortable="<?php echo BASE_URL; ?>cms/?mode=notes&amp;reorder_notes=true">
            <?php $i = 0;
            foreach ($notes as $note): ?>
                <tr id="item_<?php echo $note['id']; ?>">
                    <td class="<?php if ($i % 2 == 0): ?>a<?php else: ?>b<?php endif; ?>" style="cursor:move;">
                        <h3><?php echo stripslashes($note['title']); ?></h3>

                        <p><?php echo $note['text']; ?>
                            <?php if ($note['link'] != ''): ?><br/>
                                <a
                                href="<?php echo $note['link']; ?>"><?php echo $note['linkname']; ?></a><?php endif; ?>
                        </p>
                    </td>
                    <td class="options nowrap">
                        <a class="btn btn-primary btn-xs"
                           href="index.php?mode=notes&amp;edit_note=<?php echo $note['id']; ?>"
                           title="<?php echo $lang['edit']; ?>">
                            <span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-danger btn-xs"
                           href="index.php?mode=notes&amp;delete_note=<?php echo $note['id']; ?>"
                           title="<?php echo $lang['delete']; ?>"
                           data-delete-confirm="<?php echo rawurlencode($lang['delete_note_confirm']); ?>">
                            <span class="glyphicon glyphicon-remove"></span></a>
                        <span class="btn btn-success btn-xs sortable-handle"
                              title="<?php echo $lang['drag_and_drop']; ?>"><span
                                class="glyphicon glyphicon-sort"></span></span><!--<a href="index.php?mode=notes&amp;move_up=<?php echo $note['id']; ?>"><img src="<?php echo BASE_URL; ?>templates/admin/images/arrow_up.png" alt="<?php echo $lang['move_up']; ?>" title="<?php echo $lang['move_up']; ?>" width="16" height="16" /></a><a href="index.php?mode=notes&amp;move_down=<?php echo $note['id']; ?>"><img src="<?php echo BASE_URL; ?>templates/admin/images/arrow_down.png" alt="<?php echo $lang['move_up']; ?>" title="<?php echo $lang['move_up']; ?>" width="16" height="16" /></a>-->
                    </td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    <div class="alert alert-warning"><?php echo $lang['no_notes']; ?></div>

<?php endif; ?>
