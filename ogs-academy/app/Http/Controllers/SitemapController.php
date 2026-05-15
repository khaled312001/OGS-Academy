<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            ['loc' => route('home'),           'changefreq' => 'weekly',  'priority' => '1.0'],
            ['loc' => route('programs.index'), 'changefreq' => 'weekly',  'priority' => '0.9'],
            ['loc' => route('articles.index'), 'changefreq' => 'daily',   'priority' => '0.8'],
            ['loc' => route('about'),          'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('contact'),        'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        foreach (ProgramCategory::where('is_active', true)->get() as $cat) {
            $urls[] = [
                'loc'        => route('programs.index', ['category' => $cat->slug]),
                'lastmod'    => $cat->updated_at?->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.7',
            ];
        }

        foreach (Program::published()->get() as $p) {
            $urls[] = [
                'loc'        => route('programs.show', $p->slug),
                'lastmod'    => $p->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.8',
            ];
        }

        foreach (Article::published()->get() as $a) {
            $urls[] = [
                'loc'        => route('articles.show', $a->slug),
                'lastmod'    => ($a->updated_at ?? $a->published_at)?->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.7',
            ];
        }

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            if (! empty($u['lastmod'])) {
                $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /admin/*',
            'Disallow: /login',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
        ];
        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
