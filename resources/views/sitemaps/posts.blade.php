@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('comments','App\Http\Controllers\CommentsCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('likes', 'App\Http\Controllers\LikesCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($posts as $post)
        <url>
            <loc>{{ config('app.url', 'reallexi.com') }}/posts/{{ $post->path }}</loc>
            <lastmod>{{ ((!empty($post->created_at)) ? $post->created_at->tz('PST')->toAtomString() : '') }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>