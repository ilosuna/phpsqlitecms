<?php if (isset($edit_news)): ?>

    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h3><span class="glyphicon glyphicon-warning-sign"></span>
                <strong><?php echo $lang['error_headline']; ?></strong></h3>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?php if (isset($lang[$error])) echo $lang[$error]; else echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="form-horizontal" action="<?php echo BASE_URL . PAGE; ?>" method="post">
        <div>
            <input type="hidden" name="mode" value="news"/>
            <input type="hidden" name="edit_news_submit" value="true"/>
            <?php if (isset($edit_news['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $edit_news['id']; ?>"/>
            <?php endif; ?>

            <div class="form-group">
                <label for="title" class="col-md-2 control-label"><?php echo $lang['simple_news_edit_title']; ?></label>

                <div class="col-md-10">
                    <input id="title" class="form-control" type="text" name="title"
                           value="<?php if (isset($edit_news['title'])) echo $edit_news['title']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="teaser"
                       class="col-md-2 control-label"><?php echo $lang['simple_news_edit_teaser']; ?></label>

                <div class="col-md-10">
                    <textarea id="teaser" class="form-control" name="teaser"
                              rows="5"><?php if (isset($edit_news['teaser'])) echo $edit_news['teaser']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="text" class="col-md-2 control-label"><?php echo $lang['simple_news_edit_text']; ?></label>

                <div class="col-md-10">
                    <textarea id="text" class="form-control" name="text"
                              rows="10"><?php if (isset($edit_news['text'])) echo $edit_news['text']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="linkname"
                       class="col-md-2 control-label"><?php echo $lang['simple_news_edit_linkname']; ?></label>

                <div class="col-md-10">
                    <input id="linkname" class="form-control" type="text" name="linkname"
                           value="<?php if (isset($edit_news['linkname'])) echo $edit_news['linkname']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="newstime"
                       class="col-md-2 control-label"><?php echo $lang['simple_news_edit_time']; ?></label>

                <div class="col-md-10">
                    <input id="newstime" class="form-control" type="text" name="time"
                           value="<?php if (isset($edit_news['time'])) echo $edit_news['time']; ?>"
                           placeholder="<?php echo $lang['simple_news_edit_time_format']; ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button class="btn btn-primary" type="submit"><?php echo $lang['submit_button_ok']; ?></button>
                </div>
            </div>

        </div>
    </form>

<?php elseif (isset($delete_news)): ?>

    <p><strong><?php echo $delete_news['title']; ?></strong></p>

    <form action="<?php echo BASE_URL . PAGE; ?>" method="post">
        <div>
            <input type="hidden" name="delete" value="<?php echo $delete_news['id']; ?>"/>

            <p><input class="btn btn-danger btn-lg" type="submit" name="confirmed"
                      value="<?php echo $lang['delete_news_confirm_submit']; ?>"/></p>
        </div>
    </form>

<?php
elseif (isset($news_item)): ?>

    <?php echo $news_item['text']; ?>

    <?php if ($authorized_to_edit): ?>
        <p>
            <a class="btn btn-primary btn-xs" href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>,edit"
               title="<?php echo $lang['edit']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
            <a class="btn btn-danger btn-xs"
               href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>,delete"
               title="<?php echo $lang['delete']; ?>"
               data-delete-confirm="<?php echo rawurlencode($lang['simple_news_delete_confirm']); ?>">
                <span class="glyphicon glyphicon-remove"></span></a>
        </p>
    <?php endif; ?>

<?php
elseif (isset($news)): ?>

    <?php if ($authorized_to_edit): ?>
        <p><a class="btn btn-success" href="<?php echo BASE_URL . PAGE; ?>,add_item"><span
                    class="glyphicon glyphicon-plus"></span> <?php echo $lang['simple_news_add_item']; ?></a></p>
    <?php endif; ?>

    <?php foreach ($news as $news_item): ?>
        <div class="panel panel-default simple-news">
            <div class="panel-heading"><?php echo $lang['simple_news_time'][$news_item['id']]; ?>
                <?php if ($authorized_to_edit): ?>
                    <span class="pull-right">
                    <a class="btn btn-primary btn-xs" href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>,edit"
                       title="<?php echo $lang['edit']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a class="btn btn-danger btn-xs" href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>,delete"
                       title="<?php echo $lang['delete']; ?>"
                       data-delete-confirm="<?php echo rawurlencode($lang['simple_news_delete_confirm']); ?>"><span
                            class="glyphicon glyphicon-remove"></span></a>
                    </span>
                <?php endif; ?>
            </div>
            <div class="panel-body">
                <h2>
                    <a href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>"><?php echo $news_item['title']; ?></a>
                </h2>
                <?php if (empty($news_item['teaser'])): ?>
                    <?php echo $news_item['text']; ?>
                <?php else: ?>
                    <p><?php echo $news_item['teaser']; ?></p>
                    <p><a class="btn btn-primary"
                          href="<?php echo BASE_URL . PAGE; ?>,<?php echo $news_item['id']; ?>"><?php echo $news_item['linkname']; ?></a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ($pagination): ?>
        <ul class="pagination">
            <?php if ($pagination['previous']): ?>
                <li><a href="<?php echo BASE_URL . PAGE;
                if ($pagination['previous'] > 1): ?>,,<?php echo $pagination['previous']; endif; ?>">
                    <span  class="glyphicon glyphicon-chevron-left"></span></a></li><?php endif; ?>
            <?php foreach ($pagination['items'] as $item): ?>
                <?php if (empty($item)): ?>
                    <li><span>&hellip;</span></li><?php elseif ($item == $pagination['current']): ?>
                    <li class="active"><span><?php echo $item; ?></span></li><?php
                else: ?>
                    <li><a href="<?php echo BASE_URL . PAGE;
                    if ($item > 1): ?>,,<?php echo $item; endif; ?>"><?php echo $item; ?></a></li><?php endif; ?>
            <?php endforeach; ?>
            <?php if ($pagination['next']): ?>
                <li><a href="<?php echo BASE_URL . PAGE; ?>,,<?php echo $pagination['next']; ?>">
                    <span class="glyphicon glyphicon-chevron-right"></span></a></li><?php endif; ?>
        </ul>
    <?php endif; ?>

<?php
else: ?>

    <div class="alert alert-warning"><?php echo $lang['no_news']; ?></div>

    <?php if ($authorized_to_edit): ?>
        <p><a class="btn btn-success" href="<?php echo BASE_URL . PAGE; ?>,add_item">
                <span class="glyphicon glyphicon-plus"></span> <?php echo $lang['simple_news_add_item']; ?></a></p>
    <?php endif; ?>

<?php endif; ?>
