<form action="<?php echo BASE_URL . PAGE; ?>" method="post">

    <div class="input-group">
        <input class="form-control" type="text" name="q">
        <span class="input-group-btn">
        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
        </span>
    </div>
</form>

<?php if (isset($results)): ?>
    <p style="margin-top:20px;"><strong><?php echo $lang['search_number_of_results']; ?></strong>

    <ul id="search">
        <?php foreach ($results as $result): ?>
            <li>
                <a href="<?php echo BASE_URL . $result['page']; ?>"><?php echo $result['title']; ?></a><?php if ($result['type'] == 1): ?>
                    <span class="smallx">
                    - <?php echo $lang['search_photo']; ?></span><?php endif; ?><?php if ($result['description']): ?>
                    <span class="smallx">- <?php echo $result['description']; ?></span><?php endif; ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($pagination): ?>
        <p class="pagination"><?php echo $lang['pagination']; ?> [
            <?php if ($pagination['previous']): ?> <a href="<?php echo BASE_URL . PAGE; ?>,,<?php echo $q_encoded;
            if ($pagination['previous'] > 1): ?>,<?php echo $pagination['previous']; endif; ?>">&laquo;</a> <?php endif; ?>
            <?php foreach ($pagination['items'] as $item): ?>
                <?php if (empty($item)): ?> ..<?php elseif ($item == $pagination['current']): ?>
                    <span class="current"><?php echo $item; ?></span><?php
                else: ?> <a href="<?php echo BASE_URL . PAGE; ?>,,<?php echo $q_encoded;
                if ($item > 1): ?>,<?php echo $item; endif; ?>"><?php echo $item; ?></a><?php endif; ?>
            <?php endforeach; ?>
            <?php if ($pagination['next']): ?>
            <a href="<?php echo BASE_URL . PAGE; ?>,,<?php echo $q_encoded; ?>,<?php echo $pagination['next']; ?>">&raquo;</a><?php endif; ?>
            ]</p>
    <?php endif; ?>

<?php endif; ?>

<?php if (isset($q) && empty($results)): ?>
    <p><em><?php echo $lang['search_no_results']; ?></em></p>
<?php endif; ?>
