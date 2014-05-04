<div id="comments" class="panel panel-default">
    <div class="panel-heading">
        <?php if ($admin): ?>
            <?php if (empty($comments_closed)): ?>
                <a class="btn btn-danger btn-xs pull-right" href="<?php echo BASE_URL . PAGE; ?>,openclose">
                    <span class="glyphicon glyphicon-lock"></span> <?php echo $lang['comments_close']; ?></a>
            <?php else: ?>
                <a class="btn btn-success btn-xs pull-right" href="<?php echo BASE_URL . PAGE; ?>,openclose">
                    <span class="glyphicon glyphicon-lock"></span> <?php echo $lang['comments_open']; ?></a>
            <?php endif; ?>
        <?php endif; ?>
        <h3 class="panel-title"><?php echo $lang['comment_headline']; ?>
            <span class="badge"><?php echo $total_comments; ?></span></h3>
    </div>

    <div class="panel-body">
        <?php if (isset($edit_data)): ?>
            <form id="commentform" method="post" action="<?php echo $BASE_URL . PAGE; ?>#comments">
                <div>
                    <input type="hidden" name="current_page" value="<?php echo $edit_data['current_page']; ?>"/>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>"/>

                    <p><label for="comment_text"><strong><?php echo $lang['comment_edit_text']; ?></strong></label><br/>
                        <textarea id="comment_text" class="form-control" name="comment_text" cols="63"
                                  rows="10"><?php echo $edit_data['comment']; ?></textarea></p>

                    <p class="userdata"><label for="name"><?php echo $lang['comment_input_name']; ?></label><br/>
                        <input type="text" id="name" class="form-control" name="name"
                               value="<?php echo $edit_data['name']; ?>" size="30"/></p>

                    <p class="userdata"><label
                            for="email_hp"><?php echo $lang['comment_input_email_hp']; ?></label><br/>
                        <input type="text" id="email_hp" class="form-control" name="email_hp"
                               value="<?php echo $edit_data['email_hp']; ?>" size="30"/></p>

                    <p><input class="btn btn-primary" name="edit_save" type="submit"
                              value="<?php echo $lang['comment_input_submit']; ?>"/></p>
                </div>
            </form>

        <?php else: ?>

            <?php if ($comments): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" id="comment-<?php echo $comment['id']; ?>">
                        <h4 class="author"><?php echo $comment['nr']; ?>. <?php if (isset($comment['hp'])): ?><a
                                href="<?php echo $comment['hp']; ?>"><strong><?php echo $comment['name']; ?></strong>
                                </a><?php elseif (isset($comment['email'])): ?><a
                                href="mailto:<?php echo $comment['email']; ?>">
                                <strong><?php echo $comment['name']; ?></strong></a><?php
                            else: ?><strong><?php echo $comment['name']; ?></strong><?php endif; ?>
                            , <?php echo $lang['comment_time'][$comment['id']]; ?>:<?php if ($admin): ?>
                                <span class="smallx">(<?php echo $comment['ip']; ?>)</span><?php endif; ?></h4>

                        <p class="text"><?php echo $comment['comment']; ?></p>
                        <?php if ($admin): ?>
                            <div class="comment-admin">
                                <a class="btn btn-primary btn-xs"
                                   href="<?php echo BASE_URL . PAGE; ?>,<?php echo $current_page; ?>,edit,<?php echo $comment['id']; ?>#comments"
                                   title="<?php echo $lang['comment_edit_link']; ?>">
                                    <span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-danger btn-xs"
                                   href="<?php echo BASE_URL . PAGE; ?>,<?php echo $current_page; ?>,delete,<?php echo $comment['id']; ?>"
                                   title="<?php echo $lang['comment_delete_link']; ?>"
                                   data-delete-confirm="<?php echo rawurlencode($lang['comment_delete_confirm']); ?>">
                                    <span class="glyphicon glyphicon-remove"></span></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p class="no-comments"><em><?php echo $lang['comment_no_comments']; ?></em></p>
            <?php endif; ?>

            <?php if ($pagination): ?>
                <p class="comment-info"><?php echo $lang['comments_pagination_info']; ?></p>
                <ul class="pagination pagination-sm">
                    <?php if ($pagination['previous']): ?>
                        <li><a href="<?php echo BASE_URL . PAGE;
                        if ($pagination['previous'] > 1): ?>,<?php echo $pagination['previous']; endif; ?>#comments">&laquo;</a>
                        </li><?php endif; ?>
                    <?php foreach ($pagination['items'] as $item): ?>
                        <?php if (empty($item)): ?>
                            <li><span>…</span></li><?php elseif ($item == $pagination['current']): ?>
                            <li class="active"><a href="#"><?php echo $item; ?></a></li><?php
                        else: ?>
                            <li><a href="<?php echo BASE_URL . PAGE;
                            if ($item > 1): ?>,<?php echo $item; endif; ?>#comments"><?php echo $item; ?></a>
                            </li><?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($pagination['next']): ?>
                        <li><a
                            href="<?php echo BASE_URL . PAGE; ?>,<?php echo $pagination['next']; ?>#comments">&raquo;</a>
                        </li><?php endif; ?>
                </ul>
            <?php endif; ?>

            <?php if ($errors): ?>
                <div id="errors" class="alert alert-danger">
                    <h3><span class="glyphicon glyphicon-warning-sign"></span> <?php echo $lang['error_headline']; ?>
                    </h3>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php if (isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <script type="text/javascript">/* <![CDATA[ */
                        location.hash = 'errors';
                        /* ]]> */</script>
                </div>
            <?php endif; ?>

            <?php if (empty($comments_closed)): ?>

                <?php if (isset($preview) && empty($errors)): ?>
                    <div class="alert alert-warning">
                        <h3 id="preview"><?php echo $lang['comment_preview_hl']; ?></h3>

                        <div class="comment-preview">
                            <h4 class="author"><?php if (isset($preview['hp'])): ?>
                                <a href="<?php echo $preview['hp']; ?>">
                                    <strong><?php echo $preview['name']; ?></strong>
                                </a><?php elseif (isset($preview['email'])): ?>
                                <a href="mailto:<?php echo $preview['email']; ?>">
                                    <strong><?php echo $preview['name']; ?></strong>
                                </a><?php
                                else: ?><strong><?php echo $preview['name']; ?></strong><?php endif; ?>
                                , <?php echo $lang['comment_time']['preview']; ?>:</h4>

                            <p class="text"><?php echo $preview['comment_text']; ?></p>
                        </div>
                    </div>
                    <script type="text/javascript">/* <![CDATA[ */
                        location.hash = 'preview';
                        /* ]]> */</script>
                <?php endif; ?>

                <?php if (empty($preview) && empty($errors)): ?>
                    <p>
                        <button type="button" class="btn btn-success" data-toggle="collapse"
                                data-target="#commentformwrapper">
                            <span class="glyphicon glyphicon-plus"></span> <?php echo $lang['comments_add_comment']; ?>
                        </button>
                    </p>
                <?php endif; ?>

                <div id="commentformwrapper"
                     class="collapse<?php if (isset($preview) || $errors): ?> in<?php endif; ?>">

                    <form id="commentform" method="post" action="<?php echo $BASE_URL . PAGE; ?>">
                        <div>
                            <?php if ($form_session_data): ?>
                                <input type="hidden"
                                        name="<?php echo $form_session_data['name']; ?>"
                                        value="<?php echo $form_session_data['id']; ?>" /><?php endif; ?>

                            <div class="form-group">
                                <label for="comment_text"><?php echo $lang['comment_input_text']; ?></label><br/>
                                <textarea id="comment_text" class="form-control" name="comment_text" cols="63"
                                          rows="10"><?php echo $form_values['comment_text']; ?></textarea>
                            </div>

                            <div class="form-inline">

                                <div class="form-group">
                                    <label class="sr-only" for="name"><?php echo $lang['comment_input_name']; ?></label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="<?php echo $form_values['name']; ?>"
                                           placeholder="<?php echo $lang['comment_input_name']; ?>"/>
                                </div>

                                <div class="form-group">
                                    <label class="sr-only"
                                           for="email_hp"><?php echo $lang['comment_input_email_hp']; ?></label>
                                    <input class="form-control" type="text" id="email_hp" name="email_hp"
                                           value="<?php echo $form_values['email_hp']; ?>"
                                           placeholder="<?php echo $lang['comment_input_email_hp']; ?>"/>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="save"
                                           value="<?php echo $lang['comment_input_submit']; ?>"<?php if (!$form_session): ?> disabled="disabled"<?php endif; ?>>
                                    <input type="submit" class="btn btn-primary" name="preview"
                                           value="<?php echo $lang['comment_input_preview']; ?>"/>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>

            <?php endif; ?>

        <?php endif; ?>

        <?php if ($pingbacks): ?>
            <h3 id="pingbacks"><?php echo $lang['pingback_headline']; ?></h3>
            <ol id="pingback-list">
                <?php foreach ($pingbacks as $pingback): ?>
                    <li>
                        <a href="<?php echo $pingback['hp']; ?>"><?php echo $pingback['name']; ?></a><!-- (<?php echo $lang['comment_time'][$pingback['id']]; ?>)-->
                        <?php if ($admin): ?>
                            <br/><span class="small">
                                <a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $current_page; ?>,edit,<?php echo $pingback['id']; ?>#comments">
                                    <img src="<?php echo BASE_URL; ?>templates/images/edit_link.png" width="15"
                                        height="10" alt=""/><?php echo $lang['comment_edit_link']; ?></a> &nbsp;
                                <a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $current_page; ?>,delete,<?php echo $pingback['id']; ?>"
                                    onclick="return confirm_link('<?php echo rawurlencode($lang['comment_delete_confirm']); ?>',this,1)">
                                    <img src="<?php echo BASE_URL; ?>templates/images/delete_link.png" width="13"
                                        height="9" alt=""/><?php echo $lang['comment_delete_link']; ?></a></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>

        <?php if (isset($comments_closed)): ?>
            <p><em><span class="glyphicon glyphicon-lock"></span> <?php echo $lang['comments_closed']; ?></em></p>
        <?php endif; ?>

    </div>
</div>
