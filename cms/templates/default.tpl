<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="<?php echo $lang['charset']; ?>" />
<title><?php echo $settings['website_title']; if($page_title): ?> - <?php echo $page_title; elseif($title): ?> - <?php echo $title; endif; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
<link href="<?php echo STATIC_URL; ?>css/style.css" rel="stylesheet">
<?php if(isset($tv['map'])): ?>
<link rel="stylesheet" href="<?php echo STATIC_URL; ?>css/leaflet.css" />
<?php endif; ?>
<link rel="shortcut icon" href="<?php echo STATIC_URL; ?>img/favicon.png">
<?php if(isset($tv['map'])): ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.2&amp;sensor=false"></script>
<script src="<?php echo STATIC_URL; ?>js/leaflet.js"></script>
<?php endif; ?>
</head>

<body<?php if($admin): ?> class="admin"<?php endif; ?>>
<?php if($admin) include(BASE_PATH.'cms/templates/admin/subtemplates/admin_menu.inc.tpl'); ?>

<div class="container">

<header class="header">
<div class="row">
<div class="col-md-4 logo-wrapper">
<h1 id="logo"><a href="<?php echo BASE_URL; ?>"><?php echo $settings['website_title']; ?></a></h1>
</div>
<a id="menu-toggle-handle" href="#" class="visible-xs"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
<nav id="nav" class="col-md-8">		
<?php if($menu_1 && isset($menus[$menu_1])): ?>
<ul class="nav nav-pills">
<?php foreach($menus[$menu_1] as $item): ?><li<?php if(!empty($item['section']) && $item['section']==$section[0]): ?> class="active"<?php endif; ?>><a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"<?php if($item['accesskey']!=''): ?> accesskey="<?php echo $item['accesskey']; ?>"<?php endif; ?>><?php echo $item['name']; ?></a></li><?php endforeach; ?>
</ul>
<?php endif; ?>
</nav>
</div>
</header>

<?php if($sidebar_1): ?>
<?php echo $sidebar_1; ?>
<?php endif; ?>

<?php if($breadcrumbs): ?>
<ul class="breadcrumb">
<?php foreach($breadcrumbs as $breadcrumb): ?>
<li><a href="<?php echo BASE_URL.$breadcrumb['page']; ?>"><?php echo $breadcrumb['title']; ?></a></li>
<?php endforeach; ?>
<li><?php if($title) echo $title; ?></li>
</ul>
<?php endif; ?>

<?php if(empty($sidebar_1) && empty($breadcrumbs)): ?>
<hr class="topsep hidden-xs">
<?php endif; ?>
    
<div class="body-content">

<div class="row<?php if(isset($tv['nocolumns'])): ?> main-content<?php endif; ?>">

<?php if(empty($tv['nocolumns'])): ?>
<div class="col-md-8 main-content">
<?php endif; ?>

<?php if(empty($hide_content)) echo $content; ?>
<?php if(isset($subtemplate)) include(BASE_PATH.'cms/templates/subtemplates/'.$subtemplate); ?>

</div>

<?php if($sidebar_2): ?>
<div class="col-md-4 sidebar">
<hr class="visible-xs">
<?php echo $sidebar_2; ?>
</div>
<?php endif; ?>

<?php if(empty($tv['nocolumns'])): ?>
</div>
<?php endif; ?>

</div>

<hr class="closure">

<footer class="row footer">
<div class="col-lg-12">

<?php if($gcb_1 && isset($gcb[$gcb_1])): ?>
<?php echo $gcb[$gcb_1]; ?>
<?php else: ?>
<p>&copy; phpSQLiteCMS 2013<br /><?php if($type!='news' && $type!='search' && $type!='notes') echo $lang['page_last_modified']; ?></p>
<?php endif; ?>
</div>
</footer>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="<?php echo STATIC_URL; ?>js/main.js"></script>
<?php if($admin): ?>
<script src="<?php echo STATIC_URL; ?>js/admin_frontend.js"></script>
<?php endif; ?>
<?php if(isset($contains_thumbnails) && $settings['lightbox_enabled']): ?>
<script src="<?php echo STATIC_URL; ?>js/mylightbox.js" type="text/javascript"></script>
<?php endif; ?>    
<?php if(isset($tv['map'])): ?>
<script src="<?php echo STATIC_URL; ?>js/san_rafael_map.js"></script>
<?php endif; ?>
</body>
</html>

