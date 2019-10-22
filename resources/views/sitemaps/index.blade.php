<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ config('app.url', 'reallexi.com') }}/sitemap/posts</loc>
        <lastmod>{{ ((!empty($post->created_at)) ? $post->created_at->tz('PST')->toAtomString() : '') }}</lastmod>
    </sitemap>
</sitemapindex>