<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>@yield('title', 'Admin — Aparri Philippine Coast Guard')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('styles.css') }}" />
  <link rel="stylesheet" href="{{ asset('dashboard.css') }}" />
  @stack('styles')
</head>
<body>
  <header class="site-header">
    <a class="brand" href="{{ route('admin.dashboard') }}">
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
    <div class="admin-user-menu">
      <button class="admin-user-toggle" type="button" aria-expanded="false" aria-label="User menu">
        <div class="admin-user-text">
          <span class="admin-user-welcome">Welcome!</span>
          <span class="admin-user-name">{{ auth()->user()->name ?? 'Fullname' }}</span>
        </div>
        @if(auth()->user()->avatar)
          <img
            class="admin-user-avatar"
            src="{{ asset(auth()->user()->avatar) }}"
            alt="Profile picture"
            width="40"
            height="40"
            style="border-radius: 50%; object-fit: cover;"
          />
        @else
          <svg class="admin-user-avatar" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="20" cy="20" r="20" fill="#FF9500"/>
            <circle cx="20" cy="12" r="6" fill="white"/>
            <path d="M10 28C10 24 15 22 20 22C25 22 30 24 30 28" fill="white"/>
          </svg>
        @endif
      </button>
      <nav class="admin-user-dropdown" aria-label="Admin menu">
        <ul class="admin-menu-items">
          <li>
            <a href="{{ route('admin.dashboard') }}" class="admin-menu-link">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
              <span>Home</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.profile') }}" class="admin-menu-link">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <span>Profile</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.emergency.history') }}" class="admin-menu-link">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
              </svg>
              <span>Emergency History</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.settings') }}" class="admin-menu-link">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m2.98 2.98l4.24 4.24M1 12h6m6 0h6m-17.78 7.78l4.24-4.24m2.98-2.98l4.24-4.24"></path>
              </svg>
              <span>Settings</span>
            </a>
          </li>
          <li>
            <a href="{{ route('logout') }}" class="admin-menu-link">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
              </svg>
              <span>Logout</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <script src="{{ asset('nav.js') }}"></script>
  @stack('scripts')
</body>
</html>
