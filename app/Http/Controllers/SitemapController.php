<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $pages = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('booking.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($pages as $page) {
            $xml .= "\t<url>\n";
            $xml .= "\t\t<loc>".e($page['loc'])."</loc>\n";
            $xml .= "\t\t<priority>".$page['priority']."</priority>\n";
            $xml .= "\t\t<changefreq>".$page['changefreq']."</changefreq>\n";
            $xml .= "\t</url>\n";
        }

        $xml .= '</urlset>';

        return Response::make($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin\n";
        $robots .= "Disallow: /booking/payment\n";
        $robots .= "Disallow: /booking/receipt\n";
        $robots .= "\n";
        $robots .= "Sitemap: ".url('sitemap.xml')."\n";

        return Response::make($robots, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
