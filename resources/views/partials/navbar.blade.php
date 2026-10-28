<header class="network-header">
  <div class="header-container">
    <!-- Left: Brand & Page Title -->
    <div class="header-brand-group">
      <a href="{{ url('/dashboard') }}" class="header-logo-link d-flex align-items-center text-decoration-none gap-2">
        <img src="{{ asset('images/telkom-spark.png') }}" alt="Telkom Akses" style="height: 28px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 6px rgba(220,38,38,0.25));">
        <span style="color: #DC2626; font-size: 1.18rem; font-weight: 800; letter-spacing: -0.3px;">Telkom Akses</span>
      </a>
      <span class="header-divider">|</span>
      <span class="header-subtitle">{{ $pageSubtitle ?? 'Route Matrix' }}</span>
    </div>

    <!-- Right: Notification & User Menu -->
    <div class="header-actions-group">
      <!-- Notification Icon with red dot -->
      <div class="position-relative me-3">
        <button type="button" class="header-icon-btn" title="Notifikasi">
          <i class="bi bi-bell-fill"></i>
          <span class="notification-badge-dot"></span>
        </button>
      </div>

      <!-- User Menu -->
      @auth
      <div class="dropdown">
        <button class="user-avatar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
          <i class="bi bi-person-fill"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background-color: #2B2B36; border: 1px solid rgba(229, 231, 235, 0.15); border-radius: 12px; padding: 8px 0; min-width: 220px;">
          <li class="px-3 py-2 text-start border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
            <div class="fw-bold text-white" style="font-size: 0.925rem;">{{ Auth::user()->name }}</div>
            <div class="d-flex align-items-center justify-content-between gap-2 mt-1">
              <small class="text-muted" style="font-size: 0.775rem; color: #9CA3AF !important; word-break: break-all;">{{ Auth::user()->email }}</small>
              <span class="badge bg-danger" style="font-size: 0.7rem; font-weight: 600; padding: 2px 7px; border-radius: 4px; flex-shrink: 0;">{{ strtoupper(str_replace('_', ' ', Auth::user()->role)) }}</span>
            </div>
          </li>
          <li class="pt-1">
            <a class="dropdown-item py-2 text-light" href="{{ route('switch.account') }}" style="font-size: 0.875rem;">
              <i class="bi bi-arrow-repeat me-2 text-danger"></i>Ganti Akun
            </a>
          </li>
          <li>
            <a class="dropdown-item py-2 text-danger" href="{{ route('logout.get') }}" style="font-size: 0.875rem;">
              <i class="bi bi-box-arrow-right me-2"></i>Sign Out
            </a>
          </li>
        </ul>
      </div>
      @else
      <a href="{{ route('login') }}" class="btn btn-sm btn-danger px-3 rounded-pill" style="font-size: 0.85rem; font-weight: 600;">
        <i class="bi bi-box-arrow-in-right me-1"></i>Login
      </a>
      @endauth
    </div>
  </div>
</header>
