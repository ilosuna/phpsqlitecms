<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['comments']; ?></h1>
    </div>
    <div class="col-md-2">
        <div id="itemnav">
            <form method="get" action="index.php">
                <div class="form-group">
                    <input type="hidden" name="mode" value="comments"/>
                    <input type="hidden" name="type" value="<?php echo $type; ?>"/>
                    <select class="form-control form-control-medium btn-top pull-right" size="1" name="comment_id"
                            onchange="this.form.submit();">
                        <option
                            value="0"><?php if ($type == 0) echo $lang['comments_all_pages']; else echo $lang['comments_all_photos']; ?></option>
                        <?php foreach ($items as $key => $val): ?>
                            <option
                                value="<?php echo $key; ?>"<?php if ($key == $comment_id): ?> selected="selected"<?php endif; ?>><?php echo $val['title']; ?></option>
                        <?php endforeach; ?>
                    </select><!--<input type="submit" name="" value="" src="<?php echo BASE_URL; ?>templates/admin/images/submit.png" value="&raquo;" />
                    -->
                </div>
            </form>
        </div>
    </div>
</div>

<h1></h1>

<?php /*
<div id="nav">
 <ul id="navlist">
  <li><a <?php if($type==0): ?>class="active" <?php endif; ?>href="index.php?mode=comments&amp;type=0" style="width:140px;"><?php echo $lang['comments_page_c']; ?></a></li>
  <li><a <?php if($type==1): ?>class="active" <?php endif; ?>href="index.php?mode=comments&amp;type=1" style="width:140px;"><?php echo $lang['comments_photo_c']; ?></a></li>
 </ul>
<p>&nbsp;</p>
</div>
*/
?>

<?php if (isset($comments)): ?>

    <form id="entryeditform" method="post" action="index.php">
        <div>
            <input type="hidden" name="mode" value="comments"/>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th><?php if ($type == 0) echo $lang['comments_page']; else echo $lang['comments_photo']; ?></th>
                        <th><?php echo $lang['comments_time']; ?></th>
                        <th><?php echo $lang['comments_name']; ?></th>
                        <th><?php echo $lang['comments_comment']; ?></th>
                        <th><?php echo $lang['comments_ip']; ?></th>
                        <th colspan="<?php if ($settings['akismet_key'] != '' && $settings['akismet_entry_check'] == 1): ?>3<?php else: ?>2<?php endif; ?>">
                            &nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0;
                    foreach ($comments as $comment): ?>
                        <tr class="<?php if ($i % 2 == 0): ?>a<?php else: ?>b<?php endif; ?>">
                            <td><input class="commentcheckbox" type="checkbox" name="checked[]"
                                       value="<?php echo $comment['id']; ?>"/></td>
                            <td><?php if ($type == 1): ?><?php if (isset($items[$comment['comment_id']])): ?><a
                                    href="<?php echo BASE_URL . MEDIA_DIR . $items[$comment['comment_id']]['photo_normal']; ?>">
                                    <img
                                        src="<?php echo BASE_URL . MEDIA_DIR . $items[$comment['comment_id']]['photo_thumbnail']; ?>"
                                        title="<?php echo $items[$comment['comment_id']]['title']; ?>"
                                        alt="<?php echo $items[$comment['comment_id']]['title']; ?>" />
                                    </a><?php else: ?>-<?php endif; ?><?php else: ?><?php if (isset($items[$comment['comment_id']])): ?>
                                    <a
                                    href="<?php echo BASE_URL . $items[$comment['comment_id']]['page']; ?>#comments"><?php echo $items[$comment['comment_id']]['title']; ?></a><?php else: ?>-<?php endif; ?><?php endif; ?>
                            </td>
                            <td><?php echo strftime($lang['time_format'], $comment['time']); ?></td>
                            <td><?php if (isset($comment['email_hp'])): ?><a
                                    href="<?php echo $comment['email_hp']; ?>"><?php echo $comment['name']; ?></a><?php else: ?><?php echo $comment['name']; ?><?php endif; ?>
                            </td>
                            <td><?php if ($comment['comment'] == '' && $type == 0): ?>
                                    <em><?php echo $lang['pingback']; ?></em><?php else: echo $comment['comment']; endif; ?>
                            </td>
                            <td><?php echo $comment['ip']; ?></td>
                            <td class="options"><a class="btn btn-primary btn-xs"
                                                   href="index.php?mode=comments&amp;type=<?php echo $type; ?>&amp;edit=<?php echo $comment['id']; ?>&amp;comment_id=<?php echo $comment_id; ?>&amp;page=<?php echo $page; ?>"
                                                   title="<?php echo $lang['edit']; ?>"><span
                                        class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-danger btn-xs"
                                   href="index.php?mode=comments&type=<?php echo $type; ?>&amp;delete=<?php echo $comment['id']; ?>&amp;comment_id=<?php echo $comment_id; ?>&amp;page=<?php echo $page; ?>"
                                   title="<?php echo $lang['delete']; ?>"
                                   data-delete-confirm="<?php echo rawurlencode($lang['delete_this_comment_confirm']); ?>"><span
                                        class="glyphicon glyphicon-remove"></span></a>
                                <?php if ($settings['akismet_key'] != '' && $settings['akismet_entry_check'] == 1): ?>
                                    <a class="btn btn-danger btn-xs"
                                       href="index.php?mode=comments&type=<?php echo $type; ?>&amp;report_spam=<?php echo $comment['id']; ?>&amp;comment_id=<?php echo $comment_id; ?>&amp;page=<?php echo $page; ?>"
                                       title="<?php echo $lang['report_as_spam']; ?>"><span
                                            class="glyphicon glyphicon-warning-sign"></span></a>
                                <?php endif ?></td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-8">

                    <button type="button" class="btn btn-default"
                            data-toggle-checkboxes="commentcheckbox"><?php echo $lang['toggle_selection']; ?></button>
                    <input class="btn btn-danger" type="submit" name="delete_checked"
                           value="<?php echo $lang['comments_del_checked']; ?>"/>
                    <?php if ($comment_id == 0): ?>
                        <input class="btn btn-danger" type="submit" name="delete_all_comments"
                               value="<?php echo $lang['comments_delete_all']; ?>"/>
                    <?php else: ?>
                        <?php if ($type == 0): ?>
                            <input class="btn btn-danger" type="submit" name="delete_all_comments_page"
                                   value="<?php echo $lang['delete_all_comments_page']; ?>">
                        <?php else: ?>
                            <?php echo $lang['delete_all_comments_photo']; ?>
                            <input class="btn btn-danger" type="submit" name="delete_all_comments_page"
                                   value="<?php echo $lang['delete_all_comments_photo']; ?>">
                        <?php endif; ?>

                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"/>
                    <?php endif; ?>
                    <input type="hidden" name="type" value="<?php echo $type; ?>"/>
                    <input type="hidden" name="page" value="<?php echo $page; ?>"/>
                </div>

                <div class="col-md-4">
                    <?php if ($pagination): ?>
                        <ul class="pagination pull-right nomargin">
                            <?php if ($pagination['previous']): ?>
                                <li><a
                                    href="index.php?mode=comments&amp;type=<?php echo $type; ?>&amp;comment_id=<?php echo $comment_id; ?>&amp;page=<?php echo $pagination['previous']; ?>"><span
                                        class="glyphicon glyphicon-chevron-left"></span></a></li><?php endif; ?>
                            <?php foreach ($pagination['items'] as $item): ?>
                                <?php if (empty($item)): ?>
                                    <li><span>&hellip;</span></li><?php elseif ($item == $pagination['current']): ?>
                                    <li class="active"><span><?php echo $item; ?></span></li><?php
                                else: ?>
                                    <li><a
                                        href="index.php?mode=comments&amp;type=<?php echo $type; ?>&amp;comment_id=<?php echo $comment_id; ?>&amp;page=<?php echo $item; ?>"><?php echo $item; ?></a>
                                    </li><?php endif; ?>
                            <?php endforeach; ?>
                            <?php if ($pagination['next']): ?>
                                <li><a
                                    href="index.php?mode=comments&amp;type=<?php echo $type; ?>&amp;comment_id=<?php echo $comment_id; ?>&amp;page=<?php echo $pagination['next']; ?>"><span
                                        class="glyphicon glyphicon-chevron-right"></span></a></li><?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </form>



<?php else: ?>
    <div class="alert alert-warning">
        <?php echo $lang['no_comments']; ?>
    </div>
<?php endif; ?>

<?php if ($type == 1 && $settings['photos_commentable'] == 1): ?>
    <p class="small"><?php echo $lang['photo_comments_enabled']; ?></p>
<?php elseif ($type == 1 && $settings['photos_commentable'] == 0): ?>
    <p class="small"><?php echo $lang['photo_comments_disabled']; ?></p>
<?php endif; ?>
