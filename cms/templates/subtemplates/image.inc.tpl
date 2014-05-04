<?php if (isset($image)): ?>
    <img<?php if (isset($image['class'])): ?> class="<?php echo $image['class']; ?>" <?php endif; ?>
        src="<?php echo BASE_URL . MEDIA_DIR . $image['image']; ?>" title="<?php echo $image['alt']; ?>"
        alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>"
        height="<?php echo $image['height']; ?>"/>
<?php else: ?>
    <span class="missing">[ missing image ]</span>
<?php endif; ?>
