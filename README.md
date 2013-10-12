phpSQLiteCMS
============

<a href="http://phpsqlitecms.net/">phpSQLiteCMS</a> is a simple and lightweight open source web content management system (CMS) based on <a href="http://php.net/">PHP</a> and <a href="http://www.sqlite.org/">SQLite</a>. As SQLite is file-based, it just runs "out of the box" without installation.

System requirements
-------------------

* Apache webserver with <a href="http://httpd.apache.org/docs/2.4/mod/mod_rewrite.html">mod_rewrite</a> and <a href="http://httpd.apache.org/docs/2.4/howto/htaccess.html">.htaccess file support</a> enabled
* PHP 5 with <a href="http://php.net/manual/en/book.pdo.php">PDO</a> and <a href="http://php.net/manual/en/ref.pdo-sqlite.php">SQLite driver</a> enabled

Installation
------------

1. Load up the script files to your server
2. Depending on your server configuration you may need to change the write permissions of the following files/directories:
     * **cms/data** - directory of the SQLite database files, needs to be writable by the webserver
     * **content.sqlite**, **entries.sqlite** and **userdata.sqlite** - SQLite database files, need to be writable by the webserver
     * **cms/cache** - cache directory, needs to be writable if you want to use the caching feature
     * **cms/media** and **cms/files** - need to be writable if you want to use the file uploader
3. Ready! You should now be able to access the index page by browsing to the address you uploaded phpSQLiteCMS (e.g. http://example.org/path/to/phpsqlitecms/). To administrate the page, go to http://example.org/path/to/phpsqlitecms/cms/. The default admin userdata is: username: admin, password: admin.

phpSQLiteCMS example sites
--------------------------

* <a href="http://phpsqlitecms.net/">phpSQLiteCMS</a> - project website
* <a href="http://mylittleforum.net/">my little forum</a> - another project of the author of *phpSQLiteCMS*
* <a href="http://procosara.org/">Pro Cosara</a> - an association dedicated to the conservation of Atlantic Forest in Paraguay
* <a href="http://www.eschenhof-online.de/">Eschenhof</a> - biodynamic farm near Kassel, Germany / Biologisch-dynamische Landwirtschaft bei Kassel
* <a href="http://praxis-kunstleben.de/">Praxis Kunstleben</a> - psychologische Praxis (Einzeltherapie, Paartherapie, Coaching, Familienberatung, Supervision) in Freiburg
* <a href="http://www.elbi-bs.com/">ELBI</a> - manufacturing of individual furniture and more in Burgas, Bulgaria
* <a href="http://phpsqlitecms.cu.cc/">phpSQLiteCMS Spanish</a> - Spanish phpSQLiteCMS demo and documentation site / página de documentación y demonstración española
