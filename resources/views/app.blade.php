<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Museum Cakraningrat') }}</title>
    <meta name="description" content="{{ \App\Services\SEOService::defaultDescription() }}">

    <meta property="og:title" content="{{ config('app.name', 'Museum Cakraningrat') }}" />
    <meta property="og:description" content="{{ \App\Services\SEOService::defaultDescription() }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ \App\Services\SEOService::defaultImage() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('app.name', 'Museum Cakraningrat') }}" />
    <meta property="og:locale" content="id_ID" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ config('app.name', 'Museum Cakraningrat') }}" />
    <meta name="twitter:description" content="{{ \App\Services\SEOService::defaultDescription() }}" />
    <meta name="twitter:image" content="{{ \App\Services\SEOService::defaultImage() }}" />

    <link rel="canonical" href="{{ url()->current() }}" />

    {!! \App\Services\SEOService::renderSchema(\App\Services\SEOService::organizationSchema()) !!}
    {!! \App\Services\SEOService::renderSchema(\App\Services\SEOService::websiteSchema()) !!}

    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
    @if (config('app.env') !== 'production')
        <script>
            window.$RefreshReg$ = () => {};
            window.$RefreshSig$ = () => (type) => type;
        </script>
    @endif
</head>
<body class="min-h-screen text-slate-800 antialiased">
    @inertia
</body>
</html>