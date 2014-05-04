<div class="row">
    <div class="col-md-10">
        <h1><?php echo $lang['users']; ?></h1>
    </div>
    <div class="col-md-2">
        <?php if ($user_type == 1): ?>
            <a class="btn btn-success btn-top pull-right" href="index.php?mode=users&amp;action=new"><span
                    class="glyphicon glyphicon-plus"></span> <?php echo $lang['create_user_account']; ?></a>
        <?php endif; ?>
    </div>
</div>

<?php include('errors.inc.tpl'); ?>

<?php if (isset($users)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo $lang['user_name']; ?></th>
                <th><?php echo $lang['user_type']; ?></th>
                <th><?php echo $lang['last_login']; ?></th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars(stripslashes($user['name'])); ?></td>
                    <td><?php if ($user['type'] == 0) echo $lang['type_0']; elseif ($user['type'] == 1) echo $lang['type_1'] ?></td>
                    <td><?php if ($user['last_login']) echo strftime($lang['time_format'], $user['last_login']); ?></td>
                    <td class="options"><?php if ($user_type == 1 || $user_id == $user['id']): ?><a
                            class="btn btn-primary btn-xs"
                            href="index.php?mode=users&amp;edit=<?php echo $user['id']; ?>"
                            title="<?php echo $lang['edit']; ?>"><span class="glyphicon glyphicon-pencil"></span>
                            </a><?php endif; ?>
                        <?php if ($user_type == 1): ?><a class="btn btn-danger btn-xs"
                                                         href="index.php?mode=users&amp;delete=<?php echo $user['id']; ?>"
                                                         title="<?php echo $lang['delete']; ?>"
                                                         data-delete-confirm="<?php echo rawurlencode($lang['delete_user_confirm']); ?>">
                                <span class="glyphicon glyphicon-remove"></span></a><?php endif; ?></td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    <p><?php echo $lang['no_users']; ?></p>

<?php endif; ?>
