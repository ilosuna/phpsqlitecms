<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['photo_galleries']; ?></h1>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success btn-top pull-right" href="index.php?mode=galleries&amp;action=new"><span
                class="glyphicon glyphicon-plus"></span> <?php echo $lang['create_new_gallery']; ?></a>
    </div>
</div>

<?php if (isset($galleries)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo $lang['gallery']; ?></th>
                <th colspan="2">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            foreach ($galleries as $gallery): ?>
                <tr>
                    <td><?php echo htmlspecialchars(stripslashes($gallery)); ?></td>
                    <td class="options"><a href="index.php?mode=galleries&amp;edit=<?php echo $gallery; ?>"
                                           title="<?php echo $lang['edit']; ?>" class="btn btn-primary btn-xs"><span
                                class="glyphicon glyphicon-pencil"></span></a>&nbsp; <a
                            href="index.php?mode=galleries&amp;delete_gallery=<?php echo $gallery; ?>"
                            data-delete-confirm="<?php echo rawurlencode($lang['delete_gallery_confirm']); ?>"
                            title="<?php echo $lang['delete']; ?>" class="btn btn-danger btn-xs"><span
                                class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    <div class="alert alert-warning">
        <?php echo $lang['no_gallery']; ?>
    </div>

<?php endif; ?>
