<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
     version="2.0">
    <channel>
        <title><?= $siteMeta->title; ?></title>
        <atom:link href="<?= $siteMeta->url; ?>/feed/" rel="self" type="application/rss+xml"/>
        <link>
        <?= $siteMeta->url; ?>
        </link>
        <description><?= $siteMeta->description ?></description>
        <lastBuildDate>

        </lastBuildDate>
        <language>es-ES</language>
        <generator>https://github.com/marioperezesteso/laraweb</generator>
        @if ($articles !== null)
            @foreach($articles as $article)
                <item>
                    <title><?= $article->title; ?></title>
                    <link>
                    <?= $siteMeta->url . '/' . $article->slug; ?>
                    </link>
                    <comments>

                    </comments>
                    <pubDate>
                        <?php $objDateTime = new DateTime($article->published_at); ?>
                        <?= $objDateTime->format(DateTime::RFC822); ?>
                    </pubDate>
                    <dc:creator>
                        <![CDATA[ ]]>
                    </dc:creator>
                    <category>
                        <![CDATA[ ]]>
                    </category>
                    <description>
                        <![CDATA[ <?= $article->description; ?> ]]>
                    </description>
                    <content:encoded>
                        <![CDATA[ <?= $article->body ?> ]]>
                    </content:encoded>
                </item>
            @endforeach
        @endif
    </channel>
</rss>