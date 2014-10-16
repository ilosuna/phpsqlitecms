CREATE TABLE phpsqlitecms_banlists
(
  id serial NOT NULL,
  name character varying(255) NOT NULL DEFAULT ''::character varying,
  list text,
  CONSTRAINT phpsqlitecms_banlists_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_comments
(
  id serial NOT NULL,
  type smallint NOT NULL DEFAULT 0::smallint,
  comment_id integer NOT NULL DEFAULT 0,
  "time" integer NOT NULL DEFAULT 0,
  ip character varying(255) NOT NULL DEFAULT ''::character varying,
  name character varying(255) NOT NULL DEFAULT ''::character varying,
  email_hp character varying(255) NOT NULL DEFAULT ''::character varying,
  comment text NOT NULL,
  CONSTRAINT phpsqlitecms_comments_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_gcb
(
  id serial NOT NULL,
  identifier character varying(255) NOT NULL DEFAULT ''::character varying,
  content text NOT NULL,
  content_formatting smallint DEFAULT 0::smallint,
  CONSTRAINT phpsqlitecms_gcb_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_menus
(
  id serial NOT NULL,
  menu character varying(255) NOT NULL DEFAULT ''::character varying,
  sequence integer NOT NULL DEFAULT 1,
  name character varying(255) NOT NULL DEFAULT ''::character varying,
  title character varying(255) NOT NULL DEFAULT ''::character varying,
  link character varying(255) NOT NULL DEFAULT ''::character varying,
  section character varying(255) NOT NULL DEFAULT ''::character varying,
  accesskey character varying(255) NOT NULL DEFAULT ''::character varying,
  CONSTRAINT phpsqlitecms_menus_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_news
(
  id serial NOT NULL,
  page_id integer,
  "time" integer,
  title character varying(255) NOT NULL,
  teaser text,
  text text,
  text_formatting smallint,
  linkname character varying(255),
  CONSTRAINT phpsqlitecms_news_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_newsletter
(
  id serial NOT NULL,
  newsletter_id integer NOT NULL DEFAULT 0,
  "time" integer NOT NULL DEFAULT 0,
  ip character varying(255) NOT NULL DEFAULT ''::character varying,
  email character varying(255) NOT NULL DEFAULT ''::character varying,
  confirmed smallint DEFAULT 0::smallint,
  confirmation_code character varying(255) NOT NULL DEFAULT ''::character varying,
  CONSTRAINT phpsqlitecms_newsletter_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_notes
(
  id serial NOT NULL,
  note_section character varying(255) NOT NULL DEFAULT ''::character varying,
  sequence integer NOT NULL DEFAULT 1,
  "time" integer NOT NULL DEFAULT 0,
  title character varying(255) NOT NULL DEFAULT ''::character varying,
  text text NOT NULL,
  text_formatting smallint DEFAULT 0::smallint,
  link character varying(255) NOT NULL DEFAULT ''::character varying,
  linkname character varying(255) NOT NULL DEFAULT ''::character varying,
  CONSTRAINT phpsqlitecms_notes_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_pages
(
  id serial NOT NULL,
  page character varying(255) NOT NULL DEFAULT ''::character varying,
  author integer NOT NULL DEFAULT 0,
  type character varying(255) NOT NULL DEFAULT ''::character varying,
  type_addition character varying(255) NOT NULL DEFAULT ''::character varying,
  "time" integer NOT NULL DEFAULT 0,
  display_time smallint DEFAULT 0::smallint,
  last_modified integer NOT NULL DEFAULT 0,
  last_modified_by integer NOT NULL DEFAULT 0,
  title character varying(255) NOT NULL DEFAULT ''::character varying,
  page_title character varying(255) NOT NULL DEFAULT ''::character varying,
  description character varying(255) NOT NULL DEFAULT ''::character varying,
  keywords character varying(255) NOT NULL DEFAULT ''::character varying,
  category character varying(255),
  page_info character varying(255) NOT NULL DEFAULT ''::character varying,
  language character varying(255) NOT NULL DEFAULT ''::character varying,
  breadcrumbs character varying(255) NOT NULL DEFAULT ''::character varying,
  sections character varying(255) NOT NULL DEFAULT ''::character varying,
  include_page integer NOT NULL DEFAULT 0,
  include_order integer NOT NULL DEFAULT 0,
  include_rss integer NOT NULL DEFAULT 0,
  include_sitemap integer NOT NULL DEFAULT 0,
  link_name character varying(255) NOT NULL DEFAULT ''::character varying,
  template character varying(255) NOT NULL DEFAULT ''::character varying,
  content_type character varying(255) NOT NULL DEFAULT ''::character varying,
  charset character varying(255) NOT NULL DEFAULT ''::character varying,
  teaser_headline character varying(255) NOT NULL DEFAULT ''::character varying,
  teaser text,
  teaser_img character varying(255) NOT NULL DEFAULT ''::character varying,
  content text,
  sidebar_1 text,
  sidebar_2 text,
  sidebar_3 text,
  page_notes text,
  edit_permission character varying(255) NOT NULL DEFAULT ''::character varying,
  edit_permission_general smallint DEFAULT 0::smallint,
  tv character varying(255) NOT NULL DEFAULT ''::character varying,
  status smallint DEFAULT 2::smallint,
  views integer NOT NULL DEFAULT 0,
  include_news integer NOT NULL DEFAULT 0,
  menu_1 character varying,
  menu_2 character varying,
  menu_3 character varying,
  gcb_1 character varying,
  gcb_2 character varying,
  gcb_3 character varying,
  CONSTRAINT phpsqlitecms_pages_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_photos
(
  id serial NOT NULL,
  gallery character varying(255) NOT NULL DEFAULT ''::character varying,
  sequence integer NOT NULL DEFAULT 1,
  photo_thumbnail character varying(255) NOT NULL DEFAULT ''::character varying,
  photo_normal character varying(255) NOT NULL DEFAULT ''::character varying,
  photo_large character varying(255) NOT NULL DEFAULT ''::character varying,
  photo_xlarge character varying(255) NOT NULL DEFAULT ''::character varying,
  width integer NOT NULL DEFAULT 0,
  height integer NOT NULL DEFAULT 0,
  large_width integer NOT NULL DEFAULT 0,
  large_height integer NOT NULL DEFAULT 0,
  title character varying(255) NOT NULL DEFAULT ''::character varying,
  subtitle character varying(255) NOT NULL DEFAULT ''::character varying,
  description text NOT NULL,
  description_formatting smallint DEFAULT 0::smallint,
  template character varying(255) NOT NULL DEFAULT ''::character varying,
  photos_per_row smallint NOT NULL DEFAULT 4::smallint,
  CONSTRAINT phpsqlitecms_photos_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_settings
(
  id serial NOT NULL,
  name character varying(255) NOT NULL DEFAULT ''::character varying,
  value character varying(255) NOT NULL DEFAULT ''::character varying,
  CONSTRAINT phpsqlitecms_settings_pkey PRIMARY KEY (id)
);

CREATE TABLE phpsqlitecms_userdata
(
  id serial NOT NULL,
  name character varying(255) NOT NULL DEFAULT ''::character varying,
  type smallint NOT NULL DEFAULT 0::smallint,
  pw character varying(255) NOT NULL DEFAULT ''::character varying,
  last_login integer NOT NULL DEFAULT 0,
  wysiwyg smallint NOT NULL DEFAULT 0::smallint,
  CONSTRAINT phpsqlitecms_userdata_pkey PRIMARY KEY (id)
);

INSERT INTO phpsqlitecms_banlists (name, list) VALUES('user_agents', '');
INSERT INTO phpsqlitecms_banlists (name, list) VALUES('ips', '');
INSERT INTO phpsqlitecms_banlists (name, list) VALUES('words', '');

INSERT INTO phpsqlitecms_menus (menu, sequence, name, title, link, section, accesskey) VALUES('main_menu', 1, 'Home', 'Home', '', 'home', '0');

INSERT INTO phpsqlitecms_pages (page, author, type, type_addition, "time", display_time, last_modified, last_modified_by, title, page_title, description, keywords, category, page_info, language, breadcrumbs, sections, include_page, include_order, include_rss, include_sitemap, link_name, template, content_type, charset, teaser_headline, teaser, teaser_img, content, sidebar_1, sidebar_2, sidebar_3, page_notes, edit_permission, edit_permission_general, tv, status, views, include_news, menu_1, menu_2, menu_3, gcb_1, gcb_2, gcb_3) VALUES ('home', 1, 'default', '', 1230764400, 0, 1381589697, 1, 'Home', 'phpSQLiteCMS - a simple &amp; lightweight CMS', 'phpSQLiteCMS - a simple and lightweight content management system based on php and SQLite', 'CMS, content management system, php, sqlite', NULL, '', '', '', 'home', 0, 0, 0, 0, 'more...', 'default.tpl', '', '', '', '', '', '<h1>Welcome to phpSQLiteCMS with PostgreSQL!</h1><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '', '', '', 'Here you can write down some notes. These notes will not be published. If you see this, <em>phpSQLiteCMS</em> seems to work! First thing to do is [[cms/index.php|log in]] and [[cms/index.php?mode=user|change the password]] (the default username and password is <i>admin</i>). Then you can begin to [[cms/index.php?mode=edit&amp;id=1|edit this page]]. The other pages are examples to see what you can do with this CMS. Just play with them to learn about the functionality...', '', 0, '', 2, 0, 0, 'main_menu', '', '', '', '', '');

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
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('website_footnote_2', '&copy; 2013 &hellip;');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('email', 'me@example.com');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('index_page', 'home');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('error_page', '404');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('admin_language', 'english');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('default_page_language', 'english');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('caching', '0');
INSERT INTO phpsqlitecms_settings (name, value) VALUES ('wysiwyg_editor', '0');

INSERT INTO phpsqlitecms_userdata (name, type, pw, last_login, wysiwyg) VALUES('admin', 1, '$6$rounds=5000$56748f4e35e993f6$nW05WLxf2aJGdiALJktlCvzrAXdxlvMLhRUmNAw1W42tqVLXoS0AGRrM41.sSRp3PrYpg4qsjOHGN22jKzPxA0', 1230764400, 0);
