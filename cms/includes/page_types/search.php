<?php
if(!defined('IN_INDEX')) exit;

switch(Database::$db_settings['type'])
 {
  case 'sqlite':
  case 'sqlite2':
   $general_clause = "(page || title || page_title || content || keywords || description || sidebar_1 || sidebar_2 || sidebar_3) LIKE ?";
   $special_clause = "(page || title || page_title || keywords || description) LIKE ?";
   $photo_clause = "(title || subtitle || description) LIKE ?";
   break;
  default:
   $general_clause = "CONCAT(page, title, page_title, content, keywords, description, sidebar_1, sidebar_2, sidebar_3) LIKE ?";
   $special_clause = "CONCAT(page, title, page_title, keywords, description) LIKE ?";
   $photo_clause = "CONCAT(title, subtitle, description) LIKE ?";
 }

if(isset($_POST['q']))
 {
  $q = str_replace(',','',$_POST['q']);
  $q = urlencode($q);
  #$q = str_replace('%','~',$q);
  #header('Location: '.BASE_URL.$page.','.$q);
  if(trim($q)!='') header('Location: '.BASE_URL.PAGE.',,'.$q);
  else header('Location: '.BASE_URL.PAGE);
  exit;
 }
#if(isset($_POST['q'])) $q = $_POST['q'];
elseif(isset($_GET['get_2']))
 {
  $q = $_GET['get_2'];
  #$q = str_replace('~','%',$q);
  $q = urldecode($q);
  $no_cache = true;
 }

if(isset($_GET['get_3'])) $current_page = intval($_GET['get_3']);
else $current_page = 1;

if(isset($q))
 {
  $q = trim($q);
  $template->assign('q', htmlspecialchars($q));
  #$template->assign('q_encoded', str_replace('%','~',urlencode(htmlspecialchars($q))));
  #$q = stripslashes($q);
  $q = mb_substr($q, 0, 255);
  $q_encoded = urlencode(htmlspecialchars($q));
  $template->assign('q_encoded', $q_encoded);

  $cookie_data = $q_encoded.' '.$current_page;
  setcookie($settings['session_prefix'].'search',$cookie_data);

  $q = str_replace('"', '', $q);
  #$q = sqlite_escape_string($q);
  $q_array = explode(" ", $q);

  $number_of_words = count($q_array);
  // limitation to 3 words:
  if($number_of_words > 3)
   {
    $number_of_words = 3;
   }

  $dbr = Database::$content->query("SELECT id,page,title,description FROM ".Database::$db_settings['pages_table']." WHERE status>1");
  $dbr->execute();
  while($data = $dbr->fetch())
   {
    $pages[$data['id']]['page']=$data['page'];
    $pages[$data['id']]['title']=$data['title'];
    $pages[$data['id']]['description']=$data['description'];
   }

  // search pages:
  $general_search_clause = '';
  $special_search_clause = '';
  for($i=0;$i<$number_of_words;++$i)
   {
    $general_search_clause .= $general_clause;
    $special_search_clause .= $special_clause;
    if($i<$number_of_words-1)
     {
      $general_search_clause .= ' AND ';
      $special_search_clause .= ' AND ';
     }
   }
  // search all fields:

  $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['pages_table']." WHERE status>1 AND ".$general_search_clause);
  for($i=0;$i<$number_of_words;++$i)
   {
    $dbr->bindValue($i+1, '%'.$q_array[$i].'%', PDO::PARAM_STR);
   }
  #$dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['pages_table']." WHERE status>1 AND CONCAT(content, title) LIKE ?");
  #$dbr->bindValue(1, '%'.$q_array[0].'%', PDO::PARAM_STR);

  $dbr->execute();
  while($data = $dbr->fetch())
   {
    $result_pages[$data['id']]['id'] = $data['id'];
    $result_pages[$data['id']]['type'] = 0;
    $result_pages[$data['id']]['relevance'] = 0;
    $result_pages[$data['id']]['page'] = $pages[$data['id']]['page'];
    $result_pages[$data['id']]['title'] = $pages[$data['id']]['title'];
    $result_pages[$data['id']]['description'] = $pages[$data['id']]['description'];
   }
  if(isset($pages))
   {
    // search in special fields:
    $dbr = Database::$content->prepare("SELECT id FROM ".Database::$db_settings['pages_table']." WHERE status>1 AND ".$special_search_clause);
    for($i=0;$i<$number_of_words;++$i)
     {
      $dbr->bindValue($i+1, '%'.$q_array[$i].'%', PDO::PARAM_STR);
     }
    $dbr->execute();
    while($data = $dbr->fetch())
     {
      // enhance relevace if word found in special fields:
      if(isset($pages[$data['id']]))
       {
        ++$result_pages[$data['id']]['relevance'];
       }
     }
   }

  // search notes:
  /*
  $notes_search_string = "linkname || headline || text LIKE '%".implode("%' AND linkname || headline || text LIKE '%",$q_array)."%'";
  $notes_search_result = @sqlite_query($db_content, "SELECT note_section, order_id FROM ".Database::$db_settings['notes_table']." WHERE ".$notes_search_string." ORDER BY order_id DESC");
  while($row_n1 = sqlite_fetch_array($notes_search_result))
   {
    $notes_pages_result = @sqlite_query($db_content, "SELECT id FROM ".Database::$db_settings['pages_table']." WHERE type='notes' AND type_addition='".$row_n1['note_section']."'");
    while($row_n2 = sqlite_fetch_array($notes_pages_result))
     {
      // discard notes result if page is already in page results:
      if(empty($found_ids) || isset($found_ids) && !in_array($row_n2['id'],$found_ids))
       {
        $found_ids_notes[] = $row_n2['id'];
        // page nr of notes page
        $found_page_nr[$row_n2['id']] = ceil($row_n1['order_id'] / $settings['notes_per_page']);
       }
     }
   }
  */

  // search photos:
  /*
  $photo_search_clause = '';
  for($i=0;$i<$number_of_words;++$i)
   {
    $photo_search_clause .= $photo_clause;
    if($i<$number_of_words-1)
     {
      $photo_search_clause .= ' AND ';
     }
   }
  $dbr = Database::$content->prepare("SELECT id,title,subtitle,description FROM ".Database::$db_settings['photo_table']." WHERE ".$photo_search_clause);
  for($i=0;$i<$number_of_words;++$i)
   {
    $dbr->bindValue($i+1, '%'.$q_array[$i].'%', PDO::PARAM_STR);
   }
  $dbr->execute();
  while($data = $dbr->fetch())
   {
    $result_photos[$data['id']]['id'] = $data['id'];
    $result_photos[$data['id']]['type'] = 1;
    $result_photos[$data['id']]['relevance'] = 0;
    $result_photos[$data['id']]['page'] = PAGE.','.IMAGE_IDENTIFIER.','.$data['id'];
    $result_photos[$data['id']]['title'] = $data['title'];
    $result_photos[$data['id']]['description'] = '';
   }
  */
  // merge results:
  if(isset($result_pages))
   {
    foreach($result_pages as $result_page)
     {
      $results[] = $result_page;
     }
   }
  if(isset($result_photos))
   {
    foreach($result_photos as $result_photo)
     {
      $results[] = $result_photo;
     }
   }
  
  
  if(isset($results))
   {
    // sort by relevance:
    foreach($results as $key => $val)
     {
      $relevance[$key] = $val['relevance'];
     }
    array_multisort($relevance, SORT_DESC, $results);

    $result_count = count($results);

    $total_pages = ceil($result_count / $settings['search_results_per_page']);
    if($current_page>$total_pages) $curret_page = $total_pages;
    if($current_page<1) $current_page=1;

    #$displayed_count = 0;
    for($i=($current_page-1)*$settings['search_results_per_page'];$i<$current_page*$settings['search_results_per_page'];++$i)
     {
      if(isset($results[$i]))
       {
        $displayed_results[] = $results[$i];
        #$displayed_count++;
       }
     }

    $template->assign('pagination', pagination($total_pages,$current_page));

    $template->assign('results', $displayed_results);

    switch($result_count)
     {
      case 0:
       $localization->selectVariant('search_number_of_results', 0);
       break;
      case 1:
       $localization->selectVariant('search_number_of_results', 1);
       break;
      default:
       $localization->selectVariant('search_number_of_results', 2);
       $localization->replacePlaceholder('pages', $result_count, 'search_number_of_results');
     }
    #$loc->select_variant('search_number_of_results', 0);
    $localization->replacePlaceholder('current_page', $current_page, 'pagination');
    $localization->replacePlaceholder('total_pages', $total_pages, 'pagination');
   }
 }

$template->assign('subtemplate', 'search.inc.tpl');

if(isset($cache) && empty($no_cache))
 {
  $cache->cacheId = PAGE;
 }
?>
