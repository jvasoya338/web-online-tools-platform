<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    @if (!empty($seo['author']))
        <meta name="author" content="{{ $seo['author'] }}">
    @endif
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:site_name" content="WebToolsStation">
    <meta property="og:image" content="{{ $seo['image'] ?? url('/images/logo/webtoolsstation-logo.png') }}">
    <meta property="og:image:alt" content="WebToolsStation preview image">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] ?? url('/images/logo/webtoolsstation-logo.png') }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R5ZD94KR5T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-R5ZD94KR5T');
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9988246089680161" crossorigin="anonymous"></script>
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    <style>
        :root {
            --bg: #f4f8fc;
            --bg-strong: #ffffff;
            --ink: #171717;
            --muted: #556270;
            --line: #cddfed;
            --brand: #006dbf;
            --brand-dark: #0a4f86;
            --accent: #fc9d2a;
            --card: rgba(255, 255, 255, 0.96);
            --shadow: 0 20px 50px rgba(0, 58, 104, 0.12);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: Georgia, "Times New Roman", serif;
            background:
                radial-gradient(circle at top left, rgba(0, 109, 191, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(252, 157, 42, 0.14), transparent 24%),
                linear-gradient(180deg, #f4f8fc 0%, #edf5fb 100%);
        }

        a { color: inherit; text-decoration: none; }

        .shell { width: min(1180px, calc(100% - 28px)); margin: 0 auto; }

        .site-nav {
            position: sticky;
            top: 0;
            z-index: 30;
            background: rgba(244, 248, 252, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 109, 191, 0.10);
        }

        .nav-row, .hero-grid, .section-head, .footer-row, .tool-hero, .tool-layout, .page-layout {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .nav-row {
            min-height: 76px;
            align-items: center;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: block;
            object-fit: cover;
            box-shadow: 0 14px 30px rgba(0, 109, 191, 0.22);
        }

        .brand-copy strong {
            display: block;
            font-size: 1.05rem;
        }

        .brand-copy span, .meta-copy, .lede, .section-head p, .card p, .detail-list li, .tool-panel p, .page-copy li, .page-copy p, .footer-row p {
            color: var(--muted);
            line-height: 1.7;
        }

        .nav-links, .footer-links {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        .nav-links a, .footer-links a { color: #415162; }
        .nav-links a:hover, .footer-links a:hover { color: var(--brand-dark); }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 18px;
            border-radius: 999px;
            border: 1px solid transparent;
            cursor: pointer;
            font: inherit;
            transition: transform 150ms ease, box-shadow 150ms ease;
        }

        .button:hover { transform: translateY(-1px); }
        .button-primary { background: linear-gradient(135deg, var(--brand), var(--accent)); color: #fff; }
        .button-secondary { background: rgba(0, 109, 191, 0.06); border-color: rgba(0, 109, 191, 0.14); color: var(--brand-dark); }
        .button-ghost { background: transparent; border-color: rgba(23, 23, 23, 0.12); }

        .hero, .tool-page, .page-section { padding: 40px 0 28px; }

        .hero-grid, .tool-layout, .page-layout { align-items: stretch; }

        .hero-card, .hero-side, .card, .tool-panel, .page-copy, .footer-box, .footer-feature {
            background: var(--card);
            border: 1px solid rgba(0, 109, 191, 0.10);
            box-shadow: var(--shadow);
            border-radius: 28px;
        }

        .hero-card, .hero-side, .page-copy { padding: 32px; }
        .tool-panel, .card { padding: 24px; }

        .hero-card { flex: 1.1; }
        .hero-side { flex: 0.9; }

        .eyebrow, .mini-kicker, .tool-badge, .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(0, 109, 191, 0.08);
            color: var(--brand-dark);
            font-size: 0.82rem;
            letter-spacing: 0.04em;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        h1, h2, h3 {
            margin: 0;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            line-height: 1.05;
        }

        .hero-card h1 { margin-top: 18px; font-size: clamp(2.6rem, 6vw, 5rem); }
        .section-head h2, .tool-hero h1, .page-copy h1 { font-size: clamp(2rem, 4vw, 3.4rem); }

        .hero-actions, .tool-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 22px; }
        .hero-stats, .tool-grid, .detail-grid, .page-grid { display: grid; gap: 18px; }
        .hero-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); margin-top: 26px; }
        .tool-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .detail-grid { grid-template-columns: 1.15fr 0.85fr; }
        .page-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

        .stat, .card, .tool-panel .mini-card, .page-section-card .mini-card {
            border: 1px solid var(--line);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.72);
            padding: 18px;
        }

        .stat strong, .tool-icon, .tool-side-icon {
            display: inline-grid;
            place-items: center;
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(0, 109, 191, 0.14), rgba(252, 157, 42, 0.22));
            color: var(--brand-dark);
            font-weight: 700;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        .stat strong {
            width: auto;
            height: auto;
            background: none;
            border-radius: 0;
            font-size: 1.6rem;
            padding: 0;
        }

        .section-head {
            align-items: end;
            margin-bottom: 22px;
        }

        .section-head p { max-width: 560px; margin: 0; }

        .tool-icon, .tool-side-icon { margin-bottom: 16px; }
        .card h3, .tool-panel h2, .tool-panel h3 { margin-bottom: 12px; font-size: 1.3rem; }

        .click-card {
            position: relative;
            transition: transform 150ms ease, box-shadow 150ms ease, border-color 150ms ease;
        }

        .click-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 54px rgba(0, 58, 104, 0.16);
            border-color: rgba(0, 109, 191, 0.22);
        }

        .click-card:focus-within {
            border-color: rgba(0, 109, 191, 0.34);
            box-shadow: 0 0 0 3px rgba(0, 109, 191, 0.12);
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            color: var(--brand-dark);
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        .card-link::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
        }

        .tool-layout > div:first-child, .page-layout > div:first-child { flex: 1.15; }
        .tool-layout > aside, .page-layout > aside { flex: 0.85; }

        .tool-field, .tool-output, .tool-inline {
            width: 100%;
            border-radius: 18px;
            border: 1px solid rgba(0, 109, 191, 0.16);
            background: rgba(255, 255, 255, 0.82);
            padding: 14px 16px;
            color: var(--ink);
            font: inherit;
        }

        textarea.tool-field { min-height: 180px; resize: vertical; }
        .tool-output {
            min-height: 120px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .tool-stack, .tool-inline, .mini-stack {
            display: grid;
            gap: 12px;
        }

        .tool-inline.two, .page-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

        .detail-list, .page-copy ul {
            margin: 18px 0 0;
            padding-left: 18px;
        }

        .tool-hero {
            align-items: center;
            margin-bottom: 22px;
        }

        .footer-box {
            padding: 0;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(0, 109, 191, 0.96), rgba(10, 79, 134, 0.98)),
                linear-gradient(135deg, rgba(252, 157, 42, 0.30), transparent);
            color: #fefefe;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
            margin-top: 28px;
            margin-bottom: 0;
        }

        .footer-box p,
        .footer-box a,
        .footer-box .section-kicker {
            color: rgba(255, 255, 255, 0.88);
        }

        .footer-row {
            align-items: stretch;
            gap: 0;
            width: 100%;
        }

        .footer-main {
            flex: 1.2;
            padding: 30px;
        }

        .footer-side {
            flex: 0.8;
            padding: 30px;
            background: rgba(255, 255, 255, 0.06);
            border-left: 1px solid rgba(255, 255, 255, 0.14);
        }

        .footer-feature-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 24px;
        }

        .footer-feature {
            padding: 16px;
            background: rgba(255, 255, 255, 0.10);
            border-color: rgba(255, 255, 255, 0.10);
            box-shadow: none;
        }

        .footer-feature strong {
            display: block;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            margin-bottom: 8px;
        }

        .footer-side h3 {
            margin-bottom: 14px;
        }

        .footer-links {
            display: grid;
            gap: 10px;
        }

        .footer-links a {
            display: inline-flex;
            width: fit-content;
        }

        .footer-meta {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            font-size: 0.94rem;
        }

        .page-header-block {
            margin-bottom: 24px;
        }

        .page-sections {
            display: grid;
            gap: 20px;
        }

        .page-section-card {
            padding: 22px;
            border: 1px solid var(--line);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.72);
        }

        .page-section-card h2,
        .page-section-card h3 {
            margin-bottom: 14px;
            font-size: 1.35rem;
        }

        .page-section-card p + p {
            margin-top: 14px;
        }

        .page-side-stack {
            display: grid;
            gap: 18px;
        }

        .match-list { display: grid; gap: 10px; margin-top: 12px; }
        .match-item {
            padding: 10px 12px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(0, 109, 191, 0.12);
        }

        .toast {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 80;
            min-width: 240px;
            max-width: min(360px, calc(100% - 32px));
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid rgba(0, 109, 191, 0.14);
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 22px 50px rgba(0, 58, 104, 0.16);
            color: var(--ink);
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            opacity: 0;
            transform: translateY(12px);
            pointer-events: none;
            transition: opacity 180ms ease, transform 180ms ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.error {
            border-color: rgba(185, 28, 28, 0.18);
            background: rgba(254, 242, 242, 0.98);
            color: #991b1b;
        }

        .color-preview {
            height: 120px;
            border-radius: 18px;
            border: 1px solid rgba(0, 109, 191, 0.12);
            background: #fff;
        }

        .cookie-banner {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            display: flex;
            justify-content: center;
            background: #171717;
            color: #fff;
            padding: 14px 18px;
            box-shadow: 0 -14px 40px rgba(0, 0, 0, 0.18);
        }

        .cookie-inner {
            width: min(1180px, 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            font-size: 0.94rem;
            line-height: 1.5;
        }

        .cookie-inner a { color: #90caf9; text-decoration: underline; }
        .cookie-inner button {
            border: 0;
            border-radius: 8px;
            background: #fff;
            color: #111;
            padding: 9px 16px;
            cursor: pointer;
            font: inherit;
            white-space: nowrap;
        }

        @media (max-width: 980px) {
            .hero-grid, .tool-layout, .page-layout, .section-head, .footer-row, .tool-hero { flex-direction: column; }
            .tool-grid, .hero-stats, .detail-grid, .page-grid, .footer-feature-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 680px) {
            .nav-links { display: none; }
            .tool-inline.two { grid-template-columns: 1fr; }
            .hero-card, .hero-side, .tool-panel, .page-copy, .card { padding: 18px; border-radius: 20px; }
            .footer-box { border-radius: 0; }
            .cookie-inner { align-items: stretch; flex-direction: column; }
            .shell { width: min(100% - 18px, 1180px); }
        }
    </style>
</head>
<body>
    <nav class="site-nav">
        <div class="shell nav-row">
            <a class="brand" href="{{ url('/') }}">
                <img class="brand-mark" src="/images/logo/webtoolsstation-logo.png" alt="WebToolsStation logo">
                <span class="brand-copy">
                    <strong>WebToolsStation</strong>
                    <span>TJVerce tools platform</span>
                </span>
            </a>
            <div class="nav-links">
                <a href="{{ url('/') }}">Tools</a>
                <a href="{{ url('/guides') }}">Guides</a>
                <a href="{{ url('/authors/tj-verse') }}">Author</a>
                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/contact') }}">Contact</a>
                <a href="{{ url('/privacy-policy') }}">Privacy</a>
                <a href="{{ url('/terms-of-use') }}">Terms</a>
            </div>
            <a class="button button-primary" href="{{ url('/') }}">Open Platform</a>
        </div>
    </nav>

    @yield('content')

    <footer class="footer-box">
        <div class="shell" style="padding:24px 0;">
            <nav class="footer-links" aria-label="Footer navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/guides') }}">Guides</a>
                <a href="{{ url('/authors/tj-verse') }}">Author</a>
                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/contact') }}">Contact</a>
                <a href="{{ url('/privacy-policy') }}">Privacy</a>
                <a href="{{ url('/terms-of-use') }}">Terms</a>
            </nav>
            <p style="margin:16px 0 0;">&copy; 2026 WebToolsStation by TJVerce. Contact: <a href="mailto:webtoolsstation@gmail.com">webtoolsstation@gmail.com</a></p>
        </div>
    </footer>

    <div id="cookie-banner" class="cookie-banner">
        <div class="cookie-inner">
            <span>We use cookies for basic site functions and analytics. <a href="{{ url('/privacy-policy') }}">Learn more</a></span>
            <button type="button" onclick="document.getElementById('cookie-banner').style.display='none'; localStorage.setItem('cookie_ok', '1');">Accept</button>
        </div>
    </div>
    <script>
        if (localStorage.getItem('cookie_ok')) {
            document.getElementById('cookie-banner').style.display = 'none';
        }
    </script>

    @yield('scripts')
</body>
</html>
