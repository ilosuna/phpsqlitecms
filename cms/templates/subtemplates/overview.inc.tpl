<?php if (isset($included_pages)): ?>

    <?php for ($i = 0; $i < $included_pages_number; $i = $i + 2): ?>
        <div class="row">
            <?php for ($n = $i; $n < $i + 2; ++$n): ?>
                <div class="col-md-6">

                    <?php if (isset($included_pages[$n])): ?>
                    <div class="overview">
                        <h2 class="teaser"><a
                                href="<?php echo BASE_URL . $included_pages[$n]['page']; ?>"><?php echo $included_pages[$n]['teaser_headline']; ?></a>
                        </h2>

                        <div class="media">
                            <?php if ($included_pages[$n]['teaser_img']): ?>
                                <a class="thumbnail thumbnail-left"
                                   href="<?php echo BASE_URL . $included_pages[$n]['page']; ?>"><img
                                        src="<?php echo BASE_URL . MEDIA_DIR . $included_pages[$n]['teaser_img']; ?>"
                                        alt="<?php echo $included_pages[$n]['teaser_headline']; ?>"
                                        width="<?php echo $included_pages[$n]['teaser_img_width']; ?>"
                                        height="<?php echo $included_pages[$n]['teaser_img_height']; ?>"/></a>
                            <?php endif; ?>
                            <p class="teaser"><?php echo $included_pages[$n]['teaser']; ?></p>

                            <p><a class="btn btn-primary"
                                  href="<?php echo BASE_URL . $included_pages[$n]['page']; ?>"><?php echo $included_pages[$n]['link_name']; ?></a>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>

        </div>
    <?php endfor; ?>

<?php endif; ?>
