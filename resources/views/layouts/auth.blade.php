<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>@yield('title', 'Telkom Akses')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Telkom Akses Clean Dark Theme -->
    <style>
      :root {
        --color-canvas: #1E1E24;
        --color-card: #2B2B36;
        --color-input: #111827;
        --color-white: #FFFFFF;
        --color-muted: #9CA3AF;
        --color-border: rgba(229, 231, 235, 0.12);
        --color-border-input: #374151;
        --color-red: #DC2626;
        --color-red-hover: #E06D6D;
        --color-red-glow: rgba(224, 109, 109, 0.25);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 18px;
      }

      * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      }

      body {
        margin: 0;
        padding: 1.5rem;
        background-color: var(--color-canvas);
        background-image: 
          radial-gradient(circle at 50% -10%, rgba(220, 38, 38, 0.18) 0%, transparent 60%),
          radial-gradient(circle at 50% 110%, rgba(220, 38, 38, 0.08) 0%, transparent 50%);
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-white);
        -webkit-font-smoothing: antialiased;
      }

      .auth-container {
        width: 100%;
        max-width: 440px;
        margin: auto;
      }

      .auth-header {
        text-align: center;
        margin-bottom: 1.75rem;
      }

      .auth-logo-img {
        max-width: 220px;
        height: auto;
        display: inline-block;
        filter: drop-shadow(0 4px 16px rgba(220, 38, 38, 0.25));
        transition: transform 0.25s ease;
      }

      .auth-logo-img:hover {
        transform: translateY(-2px);
      }

      .auth-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45), 0 0 1px rgba(229, 231, 235, 0.1);
        padding: 2.25rem 2rem;
        position: relative;
        overflow: hidden;
        animation: cardFadeIn 0.35s ease-out;
      }

      /* Delicate Top Accent Line */
      .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, var(--color-red) 50%, transparent 100%);
      }

      .auth-title {
        color: var(--color-white);
        font-size: 1.45rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.02em;
        text-align: center;
      }

      .auth-subtitle {
        color: var(--color-muted);
        font-size: 0.875rem;
        margin: 0 0 1.75rem 0;
        text-align: center;
        font-weight: 400;
        line-height: 1.4;
      }

      /* Clean Input Group */
      .form-group {
        margin-bottom: 1.25rem;
      }

      .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
      }

      .input-icon {
        position: absolute;
        left: 14px;
        color: var(--color-muted);
        font-size: 1.05rem;
        pointer-events: none;
        transition: color 0.2s ease;
      }

      .auth-input {
        width: 100%;
        background-color: var(--color-input) !important;
        color: var(--color-white) !important;
        border: 1px solid var(--color-border-input);
        border-radius: var(--radius-md);
        padding: 12px 14px 12px 42px;
        font-size: 0.925rem;
        font-weight: 400;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
      }

      .auth-input::placeholder {
        color: var(--color-muted);
        font-weight: 400;
      }

      .auth-input:focus {
        background-color: var(--color-input) !important;
        color: var(--color-white) !important;
        border-color: var(--color-red);
        box-shadow: 0 0 0 3px var(--color-red-glow);
      }

      /* Consistent Dark Mode Autofill Override (Prevents Chrome/Edge/Safari from turning white) */
      .auth-input:-webkit-autofill,
      .auth-input:-webkit-autofill:hover, 
      .auth-input:-webkit-autofill:focus, 
      .auth-input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 1000px #111827 inset !important;
        box-shadow: 0 0 0 1000px #111827 inset !important;
        -webkit-text-fill-color: #FFFFFF !important;
        caret-color: #FFFFFF !important;
        transition: background-color 5000s ease-in-out 0s;
        border-color: var(--color-border-input) !important;
      }

      .auth-input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px #111827 inset, 0 0 0 3px var(--color-red-glow) !important;
        box-shadow: 0 0 0 1000px #111827 inset, 0 0 0 3px var(--color-red-glow) !important;
        border-color: var(--color-red) !important;
      }

      /* Firefox Autofill Override */
      .auth-input:autofill {
        background-color: #111827 !important;
        color: #FFFFFF !important;
        filter: none !important;
      }

      .input-wrapper:focus-within .input-icon {
        color: var(--color-red-hover);
      }

      /* Password toggle eye button */
      .password-toggle {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: var(--color-muted);
        cursor: pointer;
        padding: 4px;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
      }

      .password-toggle:hover {
        color: var(--color-white);
      }

      /* Primary Button */
      .btn-submit {
        width: 100%;
        background-color: var(--color-red);
        color: var(--color-white);
        border: none;
        border-radius: var(--radius-md);
        padding: 12px 20px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
        margin-top: 1.5rem;
      }

      .btn-submit:hover:not(:disabled) {
        background-color: var(--color-red-hover);
        box-shadow: 0 6px 22px rgba(224, 109, 109, 0.45);
        transform: translateY(-1px);
      }

      .btn-submit:active:not(:disabled) {
        transform: translateY(0);
      }

      .btn-submit:disabled {
        opacity: 0.55;
        cursor: not-allowed;
      }

      /* Secondary / Back Button */
      .btn-secondary-action {
        width: 100%;
        background: transparent;
        color: var(--color-muted);
        border: 1px solid var(--color-border-input);
        border-radius: var(--radius-md);
        padding: 10px 18px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        margin-top: 0.75rem;
      }

      .btn-secondary-action:hover {
        color: var(--color-white);
        border-color: var(--color-red);
        background-color: rgba(220, 38, 38, 0.08);
      }

      /* Clean Alerts */
      .auth-alert {
        background-color: rgba(17, 24, 39, 0.9);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        line-height: 1.4;
      }

      .auth-alert-danger {
        border-left: 3px solid var(--color-red);
        color: #FCA5A5;
      }

      .auth-alert-success {
        border-left: 3px solid #10B981;
        color: #6EE7B7;
      }

      .auth-alert-warning {
        border-left: 3px solid #F59E0B;
        color: #FCD34D;
      }

      .auth-alert i {
        font-size: 1.1rem;
        flex-shrink: 0;
        margin-top: 1px;
      }

      .auth-link {
        color: var(--color-red-hover);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
      }

      .auth-link:hover {
        color: var(--color-white);
        text-decoration: underline;
      }

      @keyframes cardFadeIn {
        from {
          opacity: 0;
          transform: translateY(12px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @media (max-width: 480px) {
        body {
          padding: 1rem;
        }
        .auth-card {
          padding: 1.75rem 1.25rem;
        }
      }
    </style>
    @yield('styles')
  </head>
  <body>
    <div class="auth-container">
      <div class="auth-header">
        <a href="{{ url('/') }}" class="text-decoration-none">
          <img src="{{ asset('images/Telkom Akses Logo.png') }}" alt="Telkom Akses" class="auth-logo-img" onerror="this.onerror=null; this.outerHTML='<span style=\'font-size:1.6rem;font-weight:800;color:#DC2626;letter-spacing:-0.5px;\'>Telkom Akses</span>';">
        </a>
      </div>
      <div class="auth-card">
        @yield('content')
      </div>
    </div>

    <!-- Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
  </body>
</html>
