<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($urls as $url)
        <url>
            <loc>
                {{ $url['loc'] }}
            </loc>
            <lastmod>
                {{ $url['lastmod'] }}
            </lastmod>
            <changefreq>
                {{ $url['changefreq'] }}
            </changefreq>
            <priority>
                {{ $url['priority'] }}
            </priority>
        </url>
    @endforeach
</urlset>