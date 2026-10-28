<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pegawai - Telkom Akses Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Telkom Red Glassmorphism Dark Theme (Consistent with Route Matrix & Designator Management) -->
    <style>
      /* ========== GLOBAL RESETS & TELKOM DARK PALETTE ========== */
      * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        box-sizing: border-box;
      }

      html, body.network-routing-body {
        margin: 0;
        padding: 0;
        background-color: #1E1E24;
        color: #FFFFFF;
        height: 100vh;
        max-height: 100vh;
        overflow: hidden;
      }

      .network-app-wrapper {
        display: flex;
        flex-direction: column;
        height: 100vh;
        max-height: 100vh;
        overflow: hidden;
        background-color: #1E1E24;
      }

      /* Global text-muted override for dark mode contrast */
      .network-app-wrapper .text-muted,
      .modal-content .text-muted,
      .dropdown-menu .text-muted {
        color: #9CA3AF !important;
      }

      /* ========== HEADER / NAVBAR - DARK ========== */
      .network-header {
        height: 60px;
        background-color: #1E1E24;
        border-bottom: 1px solid rgba(229, 231, 235, 0.1);
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
        position: sticky;
        top: 0;
        z-index: 1020;
        width: 100%;
      }

      .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
      }

      .header-brand-group {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .header-logo-link {
        display: flex;
        align-items: center;
        text-decoration: none;
      }
      .header-logo-link img {
        transition: transform 0.2s ease, filter 0.2s ease;
      }
      .header-logo-link:hover img {
        transform: scale(1.02);
        filter: drop-shadow(0 2px 8px rgba(238, 46, 36, 0.25));
      }

      .header-divider {
        color: #DC2626;
        font-size: 1.25rem;
        font-weight: 300;
        opacity: 0.8;
        margin: 0 4px;
        user-select: none;
      }

      .header-subtitle {
        font-size: 1.15rem;
        font-weight: 800;
        color: #FFFFFF;
        letter-spacing: -0.3px;
      }

      .header-actions-group {
        display: flex;
        align-items: center;
        gap: 14px;
      }

      .header-icon-btn {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #DC2626;
        cursor: pointer;
        position: relative;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
      }
      .header-icon-btn:hover { transform: scale(1.1); }

      .notification-badge-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background-color: #DC2626;
        border-radius: 50%;
        border: 2px solid #1E1E24;
      }

      .user-avatar-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #2B2B36;
        color: #FFFFFF;
        border: 1px solid rgba(229, 231, 235, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        cursor: pointer;
        transition: all 0.2s;
      }
      .user-avatar-btn:hover {
        background-color: #374151;
        border-color: #9CA3AF;
        color: #FFFFFF;
      }

      /* ========== MAIN LAYOUT - DARK ========== */
      .network-main-layout {
        display: flex;
        flex: 1;
        height: calc(100vh - 60px);
        max-height: calc(100vh - 60px);
        min-height: 0;
        width: 100%;
        overflow: hidden;
        background-color: #1E1E24;
      }

      /* Far Left Mini Rail Sidebar */
      .mini-rail-sidebar {
        width: 60px;
        min-width: 60px;
        background-color: #18181D;
        border-right: 1px solid rgba(229, 231, 235, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        z-index: 1010;
      }

      .rail-top, .rail-bottom {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        width: 100%;
      }

      .rail-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9CA3AF;
        background: transparent;
        border: none;
        text-decoration: none;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s ease;
      }
      .rail-btn:hover {
        color: #FFFFFF;
        background-color: rgba(255, 255, 255, 0.08);
      }
      .rail-btn.active {
        background-color: #DC2626;
        color: #FFFFFF;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.45);
      }

      /* ========== WORKSPACE CONTAINER ========== */
      .network-workspace-container {
        flex: 1;
        padding: 24px 28px;
        min-width: 0;
        min-height: 0;
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: #1E1E24;
        scrollbar-width: none;
        -ms-overflow-style: none;
      }

      .network-workspace-container::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }

      /* Page Intro Header */
      .page-intro-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
      }

      .page-title-group {
        display: flex;
        align-items: center;
        gap: 16px;
      }

      .page-title-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.25) 0%, rgba(185, 28, 28, 0.35) 100%);
        border: 1px solid rgba(220, 38, 38, 0.45);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #EF4444;
        font-size: 1.55rem;
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
      }

      .page-title-text h1 {
        font-size: 1.45rem;
        font-weight: 800;
        color: #FFFFFF;
        margin: 0 0 4px 0;
        letter-spacing: -0.3px;
      }

      .page-title-text p {
        font-size: 0.85rem;
        color: #9CA3AF;
        margin: 0;
      }

      /* ========== STATS CARDS GRID ========== */
      .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
        margin-bottom: 24px;
      }

      .stat-card {
        background-color: #24242F;
        border: 1px solid rgba(229, 231, 235, 0.1);
        border-radius: 14px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, border-color 0.2s ease;
      }
      .stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(220, 38, 38, 0.3);
      }

      .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
      }

      .stat-icon-red {
        background: rgba(220, 38, 38, 0.15);
        color: #EF4444;
        border: 1px solid rgba(220, 38, 38, 0.3);
      }

      .stat-icon-green {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
      }

      .stat-icon-amber {
        background: rgba(245, 158, 11, 0.15);
        color: #F59E0B;
        border: 1px solid rgba(245, 158, 11, 0.3);
      }

      .stat-content {
        flex: 1;
        min-width: 0;
      }

      .stat-val {
        font-size: 1.6rem;
        font-weight: 800;
        color: #FFFFFF;
        line-height: 1.2;
        letter-spacing: -0.5px;
      }

      .stat-label {
        font-size: 0.8rem;
        color: #9CA3AF;
        margin-top: 3px;
        font-weight: 500;
      }

      /* ========== MAIN MATRIX CARD ========== */
      .matrix-table-card {
        background-color: #2B2B36;
        border-radius: 14px;
        overflow: hidden;
        border: 1.5px solid rgba(229, 231, 235, 0.15);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
      }

      /* Card Control Toolbar */
      .matrix-toolbar {
        padding: 16px 20px;
        background-color: #24242F;
        border-bottom: 1px solid rgba(229, 231, 235, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
      }

      .toolbar-left, .toolbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
      }

      .dark-search-wrapper {
        position: relative;
        width: 320px;
        max-width: 100%;
      }

      .dark-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 0.9rem;
        pointer-events: none;
      }

      .dark-search-input {
        background-color: #111827;
        border: 1px solid #374151;
        color: #FFFFFF;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 8px 12px 8px 36px;
        width: 100%;
        transition: all 0.2s ease;
      }
      .dark-search-input:focus {
        outline: none;
        border-color: #DC2626;
        background-color: #0F172A;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25);
      }
      .dark-search-input::placeholder { color: #6B7280; }

      .badge-rows-counter {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #E5E7EB;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
      }

      /* Buttons */
      .btn-telkom-red {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        text-decoration: none;
      }
      .btn-telkom-red:hover {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.5);
        color: #FFFFFF;
      }

      .btn-secondary-pill {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #E5E7EB;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        text-decoration: none;
      }
      .btn-secondary-pill:hover {
        background-color: #2B2B36;
        color: #FFFFFF;
        border-color: #4B5563;
      }

      /* ========== DATA TABLE STYLING ========== */
      .matrix-scroll-container {
        overflow-x: auto;
        max-height: calc(100vh - 360px);
        min-height: 320px;
      }

      .matrix-clean-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.86rem;
      }

      .matrix-clean-table thead th {
        background-color: #1F1F28;
        color: #E5E7EB;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        padding: 14px 16px;
        border-bottom: 2px solid rgba(220, 38, 38, 0.4);
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
      }

      .matrix-clean-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: background-color 0.15s ease;
      }
      .matrix-clean-table tbody tr:hover {
        background-color: rgba(220, 38, 38, 0.07);
      }

      .matrix-clean-table td {
        padding: 14px 16px;
        color: #D1D5DB;
        vertical-align: middle;
      }

      /* Pegawai User Presentation */
      .user-info-cell {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.2) 0%, rgba(185, 28, 28, 0.3) 100%);
        border: 1px solid rgba(220, 38, 38, 0.35);
        color: #EF4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
      }

      .user-name-text {
        font-weight: 700;
        color: #FFFFFF;
        font-size: 0.9rem;
        margin-bottom: 2px;
      }

      .badge-role-pegawai {
        background-color: rgba(59, 130, 246, 0.18);
        color: #93C5FD;
        border: 1px solid rgba(59, 130, 246, 0.35);
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
        text-transform: uppercase;
        display: inline-block;
      }

      .email-cell {
        color: #9CA3AF;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.82rem;
        display: flex;
        align-items: center;
        gap: 6px;
      }

      .badge-status-active {
        background-color: rgba(16, 185, 129, 0.15);
        color: #34D399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }

      .badge-status-blocked {
        background-color: rgba(239, 68, 68, 0.15);
        color: #F87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }

      /* Action Buttons */
      .action-btn-group {
        display: flex;
        align-items: center;
        gap: 6px;
        justify-content: center;
      }

      .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
        font-size: 0.95rem;
      }

      .action-edit {
        background-color: rgba(59, 130, 246, 0.15);
        color: #60A5FA;
        border-color: rgba(59, 130, 246, 0.3);
      }
      .action-edit:hover {
        background-color: #2563EB;
        color: #FFFFFF;
        box-shadow: 0 2px 10px rgba(37, 99, 235, 0.4);
        transform: scale(1.08);
      }

      .action-key {
        background-color: rgba(245, 158, 11, 0.15);
        color: #FBBF24;
        border-color: rgba(245, 158, 11, 0.3);
      }
      .action-key:hover {
        background-color: #D97706;
        color: #FFFFFF;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.4);
        transform: scale(1.08);
      }

      .action-block {
        background-color: rgba(249, 115, 22, 0.15);
        color: #FB923C;
        border-color: rgba(249, 115, 22, 0.3);
      }
      .action-block:hover {
        background-color: #EA580C;
        color: #FFFFFF;
        box-shadow: 0 2px 10px rgba(234, 88, 12, 0.4);
        transform: scale(1.08);
      }

      .action-unblock {
        background-color: rgba(16, 185, 129, 0.15);
        color: #34D399;
        border-color: rgba(16, 185, 129, 0.3);
      }
      .action-unblock:hover {
        background-color: #059669;
        color: #FFFFFF;
        box-shadow: 0 2px 10px rgba(5, 150, 105, 0.4);
        transform: scale(1.08);
      }

      .action-delete {
        background-color: rgba(239, 68, 68, 0.15);
        color: #F87171;
        border-color: rgba(239, 68, 68, 0.3);
      }
      .action-delete:hover {
        background-color: #DC2626;
        color: #FFFFFF;
        box-shadow: 0 2px 10px rgba(220, 38, 38, 0.4);
        transform: scale(1.08);
      }

      /* Empty State */
      .table-empty-state {
        padding: 60px 20px;
        text-align: center;
      }
      .empty-icon {
        font-size: 2.8rem;
        color: #6B7280;
        margin-bottom: 12px;
      }
      .empty-text-main {
        font-size: 1rem;
        font-weight: 700;
        color: #E5E7EB;
        margin-bottom: 4px;
      }
      .empty-text-sub {
        font-size: 0.85rem;
        color: #9CA3AF;
      }

      /* ========== DARK GLASS MODAL ========== */
      .modal-backdrop.show {
        opacity: 0.75;
        background-color: #0B0F19;
      }

      .modal-content.dark-theme-modal {
        background-color: #25252D !important;
        border: 1px solid rgba(220, 38, 38, 0.3) !important;
        color: #FFFFFF !important;
        border-radius: 18px !important;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.6) !important;
        overflow: hidden;
      }

      .dark-theme-modal .modal-header {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.4) 0%, rgba(43, 43, 54, 0.95) 100%) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .dark-theme-modal .modal-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
      }

      .dark-theme-modal .modal-subtitle {
        color: #9CA3AF;
        margin: 0;
        font-size: 0.82rem;
      }

      .dark-theme-modal .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 8px !important;
        padding: 8px !important;
        background-size: 10px !important;
        opacity: 0.85;
        transition: all 0.2s ease;
      }
      .dark-theme-modal .btn-close:hover {
        opacity: 1;
        border-color: rgba(255, 255, 255, 0.45) !important;
        background-color: rgba(255, 255, 255, 0.08);
      }

      .dark-theme-modal .modal-body {
        padding: 24px;
      }

      .dark-theme-modal .modal-footer {
        background-color: #1E1E24 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
      }

      /* Dark Form Inputs */
      .dark-form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #E5E7EB;
        margin-bottom: 6px;
        display: block;
      }

      .dark-form-control {
        background-color: #111827 !important;
        border: 1px solid #374151 !important;
        color: #FFFFFF !important;
        border-radius: 8px !important;
        font-size: 0.88rem !important;
        padding: 10px 14px !important;
        transition: all 0.2s ease;
        width: 100%;
      }
      .dark-form-control:focus {
        border-color: #DC2626 !important;
        background-color: #0F172A !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25) !important;
        outline: none;
      }
      .dark-form-control::placeholder { color: #6B7280 !important; }

      /* Dark Email Input Group with Prefix & Domain */
      .dark-email-input-group {
        display: flex;
        width: 100%;
        position: relative;
      }
      .dark-email-input-group .dark-form-control {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        border-right: none !important;
        flex: 1 1 auto;
      }
      .dark-email-input-group .dark-email-addon {
        background-color: #1A1F2C !important;
        border: 1px solid #374151 !important;
        border-left: none !important;
        color: #EF4444 !important;
        font-family: 'JetBrains Mono', monospace !important;
        font-size: 0.88rem !important;
        font-weight: 700 !important;
        padding: 10px 14px !important;
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        display: inline-flex;
        align-items: center;
        user-select: none;
        white-space: nowrap;
        transition: border-color 0.2s ease, background-color 0.2s ease;
      }
      .dark-email-input-group:focus-within .dark-email-addon {
        border-color: #DC2626 !important;
        background-color: #222230 !important;
      }
      .dark-email-input-group .dark-form-control.is-invalid + .dark-email-addon {
        border-color: #EF4444 !important;
      }

      .dark-info-box {
        background-color: rgba(59, 130, 246, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 12px 16px;
        color: #93C5FD;
        font-size: 0.82rem;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
      }

      .password-display-box {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.35rem;
        font-weight: 700;
        padding: 16px 20px;
        background-color: #111827;
        border: 2px dashed #10B981;
        border-radius: 12px;
        text-align: center;
        letter-spacing: 3px;
        color: #34D399;
        margin: 18px 0;
        user-select: all;
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.5);
      }

      /* Floating Toast */
      .toast-container-custom {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1100;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
      }

      .toast-dark {
        pointer-events: auto;
        background-color: #2B2B36;
        border: 1px solid rgba(229, 231, 235, 0.18);
        border-radius: 12px;
        padding: 14px 18px;
        color: #FFFFFF;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45);
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 320px;
        max-width: 420px;
        animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        transition: all 0.3s ease;
      }

      .toast-dark.toast-success { border-left: 4px solid #10B981; }
      .toast-dark.toast-error   { border-left: 4px solid #EF4444; }
      .toast-dark.toast-warning { border-left: 4px solid #F59E0B; }
      .toast-dark.toast-info    { border-left: 4px solid #3B82F6; }

      .toast-icon { font-size: 1.25rem; }
      .toast-success .toast-icon { color: #10B981; }
      .toast-error   .toast-icon { color: #EF4444; }
      .toast-warning .toast-icon { color: #F59E0B; }
      .toast-info    .toast-icon { color: #3B82F6; }

      .toast-body-text { flex: 1; }
      .toast-title { font-size: 0.85rem; font-weight: 700; margin-bottom: 2px; }
      .toast-message { font-size: 0.78rem; color: #D1D5DB; line-height: 1.35; }

      .toast-close-btn {
        background: transparent;
        border: none;
        color: #9CA3AF;
        font-size: 1rem;
        cursor: pointer;
        padding: 2px;
      }
      .toast-close-btn:hover { color: #FFFFFF; }

      @keyframes toastSlideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
      }

      ::-webkit-scrollbar { width: 8px; height: 8px; }
      ::-webkit-scrollbar-track { background: #18181D; }
      ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
      ::-webkit-scrollbar-thumb:hover { background: #4B5563; }

      /* ===== INLINE VALIDATION (sama persis dengan Designator & KML) ===== */
      .dark-invalid-feedback {
        color: #F87171;
        font-size: 0.79rem;
        margin-top: 6px;
        font-weight: 500;
      }

      .dark-form-control.is-invalid {
        border-color: #EF4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
      }
    </style>
  </head>
  <!--end::Head-->

  <!--begin::Body-->
  <body class="network-routing-body">
    <div class="network-app-wrapper">
      
      <!-- Header & Navbar (Dark Telkom Red) -->
      @include('partials.navbar', ['pageSubtitle' => 'Admin Panel'])

      <!-- Main Layout: Sidebar Rail + Workspace -->
      <div class="network-main-layout">
        <!-- Far Left Mini Rail Sidebar -->
        @include('partials.sidebar')

        <!-- Workspace Container -->
        <main class="network-workspace-container">
          
          <!-- Top Page Header Intro -->
          <div class="page-intro-header">
            <div class="page-title-group">
              <div class="page-title-icon">
                <i class="bi bi-people-fill"></i>
              </div>
              <div class="page-title-text">
                <h1>Kelola Akun Pegawai</h1>
                <p>Manajemen pendaftaran, kredensial, dan status akun staf teknis Telkom Akses</p>
              </div>
            </div>

            <!-- Action: Tambah Pegawai Baru -->
            <button type="button" class="btn-telkom-red" data-bs-toggle="modal" data-bs-target="#addPegawaiModal">
              <i class="bi bi-person-plus-fill"></i>
              <span>Tambah Pegawai Baru</span>
            </button>
          </div>

          <!-- Main Table Card -->
          <div class="matrix-table-card">

            <!-- Toolbar -->
            <div class="matrix-toolbar">
              <div class="toolbar-left">
                <div class="dark-search-wrapper">
                  <i class="bi bi-search dark-search-icon"></i>
                  <input type="text" class="dark-search-input" id="pegawaiSearchInput" placeholder="Cari nama pegawai atau email..." autocomplete="off">
                </div>
              </div>

              <div class="toolbar-right">
                <span class="badge-rows-counter" id="pegawaiCountBadge">
                  <i class="bi bi-person-badge text-danger"></i>
                  <span id="pegawaiCountText">{{ $totalPegawai }} Pegawai Terdaftar</span>
                </span>
              </div>
            </div>

            <!-- Table Scroll Container -->
            <div class="matrix-scroll-container">
              <table class="matrix-clean-table" id="pegawaiTable">
                <thead>
                  <tr>
                    <th style="width: 70px; text-align: center;">NO</th>
                    <th>NAMA PEGAWAI</th>
                    <th>EMAIL</th>
                    <th>TERAKHIR LOGIN</th>
                    <th>TERDAFTAR</th>
                    <th style="width: 130px; text-align: center;">AKSI</th>
                  </tr>
                </thead>
                <tbody id="pegawaiTableBody">
                  @forelse ($pegawai as $index => $item)
                  <tr class="pegawai-table-row" data-name="{{ strtolower($item->name) }}" data-email="{{ strtolower($item->email) }}">
                    <td style="text-align: center; font-weight: 600; color: #9CA3AF;" class="row-index">
                      {{ $index + 1 }}
                    </td>
                    <td>
                      <div class="user-info-cell">
                        <div class="user-avatar">
                          {{ strtoupper(substr($item->name, 0, 1)) }}
                        </div>
                        <div>
                          <div class="user-name-text">{{ $item->name }}</div>
                          <span class="badge-role-pegawai">Pegawai</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="email-cell">
                        <i class="bi bi-envelope text-secondary"></i>
                        {{ $item->email }}
                      </span>
                    </td>
                    <td>
                      @if ($item->last_login_at)
                        <span style="color: #E5E7EB; font-weight: 500;">
                          <i class="bi bi-clock-history me-1 text-muted"></i>
                          {{ $item->last_login_at->diffForHumans() }}
                        </span>
                      @else
                        <span class="text-muted" style="font-size: 0.8rem; font-style: italic;">
                          Belum pernah login
                        </span>
                      @endif
                    </td>
                    <td style="color: #9CA3AF;">
                      <i class="bi bi-calendar3 me-1"></i>
                      {{ $item->created_at->format('d M Y') }}
                    </td>
                    <td style="text-align: center;">
                      <div class="action-btn-group">
                        <!-- Edit Button -->
                        <button type="button" class="action-btn action-edit" 
                                onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->name) }}', '{{ addslashes($item->email) }}')"
                                title="Ubah Data Pegawai">
                          <i class="bi bi-pencil-fill"></i>
                        </button>

                        <!-- Reset Password Button -->
                        <button type="button" class="action-btn action-key" 
                                onclick="openResetModal('{{ $item->id }}', '{{ addslashes($item->name) }}')"
                                title="Reset Password Pegawai">
                          <i class="bi bi-key-fill"></i>
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="action-btn action-delete" 
                                onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->name) }}')"
                                title="Hapus Akun Pegawai">
                          <i class="bi bi-trash3-fill"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="6">
                      <div class="table-empty-state">
                        <div class="empty-icon"><i class="bi bi-people"></i></div>
                        <div class="empty-text-main">Belum Ada Akun Pegawai</div>
                        <div class="empty-text-sub">Klik tombol "Tambah Pegawai Baru" di atas untuk mendaftarkan akun pegawai operasional pertama.</div>
                      </div>
                    </td>
                  </tr>
                  @endforelse

                  <!-- No Search Results Row -->
                  <tr id="noSearchResultsRow" style="display: none;">
                    <td colspan="6">

                      <div class="table-empty-state">
                        <div class="empty-icon"><i class="bi bi-search"></i></div>
                        <div class="empty-text-main">Tidak Ada Pegawai yang Cocok</div>
                        <div class="empty-text-sub">Coba gunakan kata kunci pencarian nama atau email yang berbeda.</div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </main>
      </div>
    </div>

    <!-- ===== MODAL: TAMBAH PEGAWAI BARU ===== -->
    <div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-theme-modal">
          <form id="addPegawaiForm" action="{{ route('admin.pegawai.store') }}" method="POST" novalidate>
            @csrf
            <div class="modal-header">
              <div>
                <h5 class="modal-title" id="addPegawaiModalLabel">
                  <i class="bi bi-person-plus-fill text-danger"></i>
                  Tambah Pegawai Baru
                </h5>
                <p class="modal-subtitle">Daftarkan akun staf teknis untuk operasional KML &amp; rute matrix</p>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label class="dark-form-label" for="addPegawaiName">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="dark-form-control" id="addPegawaiName" name="name" placeholder="Contoh: Ahmad Hidayat" autocomplete="off" value="{{ old('name') }}">
                <div id="addNameError" class="dark-invalid-feedback" style="display: none;"></div>
              </div>

              <div class="mb-2">
                <label class="dark-form-label" for="addPegawaiUsername">Email Pegawai <span class="text-danger">*</span></label>
                <div class="input-group dark-email-input-group">
                  <input type="text" class="form-control dark-form-control" id="addPegawaiUsername" name="email_prefix" placeholder="contoh: ahmad" autocomplete="off" value="{{ old('email_prefix', old('email') ? (str_contains(old('email'), '@') ? explode('@', old('email'))[0] : old('email')) : '') }}" oninput="updateEmailPreview()">
                  <span class="input-group-text dark-email-addon" id="emailDomainAddon">@telkom.com</span>
                </div>
                <input type="hidden" id="addPegawaiEmail" name="email" value="{{ old('email') }}">
                <div class="email-preview-text" style="font-size: 0.8rem; color: #9CA3AF; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                  <i class="bi bi-info-circle text-secondary"></i>
                  <span>Alamat email:</span>
                  <strong id="emailPreviewBadge" style="color: #60A5FA; font-family: 'JetBrains Mono', monospace; font-size: 0.84rem;">{{ old('email') ? (str_contains(old('email'), '@') ? old('email') : old('email').'@telkom.com') : (old('email_prefix') ? old('email_prefix').'@telkom.com' : '...@telkom.com') }}</strong>
                </div>
                <div id="addEmailError" class="dark-invalid-feedback" style="display: none;"></div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-secondary-pill" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn-telkom-red" onclick="submitAddPegawai()">
                <i class="bi bi-check-circle-fill"></i>
                <span>Buat Akun Pegawai</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== MODAL: EDIT PEGAWAI ===== -->
    <div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-theme-modal" style="border-color: rgba(59, 130, 246, 0.4) !important;">
          <form id="editPegawaiForm" method="POST" action="" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-header" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.35) 0%, rgba(43, 43, 54, 0.95) 100%) !important;">
              <div>
                <h5 class="modal-title" id="editPegawaiModalLabel">
                  <i class="bi bi-pencil-square text-primary"></i>
                  Ubah Data Pegawai
                </h5>
                <p class="modal-subtitle">Perbarui informasi profil akun pegawai</p>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label class="dark-form-label" for="editPegawaiName">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="dark-form-control" id="editPegawaiName" name="name" placeholder="Nama pegawai" autocomplete="off">
                <div id="editNameError" class="dark-invalid-feedback" style="display: none;"></div>
              </div>

              <div class="mb-2">
                <label class="dark-form-label" for="editPegawaiEmail">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" class="dark-form-control" id="editPegawaiEmail" name="email" placeholder="Email pegawai" autocomplete="off">
                <div id="editEmailError" class="dark-invalid-feedback" style="display: none;"></div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-secondary-pill" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn-telkom-red" style="background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);" onclick="submitEditPegawai()">
                <i class="bi bi-save-fill"></i>
                <span>Simpan Perubahan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== MODAL: RESET PASSWORD CONFIRMATION ===== -->
    <div class="modal fade" id="resetConfirmModal" tabindex="-1" aria-labelledby="resetConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-theme-modal" style="border-color: rgba(245, 158, 11, 0.4) !important;">
          <form id="resetPasswordForm" method="POST" action="">
            @csrf
            <div class="modal-header" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.35) 0%, rgba(43, 43, 54, 0.95) 100%) !important;">
              <div>
                <h5 class="modal-title" id="resetConfirmModalLabel">
                  <i class="bi bi-key-fill text-warning"></i>
                  Konfirmasi Reset Password
                </h5>
                <p class="modal-subtitle">Generate kata sandi baru untuk pegawai ini</p>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p style="color: #E5E7EB; font-size: 0.95rem; line-height: 1.5; margin-bottom: 12px;">
                Reset kata sandi untuk akun pegawai:
              </p>
              <div style="background-color: #111827; border: 1px solid #374151; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px;">
                <span style="color: #9CA3AF; font-size: 0.8rem; display: block;">Nama Pegawai:</span>
                <span id="resetTargetName" style="color: #FFFFFF; font-weight: 700; font-size: 1.05rem;"></span>
              </div>
              <div class="dark-info-box" style="background-color: rgba(245, 158, 11, 0.12); border-color: rgba(245, 158, 11, 0.3); color: #FCD34D;">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-warning flex-shrink-0"></i>
                <div>
                  Password lama akan langsung tidak berlaku. Password baru akan segera ditampilkan di layar untuk Anda salin dan bagikan ke pegawai terkait.
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn-secondary-pill" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn-telkom-red" style="background: linear-gradient(135deg, #D97706 0%, #B45309 100%);">
                <i class="bi bi-key-fill"></i>
                <span>Ya, Reset Password</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== MODAL: DELETE CONFIRMATION ===== -->
    <div class="modal fade" id="deletePegawaiModal" tabindex="-1" aria-labelledby="deletePegawaiModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-theme-modal" style="border-color: rgba(239, 68, 68, 0.4) !important;">
          <form id="deletePegawaiForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-header">
              <div>
                <h5 class="modal-title" id="deletePegawaiModalLabel">
                  <i class="bi bi-trash3-fill text-danger"></i>
                  Hapus Akun Pegawai
                </h5>
                <p class="modal-subtitle">Tindakan ini akan menghapus akun secara permanen</p>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p style="color: #E5E7EB; font-size: 0.95rem; line-height: 1.5; margin-bottom: 12px;">
                Apakah Anda yakin ingin menghapus akun pegawai berikut secara permanen?
              </p>
              <div style="background-color: #111827; border: 1px solid #374151; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px;">
                <span style="color: #9CA3AF; font-size: 0.8rem; display: block;">Nama Pegawai:</span>
                <span id="deleteTargetName" style="color: #EF4444; font-weight: 700; font-size: 1.05rem;"></span>
              </div>
              <div class="dark-info-box" style="background-color: rgba(239, 68, 68, 0.12); border-color: rgba(239, 68, 68, 0.3); color: #FCA5A5;">
                <i class="bi bi-exclamation-octagon-fill fs-5 text-danger flex-shrink-0"></i>
                <div>
                  <strong>Peringatan:</strong> Seluruh data akun pegawai ini akan dihapus dari sistem dan tidak dapat dipulihkan.
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn-secondary-pill" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn-telkom-red">
                <i class="bi bi-trash3-fill"></i>
                <span>Ya, Hapus Permanen</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== MODAL: DISPLAY NEW PASSWORD ===== -->
    @if (session('new_password'))
    <div class="modal fade" id="passwordModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-theme-modal" style="border-color: rgba(16, 185, 129, 0.4) !important;">
          <div class="modal-header" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.4) 0%, rgba(43, 43, 54, 0.95) 100%) !important;">
            <div>
              <h5 class="modal-title text-white">
                <i class="bi bi-key-fill text-success"></i>
                Password Berhasil Dibuat
              </h5>
              <p class="modal-subtitle">Kredensial login akun pegawai siap dibagikan</p>
            </div>
          </div>
          <div class="modal-body text-center">
            <div style="background-color: #111827; border-radius: 10px; padding: 14px; margin-bottom: 16px; border: 1px solid #374151; text-align: left;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span style="color: #9CA3AF; font-size: 0.8rem;">Nama:</span>
                <span style="color: #FFFFFF; font-weight: 700; font-size: 0.92rem;">{{ session('new_user_name') }}</span>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span style="color: #9CA3AF; font-size: 0.8rem;">Email:</span>
                <span style="color: #D1D5DB; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">{{ session('new_user_email') }}</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span style="color: #9CA3AF; font-size: 0.8rem;">Role:</span>
                <span class="badge-role-pegawai">PEGAWAI</span>
              </div>
            </div>

            <div class="dark-info-box" style="background-color: rgba(245, 158, 11, 0.12); border-color: rgba(245, 158, 11, 0.3); color: #FCD34D; text-align: left;">
              <i class="bi bi-exclamation-triangle-fill fs-5 text-warning flex-shrink-0"></i>
              <div>
                <strong>PENTING!</strong> Password ini hanya ditampilkan sekali demi keamanan. Segera salin dan bagikan kepada pegawai terkait.
              </div>
            </div>

            <!-- Monospace Password Field -->
            <div class="password-display-box" id="passwordBox">
              {{ session('new_password') }}
            </div>

            <button type="button" class="btn-secondary-pill w-100 justify-content-center py-2" id="copyPasswordBtn" onclick="copyGeneratedPassword()">
              <i class="bi bi-clipboard-check me-1" id="copyIcon"></i>
              <span id="copyBtnText">Salin Password ke Clipboard</span>
            </button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-telkom-red w-100 justify-content-center" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
              <i class="bi bi-check-lg me-1"></i>
              <span>Saya Sudah Menyimpan Password</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Floating Toast Notifications Container -->
    <div class="toast-container-custom" id="toastContainer">
      @if (session('success'))
        <div class="toast-dark toast-success" role="alert">
          <i class="bi bi-check-circle-fill toast-icon"></i>
          <div class="toast-body-text">
            <div class="toast-title">Berhasil</div>
            <div class="toast-message">{{ session('success') }}</div>
          </div>
          <button type="button" class="toast-close-btn" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
      @endif

      @if (session('error'))
        <div class="toast-dark toast-error" role="alert">
          <i class="bi bi-exclamation-octagon-fill toast-icon"></i>
          <div class="toast-body-text">
            <div class="toast-title">Terjadi Kesalahan</div>
            <div class="toast-message">{{ session('error') }}</div>
          </div>
          <button type="button" class="toast-close-btn" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
      @endif
    </div>

    <!-- Floating Toast Notifications JS -->
    <script>
      function showToast(type, title, message, duration) {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        const icons = {
          success : 'bi-check-circle-fill',
          error   : 'bi-exclamation-octagon-fill',
          warning : 'bi-exclamation-triangle-fill',
          info    : 'bi-info-circle-fill'
        };
        const toast = document.createElement('div');
        toast.className = `toast-dark toast-${type}`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
          <i class="bi ${icons[type] || 'bi-info-circle-fill'} toast-icon"></i>
          <div class="toast-body-text">
            <div class="toast-title">${title}</div>
            ${message ? `<div class="toast-message">${message}</div>` : ''}
          </div>
          <button type="button" class="toast-close-btn" onclick="this.parentElement.remove()" aria-label="Tutup">
            <i class="bi bi-x-lg"></i>
          </button>
        `;
        container.appendChild(toast);
        const ms = duration || (type === 'error' ? 8000 : 5000);
        setTimeout(() => {
          toast.style.opacity = '0';
          toast.style.transform = 'translateY(10px)';
          setTimeout(() => toast.remove(), 300);
        }, ms);
      }
      window.showToast = showToast;
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      // Show Password Modal automatically if session exists
      @if (session('new_password'))
        document.addEventListener('DOMContentLoaded', function() {
          const passModalEl = document.getElementById('passwordModal');
          if (passModalEl) {
            const passModal = new bootstrap.Modal(passModalEl);
            passModal.show();
          }
        });
      @endif

      // Copy password to clipboard with animation
      function copyGeneratedPassword() {
        const passwordText = "{{ session('new_password') }}";
        if (!passwordText) return;

        navigator.clipboard.writeText(passwordText).then(() => {
          const copyBtnText = document.getElementById('copyBtnText');
          const copyIcon = document.getElementById('copyIcon');
          
          if (copyBtnText && copyIcon) {
            copyBtnText.textContent = 'Berhasil Disalin!';
            copyIcon.className = 'bi bi-clipboard2-check-fill text-success me-1';
            
            setTimeout(() => {
              copyBtnText.textContent = 'Salin Password ke Clipboard';
              copyIcon.className = 'bi bi-clipboard-check me-1';
            }, 2500);
          }
        }).catch(err => {
          console.error('Copy failed:', err);
          showToast('error', 'Gagal Menyalin', 'Silakan salin password secara manual.');
        });
      }

      // ===== CLIENT-SIDE VALIDATION (pola sama dengan Designator & KML) =====

      // Helper: tampilkan error di bawah field (sama persis dengan designator/KML)
      function showFieldError(inputId, errorDivId, message) {
        const input = document.getElementById(inputId);
        const errEl = document.getElementById(errorDivId);
        if (input)  input.classList.add('is-invalid');
        if (errEl) { errEl.textContent = message; errEl.style.display = 'block'; }
        if (input)  input.focus();
      }

      // Helper: sembunyikan error field
      function hideFieldError(inputId, errorDivId) {
        const input = document.getElementById(inputId);
        const errEl = document.getElementById(errorDivId);
        if (input)  input.classList.remove('is-invalid');
        if (errEl)  errEl.style.display = 'none';
      }

      // Validasi format email
      function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
      }

      // Real-time update email preview badge & sync hidden email
      function updateEmailPreview() {
        const usernameInput = document.getElementById('addPegawaiUsername');
        const previewEl     = document.getElementById('emailPreviewBadge');
        const hiddenEmail   = document.getElementById('addPegawaiEmail');
        if (!usernameInput || !previewEl) return;

        let val = usernameInput.value.trim();
        // Bersihkan tanda @ jika user mengetikkan domain
        if (val.includes('@')) {
          val = val.split('@')[0].trim();
        }

        if (val) {
          const fullEmail = val + '@telkom.com';
          previewEl.textContent = fullEmail;
          if (hiddenEmail) hiddenEmail.value = fullEmail;
        } else {
          previewEl.textContent = '...@telkom.com';
          if (hiddenEmail) hiddenEmail.value = '';
        }
      }

      // Tombol "Buat Akun Pegawai" — validasi sebelum submit
      function submitAddPegawai() {
        const nameInput     = document.getElementById('addPegawaiName');
        const usernameInput = document.getElementById('addPegawaiUsername');
        const hiddenEmail   = document.getElementById('addPegawaiEmail');
        
        const name     = nameInput ? nameInput.value.trim() : '';
        let   username = usernameInput ? usernameInput.value.trim() : '';

        // Reset error dulu
        hideFieldError('addPegawaiName',     'addNameError');
        hideFieldError('addPegawaiUsername', 'addEmailError');

        let hasError = false;

        if (!name) {
          showFieldError('addPegawaiName', 'addNameError', 'Nama Lengkap wajib diisi!');
          hasError = true;
        }

        if (!username) {
          showFieldError('addPegawaiUsername', 'addEmailError', 'Email pegawai wajib diisi!');
          hasError = true;
        } else {
          // Bersihkan jika admin mengetikkan @telkom.com
          if (username.includes('@')) {
            username = username.split('@')[0].trim();
            usernameInput.value = username;
          }

          // Validasi karakter username (hanya alfanumerik, titik, strip, garis bawah)
          const usernameRegex = /^[a-zA-Z0-9._-]+$/;
          if (!usernameRegex.test(username)) {
            showFieldError('addPegawaiUsername', 'addEmailError', 'Format email tidak valid (hanya huruf, angka, titik, strip, garis bawah)!');
            hasError = true;
          } else {
            const fullEmail = username + '@telkom.com';
            if (hiddenEmail) hiddenEmail.value = fullEmail;
          }
        }

        if (hasError) return;

        // Pastikan hidden input email selalu terisi format lengkap sebelum submit
        if (hiddenEmail) {
          hiddenEmail.value = username + '@telkom.com';
        }

        // Semua valid — submit
        document.getElementById('addPegawaiForm').submit();
      }

      // Tombol "Simpan Perubahan" — validasi sebelum submit
      function submitEditPegawai() {
        const nameInput  = document.getElementById('editPegawaiName');
        const emailInput = document.getElementById('editPegawaiEmail');
        const name  = nameInput.value.trim();
        const email = emailInput.value.trim();

        // Reset error dulu
        hideFieldError('editPegawaiName',  'editNameError');
        hideFieldError('editPegawaiEmail', 'editEmailError');

        let hasError = false;

        if (!name) {
          showFieldError('editPegawaiName', 'editNameError', 'Nama Lengkap wajib diisi!');
          hasError = true;
        }
        if (!email) {
          showFieldError('editPegawaiEmail', 'editEmailError', 'Alamat Email wajib diisi!');
          hasError = true;
        } else if (!isValidEmail(email)) {
          showFieldError('editPegawaiEmail', 'editEmailError', 'Format Alamat Email tidak valid!');
          hasError = true;
        }

        if (hasError) return;

        // Semua valid — submit
        document.getElementById('editPegawaiForm').submit();
      }

      // Buka modal Edit & reset error
      function openEditModal(id, name, email) {
        const form = document.getElementById('editPegawaiForm');
        form.action = `/admin/pegawai/${id}`;

        document.getElementById('editPegawaiName').value  = name;
        document.getElementById('editPegawaiEmail').value = email;

        // Reset semua error sebelum buka
        hideFieldError('editPegawaiName',  'editNameError');
        hideFieldError('editPegawaiEmail', 'editEmailError');

        const modal = new bootstrap.Modal(document.getElementById('editPegawaiModal'));
        modal.show();
      }

      // Open Reset Password Confirmation Modal
      function openResetModal(id, name) {
        const form = document.getElementById('resetPasswordForm');
        form.action = `/admin/pegawai/${id}/reset-password`;
        document.getElementById('resetTargetName').textContent = name;
        
        const modal = new bootstrap.Modal(document.getElementById('resetConfirmModal'));
        modal.show();
      }

      // Open Delete Pegawai Confirmation Modal
      function openDeleteModal(id, name) {
        const form = document.getElementById('deletePegawaiForm');
        form.action = `/admin/pegawai/${id}`;
        document.getElementById('deleteTargetName').textContent = name;
        
        const modal = new bootstrap.Modal(document.getElementById('deletePegawaiModal'));
        modal.show();
      }

      // Live Search Filter for Pegawai Table
      document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('pegawaiSearchInput');
        const rows = document.querySelectorAll('.pegawai-table-row');
        const noResultsRow = document.getElementById('noSearchResultsRow');
        const countBadge = document.getElementById('pegawaiCountText');

        if (searchInput) {
          searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            let visibleCount = 0;

            rows.forEach(row => {
              const name = row.getAttribute('data-name') || '';
              const email = row.getAttribute('data-email') || '';

              if (name.includes(query) || email.includes(query)) {
                row.style.display = '';
                visibleCount++;
                const indexCell = row.querySelector('.row-index');
                if (indexCell) indexCell.textContent = visibleCount;
              } else {
                row.style.display = 'none';
              }
            });

            if (noResultsRow) {
              noResultsRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            }

            if (countBadge) {
              countBadge.textContent = `${visibleCount} Pegawai Ditemukan`;
            }
          });
        }

        // ===== RE-OPEN MODAL & TAMPILKAN ERROR SERVER (pola sama dengan KML) =====
        @if ($errors->any())
          @if (old('name') !== null || old('email') !== null || old('email_prefix') !== null)
            (function() {
              const addModal = new bootstrap.Modal(document.getElementById('addPegawaiModal'));
              addModal.show();

              // Restore old values
              const nameVal  = @json(old('name', ''));
              let emailVal = @json(old('email', old('email_prefix', '')));
              if (emailVal.includes('@')) {
                emailVal = emailVal.split('@')[0];
              }

              const nameInput     = document.getElementById('addPegawaiName');
              const usernameInput = document.getElementById('addPegawaiUsername');
              if (nameInput) nameInput.value = nameVal;
              if (usernameInput) {
                usernameInput.value = emailVal;
                updateEmailPreview();
              }

              // Tampilkan error per field (pola dark-invalid-feedback)
              @if ($errors->has('name'))
                showFieldError('addPegawaiName', 'addNameError', @json($errors->first('name')));
              @endif
              @if ($errors->has('email'))
                showFieldError('addPegawaiUsername', 'addEmailError', @json($errors->first('email')));
              @endif
            })();
          @endif
        @endif

        // Auto-sembunyikan input error saat user mulai mengetik
        ['addPegawaiName',  'addPegawaiUsername',
         'editPegawaiName', 'editPegawaiEmail'].forEach(id => {
          const el = document.getElementById(id);
          if (!el) return;
          el.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errMap = {
              'addPegawaiName':     'addNameError',
              'addPegawaiUsername': 'addEmailError',
              'editPegawaiName':    'editNameError',
              'editPegawaiEmail':   'editEmailError'
            };
            const errEl = document.getElementById(errMap[this.id]);
            if (errEl) errEl.style.display = 'none';
          });
        });

        // Intercept form submit jika tombol Enter ditekan pada form Tambah Pegawai
        const addForm = document.getElementById('addPegawaiForm');
        if (addForm) {
          addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitAddPegawai();
          });
        }

        // Auto remove floating toast alerts after 6 seconds
        setTimeout(() => {
          const toasts = document.querySelectorAll('.toast-dark');
          toasts.forEach(t => {
            t.style.opacity = '0';
            t.style.transform = 'translateY(15px)';
            setTimeout(() => t.remove(), 300);
          });
        }, 6000);
      });
    </script>
  </body>
  <!--end::Body-->
</html>
