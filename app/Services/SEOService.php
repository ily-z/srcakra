<?php

namespace App\Services;

use Illuminate\Support\Str;

class SEOService
{
    public static function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Museum',
            'name' => config('app.name', 'Museum Cakraningrat'),
            'alternateName' => 'Museum Cakraningrat Bangkalan',
            'description' => 'Museum Cakraningrat menyimpan berbagai koleksi bersejarah yang menggambarkan perjalanan budaya dan sejarah Bangkalan, Madura.',
            'url' => url('/'),
            'telephone' => '+62323123456',
            'email' => 'info@museumcakraningrat.id',
            'image' => asset('image/logo/logomuseum.png'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('image/logo/logomuseum.png'),
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Jl. Soekarno Hatta No. 44',
                'addressLocality' => 'Bangkalan',
                'addressRegion' => 'Jawa Timur',
                'postalCode' => '69115',
                'addressCountry' => 'ID',
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '08:00',
                    'closes' => '16:00',
                ],
            ],
            'sameAs' => [
                'https://www.instagram.com/museumcakraningrat',
            ],
        ];
    }

    public static function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name', 'Museum Cakraningrat'),
            'url' => url('/'),
            'potentialAction' => [
                [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => url('/').'/?q={search_term_string}',
                    ],
                    'query-input' => 'required name=search_term_string',
                ],
            ],
        ];
    }

    public static function webpageSchema(string $title, string $description, ?string $canonical = null): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $title,
            'description' => $description,
            'url' => $canonical ?? url()->current(),
            'inLanguage' => 'id',
            'isPartOf' => [
                '@id' => url('/').'/#website',
            ],
        ];
    }

    public static function breadcrumbSchema(array $items): array
    {
        $itemListElement = [];
        $position = 1;

        foreach ($items as $item) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement,
        ];
    }

    public static function defaultTitle(): string
    {
        return config('app.name', 'Museum Cakraningrat');
    }

    public static function defaultDescription(): string
    {
        return 'Museum Cakraningrat Bangkalan — wisata sejarah dan budaya Madura. Koleksi bersejarah, edukasi, dan destinasi wisata di Bangkalan. Tiket masuk Rp3.000.';
    }

    public static function defaultImage(): string
    {
        return asset('image/logo/logomuseum.png');
    }

    public static function renderSchema(array $schema): string
    {
        return '<script type="application/ld+json">'.json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE).'</script>'."\n";
    }
}
