<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracking Order - Apple Style</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Brand & Accent */
            --colors-primary: #0066cc;
            --colors-primary-focus: #0071e3;
            --colors-primary-on-dark: #2997ff;

            /* Surface */
            --colors-canvas: #ffffff;
            --colors-canvas-parchment: #f5f5f7;
            --colors-surface-pearl: #fafafc;
            --colors-surface-tile-1: #272729;
            --colors-surface-tile-2: #2a2a2c;
            --colors-surface-tile-3: #252527;
            --colors-surface-black: #000000;
            --colors-surface-chip-translucent: rgba(210, 210, 215, 0.64);

            /* Text */
            --colors-ink: #1d1d1f;
            --colors-body: #1d1d1f;
            --colors-body-on-dark: #ffffff;
            --colors-body-muted: #cccccc;
            --colors-ink-muted-80: #333333;
            --colors-ink-muted-48: #7a7a7a;

            /* Hairlines & Borders */
            --colors-divider-soft: rgba(0, 0, 0, 0.04);
            --colors-hairline: #e0e0e0;

            /* Typography */
            --font-display: "SF Pro Display", "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            --font-body: "SF Pro Text", "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;

            /* Spacing */
            --spacing-xxs: 4px;
            --spacing-xs: 8px;
            --spacing-sm: 12px;
            --spacing-md: 17px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            --spacing-xxl: 48px;
            --spacing-section: 80px;

            /* Shapes */
            --rounded-none: 0px;
            --rounded-xs: 5px;
            --rounded-sm: 8px;
            --rounded-md: 11px;
            --rounded-lg: 18px;
            --rounded-pill: 9999px;
            --rounded-full: 50%;

            /* Elevation */
            --shadow-product: rgba(0, 0, 0, 0.22) 3px 5px 30px 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--colors-canvas);
            color: var(--colors-ink);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-size: 17px;
            line-height: 1.44; /* Slightly tightened from 1.47 for Inter */
            letter-spacing: -0.374px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            border: none;
            background: none;
            cursor: pointer;
            font-family: inherit;
        }

        /* Top Navigation */
        .global-nav {
            background-color: var(--colors-surface-black);
            height: 44px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .global-nav-content {
            max-width: 980px;
            width: 100%;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-link {
            color: var(--colors-body-on-dark);
            font-size: 12px;
            font-weight: 400;
            line-height: 1.0;
            letter-spacing: -0.12px;
            opacity: 0.8;
            transition: opacity 0.2s ease;
            margin-right: 20px;
        }

        .nav-link:hover {
            opacity: 1;
        }

        .nav-logo {
            font-weight: 600;
            font-size: 14px;
            opacity: 1;
        }

        /* Sub Navigation Frosted */
        .sub-nav-frosted {
            background-color: rgba(245, 245, 247, 0.8);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            height: 52px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.08);
            position: sticky;
            top: 44px;
            z-index: 99;
        }

        .sub-nav-content {
            max-width: 980px;
            width: 100%;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-name {
            font-family: var(--font-display);
            font-size: 21px;
            font-weight: 600;
            letter-spacing: 0.231px; /* positive tracking for tagline */
            color: var(--colors-ink);
        }

        .sub-nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .button-utility {
            font-size: 14px;
            font-weight: 400;
            letter-spacing: -0.224px;
            color: var(--colors-ink);
        }

        /* Buttons */
        .button-primary {
            background-color: var(--colors-primary);
            color: #ffffff;
            font-size: 17px;
            font-weight: 400;
            border-radius: var(--rounded-pill);
            padding: 11px 22px;
            display: inline-block;
            text-align: center;
            transition: transform 0.1s ease;
        }

        .button-primary:active {
            transform: scale(0.95);
        }

        .button-primary:focus-visible {
            outline: 2px solid var(--colors-primary-focus);
            outline-offset: 2px;
        }

        .button-secondary-pill {
            background-color: transparent;
            color: var(--colors-primary);
            font-size: 17px;
            font-weight: 400;
            border: 1px solid var(--colors-primary);
            border-radius: var(--rounded-pill);
            padding: 10px 22px;
            display: inline-block;
            text-align: center;
            transition: transform 0.1s ease;
        }

        .button-secondary-pill:active {
            transform: scale(0.95);
        }

        .text-link {
            color: var(--colors-primary);
            font-size: 17px;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .text-link-on-dark {
            color: var(--colors-primary-on-dark);
            font-size: 17px;
        }

        .text-link-on-dark:hover {
            text-decoration: underline;
        }

        /* Typography */
        .hero-display {
            font-family: var(--font-display);
            font-size: 56px;
            font-weight: 600;
            line-height: 1.07;
            letter-spacing: -0.29em; /* Adjusting for Inter vs SF Pro, ~-0.28px */
            letter-spacing: calc(-0.28px - 0.01em);
            margin-bottom: var(--spacing-xs);
            font-feature-settings: "ss03"; /* Rounds out 'a' on Inter */
        }

        .display-lg {
            font-family: var(--font-display);
            font-size: 40px;
            font-weight: 600;
            line-height: 1.10;
            letter-spacing: -0.01em;
            margin-bottom: var(--spacing-xs);
            font-feature-settings: "ss03";
        }

        .lead {
            font-size: 28px;
            font-weight: 400;
            line-height: 1.14;
            letter-spacing: 0.196px;
        }

        /* Search Input */
        .search-input-wrapper {
            position: relative;
            display: inline-block;
        }

        .search-input {
            background-color: var(--colors-canvas);
            color: var(--colors-ink);
            font-size: 17px;
            font-family: var(--font-body);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: var(--rounded-pill);
            padding: 12px 20px 12px 44px;
            height: 44px;
            width: 300px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .search-input:focus {
            border-color: var(--colors-primary);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            fill: var(--colors-ink-muted-48);
        }

        /* Layout & Tiles */
        .product-tile {
            width: 100%;
            padding: var(--spacing-section) 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        .product-tile-light {
            background-color: var(--colors-canvas);
            color: var(--colors-ink);
        }

        .product-tile-dark {
            background-color: var(--colors-surface-tile-1);
            color: var(--colors-body-on-dark);
        }

        .product-tile-parchment {
            background-color: var(--colors-canvas-parchment);
            color: var(--colors-ink);
        }

        .hero-actions {
            margin-top: var(--spacing-md);
            display: flex;
            gap: 16px;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
        }

        .product-image {
            max-width: 1440px;
            width: 80%;
            height: auto;
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-product);
            margin-top: 20px;
            display: block;
        }

        /* Store Utility Grid */
        .utility-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            max-width: 1440px;
            width: 100%;
            padding: 0 40px;
            margin: 0 auto;
        }

        .store-utility-card {
            background-color: var(--colors-canvas);
            border: 1px solid var(--colors-hairline);
            border-radius: var(--rounded-lg);
            padding: var(--spacing-lg);
            text-align: left;
        }

        .body-strong {
            font-size: 17px;
            font-weight: 600;
            letter-spacing: -0.374px;
        }

        /* Footer */
        .footer {
            background-color: var(--colors-canvas-parchment);
            color: var(--colors-ink-muted-80);
            padding: 64px 20px 40px;
            width: 100%;
        }

        .footer-content {
            max-width: 980px;
            margin: 0 auto;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 64px;
        }

        .link-column {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .caption-strong {
            font-size: 14px;
            font-weight: 600;
            color: var(--colors-ink);
            letter-spacing: -0.224px;
            margin-bottom: 8px;
        }

        .dense-link {
            font-size: 17px;
            line-height: 2.41;
            color: var(--colors-ink-muted-80);
            text-decoration: none;
        }

        .dense-link:hover {
            text-decoration: underline;
        }

        .legal-row {
            margin-top: 64px;
            padding-top: 16px;
            border-top: 1px solid var(--colors-hairline);
        }

        .fine-print {
            font-size: 12px;
            color: var(--colors-ink-muted-48);
            letter-spacing: -0.12px;
            line-height: 1.0;
        }

        /* Breakpoints */
        @media (max-width: 1068px) {
            .hero-display { font-size: 40px; }
            .product-image { width: 90%; }
        }
        
        @media (max-width: 834px) {
            .global-nav-content .nav-link { display: none; }
            .global-nav-content .nav-link.nav-logo { display: block; }
            .utility-grid { grid-template-columns: repeat(2, 1fr); }
            .product-tile { padding: 48px 0; }
        }

        @media (max-width: 640px) {
            .hero-display { font-size: 34px; }
            .lead { font-size: 24px; }
            .utility-grid { grid-template-columns: 1fr; }
            .search-input { width: 200px; }
        }
        
        @media (max-width: 419px) {
            .hero-display { font-size: 28px; }
        }
    </style>
</head>
<body>

    <nav class="global-nav">
        <div class="global-nav-content">
            <a href="#" class="nav-link nav-logo"> Tracking</a>
            <div>
                <a href="#" class="nav-link">Store</a>
                <a href="#" class="nav-link">Mac</a>
                <a href="#" class="nav-link">iPad</a>
                <a href="#" class="nav-link">iPhone</a>
                <a href="#" class="nav-link">Watch</a>
                <a href="#" class="nav-link">Support</a>
            </div>
        </div>
    </nav>

    <nav class="sub-nav-frosted">
        <div class="sub-nav-content">
            <span class="category-name">Order Tracking</span>
            <div class="sub-nav-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="button-utility text-link">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="button-utility">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="button-primary" style="padding: 6px 14px; font-size: 14px;">Sign Up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="product-tile product-tile-light">
            <h1 class="hero-display">Your order, mapped.</h1>
            <p class="lead">Precision tracking from warehouse to your door.</p>
            
            <div class="hero-actions">
                <div class="search-input-wrapper">
                    <svg class="search-icon" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input type="text" class="search-input" placeholder="Enter tracking number" />
                </div>
                <button class="button-primary">Track</button>
            </div>
            
            <img src="https://images.unsplash.com/photo-1586528116311-ad8ed7c508b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1440&q=80" class="product-image" alt="A package ready for delivery" style="max-height: 600px; object-fit: cover;" />
        </section>

        <section class="product-tile product-tile-dark">
            <h2 class="display-lg">Every detail. In real-time.</h2>
            <p class="lead" style="color: var(--colors-body-muted);">Follow your package's journey with live map updates.</p>
            
            <div class="hero-actions">
                <a href="#" class="button-primary">Download App</a>
                <a href="#" class="text-link-on-dark" style="margin-left: 8px;">Learn more ></a>
            </div>
            
            <img src="https://images.unsplash.com/photo-1615655406736-b37c4fabf923?ixlib=rb-4.0.3&auto=format&fit=crop&w=1440&q=80" class="product-image" alt="Delivery van at night" style="max-height: 600px; object-fit: cover;" />
        </section>

        <section class="product-tile product-tile-parchment">
            <h2 class="display-lg">Pro-level logistics.</h2>
            <p class="lead" style="margin-bottom: 48px;">Built for speed, precision, and peace of mind.</p>
            
            <div class="utility-grid">
                <div class="store-utility-card">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&q=80" alt="Notification" style="width:100%; border-radius: var(--rounded-sm); margin-bottom: 16px;" />
                    <h3 class="body-strong">Instant Alerts</h3>
                    <p style="margin-top: 8px; color: var(--colors-ink-muted-80);">Get notified the moment your package moves. Never miss an update.</p>
                </div>
                <div class="store-utility-card">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=400&q=80" alt="Map Route" style="width:100%; border-radius: var(--rounded-sm); margin-bottom: 16px;" />
                    <h3 class="body-strong">Live Map Tracking</h3>
                    <p style="margin-top: 8px; color: var(--colors-ink-muted-80);">Watch your delivery arrive on a beautiful interactive map.</p>
                </div>
                <div class="store-utility-card">
                    <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=400&q=80" alt="Secure Dropoff" style="width:100%; border-radius: var(--rounded-sm); margin-bottom: 16px;" />
                    <h3 class="body-strong">Secure Drop-off</h3>
                    <p style="margin-top: 8px; color: var(--colors-ink-muted-80);">Photographic proof of delivery sent directly to your device.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <div class="link-column">
                    <h4 class="caption-strong">Services</h4>
                    <a href="#" class="dense-link">Order Tracking</a>
                    <a href="#" class="dense-link">Logistics Solutions</a>
                    <a href="#" class="dense-link">Returns</a>
                </div>
                <div class="link-column">
                    <h4 class="caption-strong">Account</h4>
                    <a href="#" class="dense-link">Manage Deliveries</a>
                    <a href="#" class="dense-link">Update Preferences</a>
                </div>
                <div class="link-column">
                    <h4 class="caption-strong">Company</h4>
                    <a href="#" class="dense-link">About Tracking</a>
                    <a href="#" class="dense-link">Careers</a>
                    <a href="#" class="dense-link">Contact Support</a>
                </div>
            </div>
            <div class="legal-row">
                <span class="fine-print">Copyright © 2026 TrackingOrder Inc. All rights reserved.</span>
                <span class="fine-print" style="margin-left: 20px;"><a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a> | <a href="#">Legal</a></span>
            </div>
        </div>
    </footer>

</body>
</html>
