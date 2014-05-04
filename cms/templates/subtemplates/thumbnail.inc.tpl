<?php if (isset($thumbnail)): ?>
    <?php if ($settings['lightbox_enabled']): ?>
        <a <?php if (isset($thumbnail['class'])): ?> class="<?php echo $thumbnail['class']; ?>"<?php endif; ?>
            href="<?php echo BASE_URL . MEDIA_DIR . $thumbnail['photo']; ?>" data-lightbox>
            <img  src="<?php echo BASE_URL . MEDIA_DIR . $thumbnail['image']; ?>"
                title="<?php echo $thumbnail['title']; ?>" alt="<?php echo $thumbnail['title']; ?>"
                data-subtitle="<?php echo $thumbnail['subtitle']; ?>"
                data-description="<?php echo $thumbnail['description']; ?>" width="<?php echo $thumbnail['width']; ?>"
                height="<?php echo $thumbnail['height']; ?>"/></a>
    <?php else: ?>
        <a<?php if (isset($thumbnail['class'])): ?> class="<?php echo $thumbnail['class']; ?>"<?php endif; ?>
            href="<?php echo BASE_URL . PAGE; ?>,<?php echo IMAGE_IDENTIFIER; ?>,<?php echo $thumbnail['id']; ?>">
            <img src="<?php echo BASE_URL . MEDIA_DIR . $thumbnail['image']; ?>"
                title="<?php echo $thumbnail['title']; ?>" alt="<?php echo $thumbnail['title']; ?>"
                width="<?php echo $thumbnail['width']; ?>" height="<?php echo $thumbnail['height']; ?>"/></a>
    <?php endif; ?>
<?php else: ?>
    <span class="missing">[ missing image ]</span>
<?php endif; ?>
