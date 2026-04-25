<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class PublicPagesController extends Controller
{
    protected string $canonicalBaseUrl = 'https://crm.kpvk.edu.kz';

    public function home(): \Illuminate\Contracts\View\View
    {
        return view('public.home');
    }

    public function about(): \Illuminate\Contracts\View\View
    {
        return view('public.about');
    }

    public function helpWhatIs(): \Illuminate\Contracts\View\View
    {
        return view('public.help.what-is-chaincrm');
    }

    public function sitemap(): Response
    {
        $xml = $this->buildSitemapXml();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    protected function buildSitemapXml(): string
    {
        $base = rtrim($this->canonicalBaseUrl, '/');

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

        return '<?xml version="1.0" encoding="UTF-8"?>' .
            "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" .
            $body .
            "\n</urlset>\n";
    }
}
