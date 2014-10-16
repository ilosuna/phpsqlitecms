# Converted with pg2mysql-1.9
# Converted on Sat, 19 Apr 2014 08:52:11 -0400
# Lightbox Technologies Inc. http://www.lightbox.ca

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone="+00:00";

CREATE TABLE phpsqlitecms_banlists
(
  id int(11) auto_increment NOT NULL,
  name varchar(255) NOT NULL DEFAULT '',
  list text
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_comments
(
  id int(11) auto_increment NOT NULL,
  `type` smallint NOT NULL DEFAULT 0,
  comment_id int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0,
  ip varchar(255) NOT NULL DEFAULT '',
  name varchar(255) NOT NULL DEFAULT '',
  email_hp varchar(255) NOT NULL DEFAULT '',
  comment text NOT NULL
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_gcb
(
  id int(11) auto_increment NOT NULL,
  identifier varchar(255) NOT NULL DEFAULT '',
  content text NOT NULL,
  content_formatting smallint DEFAULT 0
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_menus
(
  id int(11) auto_increment NOT NULL,
  menu varchar(255) NOT NULL DEFAULT '',
  sequence int(11) NOT NULL DEFAULT 1,
  name varchar(255) NOT NULL DEFAULT '',
  title varchar(255) NOT NULL DEFAULT '',
  link varchar(255) NOT NULL DEFAULT '',
  section varchar(255) NOT NULL DEFAULT '',
  accesskey varchar(255) NOT NULL DEFAULT ''
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_news
(
  id int(11) auto_increment NOT NULL,
  page_id int(11),
  `time` int(11),
  title varchar(255) NOT NULL,
  teaser text,
  text text,
  text_formatting smallint,
  linkname varchar(255)
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_newsletter
(
  id int(11) auto_increment NOT NULL,
  newsletter_id int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0,
  ip varchar(255) NOT NULL DEFAULT '',
  email varchar(255) NOT NULL DEFAULT '',
  confirmed smallint DEFAULT 0,
  confirmation_code varchar(255) NOT NULL DEFAULT ''
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_notes
(
  id int(11) auto_increment NOT NULL,
  note_section varchar(255) NOT NULL DEFAULT '',
  sequence int(11) NOT NULL DEFAULT 1,
  `time` int(11) NOT NULL DEFAULT 0,
  title varchar(255) NOT NULL DEFAULT '',
  text text NOT NULL,
  text_formatting smallint DEFAULT 0,
  link varchar(255) NOT NULL DEFAULT '',
  linkname varchar(255) NOT NULL DEFAULT ''
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_pages
(
  id int(11) auto_increment NOT NULL,
  page varchar(255) NOT NULL DEFAULT '',
  author int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL DEFAULT '',
  type_addition varchar(255) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0,
  display_time smallint DEFAULT 0,
  last_modified int(11) NOT NULL DEFAULT 0,
  last_modified_by int(11) NOT NULL DEFAULT 0,
  title varchar(255) NOT NULL DEFAULT '',
  page_title varchar(255) NOT NULL DEFAULT '',
  description varchar(255) NOT NULL DEFAULT '',
  keywords varchar(255) NOT NULL DEFAULT '',
  category varchar(255),
  page_info varchar(255) NOT NULL DEFAULT '',
  language varchar(255) NOT NULL DEFAULT '',
  breadcrumbs varchar(255) NOT NULL DEFAULT '',
  sections varchar(255) NOT NULL DEFAULT '',
  include_page int(11) NOT NULL DEFAULT 0,
  include_order int(11) NOT NULL DEFAULT 0,
  include_rss int(11) NOT NULL DEFAULT 0,
  include_sitemap int(11) NOT NULL DEFAULT 0,
  link_name varchar(255) NOT NULL DEFAULT '',
  template varchar(255) NOT NULL DEFAULT '',
  content_type varchar(255) NOT NULL DEFAULT '',
  charset varchar(255) NOT NULL DEFAULT '',
  teaser_headline varchar(255) NOT NULL DEFAULT '',
  teaser text,
  teaser_img varchar(255) NOT NULL DEFAULT '',
  content text,
  sidebar_1 text,
  sidebar_2 text,
  sidebar_3 text,
  page_notes text,
  edit_permission varchar(255) NOT NULL DEFAULT '',
  edit_permission_general smallint DEFAULT 0,
  tv varchar(255) NOT NULL DEFAULT '',
  `status` smallint DEFAULT 2,
  views int(11) NOT NULL DEFAULT 0,
  include_news int(11) NOT NULL DEFAULT 0,
  menu_1 varchar(255),
  menu_2 varchar(255),
  menu_3 varchar(255),
  gcb_1 varchar(255),
  gcb_2 varchar(255),
  gcb_3 varchar(255)
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_photos
(
  id int(11) auto_increment NOT NULL,
  gallery varchar(255) NOT NULL DEFAULT '',
  sequence int(11) NOT NULL DEFAULT 1,
  photo_thumbnail varchar(255) NOT NULL DEFAULT '',
  photo_normal varchar(255) NOT NULL DEFAULT '',
  photo_large varchar(255) NOT NULL DEFAULT '',
  photo_xlarge varchar(255) NOT NULL DEFAULT '',
  width int(11) NOT NULL DEFAULT 0,
  height int(11) NOT NULL DEFAULT 0,
  large_width int(11) NOT NULL DEFAULT 0,
  large_height int(11) NOT NULL DEFAULT 0,
  title varchar(255) NOT NULL DEFAULT '',
  subtitle varchar(255) NOT NULL DEFAULT '',
  description text NOT NULL,
  description_formatting smallint DEFAULT 0,
  template varchar(255) NOT NULL DEFAULT '',
  photos_per_row smallint NOT NULL DEFAULT 4
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_settings
(
  id int(11) auto_increment NOT NULL,
  name varchar(255) NOT NULL DEFAULT '',
  value varchar(255) NOT NULL DEFAULT ''
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

CREATE TABLE phpsqlitecms_userdata
(
  id int(11) auto_increment NOT NULL,
  name varchar(255) NOT NULL DEFAULT '',
  `type` smallint NOT NULL DEFAULT 0,
  pw varchar(255) NOT NULL DEFAULT '',
  last_login int(11) NOT NULL DEFAULT 0,
  wysiwyg smallint NOT NULL DEFAULT 0
, PRIMARY KEY(`id`)
) ENGINE=MyISAM;

INSERT INTO phpsqlitecms_banlists (name, list) VALUES('user_agents', '');
INSERT INTO phpsqlitecms_banlists (name, list) VALUES('ips', '');
INSERT INTO phpsqlitecms_banlists (name, list) VALUES('words', '');
INSERT INTO phpsqlitecms_menus (menu, sequence, name, title, link, section, accesskey) VALUES('main_menu', 1, 'Home', 'Home', '', 'home', '0');
INSERT INTO phpsqlitecms_pages (page, author, type, type_addition, `time`, display_time, last_modified, last_modified_by, title, page_title, description, keywords, category, page_info, language, breadcrumbs, sections, include_page, include_order, include_rss, include_sitemap, link_name, template, content_type, charset, teaser_headline, teaser, teaser_img, content, sidebar_1, sidebar_2, sidebar_3, page_notes, edit_permission, edit_permission_general, tv, status, views, include_news, menu_1, menu_2, menu_3, gcb_1, gcb_2, gcb_3) VALUES ('home', 1, 'default', '', 1230764400, 0, 1381589697, 1, 'Home', 'phpSQLiteCMS - a simple & lightweight CMS', 'phpSQLiteCMS - a simple and lightweight content management system based on php and SQLite', 'CMS, content management system, php, sqlite', NULL, '', '', '', 'home', 0, 0, 0, 0, 'more...', 'default.tpl', '', '', '', '', '', '<h1>Welcome to phpSQLiteCMS with MySQL!</h1><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '', '', '', 'Here you can write down some notes. These notes will not be published. If you see this, <em>phpSQLiteCMS</em> seems to work! First thing to do is [[cms/index.php|log in]] and [[cms/index.php?mode=user|change the password]] (the default username and password is <i>admin</i>). Then you can begin to [[cms/index.php?mode=edit&id=1|edit this page]]. The other pages are examples to see what you can do with this CMS. Just play with them to learn about the functionality...', '', 0, '', 2, 0, 0, 'main_menu', '', '', '', '', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comment_order', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comments_per_page', '10');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('news_per_page', '10');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comment_notification', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comment_maxlength', '1000');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('word_maxlength', '30');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('name_maxlength', '50');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('email_hp_maxlength', '100');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_image_class', 'teaser');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_thumbnail_class', 'teaser');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_gallery_image_class', 'thumbnail');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('image_classes', 'float-left, float-right, thumbnail');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('photos_commentable', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('count_views', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_template', 'default.tpl');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_photo_template', 'photo.tpl');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_slideshow_template', 'slideshow.tpl');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('location_maxlength', '50');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('admin_entries_per_page', '20');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('resize', '640');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('resize_xy', 'x');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('compression', '80');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('session_prefix', 'phpsqlitecms_');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('smiley_directory', 'images/smilies');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comment_smilies', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comment_auto_link', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('content_smilies', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('content_auto_link', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_description', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_keywords', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('akismet_key', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('rss_maximum_items', '20');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('search_results_per_page', '20');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('counter_last_resetted', '1249183456');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('notes_per_page', '10');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('entries_show_email', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('mail_parameter', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('base_url', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_photos_per_row', '4');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('version', '2.0.2');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('breadcrumbs', '5');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('slideshow', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('base_path', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_formatting', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('akismet_entry_check', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('akismet_mail_check', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('prevent_repeated_posts_minutes', '2');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('comment_remove_blank_lines', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('admin_auto_clear_cache', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('check_access_permission', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('time_zone', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('simple_news_per_page', '10');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('global_content_blocks', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('include_news_items', '3');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('content_functions', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('rss_feed', 'rss');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('email_subject_maxlength', '100');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('email_text_maxlength', '10000');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('enable_fullfeeds', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('pingback_title_maxlength', '60');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('pingbacks_enabled', '1');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('lightbox_enabled', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('thumbnail_resize_xy', 'x');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('thumbnail_compression', '70');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('thumbnail_resize', '170');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('thumbnail_postfix', '_thumbnail');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('thumbnail_prefix', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_menu', 'main_menu');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('website_title', 'phpSQLiteCMS');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('website_subtitle', 'a simple & lightweight CMS');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('website_footnote_1', '');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('website_footnote_2', '© 2013 …');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('email', 'me@example.com');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('index_page', 'home');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('error_page', '404');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('admin_language', 'english');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_page_language', 'english');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('caching', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('wysiwyg_editor', '0');
INSERT INTO phpsqlitecms_userdata (name, type, pw, last_login, wysiwyg) VALUES('admin', 1, '$6$rounds=5000$56748f4e35e993f6$nW05WLxf2aJGdiALJktlCvzrAXdxlvMLhRUmNAw1W42tqVLXoS0AGRrM41.sSRp3PrYpg4qsjOHGN22jKzPxA0', 1230764400, 0);
