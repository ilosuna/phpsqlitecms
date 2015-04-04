phpSQLiteCMS
============

<a href="http://phpsqlitecms.net/">phpSQLiteCMS</a> 是一个轻量的开源CMS系统，基于 <a href="http://php.net/">PHP</a> 和 <a href="http://www.sqlite.org/">SQLite</a>. 得益于SQLite是基于文件的，它能够“开箱即用”，无需繁琐的安装步骤。

系统需求
-------------------

* Apache 服务器并开启 <a href="http://httpd.apache.org/docs/2.4/mod/mod_rewrite.html">mod_rewrite</a> 和 <a href="http://httpd.apache.org/docs/2.4/howto/htaccess.html">.htaccess file support</a> 支持。
* PHP 5 并开启 <a href="http://php.net/manual/en/book.pdo.php">PDO</a> 和 <a href="http://php.net/manual/en/ref.pdo-sqlite.php">SQLite driver</a> 支持。

安装
------------

1. 上传所有文件到服务器。
2. 根据您的服务器配置，您可能需要更改下列文件和目录的写权限：
     * **cms/data** - SQLite 数据库目录
     * **content.sqlite**, **entries.sqlite** and **userdata.sqlite** - SQLite 数据库文件
     * **cms/cache** - 缓存目录，如果你要使用缓存功能 
     * **cms/media** and **cms/files** - 上传目录
3. 就这么简单，完成了！用浏览器访问您的网站(例如 http://example.org/path/to/phpsqlitecms/)。 后台地址是/cms  (例如 http://example.org/path/to/phpsqlitecms/cms/)。 默认管理员账户是： admin, 密码： admin，强烈建议您修改密码。

