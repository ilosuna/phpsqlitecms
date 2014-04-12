<?php
if(!defined('IN_INDEX')) exit;

if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

  if(isset($_SESSION[$settings['session_prefix'].'wysiwyg']) && $_SESSION[$settings['session_prefix'].'wysiwyg']==1) $wysiwyg = true;

  if(isset($_REQUEST['enable_wysiwyg']))
   {
    $wysiwyg = true;
    $dbr = Database::$userdata->prepare("UPDATE ".Database::$db_settings['userdata_table']." SET wysiwyg=1 WHERE id=:id");
    $dbr->bindParam(':id', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
    $dbr->execute();
    $_SESSION[$settings['session_prefix'].'wysiwyg'] = 1;
   }
  if(isset($_REQUEST['disable_wysiwyg']))
   {
    unset($wysiwyg);
    $dbr = Database::$userdata->prepare("UPDATE ".Database::$db_settings['userdata_table']." SET wysiwyg=0 WHERE id=:id");
    $dbr->bindParam(':id', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
    $dbr->execute();
    $_SESSION[$settings['session_prefix'].'wysiwyg'] = 0;
   }
   
  if(isset($wysiwyg)) $template->assign('wysiwyg', true);

  include(BASE_PATH.'cms/config/page_types.conf.php');
  $template->assign('page_types',$page_types);

  // users:
  $user_result = Database::$userdata->query("SELECT id, name FROM ".Database::$db_settings['userdata_table']." ORDER BY id ASC");
  $i=0;
  while($data = $user_result->fetch())
   {
    $users[$data['id']] = $data['name'];
   }

  // get data to edit and perform general checks:
  if(isset($_GET['id']))
   {
    $dbr = Database::$content->prepare("SELECT id,page,author,type,type_addition,time,last_modified,display_time,title,page_title,description,keywords,category,page_info,breadcrumbs,sections,include_page,include_order,include_rss,include_sitemap,include_news,link_name,menu_1,menu_2,menu_3,gcb_1,gcb_2,gcb_3,template,language,content_type,charset,teaser_headline,teaser,teaser_img,content,sidebar_1,sidebar_2,sidebar_3,page_notes, edit_permission, edit_permission_general, tv, status FROM ".Database::$db_settings['pages_table']." WHERE id=:id LIMIT 1");
    $dbr->bindParam(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $dbr->execute();
    $data = $dbr->fetch();
    if(!isset($data['id']))
     {
      $action='page_doesnt_exist';
     }
    elseif(!is_authorized_to_edit($_SESSION[$settings['session_prefix'].'user_id'],$_SESSION[$settings['session_prefix'].'user_type'],$data['author'],$data['edit_permission'],$data['edit_permission_general']))
     {
      $action='no_authorization';
     }
    else
     {
      $page_data['id'] = intval($data['id']);
      $page_data['page'] = htmlspecialchars($data['page']);
      $page_data['author'] = intval($data['author']);
      $page_data['type'] = htmlspecialchars($data['type']);
      $page_data['type_addition'] = htmlspecialchars($data['type_addition']);
      $page_data['time'] = date("Y-m-d H:i:s", $data['time']);
      $page_data['last_modified'] = date("Y-m-d H:i:s");
      $page_data['display_time'] = intval($data['display_time']);
      $page_data['title'] = htmlspecialchars($data['title']);
      $page_data['page_title'] = htmlspecialchars($data['page_title']);
      $page_data['description'] = htmlspecialchars($data['description']);
      $page_data['keywords'] = htmlspecialchars($data['keywords']);
      $page_data['category'] = htmlspecialchars($data['category']);
      $page_data['page_info'] = htmlspecialchars($data['page_info']);
      $page_data['breadcrumbs'] = explode(',',htmlspecialchars($data['breadcrumbs']));
      $page_data['sections'] = str_replace(',',', ',htmlspecialchars($data['sections']));
      $page_data['include_page'] = intval($data['include_page']);
      $page_data['include_order'] = intval($data['include_order']);
      $page_data['include_rss'] = intval($data['include_rss']);
      $page_data['include_sitemap'] = intval($data['include_sitemap']);
      $page_data['include_news'] = intval($data['include_news']);
      $page_data['link_name'] = htmlspecialchars($data['link_name']);
      $page_data['menu_1'] = htmlspecialchars($data['menu_1']);
      $page_data['menu_2'] = htmlspecialchars($data['menu_2']);
      $page_data['menu_3'] = htmlspecialchars($data['menu_3']);
      $page_data['gcb_1'] = htmlspecialchars($data['gcb_1']);
      $page_data['gcb_2'] = htmlspecialchars($data['gcb_2']);
      $page_data['gcb_3'] = htmlspecialchars($data['gcb_3']);
      $page_data['template'] = htmlspecialchars($data['template']);
      $page_data['language'] = htmlspecialchars($data['language']);
      $page_data['content_type'] = htmlspecialchars($data['content_type']);
      $page_data['charset'] = htmlspecialchars($data['charset']);
      $page_data['teaser_headline'] = htmlspecialchars($data['teaser_headline']);
      $page_data['teaser'] = htmlspecialchars($data['teaser']);
      $page_data['teaser_img'] = htmlspecialchars($data['teaser_img']);
      $page_data['sidebar_1'] = htmlspecialchars($data['sidebar_1']);
      $page_data['sidebar_2'] = htmlspecialchars($data['sidebar_2']);
      $page_data['sidebar_3'] = htmlspecialchars($data['sidebar_3']);
      $page_data['page_notes'] = htmlspecialchars($data['page_notes']);
      $page_data['edit_permission_general'] = intval($data['edit_permission_general']);
      $page_data['tv'] = str_replace(',',', ',htmlspecialchars($data['tv']));
      $page_data['status'] = intval($data['status']);
      $page_data['content'] = htmlspecialchars($data['content']);

      $edit_permission_array = explode(',',$data['edit_permission']);
      foreach($edit_permission_array as $edit_permission)
       {
        $edit_permission = intval(trim($edit_permission));
        if(isset($users[$edit_permission]))
         {
          $permitted_users[] = htmlspecialchars($users[$edit_permission]);
         }
       }
      if(isset($permitted_users))
       {
        $page_data['edit_permission'] = implode(', ',$permitted_users);
       }
      else
       {
        $page_data['edit_permission'] = '';
       }

      $send_pingbacks = 0;
      $action='main';
     }
   }
  else
   {
    // set default values for new pages:
    $page_data['time'] = date("Y-m-d H:i:s");
    $page_data['last_modified'] = date("Y-m-d H:i:s");
    $page_data['display_time'] = 0;
    $page_data['include_page'] = 0;
    $page_data['include_order'] = 0;
    $page_data['include_rss'] = 0;
    $page_data['include_sitemap'] = 0;
    $page_data['include_news'] = 0;
    $page_data['link_name'] = Localization::$lang['teaser_default_linkname'];
    $page_data['template'] = $settings['default_template'];
    $page_data['menu_1'] = $settings['default_menu'];
    $page_data['edit_permission_general'] = 0;
    $page_data['status'] = 2;
    $send_pingbacks = $settings['pingbacks_enabled'] ? 1 : 0;
   }

  // edit submitted:
  if(isset($_POST['content']))
   {
    if(isset($_POST['id']))
     {
      $dbr = Database::$content->prepare("SELECT id,author,edit_permission,edit_permission_general FROM ".Database::$db_settings['pages_table']." WHERE id=:id LIMIT 1");
      $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
      $dbr->execute();
      $data = $dbr->fetch();
      if(!isset($data['id']))
       {
        $errors[] = 'page_doesnt_exist';
       }
      elseif(!is_authorized_to_edit($_SESSION[$settings['session_prefix'].'user_id'],$_SESSION[$settings['session_prefix'].'user_type'],$data['author'],$data['edit_permission'],$data['edit_permission_general']))
       {
        $errors[] = 'no_authorization_edit';
       }
     }

    if(empty($errors))
     {
      $_POST['page'] = isset($_POST['page']) ? trim($_POST['page']) : '';
      $_POST['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
      $_POST['gcb_1'] = isset($_POST['gcb_1']) ? trim($_POST['gcb_1']) : '';
      $_POST['gcb_2'] = isset($_POST['gcb_2']) ? trim($_POST['gcb_2']) : '';
      $_POST['gcb_3'] = isset($_POST['gcb_3']) ? trim($_POST['gcb_3']) : '';
      $_POST['include_page'] = isset($_POST['include_page']) ? intval($_POST['include_page']) : 0;
      $_POST['include_rss'] = isset($_POST['include_rss']) ? intval($_POST['include_rss']) : 0;
      $_POST['include_sitemap'] = isset($_POST['include_sitemap']) ? intval($_POST['include_sitemap']) : 0;
      $_POST['include_news'] = isset($_POST['include_news']) ? intval($_POST['include_news']) : 0;
      if(empty($_POST['rss'])) $_POST['rss'] = 0;
      if(empty($_POST['sitemap'])) $_POST['sitemap'] = 0;
      if(empty($_POST['content_type'])) $_POST['content_type'] = '';
      if(empty($_POST['charset'])) $_POST['charset'] = '';
      if(empty($_POST['edit_permission_general'])) $_POST['edit_permission_general'] = 0;
      $_POST['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
      $_POST['display_time'] = isset($_POST['display_time']) && $_POST['display_time']==1 ? 1 : 0;
      if($_POST['status']>2) $_POST['status'] = 2;
      $send_pingbacks = isset($_POST['send_pingbacks']) && $_POST['send_pingbacks']==1 ? 1 : 0;
      
      // trim sections:
      $sections_array = explode(',',$_POST['sections']);
      foreach($sections_array as $item)
       {
        if(trim($item)!='')
         {
          $cleared_sections_array[] = trim($item);
         }
       }
      $_POST['sections'] = '';
      if(isset($cleared_sections_array))
       {
        $cleared_sections_array_count = count($cleared_sections_array);
        $i=1;
        foreach($cleared_sections_array as $section)
         {
          $_POST['sections'] .= $section;
          if($i<$cleared_sections_array_count) $_POST['sections'] .= ',';
          ++$i;
         }
       }

      // trim custom values:
      $tv_array = explode(',', $_POST['tv']);
      foreach($tv_array as $item)
       {
        if(trim($item)!='')
         {
          $cleared_tv_array[] = trim($item);
         }
       }
      if(isset($cleared_tv_array)) $_POST['tv'] = implode(',', $cleared_tv_array);
      else $_POST['tv'] = '';

      // generate breadcrumb list:
      if(isset($_POST['breadcrumbs']) && is_array($_POST['breadcrumbs']))
       {
        foreach($_POST['breadcrumbs'] as $breadcrumb)
         {
          if(!empty($breadcrumb)) $cleared_breadcrumbs[] = intval($breadcrumb);
         }
        if(isset($cleared_breadcrumbs))
         {
          $breadcrumb_list = implode(',',$cleared_breadcrumbs);
         }
       }
      if(empty($breadcrumb_list))
       {
        $breadcrumb_list = '';
       }

      // generate edit permission list:
      $edit_permission_list = '';
      $users_array = explode(',',$_POST['edit_permission']);
      foreach($users_array as $current_user)
       {
        if(trim($current_user)!='' && in_array(strtolower(trim($current_user)),$users))
         {
          $cleared_users_array[] = strtolower(trim($current_user));
         }
        else
         {
          if(trim($current_user)!='')
           {
            $invalid_username = true;
           }
         }
       }
      if(isset($cleared_users_array))
       {
        $cleared_users_array_count = count($cleared_users_array);
        $users_trans = array_flip($users);
        $i=1;
        foreach($cleared_users_array as $current_user)
         {
          $edit_permission_list .= $users_trans[$current_user];
          if($i<$cleared_users_array_count) $edit_permission_list .= ',';
          ++$i;
         }
       }
      if(isset($invalid_username))
       {
        $errors[] = 'invalid_edit_auth_list';
       }

      #$page = trim($_POST['page']);
      $type_addition = trim($_POST['type_addition']);
      if(empty($_POST['page'])) $errors[] = 'error_page_name_empty';
      elseif(!preg_match(VALID_URL_CHARACTERS, $_POST['page'])) $errors[] ='error_page_name_spec_chars';

      #if(empty($_POST['title'])) $errors[] = 'error_no_title';

      if($_POST['teaser_img']!='' && !file_exists(BASE_PATH.MEDIA_DIR.$_POST['teaser_img'])) $errors[] = 'err_teaser_img_doesnt_exist';

      if(empty($page_types[$_POST['type']])) $errors[] = 'invalid_page_type';
      if(isset($page_types[$_POST['type']]) && $page_types[$_POST['type']]['requires_parameter'] == true && trim($type_addition)=='') $errors[] = 'page_type_req_param';

      if(($time = strtotime($_POST['time']))===false) $errors[] = 'time_invalid';
      if(($last_modified = strtotime($_POST['last_modified']))===false) $errors[] = 'last_modified_invalid';

     }

    if(empty($errors))
     {
      $dbr = Database::$content->prepare("SELECT id, page FROM ".Database::$db_settings['pages_table']." WHERE lower(page)=:page LIMIT 1");
      $dbr->bindValue(':page', strtolower($_POST['page']), PDO::PARAM_STR);
      $dbr->execute();
      $data = $dbr->fetch();
      if(isset($data['id']))
       {
        #if(isset($_POST['id']) && intval($_POST['id'])==intval($data['id']) && empty($_POST['edit_mode']))
        # {
        #  // OK...
        # }
        if(!(isset($_POST['id']) && empty($_POST['edit_mode']) && intval($data['id'])==intval($_POST['id']))) $errors[] = 'error_page_name_alr_exists';
       }
     }

    if(empty($errors))
     {
      if(isset($_POST['id']) && empty($_POST['edit_mode']))
       {
        $dbr = Database::$content->prepare("UPDATE ".Database::$db_settings['pages_table']." SET page=:page, type=:type, type_addition=:type_addition, time=:time, last_modified=:last_modified, display_time=:display_time, last_modified_by=:last_modified_by, title=:title, page_title=:page_title, description=:description, keywords=:keywords, category=:category, page_info=:page_info, breadcrumbs=:breadcrumbs, teaser_headline=:teaser_headline, teaser=:teaser, teaser_img=:teaser_img, content=:content, sidebar_1=:sidebar_1, sidebar_2=:sidebar_2, sidebar_3=:sidebar_3, sections=:sections, include_page=:include_page, include_order=:include_order, include_rss=:include_rss, include_sitemap=:include_sitemap, include_news=:include_news, link_name=:link_name, menu_1=:menu_1, menu_2=:menu_2, menu_3=:menu_3, gcb_1=:gcb_1, gcb_2=:gcb_2, gcb_3=:gcb_3, template=:template, language=:language, content_type=:content_type, charset=:charset, page_notes=:page_notes, edit_permission=:edit_permission, edit_permission_general=:edit_permission_general, tv=:tv, status=:status WHERE id=:id");
        $dbr->bindParam(':page', $_POST['page'], PDO::PARAM_STR);
        $dbr->bindParam(':type', $_POST['type'], PDO::PARAM_STR);
        $dbr->bindParam(':type_addition', $type_addition, PDO::PARAM_STR);
        $dbr->bindParam(':time', $time, PDO::PARAM_INT);
        $dbr->bindParam(':last_modified', $last_modified, PDO::PARAM_INT);
        $dbr->bindParam(':display_time', $_POST['display_time'], PDO::PARAM_INT);
        $dbr->bindParam(':last_modified_by', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
        $dbr->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
        $dbr->bindParam(':page_title', $_POST['page_title'], PDO::PARAM_STR);
        $dbr->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
        $dbr->bindParam(':keywords', $_POST['keywords'], PDO::PARAM_STR);
        $dbr->bindParam(':category', $_POST['category'], PDO::PARAM_STR);
        $dbr->bindParam(':page_info', $_POST['page_info'], PDO::PARAM_STR);
        $dbr->bindParam(':breadcrumbs', $breadcrumb_list, PDO::PARAM_STR);
        $dbr->bindParam(':teaser_headline', $_POST['teaser_headline'], PDO::PARAM_STR);
        $dbr->bindParam(':teaser', $_POST['teaser'], PDO::PARAM_STR);
        $dbr->bindParam(':teaser_img', $_POST['teaser_img'], PDO::PARAM_STR);
        $dbr->bindParam(':content', $_POST['content'], PDO::PARAM_STR);
        $dbr->bindParam(':sidebar_1', $_POST['sidebar_1'], PDO::PARAM_STR);
        $dbr->bindParam(':sidebar_2', $_POST['sidebar_2'], PDO::PARAM_STR);
        $dbr->bindParam(':sidebar_3', $_POST['sidebar_3'], PDO::PARAM_STR);
        $dbr->bindParam(':sections', $_POST['sections'], PDO::PARAM_STR);
        $dbr->bindParam(':include_page', $_POST['include_page'], PDO::PARAM_INT);
        $dbr->bindParam(':include_order', $_POST['include_order'], PDO::PARAM_INT);
        $dbr->bindParam(':include_rss', $_POST['include_rss'], PDO::PARAM_INT);
        $dbr->bindParam(':include_sitemap', $_POST['include_sitemap'], PDO::PARAM_INT);
        $dbr->bindParam(':include_news', $_POST['include_news'], PDO::PARAM_INT);
        $dbr->bindParam(':link_name', $_POST['link_name'], PDO::PARAM_STR);
        $dbr->bindParam(':menu_1', $_POST['menu_1'], PDO::PARAM_STR);
        $dbr->bindParam(':menu_2', $_POST['menu_2'], PDO::PARAM_STR);
        $dbr->bindParam(':menu_3', $_POST['menu_3'], PDO::PARAM_STR);
        $dbr->bindParam(':gcb_1', $_POST['gcb_1'], PDO::PARAM_STR);
        $dbr->bindParam(':gcb_2', $_POST['gcb_2'], PDO::PARAM_STR);
        $dbr->bindParam(':gcb_3', $_POST['gcb_3'], PDO::PARAM_STR);
        $dbr->bindParam(':template', $_POST['template'], PDO::PARAM_STR);
        $dbr->bindParam(':language', $_POST['language'], PDO::PARAM_STR);
        $dbr->bindParam(':content_type', $_POST['content_type'], PDO::PARAM_STR);
        $dbr->bindParam(':charset', $_POST['charset'], PDO::PARAM_STR);
        $dbr->bindParam(':page_notes', $_POST['page_notes'], PDO::PARAM_STR);
        $dbr->bindParam(':edit_permission', $edit_permission_list, PDO::PARAM_STR);
        $dbr->bindParam(':edit_permission_general', $_POST['edit_permission_general'], PDO::PARAM_INT);
        $dbr->bindParam(':tv', $_POST['tv'], PDO::PARAM_STR);
        $dbr->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
        $dbr->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $dbr->execute();
        #print_r(Database::$content->errorInfo());
       }
      else
       {
        if(isset($_POST['edit_mode']))
         {
          $time = $last_modified;
         }
        $dbr = Database::$content->prepare("INSERT INTO ".Database::$db_settings['pages_table']." (page,type,type_addition,time,last_modified,display_time,last_modified_by,title,page_title,description,keywords,category,page_info,breadcrumbs,teaser_headline,teaser,teaser_img,content,sidebar_1,sidebar_2,sidebar_3,sections,include_page,include_order,include_rss,include_sitemap,include_news,link_name,menu_1,menu_2,menu_3,gcb_1,gcb_2,gcb_3,template,language,content_type,charset,page_notes,edit_permission,edit_permission_general,tv,status,author) VALUES (:page,:type,:type_addition,:time,:last_modified,:display_time,:last_modified_by,:title,:page_title,:description,:keywords,:category,:page_info,:breadcrumbs,:teaser_headline,:teaser,:teaser_img,:content,:sidebar_1,:sidebar_2,:sidebar_3,:sections,:include_page,:include_order,:include_rss,:include_sitemap,:include_news,:link_name,:menu_1,:menu_2,:menu_3,:gcb_1,:gcb_2,:gcb_3,:template,:language,:content_type,:charset,:page_notes,:edit_permission,:edit_permission_general,:tv,:status,:author)");
        $dbr->bindParam(':page', $_POST['page'], PDO::PARAM_STR);
        $dbr->bindParam(':type', $_POST['type'], PDO::PARAM_STR);
        $dbr->bindParam(':type_addition', $type_addition, PDO::PARAM_STR);
        $dbr->bindParam(':time', $time, PDO::PARAM_INT);
        $dbr->bindParam(':last_modified', $last_modified, PDO::PARAM_INT);
        $dbr->bindParam(':display_time', $_POST['display_time'], PDO::PARAM_INT);
        $dbr->bindParam(':last_modified_by', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
        $dbr->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
        $dbr->bindParam(':page_title', $_POST['page_title'], PDO::PARAM_STR);
        $dbr->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
        $dbr->bindParam(':keywords', $_POST['keywords'], PDO::PARAM_STR);
        $dbr->bindParam(':category', $_POST['category'], PDO::PARAM_STR);
        $dbr->bindParam(':page_info', $_POST['page_info'], PDO::PARAM_STR);
        $dbr->bindParam(':breadcrumbs', $breadcrumb_list, PDO::PARAM_STR);
        $dbr->bindParam(':teaser_headline', $_POST['teaser_headline'], PDO::PARAM_STR);
        $dbr->bindParam(':teaser', $_POST['teaser'], PDO::PARAM_STR);
        $dbr->bindParam(':teaser_img', $_POST['teaser_img'], PDO::PARAM_STR);
        $dbr->bindParam(':content', $_POST['content'], PDO::PARAM_STR);
        $dbr->bindParam(':sidebar_1', $_POST['sidebar_1'], PDO::PARAM_STR);
        $dbr->bindParam(':sidebar_2', $_POST['sidebar_2'], PDO::PARAM_STR);
        $dbr->bindParam(':sidebar_3', $_POST['sidebar_3'], PDO::PARAM_STR);
        $dbr->bindParam(':sections', $_POST['sections'], PDO::PARAM_STR);
        $dbr->bindParam(':include_page', $_POST['include_page'], PDO::PARAM_INT);
        $dbr->bindParam(':include_order', $_POST['include_order'], PDO::PARAM_INT);
        $dbr->bindParam(':include_rss', $_POST['include_rss'], PDO::PARAM_INT);
        $dbr->bindParam(':include_sitemap', $_POST['include_sitemap'], PDO::PARAM_INT);
        $dbr->bindParam(':include_news', $_POST['include_news'], PDO::PARAM_INT);
        $dbr->bindParam(':link_name', $_POST['link_name'], PDO::PARAM_STR);
        $dbr->bindParam(':menu_1', $_POST['menu_1'], PDO::PARAM_STR);
        $dbr->bindParam(':menu_2', $_POST['menu_2'], PDO::PARAM_STR);
        $dbr->bindParam(':menu_3', $_POST['menu_3'], PDO::PARAM_STR);
        $dbr->bindParam(':gcb_1', $_POST['gcb_1'], PDO::PARAM_STR);
        $dbr->bindParam(':gcb_2', $_POST['gcb_2'], PDO::PARAM_STR);
        $dbr->bindParam(':gcb_3', $_POST['gcb_3'], PDO::PARAM_STR);
        $dbr->bindParam(':template', $_POST['template'], PDO::PARAM_STR);
        $dbr->bindParam(':language', $_POST['language'], PDO::PARAM_STR);
        $dbr->bindParam(':content_type', $_POST['content_type'], PDO::PARAM_STR);
        $dbr->bindParam(':charset', $_POST['charset'], PDO::PARAM_STR);
        $dbr->bindParam(':page_notes', $_POST['page_notes'], PDO::PARAM_STR);
        $dbr->bindParam(':edit_permission', $edit_permission_list, PDO::PARAM_STR);
        $dbr->bindParam(':edit_permission_general', $_POST['edit_permission_general'], PDO::PARAM_INT);
        $dbr->bindParam(':tv', $_POST['tv'], PDO::PARAM_STR);
        $dbr->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
        $dbr->bindParam(':author', $_SESSION[$settings['session_prefix'].'user_id'], PDO::PARAM_INT);
        $dbr->execute();
       }

      if(isset($cache) && $cache->autoClear) $cache->clear();
      
      if($settings['pingbacks_enabled'] && $send_pingbacks)
       {
        $page_content = $_POST['content'];
        if($settings['content_auto_link']==1) $page_content = make_link($page_content);
        $page_content = parse_special_tags($page_content);
        $pingback = new Pingback();
        $pingback->ping(BASE_URL.$_POST['page'], $page_content);
       }
      
      if(intval($_POST['status'])==0)
       {
        header('Location: '.BASE_URL.ADMIN_DIR.'index.php?mode=pages');
        exit;
       }
      else
       {
        header('Location: '.BASE_URL.$_POST['page']);
       }
     }
    else
     {
      $template->assign('errors',$errors);
      if(isset($_POST['id'])) $page_data['id'] = intval($_POST['id']);
      $page_data['edit_mode'] = isset($_POST['edit_mode']) ? intval($_POST['edit_mode']) : 0;
      $page_data['page'] = isset($_POST['page']) ? htmlspecialchars($_POST['page']) : '';
      $page_data['category'] = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '';
      $page_data['page_info'] = isset($_POST['page_info']) ? htmlspecialchars($_POST['page_info']) : '';
      $page_data['page_title'] = isset($_POST['page_title']) ? htmlspecialchars($_POST['page_title']) : '';
      $page_data['description'] = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
      $page_data['keywords'] = isset($_POST['keywords']) ? htmlspecialchars($_POST['keywords']) : '';
      $page_data['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
      $page_data['teaser'] = isset($_POST['teaser']) ? htmlspecialchars($_POST['teaser']) : '';
      $page_data['teaser_headline'] = isset($_POST['teaser_headline']) ? htmlspecialchars($_POST['teaser_headline']) : '';
      $page_data['teaser_img'] = isset($_POST['teaser_img']) ? htmlspecialchars($_POST['teaser_img']) : '';
      $page_data['sidebar_1'] = isset($_POST['sidebar_1']) ? htmlspecialchars($_POST['sidebar_1']) : '';
      $page_data['sidebar_2'] = isset($_POST['sidebar_2']) ? htmlspecialchars($_POST['sidebar_2']) : '';
      $page_data['sidebar_3'] = isset($_POST['sidebar_3']) ? htmlspecialchars($_POST['sidebar_3']) : '';
      $page_data['type'] = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
      $page_data['type_addition'] = isset($_POST['type_addition']) ? htmlspecialchars($_POST['type_addition']) : '';
      $page_data['time'] = isset($_POST['time']) ? htmlspecialchars($_POST['time']) : '';
      $page_data['last_modified'] = isset($_POST['last_modified']) ? htmlspecialchars($_POST['last_modified']) : '';
      $page_data['display_time'] = isset($_POST['display_time']) && $_POST['display_time']==1 ? 1 : 0;
      $page_data['include_page'] = isset($_POST['include_page']) ? intval($_POST['include_page']) : 0;
      $page_data['include_order'] = isset($_POST['include_order']) ? intval($_POST['include_order']) : 0;
      $page_data['include_rss'] = isset($_POST['include_rss']) ? intval($_POST['include_rss']) : 0;
      $page_data['include_sitemap'] = isset($_POST['include_sitemap']) ? intval($_POST['include_sitemap']) : 0;
      $page_data['include_news'] = isset($_POST['include_news']) ? intval($_POST['include_news']) : 0;
      $page_data['link_name'] = isset($_POST['link_name']) ? htmlspecialchars($_POST['link_name']) : Localization::$lang['teaser_default_linkname'];
      $page_data['template'] = isset($_POST['template']) ? htmlspecialchars($_POST['template']) : $settings['default_template'];
      $page_data['language'] = isset($_POST['language']) ? htmlspecialchars($_POST['language']) : '';
      $page_data['content_type'] = isset($_POST['content_type']) ? htmlspecialchars($_POST['content_type']) : '';
      $page_data['charset'] = isset($_POST['charset']) ? htmlspecialchars($_POST['charset']) : '';
      $page_data['menu_1'] = isset($_POST['menu_1']) ? htmlspecialchars($_POST['menu_1']) : $settings['default_menu'];
      $page_data['menu_2'] = isset($_POST['menu_2']) ? htmlspecialchars($_POST['menu_2']) : '';
      $page_data['menu_3'] = isset($_POST['menu_3']) ? htmlspecialchars($_POST['menu_3']) : '';
      $page_data['gcb_1'] = isset($_POST['gcb_1']) ? htmlspecialchars($_POST['gcb_1']) : '';
      $page_data['gcb_2'] = isset($_POST['gcb_2']) ? htmlspecialchars($_POST['gcb_2']) : '';
      $page_data['gcb_3'] = isset($_POST['gcb_3']) ? htmlspecialchars($_POST['gcb_3']) : '';
      $page_data['page_notes'] = isset($_POST['page_notes']) ? htmlspecialchars($_POST['page_notes']) : '';
      $page_data['sections'] = isset($_POST['sections']) ? htmlspecialchars($_POST['sections']) : '';
      $page_data['tv'] = isset($_POST['tv']) ? htmlspecialchars($_POST['tv']) : '';
      $page_data['edit_permission_general'] = isset($_POST['edit_permission_general']) ? intval($_POST['edit_permission_general']) : 0;
      $page_data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

      if(isset($_POST['breadcrumbs']) && is_array($_POST['breadcrumbs']))
       {
        foreach($_POST['breadcrumbs'] as $breadcrumb)
         {
          if(!empty($breadcrumb)) $page_data['breadcrumbs'][] = intval($breadcrumb);
         }
       }

      $page_data['content'] = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';

      $edit_mode = isset($_POST['edit_mode']) && $_POST['edit_mode']==1 ? 1 : 0;
     }
   }
  // end if(isset($_POST['content']))

  switch($action)
   {
    case 'main':
     // get available pages:
     $dbr = Database::$content->query("SELECT id, page, type FROM ".Database::$db_settings['pages_table']." ORDER BY page ASC");
     $i=0;
     $ii=0;
     while($pages_data = $dbr->fetch())
      {
       $pages[$i]['id'] = $pages_data['id'];
       $pages[$i]['page'] = $pages_data['page'];
       $pages[$i]['type'] = $pages_data['type'];

       if($pages_data['type']=='news' || $pages_data['type']=='simple_news')
        {
         $simple_news_pages[$ii]['id'] = $pages_data['id'];
         $simple_news_pages[$ii]['page'] = $pages_data['page'];
         ++$ii;
        }

       ++$i;
      }
     if(isset($pages))
      {
       $template->assign('pages',$pages);
      }
     if(isset($simple_news_pages))
      {
       $template->assign('simple_news_pages',$simple_news_pages);
      }

     // get menus:
     $menu_result = Database::$content->query("SELECT DISTINCT menu FROM ".Database::$db_settings['menu_table']." ORDER BY menu ASC");
     while($menu_data = $menu_result->fetch())
      {
       $menus[] = $menu_data['menu'];
      }
     if(isset($menus))
      {
       $template->assign('menus',$menus);
      }

     // get global content blocks:
     $gcb_result = Database::$content->query("SELECT id, identifier FROM ".Database::$db_settings['gcb_table']." ORDER BY id ASC");
     $i=0;
     while($gcb_data = $gcb_result->fetch())
      {
       $gcbs[$i]['id'] = $gcb_data['id'];
       $gcbs[$i]['identifier'] = $gcb_data['identifier'];
       $i++;
      }
     if(isset($gcbs))
      {
       $template->assign('gcbs',$gcbs);
      }

     // get available templates:
     $handle=opendir(BASE_PATH.'cms/templates/');
     while($file = readdir($handle))
      {
       if(preg_match('/\.tpl$/i', $file))
        {
         $template_file_array[] = $file;
        }
      }
     closedir($handle);
     natcasesort($template_file_array);
     $i=0;
     foreach($template_file_array as $file)
      {
       $template_files[$i] = $file;
       #$template_files[$i]['name'] = htmlspecialchars($file);
       $i++;
      }
     if(isset($template_files))
      {
       $template->assign('template_files',$template_files);
      }

     $template->assign('page_languages', get_languages());

     if(empty($edit_mode))
      {
       $edit_mode=0;
      }
     $template->assign('edit_mode',$edit_mode);
     if(isset($page_data))
      {
       $template->assign('page_data', $page_data);
       $template->assign('send_pingbacks', $send_pingbacks);
      }
     $template->assign('subtemplate', 'edit.inc.tpl');
     break;

    case 'page_doesnt_exist':
     $template->assign('invalid_request', 'page_doesnt_exist');
     $template->assign('subtemplate', 'edit.inc.tpl');
     break;
    case 'no_authorization':
     $template->assign('invalid_request', 'no_authorization_edit');
     $template->assign('subtemplate', 'edit.inc.tpl');
     break;
 }
}
