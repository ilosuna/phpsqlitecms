<?php if (isset($notes)): ?>

    <?php foreach ($notes as $note): ?>
        <div class="news">
            <p class="time"><?php echo $lang['note_time'][$note['id']]; ?></p>

            <h2><?php if ($note['link']): ?>
                    <a href="<?php echo $note['link']; ?>"><?php echo $note['title']; ?></a><?php else: ?><?php echo $note['title']; ?><?php endif; ?>
            </h2>
            <?php if ($note['text']): ?><p><?php echo $note['text']; ?></p><?php endif; ?>
            <?php if ($note['linkname']): ?><p class="link">
                <a class="btn btn-primary"
                    href="<?php echo $note['link']; ?>"><?php echo $note['linkname']; ?></a>
                </p><?php endif; ?>
        </div>
    <?php endforeach; ?>

    <?php if ($pagination): ?>
        <p class="pagination"><?php echo $lang['pagination']; ?> [
            <?php if ($pagination['previous']): ?> <a href="<?php echo BASE_URL . PAGE;
            if ($pagination['previous'] > 1): ?>,<?php echo $pagination['previous']; endif; ?>">&laquo;</a> <?php endif; ?>
            <?php foreach ($pagination['items'] as $item): ?>
                <?php if (empty($item)): ?> ..<?php elseif ($item == $pagination['current']): ?>
                    <span class="current"><?php echo $item; ?></span><?php
                else: ?> <a href="<?php echo BASE_URL . PAGE;
                if ($item > 1): ?>,<?php echo $item; endif; ?>"><?php echo $item; ?></a><?php endif; ?>
            <?php endforeach; ?>
            <?php if ($pagination['next']): ?> <a
                href="<?php echo BASE_URL . PAGE; ?>,<?php echo $pagination['next']; ?>">&raquo;</a><?php endif; ?>
            ]</p>
    <?php endif; ?>

<?php else: ?>

    <?php echo $lang['no_notes']; ?>

<?php endif; ?>
S