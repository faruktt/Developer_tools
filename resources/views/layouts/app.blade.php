<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Faruk Tools - Free Developer Tools for Everyone')</title>
    <meta name="description" content="@yield('meta_description', 'Fast, simple and privacy-friendly online tools for developers, designers and web professionals.')">
    <meta name="keywords" content="@yield('meta_keywords', 'developer tools, online utilities, json formatter, json validator, base64 encoder decoder, uuid generator, password generator, qr code generator, slug generator, jwt decoder, unix timestamp converter, html formatter, css formatter, sql formatter, image compressor, word counter, case converter, color converter')">
    <meta name="author" content="Md. Faruk Hossain">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Faruk Tools">
    <meta property="og:title" content="@yield('title', 'Faruk Tools - Free Developer Tools for Everyone')">
    <meta property="og:description" content="@yield('meta_description', 'Fast, simple and privacy-friendly online tools for developers, designers and web professionals.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@Ahmedfaruk420">
    <meta name="twitter:creator" content="@Ahmedfaruk420">
    <meta name="twitter:title" content="@yield('title', 'Faruk Tools - Free Developer Tools for Everyone')">
    <meta name="twitter:description" content="@yield('meta_description', 'Fast, simple and privacy-friendly online tools for developers, designers and web professionals.')">

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Faruk Tools',
        'url' => 'https://tools.faruk.stsoft.top/',
        'description' => 'Fast, simple and privacy-friendly online tools for developers, designers and web professionals.',
        'creator' => [
            '@type' => 'Person',
            'name' => 'Md. Faruk Hossain',
            'jobTitle' => 'PHP Laravel Developer',
            'url' => 'https://faruk.stsoft.top',
            'sameAs' => [
                'https://github.com/faruktt',
                'https://www.linkedin.com/in/md-faruk-hossain-049241236',
                'https://www.facebook.com/web.faruk.ahmed',
                'https://x.com/Ahmedfaruk420',
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @stack('schema')

    <!-- Modern Developer Typography: Geist & Geist Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800&family=Geist+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <header class="navbar">
        <div class="container nav-wrapper">
            <a href="{{ route('home') }}" class="brand">
                <div class="brand-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <div class="brand-text">Faruk<span>Tools</span></div>
            </a>

            <!-- Nav Links -->
            <nav>
                <ul class="nav-links" id="nav-links">
                    <li><a href="{{ route('home') }}#tools" class="nav-link">Tools</a></li>
                    <li><a href="{{ route('home') }}#categories" class="nav-link">Categories</a></li>
                    <li><a href="{{ route('home') }}#about" class="nav-link">About</a></li>
                    <li><a href="https://faruk.stsoft.top" target="_blank" rel="noopener noreferrer" class="nav-link">Portfolio</a></li>
                    <li><a href="https://github.com/faruktt" target="_blank" rel="noopener noreferrer" class="nav-link">GitHub</a></li>
                </ul>
            </nav>

            <!-- Actions -->
            <div class="nav-actions">
                <button type="button" class="btn-icon" id="theme-toggle-btn" onclick="toggleTheme()" aria-label="Toggle theme">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
                <button type="button" class="btn-icon mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-simple">
                <div class="footer-left">
                    <div class="footer-owner-line">
                        <span class="owner-name">Faruk Tools</span>
                        <span class="owner-sep">&bull;</span>
                        <span>Md. Faruk Hossain</span>
                        <span class="owner-badge">PHP Laravel Developer</span>
                    </div>
                </div>

                <div class="social-links-row">
                    <a href="https://faruk.stsoft.top" target="_blank" rel="noopener noreferrer" class="social-link-pill">Portfolio</a>
                    <a href="https://github.com/faruktt" target="_blank" rel="noopener noreferrer" class="social-link-pill">GitHub</a>
                    <a href="https://www.linkedin.com/in/md-faruk-hossain-049241236" target="_blank" rel="noopener noreferrer" class="social-link-pill">LinkedIn</a>
                    <a href="https://www.facebook.com/web.faruk.ahmed" target="_blank" rel="noopener noreferrer" class="social-link-pill">Facebook</a>
                    <a href="https://x.com/Ahmedfaruk420" target="_blank" rel="noopener noreferrer" class="social-link-pill">X</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global App Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
