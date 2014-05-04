<?php $photos_per_row = 3;
if (isset($photos)): ?>

    <?php for ($i = 0; $i < $number_of_photos; $i = $i + $photos_per_row): ?>
        <div class="row">
            <?php for ($n = $i; $n < $i + $photos_per_row; ++$n): ?>
                <div class="col-xs-4">
                    <?php if (isset($photos[$n])): ?>

                        <?php if ($settings['lightbox_enabled']): ?>
                            <div class="thumbnail-wrapper">
                                <a class="thumbnail"
                                   href="<?php echo BASE_URL . MEDIA_DIR . $photos[$n]['photo_normal']; ?>"
                                   data-lightbox><img
                                        src="<?php echo BASE_URL . MEDIA_DIR . $photos[$n]['photo_thumbnail']; ?>"
                                        title="<?php echo $photos[$n]['title']; ?>"
                                        alt="<?php echo $photos[$n]['title']; ?>"
                                        data-subtitle="<?php echo $photos[$n]['subtitle']; ?>"
                                        data-description="<?php echo $photos[$n]['description']; ?>"
                                        width="<?php echo $photos[$n]['width']; ?>"
                                        height="<?php echo $photos[$n]['height']; ?>"/></a>
                            </div>
                        <?php else: ?>
                            <a class="thumbnail"
                               href="<?php echo BASE_URL . PAGE; ?>,<?php echo IMAGE_IDENTIFIER; ?>,<?php echo $photos[$n]['id']; ?>"><img
                                    src="<?php echo BASE_URL . MEDIA_DIR . $photos[$n]['photo_thumbnail']; ?>"
                                    title="<?php echo $photos[$n]['title']; ?>"
                                    alt="<?php echo $photos[$n]['title']; ?>"
                                    width="<?php echo $photos[$n]['width']; ?>"
                                    height="<?php $photos[$n]['height']; ?>"/></a>
                        <?php endif; ?>

                    <?php else: ?>
                    <?php endif; ?>

                </div>
            <?php endfor; ?>

        </div>
    <?php endfor; ?>



<?php else: ?>
<p><em>No photo in this gallery</em><p>
    <?php endif; ?>
