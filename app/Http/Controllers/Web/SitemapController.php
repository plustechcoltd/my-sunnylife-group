<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    /**
     * Generate and serve the sitemap XML for web users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fe_url = env('APP_URL');

        $data = [
            [
                'loc' => $fe_url,
                'changefreq' => 'daily',
                'priority' => 1.0,
            ],
            [
                'loc' => route('web.chats.index'),
                'changefreq' => 'daily',
                'priority' => 1.0,
            ],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($data as $item) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($item['loc']) . '</loc>';
            $xml .= '<changefreq>' . htmlspecialchars($item['changefreq']) . '</changefreq>';
            $xml .= '<priority>' . htmlspecialchars($item['priority']) . '</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
