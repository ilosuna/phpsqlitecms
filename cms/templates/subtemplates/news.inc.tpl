<?php if ($news): ?>
    <?php foreach ($news as $item): ?>

        <div class="news">

            <p class="time"><?php echo $lang['news_time'][$item['id']]; ?></p>

            <h2 class="media-heading"><a
                    href="<?php echo BASE_URL . $item['page']; ?>"><?php echo $item['teaser_headline']; ?></a></h2>

            <div class="media">

                <?php if (isset($item['teaser_img'])): ?>
                    <a class="pull-left thumbnail" href="<?php echo BASE_URL . $item['page']; ?>">
                        <img class="media-object" src="<?php echo BASE_URL . MEDIA_DIR . $item['teaser_img']; ?>"
                            alt="<?php echo $item['teaser_headline']; ?>"
                            width="<?php echo $item['teaser_img_width']; ?>"
                            height="<?php echo $item['teaser_img_height']; ?>"/></a>
                <?php endif; ?>



                <?php if (isset($item['teaser'])): ?>
                    <p><?php echo $item['teaser']; ?></p>
                <?php endif; ?>

                <p><a class="btn btn-primary"
                      href="<?php echo BASE_URL . $item['page']; ?>"><?php echo $item['link_name']; ?></a>
                    <?php if (isset($item['comments'])): ?>
                        <a class="btn btn-default"
                          href="<?php echo BASE_URL . $item['page']; ?>#comments"
                          class="comments"><?php echo $lang['number_of_comments'][$item['id']]; ?></a>
                    <?php endif; ?>
                </p>

            </div>
        </div>
    <?php endforeach; ?>

    <?php if ($pagination): ?>
        <!--<p><?php echo $lang['pagination']; ?></p>-->
        <ul class="pagination">
            <?php if ($pagination['previous']): ?>
                <li><a href="<?php echo BASE_URL . PAGE;
                if ($pagination['previous'] > 1 || $current_category): ?>,<?php if ($current_category) echo CATEGORY_IDENTIFIER . $current_category_urlencoded; ?><?php if ($pagination['previous'] > 1): ?>,<?php echo $pagination['previous']; endif; endif; ?>">&laquo;</a>
                </li><?php endif; ?><?php foreach ($pagination['items'] as $item): ?><?php if (empty($item)): ?>
                <li>..</li><?php elseif ($item == $pagination['current']): ?>
                <li class="active"><a href="#"><?php echo $item; ?></a></li><?php
            else: ?>
                <li><a href="<?php echo BASE_URL . PAGE;
                if ($item > 1 || $current_category): ?>,<?php if ($current_category) echo CATEGORY_IDENTIFIER . $current_category_urlencoded; ?><?php if ($item > 1): ?>,<?php echo $item; endif; endif; ?>"><?php echo $item; ?></a>
                </li><?php endif; ?><?php endforeach; ?><?php if ($pagination['next']): ?>
                <li><a href="<?php echo BASE_URL . PAGE; ?>,<?php if ($current_category) echo CATEGORY_IDENTIFIER . $current_category_urlencoded; ?><?php if ($pagination['next'] > 1): ?>,<?php echo $pagination['next']; ?><?php endif; ?>">&raquo;</a>
                </li><?php endif; ?>
        </ul>
    <?php endif; ?>

<?php else: ?>

    <div class="alert alert-warning">
        <?php echo $lang['no_news']; ?>
    </div>

<?php endif; ?>
