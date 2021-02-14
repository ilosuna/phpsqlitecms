<?php

if (!defined('IN_INDEX'))
    exit;

if (isset($_SESSION[$settings['session_prefix'] . 'user_id']) && $_SESSION[$settings['session_prefix'] . 'user_type'] == 1) {
    if (isset($_POST['google_analytics_submit'])) {
        $google_analytics_id = !empty($_POST['google_analytics_id']) ? $_POST['google_analytics_id'] : '';
        $google_analytics_check = isset($_POST['google_analytics_check']) ? 1 : 0;

        if ($google_analytics_check && empty($google_analytics_id))
            $errors[] = 'error_google_analytics_id';

        if (empty($errors)) {
            Database::$content->beginTransaction();
            $dbr = Database::$content->prepare("UPDATE " . Database::$db_settings['settings_table'] . " SET value=:value WHERE name=:name");
            $dbr->bindValue(':name', 'google_analytics_id', PDO::PARAM_STR);
            $dbr->bindParam(':value', $google_analytics_id, PDO::PARAM_STR);
            $dbr->execute();
            $dbr->bindValue(':name', 'google_analytics_check', PDO::PARAM_STR);
            $dbr->bindParam(':value', $google_analytics_check, PDO::PARAM_STR);
            $dbr->execute();
            Database::$content->commit();

            header('Location: ' . BASE_URL . ADMIN_DIR . 'index.php?mode=google_analytics&saved=true');
            exit;
        }

        if (isset($errors)) {
            $template->assign('errors',$errors);
            if(isset($_POST['google_analytics_id'])) $template->assign('google_analytics_id',htmlspecialchars(stripslashes($_POST['google_analytics_id'])));
            if(isset($_POST['google_analytics_check'])) $template->assign('google_analytics_check',intval($_POST['google_analytics_check']));
        }
    } else {
        $template->assign('google_analytics_id', htmlspecialchars(stripslashes($settings['google_analytics_id'])));
        $template->assign('google_analytics_check',intval($settings['google_analytics_check']));
    }
    
    if (isset($_GET['saved'])) {
        $template->assign('saved', true);
    }
    $template->assign('subtitle', Localization::$lang['google_analytics']);
    $template->assign('subtemplate', 'google_analytics.inc.tpl');
}