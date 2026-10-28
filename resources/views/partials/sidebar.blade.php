@php
  $currentRoute = request()->path();
  $isDashboard1 = $currentRoute === '/' || $currentRoute === 'dashboard' || empty($currentRoute);
  $isDashboard2 = $currentRoute === 'dashboard2';
  $isAdmin = request()->routeIs('admin.*') || str_starts_with($currentRoute, 'admin');
@endphp
<aside class="mini-rail-sidebar">
  <div class="rail-top">
    <!-- Home / Route Matrix -->
    <a href="{{ url('/dashboard') }}" class="rail-btn {{ $isDashboard1 ? 'active' : '' }}" title="Route Matrix">
      <i class="bi bi-house-door-fill"></i>
    </a>

    <!-- Data Manager (Designator & KML) -->
    @auth
      @if(auth()->user()->canManageDesignators())
      <a href="{{ url('/dashboard2') }}" class="rail-btn {{ $isDashboard2 ? 'active' : '' }}" title="Data Manager">
        <i class="bi bi-database-fill"></i>
      </a>
      @endif

      <!-- Admin: Kelola Pegawai -->
      @if(auth()->user()->isAdmin())
      <a href="{{ route('admin.pegawai.index') }}" class="rail-btn {{ $isAdmin ? 'active' : '' }}" title="Kelola Pegawai">
        <i class="bi bi-people-fill"></i>
      </a>
      @endif
    @endauth
  </div>

  <div class="rail-bottom">
    @auth
      <a href="{{ route('logout.get') }}" class="rail-btn" title="Sign Out">
        <i class="bi bi-box-arrow-right"></i>
      </a>
    @else
      <a href="{{ route('login') }}" class="rail-btn" title="Login">
        <i class="bi bi-box-arrow-in-right"></i>
      </a>
    @endauth
  </div>
</aside>
