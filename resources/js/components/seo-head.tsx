import { Head } from '@inertiajs/react';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

function absoluteUrl(path: string): string {
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    const origin = typeof window !== 'undefined' ? window.location.origin : '';
    return `${origin}${path.startsWith('/') ? '' : '/'}${path}`;
}

interface SEOHeadProps {
    title: string;
    description?: string;
    image?: string;
    canonical?: string;
    noindex?: boolean;
    ogType?: string;
}

export default function SEOHead({
    title,
    description,
    image,
    canonical,
    noindex,
    ogType = 'website',
}: SEOHeadProps) {
    const fullTitle = `${title} - ${appName}`;
    const desc =
        description ||
        'Museum Cakraningrat Bangkalan — wisata sejarah dan budaya Madura. Koleksi bersejarah, edukasi, dan destinasi wisata di Bangkalan.';
    const img = absoluteUrl(image || '/image/logo/logomuseum.png');
    const url = canonical || (typeof window !== 'undefined' ? window.location.href : '');

    return (
        <Head title={title}>
            <meta name="description" content={desc} />

            <meta property="og:title" content={fullTitle} />
            <meta property="og:description" content={desc} />
            <meta property="og:image" content={img} />
            <meta property="og:url" content={url} />
            <meta property="og:type" content={ogType} />
            <meta property="og:site_name" content={appName} />
            <meta property="og:locale" content="id_ID" />

            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" content={fullTitle} />
            <meta name="twitter:description" content={desc} />
            <meta name="twitter:image" content={img} />

            <link rel="canonical" href={url} />

            {noindex && <meta name="robots" content="noindex, nofollow" />}
        </Head>
    );
}
