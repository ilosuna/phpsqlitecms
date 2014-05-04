<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['gcb']; ?></h1>
    </div>
    <div class="col-md-2">
        <a href="index.php?mode=gcb&amp;add_gcb=true" class="btn btn-success btn-top pull-right"><span
                class="glyphicon glyphicon-plus"></span> <?php echo $lang['add_gcb']; ?></a>
    </div>
</div>

<?php if (isset($gcbs)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo $lang['gcb_identifier']; ?></th>
                <th><?php echo $lang['gcb_content']; ?></th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            foreach ($gcbs as $gcb): ?>
                <tr>
                    <td><?php echo $gcb['identifier']; ?></td>
                    <td><?php echo $gcb['content']; ?></td>
                    <td class="options nowrap"><a href="index.php?mode=gcb&amp;edit=<?php echo $gcb['id']; ?>"
                                                  title="<?php echo $lang['edit']; ?>"
                                                  class="btn btn-primary btn-xs"><span
                                class="glyphicon glyphicon-pencil"></span></a>&nbsp; <a
                            href="index.php?mode=gcb&amp;delete=<?php echo $gcb['id']; ?>"
                            title="<?php echo $lang['delete']; ?>"
                            data-delete-confirm="<?php echo rawurlencode($lang['delete_gcb_confirm']); ?>"
                            class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    <div class="alert alert-warning">
        <?php echo $lang['no_gcb']; ?>
    </div>

<?php endif; ?>

