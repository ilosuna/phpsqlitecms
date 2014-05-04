<?php echo '<?xml version="1.0" encoding="' . $lang['charset'] . '" ?>'; ?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
    <?php if (isset($sitemap_items)): foreach ($sitemap_items as $item): ?>
        <url>
            <loc><?php echo $item['loc'] ?></loc>
            <lastmod><?php echo $item['lastmod'] ?></lastmod>
        </url>
    <?php endforeach; endif; ?>
</urlset>
