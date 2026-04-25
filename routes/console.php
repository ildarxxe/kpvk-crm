<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sitemap:generate', function () {
    $base = 'https://crm.kpvk.edu.kz';

    $urls = [
        [
            'loc' => $base . '/',
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ],
        [
            'loc' => $base . '/about-system',
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ],
        [
            'loc' => $base . '/help/what-is-chaincrm',
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ],
    ];

    $lastmod = now()->toAtomString();

    $body = '';
    foreach ($urls as $url) {
        $loc = htmlspecialchars($url['loc'], ENT_XML1);
        $changefreq = htmlspecialchars($url['changefreq'], ENT_XML1);
        $priority = htmlspecialchars($url['priority'], ENT_XML1);

        $body .= "\n  <url>";
        $body .= "\n    <loc>{$loc}</loc>";
        $body .= "\n    <lastmod>{$lastmod}</lastmod>";
        $body .= "\n    <changefreq>{$changefreq}</changefreq>";
        $body .= "\n    <priority>{$priority}</priority>";
        $body .= "\n  </url>";
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' .
        "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" .
        $body .
        "\n</urlset>\n";

    $path = public_path('sitemap.xml');
    File::put($path, $xml);

    $this->info("Sitemap generated: {$path}");
})->purpose('Generate public sitemap.xml for SEO pages');
