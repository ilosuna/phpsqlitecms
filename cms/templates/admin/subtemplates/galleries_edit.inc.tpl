<ol class="breadcrumb">
    <li><a href="index.php?mode=galleries"><?php echo $lang['photo_galleries']; ?></a></li>
    <li class="active"><?php echo str_replace('[gallery]', $gallery, $lang['edit_gallery']); ?></li>
</ol>

<div class="row">
    <div class="col-md-10">
        <h1><?php echo str_replace('[gallery]', $gallery, $lang['edit_gallery']); ?></h1>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success btn-top pull-right"
           href="index.php?mode=galleries&amp;new_photo=<?php echo $gallery; ?>"><span
                class="glyphicon glyphicon-plus"></span> <?php echo $lang['add_photo']; ?></a>
    </div>
</div>

<?php if (isset($items)): ?>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th><?php echo $lang['photo']; ?></th>
            <th><?php echo $lang['photo_title']; ?></th>
            <th><?php echo $lang['photo_subtitle']; ?></th>
            <th><?php echo $lang['photo_description']; ?></th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody data-sortable="<?php echo BASE_URL; ?>cms/?mode=galleries&amp;reorder_photos=true">
        <?php $i = 0;
        foreach ($items as $item): ?>
            <tr id="item_<?php echo $item['id']; ?>">
                <td><a class="thumbnail" href="<?php echo BASE_URL . MEDIA_DIR . $item['photo_normal']; ?>"
                       data-lightbox><img id="photo<?php echo $item['id']; ?>"
                                          src="<?php echo BASE_URL . MEDIA_DIR . $item['photo_thumbnail']; ?>"
                                          title="<?php echo htmlspecialchars($item['title']); ?>"
                                          alt="<?php echo htmlspecialchars($item['title']); ?>"
                                          data-subtitle="<?php echo htmlspecialchars($item['subtitle']); ?>"
                                          data-description="<?php echo htmlspecialchars($item['description']); ?>"/></a>
                </td>
                <td><?php echo $item['title']; ?></td>
                <td><?php echo $item['subtitle']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td class="nowrap"><a href="index.php?mode=galleries&amp;edit_photo=<?php echo $item['id']; ?>"
                                      title="<?php echo $lang['edit']; ?>" class="btn btn-primary btn-xs"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                    <a href="index.php?mode=galleries&amp;delete_photo=<?php echo $item['id']; ?>"
                       title="<?php echo $lang['delete']; ?>"
                       data-delete-confirm="<?php echo rawurlencode($lang['delete_photo_confirm']); ?>"
                       class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
                    <span class="btn btn-success btn-xs sortable-handle"
                          title="<?php echo $lang['drag_and_drop']; ?>"><span
                            class="glyphicon glyphicon-sort"></span></span><!--<a href="index.php?mode=galleries&amp;move_up_photo=<?php echo $item['id']; ?>#photo<?php echo $item['id']; ?>"><img src="<?php echo BASE_URL; ?>templates/admin/images/arrow_up.png" alt="<?php echo $lang['move_up']; ?>" title="<?php echo $lang['move_up']; ?>" width="16" height="16" /></a><a href="index.php?mode=galleries&amp;move_down_photo=<?php echo $item['id']; ?>#photo<?php echo $item['id']; ?>"><img src="<?php echo BASE_URL; ?>templates/admin/images/arrow_down.png" alt="<?php echo $lang['move_down']; ?>" title="<?php echo $lang['move_down']; ?>" width="16" height="16" /></a>-->
                </td>
            </tr>
            <?php $i++; endforeach ?>
        </tbody>
    </table>

<?php else: ?>

    <div class="alert alert-warning">
        <?php echo $lang['no_photo']; ?>
    </div>

<?php endif; ?>
