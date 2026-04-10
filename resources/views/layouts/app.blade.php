<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>@yield('title', 'Aparri Philippine Coast Guard Boat Tracker')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('styles.css') }}" />
  @stack('styles')
</head>
<body>
  <header class="site-header">
    <a class="brand" href="{{ route('home') }}">
      <span class="brand-marks">
        <img
          class="brand-mark"
          src="{{ asset('assets/logo-district-northeastern-luzon.png') }}"
          width="56"
          height="56"
          alt="Seal of the Coast Guard District North Eastern Luzon"
        />
        <img
          class="brand-mark"
          src="{{ asset('assets/logo-station-cagayan.png') }}"
          width="56"
          height="56"
          alt="Seal of Coast Guard Station Cagayan"
        />
      </span>
      <span class="brand-title">Philippine Coast Guard Cagayan</span>
    </a>
    <button
      class="nav-toggle"
      type="button"
      aria-expanded="false"
      aria-controls="primary-nav"
      aria-label="Open menu"
    >
      <span class="nav-toggle-bar" aria-hidden="true"></span>
      <span class="nav-toggle-bar" aria-hidden="true"></span>
      <span class="nav-toggle-bar" aria-hidden="true"></span>
    </button>
    <nav id="primary-nav" class="site-nav" aria-label="Primary">
      <ul class="nav-links">
        <li>
          <a href="{{ route('home') }}"{{ request()->routeIs('home') ? ' aria-current="page"' : '' }}>Home</a>
        </li>
        <li>
          <a href="{{ route('about') }}"{{ request()->routeIs('about') ? ' aria-current="page"' : '' }}>About Us</a>
        </li>
        <li>
          <a href="{{ route('contact') }}"{{ request()->routeIs('contact') ? ' aria-current="page"' : '' }}>Contact Us</a>
        </li>
      </ul>
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="site-footer" role="contentinfo">
    <div class="site-footer__inner">
      <a class="site-footer__link" href="#" target="_blank" rel="noopener noreferrer" aria-label="Visit our Facebook page">
        <span class="site-footer__icon site-footer__icon--facebook" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="48" height="48" focusable="false">
            <circle cx="12" cy="12" r="12" fill="#1877f2" />
            <path
              fill="#fff"
              d="M13.5 21.5v-7.3H11V11h2.5V8.9C13.5 6.4 15.1 5 17.8 5H20v3.2h-1.9c-1 0-1.3.5-1.3 1.4V11H20l-.4 3.2h-3.1v7.3h-3.2z"
            />
          </svg>
        </span>
        <span class="site-footer__label">Website link</span>
      </a>
      <a class="site-footer__link" href="mailto:email@example.com" aria-label="Send us an email">
        <span class="site-footer__icon site-footer__icon--email" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="48" height="48" focusable="false">
          <circle cx="12" cy="12" r="12" fill="#1a1a1a" />
          <path
            fill="none"
            stroke="#fff"
            stroke-width="1.4"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M7 9h10v8H7V9zm0 0l5 3.5L17 9"
          />
        </svg>
        </span>
        <span class="site-footer__label">email</span>
      </a>
    </div>
  </footer>

  <script src="{{ asset('nav.js') }}"></script>
  @stack('scripts')
</body>
</html>
