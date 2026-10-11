<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Profile;
use App\Models\Occupation;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for Search Engines (Google, Bing).
     */
    public function index(): Response
    {
        $content = Cache::remember('sitemap_xml', 43200, function () {
            $baseUrl = rtrim(config('app.url', url('/')), '/');

            $profiles = Profile::with('vendor')
                ->where('profile_status', 1)
                ->select('id', 'updated_at')
                ->get();

            $occupations = Occupation::where('status', 1)
                ->select('id', 'updated_at')
                ->get();

            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            // Static Primary Pages
            $staticPages = [
                ['url' => $baseUrl, 'changefreq' => 'daily', 'priority' => '1.0'],
                ['url' => $baseUrl . '/categories', 'changefreq' => 'weekly', 'priority' => '0.8'],
                ['url' => $baseUrl . '/about-us', 'changefreq' => 'monthly', 'priority' => '0.5'],
                ['url' => $baseUrl . '/contact-us', 'changefreq' => 'monthly', 'priority' => '0.5'],
            ];

            foreach ($staticPages as $page) {
                $xml .= '<url>';
                $xml .= '<loc>' . htmlspecialchars($page['url']) . '</loc>';
                $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
                $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
                $xml .= '<priority>' . $page['priority'] . '</priority>';
                $xml .= '</url>';
            }

            // Vendor Profiles
            foreach ($profiles as $profile) {
                $xml .= '<url>';
                $xml .= '<loc>' . htmlspecialchars(vendorProfileUrl($profile)) . '</loc>';
                $xml .= '<lastmod>' . ($profile->updated_at ? $profile->updated_at->format('Y-m-d') : date('Y-m-d')) . '</lastmod>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.9</priority>';
                $xml .= '</url>';
            }

            // Category Search Pages
            foreach ($occupations as $occ) {
                $xml .= '<url>';
                $xml .= '<loc>' . htmlspecialchars($baseUrl . '/search?occupation_id=' . $occ->id) . '</loc>';
                $xml .= '<lastmod>' . ($occ->updated_at ? $occ->updated_at->format('Y-m-d') : date('Y-m-d')) . '</lastmod>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.8</priority>';
                $xml .= '</url>';
            }

            $xml .= '</urlset>';
            return $xml;
        });

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Generate dynamic robots.txt file.
     */
    public function robots(): Response
    {
        $baseUrl = rtrim(config('app.url', url('/')), '/');

        $content = "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /vendor/dashboard\n";
        $content .= "Disallow: /clear-cache\n";
        $content .= "Disallow: /chat\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: " . $baseUrl . "/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
