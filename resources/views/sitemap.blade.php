<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://entertale.com/</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://entertale.com/login</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://entertale.com/register</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://entertale.com/partners</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://entertale.com/news</loc>
        <priority>1.0</priority>
    </url>

    @foreach($news as $new)
        <url>
            <loc>https://entertale.com/news/{{ $new->slug }}</loc>
            <priority>0.5</priority>
        </url>
    @endforeach

</urlset>