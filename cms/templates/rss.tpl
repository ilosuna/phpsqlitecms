<?php echo '<?xml version="1.0" encoding="' . $lang['charset'] . '" ?>'; ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?php echo $title; ?></title>
        <link><?php echo BASE_URL; ?></link>
        <description><?php echo $description; ?></description>
        <language><?php echo $lang['lang']; ?></language>
        <?php if (isset($rss_items)): foreach ($rss_items as $item): ?>
            <item>
                <title><?php echo $item['title'] ?></title>
                <content:encoded><![CDATA[<?php echo $item['content'] ?>]]></content:encoded>
                <link><?php echo $item['link'] ?></link>
                <pubDate><?php echo $item['pubdate'] ?></pubDate>
            </item>
        <?php endforeach; endif; ?>
    </channel>
</rss>
