<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] ?? 'WebToolsStation | Free Online Tools' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'Free online tools for developers, PDF checks, text cleanup, and everyday web work.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'free online tools, developer tools, pdf tools, web tools' }}">
    <meta name="language" content="English">
    <meta name="content-language" content="en">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta name="publisher" content="WebToolsStation">
    @if (!empty($seo['author']))
        <meta name="author" content="{{ $seo['author'] }}">
    @endif
    <meta name="robots" content="index, follow">
    <meta property="og:locale" content="en_US">
    <meta property="og:title" content="{{ $seo['title'] ?? 'WebToolsStation | Free Online Tools' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? 'Free online tools for developers, PDF checks, text cleanup, and everyday web work.' }}">
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta property="og:site_name" content="WebToolsStation">
    <meta property="og:image" content="{{ $seo['image'] ?? url('/images/logo/webtoolsstation-logo.png') }}">
    <meta property="og:image:alt" content="WebToolsStation preview image">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] ?? 'WebToolsStation | Free Online Tools' }}">
    <meta name="twitter:description" content="{{ $seo['description'] ?? 'Free online tools for developers, PDF checks, text cleanup, and everyday web work.' }}">
    <meta name="twitter:image" content="{{ $seo['image'] ?? url('/images/logo/webtoolsstation-logo.png') }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
    <link rel="alternate" hreflang="en-US" href="{{ $seo['canonical'] ?? url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seo['canonical'] ?? url()->current() }}">
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
    <meta name="theme-color" content="#0284c7">
    <script>
        (function() {
            try {
                const theme = localStorage.getItem('wts_theme');
                if (theme === 'dark' || (!theme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-theme', 'light');
                }
            } catch(e) {}
        })();
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R5ZD94KR5T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-R5ZD94KR5T');
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9988246089680161" crossorigin="anonymous"></script>
    @if (!empty($schema))
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface-subtle: #f1f5f9;
            --border: #e2e8f0;
            --border-hover: #cbd5e1;
            --border-focus: #0284c7;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-dim: #94a3b8;
            --brand: #0284c7;
            --brand-dark: #0369a1;
            --brand-light: #e0f2fe;
            --success: #16a34a;
            --success-bg: #dcfce7;
            --warning: #d97706;
            --warning-bg: #fef3c7;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --font-sans: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.06), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.03);
        }

        [data-theme="dark"] {
            --bg: #0b1120;
            --surface: #131d33;
            --surface-subtle: #1a2744;
            --border: #243456;
            --border-hover: #384c75;
            --border-focus: #38bdf8;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            --brand: #38bdf8;
            --brand-dark: #0ea5e9;
            --brand-light: #0c4a6e;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.4);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.6);
        }

        [data-theme="dark"] .site-nav {
            background: rgba(19, 29, 51, 0.95);
            border-bottom: 1px solid var(--border);
        }

        [data-theme="dark"] .tool-field,
        [data-theme="dark"] .tool-field-code,
        [data-theme="dark"] input[type="text"],
        [data-theme="dark"] textarea,
        [data-theme="dark"] select {
            background-color: #0b1120 !important;
            color: #f1f5f9 !important;
            border-color: var(--border) !important;
        }

        [data-theme="dark"] .card,
        [data-theme="dark"] .hero-card,
        [data-theme="dark"] .hero-side,
        [data-theme="dark"] .page-section-card,
        [data-theme="dark"] .tool-workspace-card,
        [data-theme="dark"] .modal-card,
        [data-theme="dark"] .dropdown-menu {
            background-color: var(--surface) !important;
            border-color: var(--border) !important;
        }

        [data-theme="dark"] .mini-card,
        [data-theme="dark"] .modal-result-item {
            background-color: var(--surface-subtle) !important;
            border-color: var(--border) !important;
        }

        [data-theme="dark"] .button-secondary {
            background-color: var(--surface-subtle) !important;
            color: var(--text) !important;
            border-color: var(--border) !important;
        }

        [data-theme="dark"] .site-footer {
            background-color: #080c16 !important;
            border-top-color: var(--border) !important;
        }

        .header-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .header-action-btn:hover {
            color: var(--text);
            border-color: var(--border-hover);
            background: var(--surface-subtle);
        }

        * { box-sizing: border-box; }
        html {
            scroll-behavior: smooth;
            font-size: 16px;
            overflow-x: hidden;
        }
        body {
            margin: 0;
            background-color: var(--bg);
            color: var(--text);
            font-family: var(--font-sans);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            max-width: 100vw;
        }

        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; height: auto; }

        .skip-link {
            position: absolute;
            top: -60px;
            left: 16px;
            z-index: 1000;
            background: var(--brand);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.88rem;
            transition: top 0.2s;
        }
        .skip-link:focus { top: 12px; }

        .shell {
            width: min(1200px, calc(100% - 32px));
            margin: 0 auto;
        }

        /* Top Navbar */
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
        }

        .nav-row {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: block;
            object-fit: cover;
            border: 1px solid rgba(2, 132, 199, 0.2);
        }

        .brand-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-badge {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 999px;
            background: var(--brand-light);
            color: var(--brand-dark);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            font-size: 0.92rem;
            font-weight: 500;
            color: var(--text-muted);
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            transition: color 0.15s ease, background-color 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--text);
            background: var(--surface-subtle);
        }

        .nav-link svg {
            width: 14px;
            height: 14px;
            transition: transform 0.2s;
        }

        /* Dropdown menus */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 6px;
            min-width: 240px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            padding: 6px;
            display: none;
            z-index: 60;
        }

        .nav-item:hover .dropdown-menu,
        .nav-item:focus-within .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            color: var(--text);
            transition: background-color 0.15s;
        }

        .dropdown-item:hover {
            background-color: var(--surface-subtle);
            color: var(--brand-dark);
        }

        .dropdown-item .item-icon {
            font-size: 0.78rem;
            font-weight: 700;
            font-family: var(--font-mono);
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: var(--surface-subtle);
            color: var(--text-muted);
        }

        /* Header Quick Search Button */
        .header-search-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            height: 38px;
            padding: 0 12px;
            background: var(--surface-subtle);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            font-size: 0.85rem;
            cursor: pointer;
            transition: border-color 0.15s, background-color 0.15s;
        }

        .header-search-btn:hover {
            border-color: var(--border-hover);
            background: #ffffff;
            color: var(--text);
        }

        .header-search-btn svg { width: 16px; height: 16px; }

        .search-kbd {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            padding: 2px 6px;
            border-radius: 4px;
            background: #ffffff;
            border: 1px solid var(--border);
            color: var(--text-muted);
            line-height: 1;
        }

        .mobile-toggle {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #ffffff;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            color: var(--text);
        }

        .mobile-toggle svg { width: 20px; height: 20px; }

        /* Mobile Drawer */
        .mobile-nav-drawer {
            display: none;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
            box-shadow: var(--shadow-md);
        }

        .mobile-nav-drawer.open { display: block; }

        .mobile-search-input {
            width: 100%;
            height: 42px;
            padding: 0 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.95rem;
            margin-bottom: 16px;
            background: var(--surface-subtle);
        }

        .mobile-category-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }

        .mobile-category-chip {
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            background: var(--surface-subtle);
            font-size: 0.86rem;
            font-weight: 500;
            color: var(--text);
        }

        /* Buttons & Actions */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 38px;
            padding: 0 15px;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .btn-sm {
            height: 32px;
            padding: 0 11px;
            font-size: 0.82rem;
        }

        .btn-lg {
            height: 44px;
            padding: 0 20px;
            font-size: 0.96rem;
        }

        .btn-primary {
            background: var(--brand);
            color: #ffffff;
        }
        .btn-primary:hover {
            background: var(--brand-dark);
        }

        .btn-secondary {
            background: #ffffff;
            border-color: var(--border);
            color: var(--text);
        }
        .btn-secondary:hover {
            border-color: var(--border-hover);
            background: var(--surface-subtle);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-muted);
        }
        .btn-ghost:hover {
            background: var(--surface-subtle);
            color: var(--text);
        }

        .btn-danger {
            background: #ffffff;
            border-color: var(--danger);
            color: var(--danger);
        }
        .btn-danger:hover {
            background: var(--danger-bg);
        }

        /* Form Inputs */
        input[type="text"], input[type="number"], select, textarea {
            font-family: inherit;
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: #ffffff;
            padding: 8px 12px;
            font-size: 0.92rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        /* Modal Overlay for Global Search */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            display: none;
            align-items: flex-start;
            justify-content: center;
            padding: 70px 16px 20px;
        }

        .modal-overlay.open { display: flex; }

        .modal-card {
            width: 100%;
            max-width: 640px;
            background: #ffffff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 80vh;
        }

        .modal-search-header {
            display: flex;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            gap: 12px;
        }

        .modal-search-header svg { width: 20px; height: 20px; color: var(--text-muted); flex-shrink: 0; }

        .modal-search-input {
            flex: 1;
            border: none;
            font-size: 1.05rem;
            color: var(--text);
            outline: none;
            background: transparent;
        }

        .modal-search-input:focus { box-shadow: none; border: none; }

        .modal-results-list {
            padding: 8px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-result-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text);
            transition: background-color 0.12s;
        }

        .modal-result-item:hover, .modal-result-item.selected {
            background-color: var(--surface-subtle);
        }

        .modal-result-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--brand-light);
            color: var(--brand-dark);
            font-family: var(--font-mono);
            font-size: 0.78rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .modal-result-info { flex: 1; min-width: 0; }
        .modal-result-title { font-weight: 600; font-size: 0.92rem; display: flex; align-items: center; gap: 8px; }
        .modal-result-badge { font-size: 0.72rem; padding: 1px 6px; border-radius: 4px; background: var(--surface-subtle); color: var(--text-muted); font-weight: 500; }
        .modal-result-desc { font-size: 0.8rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }

        .modal-footer {
            padding: 8px 16px;
            background: var(--surface-subtle);
            border-top: 1px solid var(--border);
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
        }

        /* Tool Workspace Styles */
        .tool-header-block {
            padding: 24px 0 16px;
        }

        .breadcrumbs {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .breadcrumbs a:hover { color: var(--brand); }

        .tool-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .tool-title-group {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .tool-page-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            background: var(--brand-light);
            color: var(--brand-dark);
            font-family: var(--font-mono);
            font-size: 1.15rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(2, 132, 199, 0.2);
        }

        .tool-page-title {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.02em;
        }

        .tool-page-desc {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 0.98rem;
            max-width: 780px;
        }

        .privacy-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--success-bg);
            color: var(--success);
            font-size: 0.78rem;
            font-weight: 600;
            border: 1px solid rgba(22, 163, 74, 0.2);
            white-space: nowrap;
        }

        .privacy-badge svg { width: 14px; height: 14px; }

        /* Main Tool Workspace Container */
        .tool-workspace-hero {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 20px;
            margin: 16px 0 36px;
        }

        .workspace-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .pane-card {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: #ffffff;
            overflow: hidden;
        }

        .pane-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: var(--surface-subtle);
            border-bottom: 1px solid var(--border);
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .pane-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .editor-textarea {
            width: 100%;
            height: 360px;
            font-family: var(--font-mono);
            font-size: 0.88rem;
            line-height: 1.55;
            padding: 14px;
            border: none;
            outline: none;
            resize: vertical;
            background: #ffffff;
            color: var(--text);
            box-sizing: border-box;
        }

        .editor-textarea:focus { box-shadow: none; }

        .output-pre {
            width: 100%;
            height: 360px;
            font-family: var(--font-mono);
            font-size: 0.88rem;
            line-height: 1.55;
            padding: 14px;
            margin: 0;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-all;
            background: #ffffff;
            color: var(--text);
            box-sizing: border-box;
        }

        .workspace-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-top: 16px;
        }

        .workspace-btn-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Toast Feedback */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 200;
            background: var(--text);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-size: 0.88rem;
            font-weight: 500;
            display: none;
            box-shadow: var(--shadow-lg);
            animation: fadeIn 0.15s ease;
        }

        .toast.show { display: block; }
        .toast.error { background: var(--danger); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Content Sections Below Tool */
        .content-section {
            margin: 32px 0;
        }

        .content-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 20px;
        }

        .content-card h2, .content-card h3 {
            margin: 0 0 14px;
            color: var(--text);
            font-size: 1.25rem;
            font-weight: 700;
        }

        .content-card p {
            color: var(--text-muted);
            line-height: 1.65;
            margin: 0 0 12px;
        }

        .content-card p:last-child { margin-bottom: 0; }

        .step-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            margin-top: 16px;
        }

        .step-card {
            padding: 16px;
            border-radius: var(--radius-md);
            background: var(--surface-subtle);
            border: 1px solid var(--border);
        }

        .step-num {
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: var(--brand);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        /* Tool Cards Grid */
        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .tool-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px;
            display: flex;
            flex-direction: column;
            transition: transform 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .tool-card:hover {
            transform: translateY(-2px);
            border-color: var(--brand);
            box-shadow: var(--shadow-md);
        }

        .tool-card-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .tool-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--brand-light);
            color: var(--brand-dark);
            font-family: var(--font-mono);
            font-size: 0.82rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .tool-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .tool-card-desc {
            font-size: 0.86rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin: 0 0 14px;
            flex: 1;
        }

        .tool-card-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--brand);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Footer */
        .site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border);
            padding: 48px 0 24px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1fr;
            gap: 32px;
            margin-bottom: 36px;
        }

        .footer-about h3 {
            margin: 0 0 10px;
            font-size: 1.05rem;
            color: var(--text);
        }

        .footer-about p {
            color: var(--text-muted);
            font-size: 0.88rem;
            line-height: 1.6;
            margin: 0;
        }

        .footer-col h4 {
            margin: 0 0 12px;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text);
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .footer-col a {
            font-size: 0.88rem;
            color: var(--text-muted);
            transition: color 0.15s;
        }
        .footer-col a:hover { color: var(--brand); }

        .footer-bottom {
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            color: var(--text-dim);
            flex-wrap: wrap;
            gap: 12px;
        }

        /* Grid & Card Compatibility */
        .tool-grid, .page-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: transform 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .card.click-card:hover {
            transform: translateY(-2px);
            border-color: var(--brand);
            box-shadow: var(--shadow-md);
        }

        .tool-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--brand-light);
            color: var(--brand-dark);
            font-family: var(--font-mono);
            font-size: 0.82rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(2, 132, 199, 0.2);
        }

        .tool-badge {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            background: var(--surface-subtle);
            color: var(--text-muted);
            border: 1px solid var(--border);
            margin-top: 8px;
            align-self: flex-start;
        }

        .card h3 {
            font-size: 1.05rem;
            font-weight: 700;
            margin: 12px 0 6px;
            color: var(--text);
        }

        .card p {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin: 0 0 14px;
            flex: 1;
        }

        .card-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--brand);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: auto;
        }

        /* Button Compatibility */
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 38px;
            padding: 0 16px;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .button-primary {
            background: var(--brand);
            color: #ffffff !important;
        }
        .button-primary:hover {
            background: var(--brand-dark);
        }

        .button-secondary {
            background: #ffffff;
            border-color: var(--border);
            color: var(--text) !important;
        }
        .button-secondary:hover {
            border-color: var(--border-hover);
            background: var(--surface-subtle);
        }

        .button-ghost {
            background: transparent;
            border-color: var(--border);
            color: var(--text-muted) !important;
        }
        .button-ghost:hover {
            background: var(--surface-subtle);
            color: var(--text) !important;
        }

        /* Hero & Section Typography */
        .hero {
            padding: 36px 0 24px;
            background: linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
            border-bottom: 1px solid var(--border);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 28px;
            align-items: start;
        }

        .hero-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: var(--shadow-sm);
        }

        .hero-card h1 {
            font-size: 1.95rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--text);
            margin: 10px 0;
            line-height: 1.25;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .stat strong {
            display: block;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--brand);
        }

        .stat p {
            margin: 4px 0 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .hero-side {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px;
            box-shadow: var(--shadow-sm);
        }

        .eyebrow {
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--brand);
            display: inline-block;
        }

        .mini-kicker, .section-kicker {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--brand);
            display: block;
            margin-bottom: 6px;
        }

        .lede {
            font-size: 1rem;
            line-height: 1.65;
            color: var(--text-muted);
            margin: 8px 0 0;
        }

        .page-section {
            padding: 40px 0;
        }

        .section-head {
            margin-bottom: 24px;
        }

        .section-head h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
            margin: 4px 0 8px;
            letter-spacing: -0.02em;
        }

        .section-head p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin: 0;
            max-width: 720px;
        }

        .mini-stack {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mini-card {
            background: var(--surface-subtle);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
        }

        .mini-card strong {
            font-size: 0.88rem;
            color: var(--text);
            display: block;
        }

        .mini-card p {
            font-size: 0.84rem;
            color: var(--text-muted);
            margin: 4px 0 0;
            line-height: 1.5;
        }

        .detail-list {
            padding-left: 20px;
            margin: 10px 0 0;
            color: var(--text-muted);
        }

        .detail-list li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .page-layout {
            display: grid;
            grid-template-columns: 1.8fr 1fr;
            gap: 28px;
        }

        .page-copy h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text);
            margin: 0 0 12px;
        }

        .page-section-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            margin-bottom: 16px;
        }

        .page-section-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 8px;
            color: var(--text);
        }

        .page-section-card p {
            font-size: 0.92rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0 0 10px;
        }

        .page-side-stack {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-grid { grid-template-columns: 1fr; }
            .page-layout { grid-template-columns: 1fr; }
            .workspace-split { grid-template-columns: 1fr; }
        }

        @media (max-width: 720px) {
            .nav-center, .header-search-btn { display: none !important; }
            .mobile-toggle { display: inline-flex !important; }
            .footer-grid { grid-template-columns: 1fr; }
            .tool-page-title { font-size: 1.45rem; }
            .tool-title-row { flex-direction: column; align-items: flex-start; }
            .editor-textarea, .output-pre { height: 260px; }
            .hero-card { padding: 22px 16px; }
            .hero-side { padding: 20px 16px; }
            .hero-card h1 { font-size: 1.55rem; }
            .hero-stats { grid-template-columns: repeat(3, 1fr); gap: 8px; }
            .stat strong { font-size: 1.25rem; }
            .stat p { font-size: 0.72rem; }
            .content-card { padding: 18px 14px; }
            .tool-workspace-hero { padding: 14px 12px; }
        }

        @media (max-width: 480px) {
            .brand-name { font-size: 0.92rem; }
            .brand-badge { display: none; }
            .hero-stats { grid-template-columns: 1fr; }
            .hero-actions .button { width: 100%; }
            .breadcrumbs { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <nav class="site-nav" aria-label="Main navigation">
        <div class="shell nav-row">
            <a class="brand" href="{{ url('/') }}" aria-label="WebToolsStation homepage">
                <img class="brand-mark" src="/images/logo/webtoolsstation-logo.png" alt="WebToolsStation logo" width="36" height="36">
                <span class="brand-name">
                    WebToolsStation
                    <span class="brand-badge">Free</span>
                </span>
            </a>

            <div class="nav-center">
                <div class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}#tool-grid">
                        Tools
                        <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </a>
                    <div class="dropdown-menu">
                        @if (!empty($navTools))
                            @foreach (array_slice($navTools, 0, 8) as $nt)
                                <a class="dropdown-item" href="{{ url('/tools/' . $nt['slug']) }}">
                                    <span class="item-icon">{{ $nt['icon'] }}</span>
                                    <span>{{ $nt['title'] }}</span>
                                </a>
                            @endforeach
                        @endif
                        <div style="border-top:1px solid var(--border); margin:4px 0; padding-top:4px;">
                            <a class="dropdown-item" href="{{ url('/') }}#tool-grid" style="color:var(--brand); font-weight:600;">
                                View all {{ !empty($navTools) ? count($navTools) : 54 }} tools →
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nav-item">
                    <a class="nav-link" href="{{ url('/categories/developer-tools') }}">
                        Categories
                        <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/categories/developer-tools') }}">
                            <span class="item-icon">DV</span>
                            <span>Developer Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/categories/text-tools') }}">
                            <span class="item-icon">TX</span>
                            <span>Text & Content</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/categories/image-tools') }}">
                            <span class="item-icon">IM</span>
                            <span>Image Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/categories/security-tools') }}">
                            <span class="item-icon">SC</span>
                            <span>Security Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/categories/pdf-tools') }}">
                            <span class="item-icon">PD</span>
                            <span>PDF Utilities</span>
                        </a>
                    </div>
                </div>

                <div class="nav-item">
                    <a class="nav-link" href="{{ url('/collections/best-developer-tools') }}">
                        Collections
                        <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/collections/best-developer-tools') }}">
                            <span class="item-icon">DV</span>
                            <span>Best Developer Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/collections/best-json-tools') }}">
                            <span class="item-icon">JS</span>
                            <span>Best JSON Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/collections/best-text-tools') }}">
                            <span class="item-icon">TX</span>
                            <span>Best Text Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/collections/best-image-tools') }}">
                            <span class="item-icon">IM</span>
                            <span>Best Image Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/collections/best-pdf-tools') }}">
                            <span class="item-icon">PD</span>
                            <span>Best PDF Tools</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/collections/best-seo-tools') }}">
                            <span class="item-icon">SE</span>
                            <span>Best SEO Tools</span>
                        </a>
                    </div>
                </div>

                <a class="nav-link" href="{{ url('/guides') }}">Guides</a>
                <a class="nav-link" href="{{ url('/about') }}">About</a>
                <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
            </div>

            <div style="display:flex; align-items:center; gap:8px;">
                <button id="theme-toggle-btn" class="header-action-btn" type="button" aria-label="Toggle dark mode" title="Switch theme">
                    <svg id="theme-moon-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    <svg id="theme-sun-icon" style="display:none;" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </button>

                <button id="favorites-trigger" class="header-action-btn" type="button" aria-label="Favorites and Recents" title="Favorite & Recent Tools">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </button>

                <button id="global-search-trigger" class="header-search-btn" type="button" aria-label="Search tools">
                    <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                    <span>Search {{ !empty($navTools) ? count($navTools) : 54 }} tools...</span>
                    <kbd class="search-kbd">⌘K</kbd>
                </button>

                <button id="mobile-menu-btn" class="mobile-toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-nav" class="mobile-nav-drawer" role="region" aria-label="Mobile navigation">
            <div class="shell">
                <input type="text" id="mobile-search-input" class="mobile-search-input" placeholder="Search {{ !empty($navTools) ? count($navTools) : 54 }} tools (e.g. JSON, PDF, UUID)...">
                <div class="mobile-category-links">
                    <a class="mobile-category-chip" href="{{ url('/categories/developer-tools') }}">Developer Tools</a>
                    <a class="mobile-category-chip" href="{{ url('/categories/text-tools') }}">Text Tools</a>
                    <a class="mobile-category-chip" href="{{ url('/categories/image-tools') }}">Image Tools</a>
                    <a class="mobile-category-chip" href="{{ url('/categories/security-tools') }}">Security Tools</a>
                    <a class="mobile-category-chip" href="{{ url('/categories/pdf-tools') }}">PDF Utilities</a>
                    <a class="mobile-category-chip" href="{{ url('/guides') }}">Help Guides</a>
                </div>
                <div style="display:flex; gap:12px; font-size:0.86rem; color:var(--text-muted); border-top:1px solid var(--border); padding-top:12px;">
                    <a href="{{ url('/about') }}">About</a>
                    <a href="{{ url('/contact') }}">Contact</a>
                    <a href="{{ url('/privacy-policy') }}">Privacy</a>
                    <a href="{{ url('/disclaimer') }}">Disclaimer</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Search Modal (⌘K) -->
    <div id="search-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-label="Quick tool search">
        <div class="modal-card">
            <div class="modal-search-header">
                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                <input type="text" id="modal-search-input" class="modal-search-input" placeholder="Search tools by name, action or category (e.g., JSON, Base64, PDF, UUID)..." autocomplete="off">
                <kbd class="search-kbd" style="cursor:pointer;" id="modal-close-btn">ESC</kbd>
            </div>
            <div class="modal-results-list" id="modal-results-container">
                <!-- Dynamically populated -->
            </div>
            <div class="modal-footer">
                <span>Navigate with <kbd class="search-kbd">↑</kbd> <kbd class="search-kbd">↓</kbd></span>
                <span>Select with <kbd class="search-kbd">↵</kbd></span>
                <span>Close with <kbd class="search-kbd">ESC</kbd></span>
            </div>
        </div>
    </div>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="site-footer" aria-label="Site footer">
        <div class="shell">
            <div class="footer-grid">
                <div class="footer-about">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                        <img src="/images/logo/webtoolsstation-logo.png" alt="WebToolsStation" width="28" height="28" style="border-radius:6px;">
                        <strong style="font-size:1.05rem; color:var(--text);">WebToolsStation</strong>
                    </div>
                    <p>
                        A fast, privacy-focused online utility platform built by TJ Verse.
                        All transformations run client-side in your browser runtime—your sensitive data, tokens, and documents are never uploaded to remote servers.
                    </p>
                </div>
                <div class="footer-col">
                    <h4>Tool Categories</h4>
                    <ul>
                        <li><a href="{{ url('/categories/developer-tools') }}">Developer Tools</a></li>
                        <li><a href="{{ url('/categories/text-tools') }}">Text & Content</a></li>
                        <li><a href="{{ url('/categories/image-tools') }}">Image Tools</a></li>
                        <li><a href="{{ url('/categories/security-tools') }}">Security & Network</a></li>
                        <li><a href="{{ url('/categories/pdf-tools') }}">PDF Utilities</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="{{ url('/') }}#tool-grid">All {{ !empty($navTools) ? count($navTools) : 54 }} Tools</a></li>
                        <li><a href="{{ url('/collections/best-developer-tools') }}">Tool Collections</a></li>
                        <li><a href="{{ url('/guides') }}">Technical Guides</a></li>
                        <li><a href="{{ url('/authors/tj-verse') }}">Author & Editorial</a></li>
                        <li><a href="{{ url('/sitemap.xml') }}">XML Sitemap</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Trust & Legal</h4>
                    <ul>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/contact') }}">Contact Support</a></li>
                        <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('/cookie-policy') }}">Cookie Policy</a></li>
                        <li><a href="{{ url('/terms-of-use') }}">Terms of Use</a></li>
                        <li><a href="{{ url('/disclaimer') }}">Legal Disclaimer</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} WebToolsStation by TJ Verse. All rights reserved.</span>
                <span>Client-Side Local Processing Guaranteed</span>
            </div>
        </div>
    </footer>

    <!-- Global Datasets for Instant Multi-Entity Search -->
    <script id="global-tools-data" type="application/json">
        {!! json_encode($navTools ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script id="global-categories-data" type="application/json">
        {!! json_encode($navCategories ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script id="global-collections-data" type="application/json">
        {!! json_encode($navCollections ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script id="global-guides-data" type="application/json">
        {!! json_encode($navGuides ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Dark Mode System
        const themeBtn = document.getElementById('theme-toggle-btn');
        const sunIcon = document.getElementById('theme-sun-icon');
        const moonIcon = document.getElementById('theme-moon-icon');

        function updateThemeIcons(isDark) {
            if (sunIcon && moonIcon) {
                sunIcon.style.display = isDark ? 'block' : 'none';
                moonIcon.style.display = isDark ? 'none' : 'block';
            }
        }

        const initialTheme = document.documentElement.getAttribute('data-theme') || 'light';
        updateThemeIcons(initialTheme === 'dark');

        if (themeBtn) {
            themeBtn.addEventListener('click', function() {
                const current = document.documentElement.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                localStorage.setItem('wts_theme', next);
                updateThemeIcons(next === 'dark');
            });
        }

        // 2. Favorites & Recent History Tracking
        window.getFavorites = function() {
            try { return JSON.parse(localStorage.getItem('wts_favorites') || '[]'); } catch(e) { return []; }
        };

        window.toggleFavorite = function(slug) {
            let favs = window.getFavorites();
            const idx = favs.indexOf(slug);
            if (idx === -1) {
                favs.push(slug);
            } else {
                favs.splice(idx, 1);
            }
            localStorage.setItem('wts_favorites', JSON.stringify(favs));
            updateFavoriteButtons();
            return idx === -1;
        };

        function updateFavoriteButtons() {
            const favs = window.getFavorites();
            document.querySelectorAll('[data-fav-slug]').forEach(function(btn) {
                const s = btn.getAttribute('data-fav-slug');
                const isFav = favs.includes(s);
                btn.classList.toggle('active', isFav);
                btn.style.color = isFav ? '#eab308' : 'var(--text-dim)';
            });
        }
        updateFavoriteButtons();

        // Track Current Tool Visit in Recents
        const pathParts = window.location.pathname.split('/').filter(Boolean);
        if (pathParts[0] === 'tools' && pathParts[1]) {
            const activeToolSlug = pathParts[1];
            try {
                let recents = JSON.parse(localStorage.getItem('wts_recents') || '[]');
                recents = recents.filter(function(s) { return s !== activeToolSlug; });
                recents.unshift(activeToolSlug);
                if (recents.length > 8) recents = recents.slice(0, 8);
                localStorage.setItem('wts_recents', JSON.stringify(recents));
            } catch(e) {}
        }

        // 3. Mobile Navigation Toggle
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileNav = document.getElementById('mobile-nav');
        if (mobileBtn && mobileNav) {
            mobileBtn.addEventListener('click', function() {
                const isOpen = mobileNav.classList.toggle('open');
                mobileBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        // 4. Enhanced Multi-Entity Global Search Modal Logic (⌘K)
        const modal = document.getElementById('search-modal');
        const searchTrigger = document.getElementById('global-search-trigger');
        const favTrigger = document.getElementById('favorites-trigger');
        const modalInput = document.getElementById('modal-search-input');
        const resultsContainer = document.getElementById('modal-results-container');
        const closeBtn = document.getElementById('modal-close-btn');

        let tools = [], categories = [], collections = [], guides = [];
        try {
            tools = JSON.parse(document.getElementById('global-tools-data')?.textContent || '[]');
            categories = Object.values(JSON.parse(document.getElementById('global-categories-data')?.textContent || '{}'));
            collections = Object.values(JSON.parse(document.getElementById('global-collections-data')?.textContent || '{}'));
            guides = JSON.parse(document.getElementById('global-guides-data')?.textContent || '[]');
        } catch(e) {}

        function openModal(defaultQuery) {
            if (!modal) return;
            modal.classList.add('open');
            if (modalInput) {
                modalInput.value = defaultQuery || '';
                modalInput.focus();
                renderResults(defaultQuery || '');
            }
        }

        function closeModal() {
            if (!modal) return;
            modal.classList.remove('open');
        }

        function renderResults(query) {
            if (!resultsContainer) return;
            const q = (query || '').trim().toLowerCase();

            // Default State: Pinned Favorites, Recently Used, and Curated Collections
            if (!q) {
                const favs = window.getFavorites();
                let recents = [];
                try { recents = JSON.parse(localStorage.getItem('wts_recents') || '[]'); } catch(e) {}

                let html = '';

                if (favs.length > 0) {
                    html += '<div style="padding:8px 14px; font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">★ Pinned Favorites</div>';
                    favs.forEach(function(s) {
                        const t = tools.find(function(x) { return x.slug === s; });
                        if (t) {
                            html += '<a class="modal-result-item" href="/tools/' + t.slug + '">' +
                                '<span class="modal-result-icon">' + (t.icon || '★') + '</span>' +
                                '<div class="modal-result-info">' +
                                    '<div class="modal-result-title">' + t.title + ' <span class="modal-result-badge" style="background:#fef08a; color:#854d0e;">Favorite</span></div>' +
                                    '<div class="modal-result-desc">' + (t.summary || '') + '</div>' +
                                '</div>' +
                                '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                            '</a>';
                        }
                    });
                }

                if (recents.length > 0) {
                    html += '<div style="padding:8px 14px; font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-top:6px;">🕒 Recently Visited</div>';
                    recents.slice(0, 4).forEach(function(s) {
                        const t = tools.find(function(x) { return x.slug === s; });
                        if (t) {
                            html += '<a class="modal-result-item" href="/tools/' + t.slug + '">' +
                                '<span class="modal-result-icon">' + (t.icon || 'TL') + '</span>' +
                                '<div class="modal-result-info">' +
                                    '<div class="modal-result-title">' + t.title + ' <span class="modal-result-badge">Recent</span></div>' +
                                    '<div class="modal-result-desc">' + (t.summary || '') + '</div>' +
                                '</div>' +
                                '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                            '</a>';
                        }
                    });
                }

                if (collections.length > 0) {
                    html += '<div style="padding:8px 14px; font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-top:6px;">📁 Curated Collections</div>';
                    collections.slice(0, 3).forEach(function(c) {
                        html += '<a class="modal-result-item" href="/collections/' + c.slug + '">' +
                            '<span class="modal-result-icon">' + (c.icon || 'CL') + '</span>' +
                            '<div class="modal-result-info">' +
                                '<div class="modal-result-title">' + (c.short_title || c.title) + ' <span class="modal-result-badge" style="background:#e0e7ff; color:#3730a3;">Collection</span></div>' +
                                '<div class="modal-result-desc">' + (c.tagline || '') + '</div>' +
                            '</div>' +
                            '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                        '</a>';
                    });
                }

                resultsContainer.innerHTML = html || '<div style="padding:24px; text-align:center; color:var(--text-muted); font-size:0.9rem;">Type to search all tools, guides, and categories...</div>';
                return;
            }

            // Query Matching Across Entities
            const matchedTools = tools.filter(function(t) {
                return (t.title && t.title.toLowerCase().includes(q)) ||
                       (t.category && t.category.toLowerCase().includes(q)) ||
                       (t.summary && t.summary.toLowerCase().includes(q)) ||
                       (t.keywords && Array.isArray(t.keywords) && t.keywords.some(function(k) { return k.toLowerCase().includes(q); }));
            }).slice(0, 7);

            const matchedCollections = collections.filter(function(c) {
                return (c.title && c.title.toLowerCase().includes(q)) ||
                       (c.short_title && c.short_title.toLowerCase().includes(q)) ||
                       (c.tagline && c.tagline.toLowerCase().includes(q));
            }).slice(0, 3);

            const matchedGuides = guides.filter(function(g) {
                return (g.title && g.title.toLowerCase().includes(q)) ||
                       (g.intro && g.intro.toLowerCase().includes(q));
            }).slice(0, 3);

            const matchedCategories = categories.filter(function(c) {
                return (c.name && c.name.toLowerCase().includes(q)) ||
                       (c.tagline && c.tagline.toLowerCase().includes(q));
            }).slice(0, 2);

            const totalMatches = matchedTools.length + matchedCollections.length + matchedGuides.length + matchedCategories.length;

            if (totalMatches === 0) {
                resultsContainer.innerHTML = '<div style="padding:28px; text-align:center; color:var(--text-muted); font-size:0.92rem;">No tools, guides, or collections matching "<strong>' + escapeHtml(query) + '</strong>"</div>';
                return;
            }

            let html = '';

            matchedTools.forEach(function(t, idx) {
                html += '<a class="modal-result-item' + (idx === 0 ? ' selected' : '') + '" href="/tools/' + t.slug + '">' +
                    '<span class="modal-result-icon">' + (t.icon || 'TL') + '</span>' +
                    '<div class="modal-result-info">' +
                        '<div class="modal-result-title">' + t.title + ' <span class="modal-result-badge">' + t.category + '</span></div>' +
                        '<div class="modal-result-desc">' + (t.summary || '') + '</div>' +
                    '</div>' +
                    '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                '</a>';
            });

            matchedCollections.forEach(function(c) {
                html += '<a class="modal-result-item" href="/collections/' + c.slug + '">' +
                    '<span class="modal-result-icon">' + (c.icon || 'CL') + '</span>' +
                    '<div class="modal-result-info">' +
                        '<div class="modal-result-title">' + (c.short_title || c.title) + ' <span class="modal-result-badge" style="background:#e0e7ff; color:#3730a3;">Collection</span></div>' +
                        '<div class="modal-result-desc">' + (c.tagline || '') + '</div>' +
                    '</div>' +
                    '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                '</a>';
            });

            matchedGuides.forEach(function(g) {
                html += '<a class="modal-result-item" href="/guides/' + g.slug + '">' +
                    '<span class="modal-result-icon">GD</span>' +
                    '<div class="modal-result-info">' +
                        '<div class="modal-result-title">' + g.title + ' <span class="modal-result-badge" style="background:#dcfce7; color:#15803d;">Guide</span></div>' +
                        '<div class="modal-result-desc">' + (g.intro ? g.intro.substring(0, 100) + '...' : '') + '</div>' +
                    '</div>' +
                    '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                '</a>';
            });

            matchedCategories.forEach(function(cat) {
                html += '<a class="modal-result-item" href="/categories/' + cat.slug + '">' +
                    '<span class="modal-result-icon">' + (cat.icon || 'CT') + '</span>' +
                    '<div class="modal-result-info">' +
                        '<div class="modal-result-title">' + cat.name + ' <span class="modal-result-badge" style="background:#fef3c7; color:#b45309;">Category</span></div>' +
                        '<div class="modal-result-desc">' + (cat.tagline || '') + '</div>' +
                    '</div>' +
                    '<span style="color:var(--text-dim); font-size:0.85rem;">↵</span>' +
                '</a>';
            });

            resultsContainer.innerHTML = html;
        }

        function escapeHtml(str) {
            return String(str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        if (searchTrigger) searchTrigger.addEventListener('click', function() { openModal(); });
        if (favTrigger) favTrigger.addEventListener('click', function() { openModal(); });
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });
        }

        if (modalInput) {
            modalInput.addEventListener('input', function() {
                renderResults(modalInput.value);
            });

            modalInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const items = resultsContainer.querySelectorAll('.modal-result-item');
                    if (!items.length) return;
                    let currentIdx = -1;
                    items.forEach(function(item, idx) {
                        if (item.classList.contains('selected')) currentIdx = idx;
                    });
                    if (e.key === 'ArrowDown') {
                        currentIdx = (currentIdx + 1) % items.length;
                    } else {
                        currentIdx = (currentIdx - 1 + items.length) % items.length;
                    }
                    items.forEach(function(item, idx) {
                        item.classList.toggle('selected', idx === currentIdx);
                    });
                    items[currentIdx].scrollIntoView({ block: 'nearest' });
                } else if (e.key === 'Enter') {
                    const selected = resultsContainer.querySelector('.modal-result-item.selected') || resultsContainer.querySelector('.modal-result-item');
                    if (selected) {
                        window.location.href = selected.getAttribute('href');
                    }
                }
            });
        }

        // Global hotkey: ⌘K, Ctrl+K
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                if (modal && modal.classList.contains('open')) {
                    closeModal();
                } else {
                    openModal();
                }
            } else if (e.key === 'Escape' && modal && modal.classList.contains('open')) {
                closeModal();
            }
        });

        // Mobile search input
        const mobileInput = document.getElementById('mobile-search-input');
        if (mobileInput) {
            mobileInput.addEventListener('focus', function() {
                openModal(mobileInput.value);
            });
        }
    });
    </script>
    @yield('scripts')
</body>
</html>