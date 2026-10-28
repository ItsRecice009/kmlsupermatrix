@extends('layouts.auth')

@section('title', 'Telkom Akses | Login')

@section('styles')
<style>
  /* Custom Validation Tooltip sejajar dengan huruf pertama placeholder / input (42px) */
  .auth-tooltip {
    position: absolute;
    top: calc(100% + 7px);
    left: 42px; /* Sejajar persis dengan huruf pertama (padding-left input adalah 42px) */
    background: #FFFFFF;
    color: #1F2937;
    border-radius: 4px;
    padding: 7px 12px 7px 10px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.45);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 500;
    z-index: 100;
    white-space: nowrap;
    animation: authTooltipFadeIn 0.18s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
  }

  .auth-tooltip::before {
    content: '';
    position: absolute;
    top: -6px;
    left: 8px; /* Panah tepat berada di awal notifikasi, mengarah ke huruf pertama */
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #FFFFFF;
  }

  .auth-tooltip-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #ea580c;
    color: #FFFFFF;
    width: 17px;
    height: 18px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 800;
    line-height: 1;
    flex-shrink: 0;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
  }

  .auth-tooltip-text {
    line-height: 1.2;
    color: #1F2937;
    font-size: 13px;
    font-weight: 500;
  }

  @keyframes authTooltipFadeIn {
    0% {
      opacity: 0;
      transform: translateY(-4px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
@endsection

@section('content')
  <h1 class="auth-title">Masuk ke Akun</h1>
  <p class="auth-subtitle">Silakan masukkan email dan password Anda</p>
  
  @if (session('success'))
    <div class="auth-alert auth-alert-success">
      <i class="bi bi-check-circle-fill"></i>
      <div>{{ session('success') }}</div>
    </div>
  @endif
  
  @if (session('info'))
    <div class="auth-alert auth-alert-warning">
      <i class="bi bi-info-circle-fill"></i>
      <div>{{ session('info') }}</div>
    </div>
  @endif
  
  @if (session('session_expired'))
    <div class="auth-alert auth-alert-warning">
      <i class="bi bi-exclamation-triangle-fill"></i>
      <div>{{ session('session_expired') }}</div>
    </div>
  @endif
  
  @if (session('error'))
    <div class="auth-alert auth-alert-danger">
      <i class="bi bi-exclamation-octagon-fill"></i>
      <div>{{ session('error') }}</div>
    </div>
  @endif
  
  @if ($errors->any())
    <div class="auth-alert auth-alert-danger">
      <i class="bi bi-exclamation-octagon-fill"></i>
      <div>{{ $errors->first() }}</div>
    </div>
  @endif
  
  <form action="{{ route('login.submit') }}" method="post" id="loginForm" novalidate>
    @csrf
    <div class="form-group">
      <div class="input-wrapper">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" id="loginEmail" class="auth-input" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="email" />
      </div>
    </div>

    <div class="form-group">
      <div class="input-wrapper">
        <i class="bi bi-lock-fill input-icon"></i>
        <input type="password" name="password" id="loginPassword" class="auth-input" placeholder="Password" required autocomplete="current-password" />
        <button type="button" class="password-toggle" id="toggleLoginPassword" aria-label="Toggle password visibility">
          <i class="bi bi-eye" id="toggleLoginIcon"></i>
        </button>
      </div>
    </div>

    <button type="submit" class="btn-submit">
      <span>Login</span>
    </button>
  </form>
@endsection

@section('scripts')
<script>
  const toggleLoginPassword = document.getElementById('toggleLoginPassword');
  const loginPassword = document.getElementById('loginPassword');
  const toggleLoginIcon = document.getElementById('toggleLoginIcon');
  const loginForm = document.getElementById('loginForm');
  const loginEmail = document.getElementById('loginEmail');

  // Toggle show/hide password
  if (toggleLoginPassword && loginPassword && toggleLoginIcon) {
    toggleLoginPassword.addEventListener('click', function() {
      const isPassword = loginPassword.type === 'password';
      loginPassword.type = isPassword ? 'text' : 'password';
      toggleLoginIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  }

  // Helper untuk menampilkan notifikasi tooltip kustom
  function showAuthTooltip(inputElement, message) {
    hideAuthTooltip();
    const wrapper = inputElement.closest('.input-wrapper');
    if (!wrapper) return;

    const tooltip = document.createElement('div');
    tooltip.className = 'auth-tooltip';
    tooltip.id = 'authActiveTooltip';
    tooltip.setAttribute('role', 'alert');
    tooltip.innerHTML = `
      <span class="auth-tooltip-icon">!</span>
      <span class="auth-tooltip-text">${message}</span>
    `;

    wrapper.appendChild(tooltip);
    inputElement.focus();
  }

  // Helper untuk menghilangkan notifikasi tooltip
  function hideAuthTooltip() {
    const activeTooltip = document.getElementById('authActiveTooltip');
    if (activeTooltip) {
      activeTooltip.remove();
    }
  }

  // Sembunyikan notifikasi saat user mulai mengetik atau klik di luar
  if (loginEmail) {
    loginEmail.addEventListener('input', hideAuthTooltip);
  }
  if (loginPassword) {
    loginPassword.addEventListener('input', hideAuthTooltip);
  }
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.auth-input') && !e.target.closest('.btn-submit')) {
      hideAuthTooltip();
    }
  });

  // Validasi form saat submit
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
      // 1. Cek email jika kosong
      if (!loginEmail.value.trim()) {
        e.preventDefault();
        showAuthTooltip(loginEmail, 'Tolong isi kolom ini.');
        return;
      }

      // 2. Cek format email jika tidak valid
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(loginEmail.value.trim())) {
        e.preventDefault();
        showAuthTooltip(loginEmail, 'Tolong masukkan alamat email yang valid.');
        return;
      }

      // 3. Cek password jika kosong
      if (!loginPassword.value) {
        e.preventDefault();
        showAuthTooltip(loginPassword, 'Tolong isi kolom ini.');
        return;
      }

      // Hapus tooltip jika semua valid dan form siap dikirim
      hideAuthTooltip();
    });
  }
</script>
@endsection

