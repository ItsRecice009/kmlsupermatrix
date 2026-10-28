<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Telkom Akses - Data Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Custom Telkom Red Glassmorphism Dark Theme (Matching Route Matrix) -->
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

      .header-icon-btn:hover {
        transform: scale(1.1);
      }

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

      /* Page Banner / Header Card */
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
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.2) 0%, rgba(185, 28, 28, 0.3) 100%);
        border: 1px solid rgba(220, 38, 38, 0.4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #EF4444;
        font-size: 1.5rem;
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.25);
      }

      .page-title-text h1 {
        font-size: 1.45rem;
        font-weight: 800;
        color: #FFFFFF;
        margin: 0 0 4px 0;
        letter-spacing: -0.3px;
      }

      /* ========== MAIN MATRIX CARD ========== */
      .matrix-table-card {
        background-color: #24242F;
        border-radius: 14px;
        border-top-left-radius: 0 !important;
        overflow: hidden;
        border: 1.5px solid rgba(229, 231, 235, 0.15);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 1;
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

      .dark-search-input::placeholder,
      .dark-form-control::placeholder {
        color: #9CA3AF !important;
        opacity: 1 !important;
      }

      .dark-search-input:focus {
        border-color: #DC2626;
        color: #FFFFFF;
        background-color: #111827;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25);
        outline: none;
      }

      .dark-select-entries {
        background-color: #111827;
        border: 1px solid #374151;
        color: #F3F4F6;
        border-radius: 8px;
        font-size: 0.84rem;
        padding: 8px 12px;
        cursor: pointer;
        transition: all 0.2s ease;
      }

      .dark-select-entries option {
        background-color: #111827;
        color: #F3F4F6;
      }

      .dark-select-entries:focus {
        border-color: #DC2626;
        outline: none;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25);
      }

      .entries-label {
        font-size: 0.84rem;
        color: #E5E7EB;
        font-weight: 600;
        margin: 0;
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
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        transition: all 0.2s ease;
      }

      .btn-telkom-red:hover {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.45);
        color: #FFFFFF;
      }

      .btn-telkom-red:active {
        transform: translateY(0);
      }

      .btn-topbar-pill {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #E5E7EB;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        text-decoration: none;
      }

      .btn-topbar-pill:hover {
        background-color: #24242F;
        color: #FFFFFF;
        border-color: #4B5563;
      }

      /* ========== MATRIX CLEAN TABLE ========== */
      .matrix-scroll-container {
        overflow-x: auto;
        overflow-y: auto;
        max-height: calc(100vh - 280px);
      }

      .matrix-clean-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
        background-color: #2B2B36;
        color: #E5E7EB;
      }

      .matrix-clean-table thead {
        position: sticky;
        top: 0;
        z-index: 20;
        background-color: #1E1E24;
      }

      .matrix-clean-table th {
        background-color: #1E1E24 !important;
        color: #FFFFFF !important;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        padding: 12px 16px !important;
        border-bottom: 1.5px solid rgba(229, 231, 235, 0.15) !important;
        border-top: none;
        border-left: none;
        border-right: none;
        text-align: left;
        vertical-align: middle;
        white-space: nowrap;
        text-transform: uppercase;
      }

      .matrix-clean-table tbody tr {
        transition: background-color 0.15s ease;
        background-color: #2B2B36;
      }

      .matrix-clean-table tbody tr:nth-child(even) {
        background-color: #24242F;
      }

      .matrix-clean-table tbody tr:hover {
        background-color: #353542 !important;
      }

      .matrix-clean-table td {
        padding: 12px 16px !important;
        font-size: 0.85rem;
        color: #F3F4F6;
        border-bottom: 1px solid rgba(229, 231, 235, 0.08) !important;
        border-top: none;
        border-left: none;
        border-right: none;
        vertical-align: middle;
      }

      .td-number {
        font-weight: 600;
        color: #E2E8F0 !important;
        width: 70px;
        text-align: center;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
      }

      .designator-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #FFFFFF;
        font-size: 0.88rem;
      }

      .designator-tag-icon {
        color: #EF4444;
        font-size: 0.85rem;
      }

      .rumus-code-badge {
        font-family: 'JetBrains Mono', monospace;
        background: #18181D;
        color: #FCA5A5;
        border: 1px solid rgba(248, 113, 113, 0.35);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.82rem;
        display: inline-block;
        max-width: 100%;
        word-break: break-all;
        letter-spacing: 0.2px;
      }

      .rumus-empty {
        color: #9CA3AF;
        font-style: italic;
        font-size: 0.83rem;
        font-weight: 400;
      }

      /* Action Icon Buttons */
      .action-btn-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
      }

      .action-pill-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
      }

      .action-edit {
        background-color: rgba(245, 158, 11, 0.15);
        color: #FBBF24;
        border-color: rgba(245, 158, 11, 0.3);
      }

      .action-edit:hover {
        background-color: #F59E0B;
        color: #000000;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.4);
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

      /* Table Footer & Pagination */
      .matrix-footer {
        padding: 14px 20px;
        background-color: #24242F;
        border-top: 1px solid rgba(229, 231, 235, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
      }

      .footer-info-text {
        font-size: 0.85rem;
        color: #E5E7EB;
        font-weight: 500;
        margin: 0;
      }

      .pagination-controls {
        display: flex;
        align-items: center;
        gap: 6px;
      }

      .page-nav-btn {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #F3F4F6;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }

      .page-nav-btn:hover:not(:disabled) {
        background-color: #374151;
        color: #FFFFFF;
        border-color: #4B5563;
      }

      .page-nav-btn:disabled {
        opacity: 0.45;
        color: #9CA3AF;
        border-color: #2D3748;
        cursor: not-allowed;
      }

      .page-number-pill {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 6px;
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #F3F4F6;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
      }

      .page-number-pill:hover:not(.active) {
        background-color: #374151;
        color: #FFFFFF;
        border-color: #4B5563;
      }

      .page-number-pill.active {
        background-color: #DC2626;
        border-color: #DC2626;
        color: #FFFFFF;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
      }

      .pagination-ellipsis {
        color: #E5E7EB;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 2px;
        padding: 0 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        user-select: none;
      }

      /* Global text-muted override for dark mode contrast */
      .network-app-wrapper .text-muted,
      .modal-content .text-muted {
        color: #9CA3AF !important;
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
        color: #D1D5DB;
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

      .dark-theme-modal .btn-close:focus {
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.4) !important;
        outline: none !important;
      }

      .dark-theme-modal .modal-body {
        padding: 24px;
        background-color: #25252D;
      }

      .dark-theme-modal .modal-footer {
        background-color: #1E1E24;
        border-top: 1px solid rgba(229, 231, 235, 0.1);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
      }

      /* Dark Form Inputs */
      .dark-form-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #E5E7EB;
        margin-bottom: 6px;
        display: block;
      }

      .dark-form-control {
        background-color: #111827 !important;
        border: 1px solid #374151 !important;
        color: #FFFFFF !important;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.85rem;
        width: 100%;
        transition: all 0.2s ease;
      }

      .dark-form-control:focus {
        border-color: #DC2626 !important;
        background-color: #111827 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25) !important;
        outline: none !important;
        color: #FFFFFF !important;
      }

      .dark-form-control.is-invalid {
        border-color: #EF4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
      }

      .dark-input-hint {
        font-size: 0.77rem;
        color: #9CA3AF;
        margin-top: 6px;
        display: block;
      }

      .dark-invalid-feedback {
        color: #F87171;
        font-size: 0.79rem;
        margin-top: 6px;
        font-weight: 500;
      }

      /* Dark Toast / Floating Alerts */
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

      .toast-dark.toast-success {
        border-left: 4px solid #10B981;
      }

      .toast-dark.toast-error {
        border-left: 4px solid #EF4444;
      }

      .toast-dark.toast-warning {
        border-left: 4px solid #F59E0B;
      }

      .toast-dark.toast-info {
        border-left: 4px solid #3B82F6;
      }

      .toast-icon {
        font-size: 1.25rem;
      }

      .toast-success .toast-icon { color: #10B981; }
      .toast-error .toast-icon { color: #EF4444; }
      .toast-warning .toast-icon { color: #F59E0B; }
      .toast-info .toast-icon { color: #3B82F6; }

      .toast-body-text {
        flex: 1;
      }

      .toast-title {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 2px;
      }

      .toast-message {
        font-size: 0.78rem;
        color: #D1D5DB;
        line-height: 1.35;
      }

      .toast-close-btn {
        background: transparent;
        border: none;
        color: #9CA3AF;
        font-size: 1rem;
        cursor: pointer;
        padding: 2px;
      }

      .toast-close-btn:hover {
        color: #FFFFFF;
      }

      @keyframes toastSlideIn {
        from {
          transform: translateY(20px);
          opacity: 0;
        }
        to {
          transform: translateY(0);
          opacity: 1;
        }
      }

      /* Custom Scrollbars */
      ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
      }

      ::-webkit-scrollbar-track {
        background: #18181D;
      }

      ::-webkit-scrollbar-thumb {
        background: #374151;
        border-radius: 4px;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #4B5563;
      }

      /* ========== DATA MANAGER TOP TABS BAR (DESIGNATOR & KML) ========== */
      .data-manager-tabs-container {
        display: flex;
        align-items: flex-end;
        gap: 0;
        margin-bottom: -1.5px;
        z-index: 10;
        position: relative;
        padding-left: 0;
        margin-left: 0;
      }

      .data-tab-nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 26px;
        font-size: 0.92rem;
        font-weight: 600;
        color: #9CA3AF;
        background: #181822;
        border: 1.5px solid rgba(229, 231, 235, 0.15);
        border-bottom: 1.5px solid rgba(229, 231, 235, 0.15);
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        cursor: pointer;
        transition: color 0.18s ease, background 0.18s ease;
        text-decoration: none;
        position: relative;
        user-select: none;
        margin-right: -1.5px;
      }

      .data-tab-nav-btn:hover:not(.active) {
        color: #FFFFFF;
        background: #20202A;
        border-color: rgba(220, 38, 38, 0.35);
        border-bottom-color: rgba(229, 231, 235, 0.15);
      }

      .data-tab-nav-btn.active {
        color: #FFFFFF;
        background: #24242F;
        border-color: rgba(229, 231, 235, 0.15);
        border-bottom: 2px solid #24242F !important;
        font-weight: 700;
        z-index: 12;
        box-shadow: none;
      }


      .data-tab-nav-btn .tab-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.08);
        color: #D1D5DB;
        transition: all 0.2s;
      }

      .data-tab-nav-btn.active .tab-badge {
        background: rgba(220, 38, 38, 0.25);
        color: #FCA5A5;
        border: 1px solid rgba(220, 38, 38, 0.35);
      }

      /* Quick Stats Grid for KML */
      .kml-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        padding: 16px 20px;
        background: #24242F;
        border-bottom: 1px solid rgba(229, 231, 235, 0.08);
      }

      .kml-stat-card {
        background: rgba(43, 43, 54, 0.6);
        border: 1px solid rgba(229, 231, 235, 0.1);
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: transform 0.2s, border-color 0.2s;
      }

      .kml-stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(220, 38, 38, 0.35);
      }

      .kml-stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
      }

      .kml-stat-icon.red {
        background: rgba(220, 38, 38, 0.15);
        color: #EF4444;
        border: 1px solid rgba(220, 38, 38, 0.3);
      }

      .kml-stat-icon.blue {
        background: rgba(37, 99, 235, 0.15);
        color: #60A5FA;
        border: 1px solid rgba(37, 99, 235, 0.3);
      }

      .kml-stat-icon.amber {
        background: rgba(245, 158, 11, 0.15);
        color: #FBBF24;
        border: 1px solid rgba(245, 158, 11, 0.3);
      }

      .kml-stat-icon.green {
        background: rgba(16, 185, 129, 0.15);
        color: #34D399;
        border: 1px solid rgba(16, 185, 129, 0.3);
      }

      .kml-stat-number {
        font-size: 1.2rem;
        font-weight: 800;
        color: #FFFFFF;
        line-height: 1.2;
      }

      .kml-stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.4px;
      }

      /* Badges for KML Status */
      .badge-kml-validated {
        background: rgba(16, 185, 129, 0.15);
        color: #34D399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }

      .badge-kml-draft {
        background: rgba(245, 158, 11, 0.15);
        color: #FBBF24;
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }

      .badge-kml-exported {
        background: rgba(59, 130, 246, 0.15);
        color: #60A5FA;
        border: 1px solid rgba(59, 130, 246, 0.3);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }



      .action-pill-btn.action-map {
        background-color: rgba(245, 158, 11, 0.15);
        color: #FBBF24;
        border-color: rgba(245, 158, 11, 0.3);
      }
      .action-pill-btn.action-map:hover {
        background-color: #F59E0B;
        color: #000000;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.45);
        transform: scale(1.08);
      }
    </style>
  </head>
  <!--end::Head-->

  <!--begin::Body-->
  <body class="network-routing-body">
    <!--begin::App Wrapper-->
    <div class="network-app-wrapper">
      <!-- Header & Navbar (Dark Telkom Red) -->
      @include('partials.navbar', ['pageSubtitle' => 'Data Manager'])

      <!-- Main Layout: Sidebar Rail + Workspace -->
      <div class="network-main-layout">
        <!-- Far Left Mini Rail Sidebar -->
        @include('partials.sidebar')

        <!-- Workspace Container -->
        <main class="network-workspace-container">
          
          <!-- Top Page Header Intro -->
          <div class="page-intro-header">
            <div class="page-title-group">
              <div class="page-title-icon" id="pageTitleIcon">
                <i class="bi bi-grid-1x2-fill"></i>
              </div>
              <div class="page-title-text">
                <h1 id="pageTitleHeading">Master Data Designator</h1>
                <p id="pageTitleSubheading" class="text-muted mb-0" style="font-size: 0.85rem; color: #9CA3AF !important;">Kelola basis data master designator & rumus kalkulasi kabel fiber optik</p>
              </div>
            </div>
          </div>

          <!-- Data Manager Tabs Navigation (Designator & KML) -->
          <div class="data-manager-tabs-container">
            <button type="button" class="data-tab-nav-btn active" id="tabBtnDesignator" onclick="switchDataTab('designator')">
              <i class="bi bi-grid-fill"></i>
              <span>Designator</span>
              <span class="tab-badge" id="badgeDesignatorCount">...</span>
            </button>
            <button type="button" class="data-tab-nav-btn" id="tabBtnKml" onclick="switchDataTab('kml')">
              <i class="bi bi-geo-alt-fill"></i>
              <span>KML</span>
              <span class="tab-badge" id="badgeKmlCount">...</span>
            </button>
          </div>

          <!-- Main Table Card -->
          <div class="matrix-table-card">
            <!-- ===== PANEL 1: MASTER DESIGNATOR ===== -->
            <div id="panelDesignator" class="data-tab-panel">
              <!-- Toolbar -->
              <div class="matrix-toolbar">
                <div class="toolbar-left">
                  <!-- Entries per page -->
                  <div class="d-flex align-items-center gap-2">
                    <label for="showEntries" class="entries-label">Tampilkan:</label>
                    <select class="dark-select-entries" id="showEntries">
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="all">Semua Data</option>
                    </select>
                  </div>

                  <!-- Search Input -->
                  <div class="dark-search-wrapper">
                    <i class="bi bi-search dark-search-icon"></i>
                    <input type="text" class="dark-search-input" id="searchInput" placeholder="Cari nama designator atau rumus..." autocomplete="off">
                  </div>
                </div>

                <div class="toolbar-right">
                  @auth
                    @if(Auth::user()->canManageDesignators())
                      <button type="button" class="btn-telkom-red" id="addDesignatorBtn">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Tambah Designator</span>
                      </button>
                    @else
                      <div class="badge bg-secondary px-3 py-2" style="font-size: 0.8rem;">
                        <i class="bi bi-lock me-1"></i> Mode Read-Only
                      </div>
                    @endif
                  @else
                    <a href="{{ route('login') }}" class="btn-telkom-red">
                      <i class="bi bi-box-arrow-in-right"></i>
                      <span>Login untuk Mengelola</span>
                    </a>
                  @endauth
                </div>
              </div>

              <!-- Table Scroll Container -->
              <div class="matrix-scroll-container">
                <table class="matrix-clean-table">
                  <thead>
                    <tr>
                      <th style="width: 70px; text-align: center;">NO</th>
                      <th>NAMA DESIGNATOR</th>
                      <th>RUMUS EXCEL</th>
                      @auth
                        @if(Auth::user()->canManageDesignators())
                          <th style="width: 120px; text-align: center;">AKSI</th>
                        @endif
                      @endauth
                    </tr>
                  </thead>
                  <tbody id="designatorTableBody">
                    <!-- Will be populated by JS -->
                    <tr>
                      <td colspan="4" class="text-center py-5">
                        <div class="spinner-border text-danger spinner-border-sm me-2" role="status"></div>
                        <span style="color: #E5E7EB; font-size: 0.9rem; font-weight: 500;">Memuat data dari database...</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Table Footer -->
              <div class="matrix-footer">
                <p class="footer-info-text" id="tableInfo">Menampilkan 0 dari 0 data</p>

                <!-- Pagination Controls -->
                <div class="pagination-controls" id="paginationControls">
                  <!-- Page numbers generated by JS -->
                </div>
              </div>
            </div>

            <!-- ===== PANEL 2: TAMPUNGAN DATABASE KML ===== -->
            <div id="panelKml" class="data-tab-panel" style="display: none;">

              <!-- KML Toolbar -->
              <div class="matrix-toolbar">
                <div class="toolbar-left">
                  <!-- Entries per page -->
                  <div class="d-flex align-items-center gap-2">
                    <label for="showKmlEntries" class="entries-label">Tampilkan:</label>
                    <select class="dark-select-entries" id="showKmlEntries">
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="all">Semua Data</option>
                    </select>
                  </div>

                  <!-- Search Input -->
                  <div class="dark-search-wrapper" style="width: 300px;">
                    <i class="bi bi-search dark-search-icon"></i>
                    <input type="text" class="dark-search-input" id="searchKmlInput" placeholder="Cari nama proyek, area, surveyor..." autocomplete="off">
                  </div>
                </div>

                <div class="toolbar-right">
                  @auth
                    @if(Auth::user()->canManageDesignators())
                      <button type="button" class="btn-telkom-red" id="openUploadKmlBtn">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        <span>Upload File KML</span>
                      </button>
                    @endif
                  @endauth
                </div>
              </div>

              <!-- KML Table Scroll Container -->
              <div class="matrix-scroll-container">
                <table class="matrix-clean-table">
                  <thead>
                    <tr>
                      <th style="width: 60px; text-align: center;">NO</th>
                      <th>NAMA PROYEK / BERKAS KML</th>
                      <th>AREA / WITEL</th>
                      <th>TANGGAL SURVEI</th>
                      <th>DIBUAT OLEH</th>
                      <th style="width: 110px; text-align: center;">AKSI</th>
                    </tr>
                  </thead>
                  <tbody id="kmlTableBody">
                    <tr>
                      <td colspan="6" class="text-center py-5">
                        <div class="spinner-border text-danger spinner-border-sm me-2" role="status"></div>
                        <span style="color: #E5E7EB; font-size: 0.9rem; font-weight: 500;">Memuat database KML...</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- KML Table Footer -->
              <div class="matrix-footer">
                <p class="footer-info-text" id="kmlTableInfo">Menampilkan 0 dari 0 data KML</p>

                <!-- Pagination Controls -->
                <div class="pagination-controls" id="kmlPaginationControls">
                  <!-- Page numbers generated by JS -->
                </div>
              </div>
            </div>
          </div>

        </main>
      </div>
    </div>
    <!--end::App Wrapper-->

    <!-- Toast Notification Container -->
    <div class="toast-container-custom" id="toastContainer"></div>

    <!-- Modal Add / Edit Designator (Dark Theme Glassmorphism - Matching Route Matrix) -->
    <div class="modal fade" id="designatorModal" tabindex="-1" aria-labelledby="designatorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content dark-theme-modal">
          <div class="modal-header">
            <div>
              <h5 class="modal-title" id="designatorModalLabel">
                <i class="bi bi-tag-fill me-2 text-danger"></i>
                <span id="modalTitleText">Tambah Designator Baru</span>
              </h5>
              <p class="modal-subtitle" id="modalSubtitleText">Masukkan rincian item material kabel dan formula perhitungan</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="designatorForm" onsubmit="event.preventDefault(); saveDesignator();">
              <input type="hidden" id="designatorId">

              <div class="mb-3">
                <label for="designatorName" class="dark-form-label">
                  Nama Designator <span class="text-danger">*</span>
                </label>
                <input type="text" class="dark-form-control" id="designatorName" placeholder="Misal: ODC-C-48, TIANG-7M, dll." autocomplete="off">
                <div id="errorMessage" class="dark-invalid-feedback" style="display: none;"></div>
              </div>

              <div class="mb-2">
                <label for="designatorRumus" class="dark-form-label">
                  Rumus Formula Excel <span style="color: #9CA3AF; font-weight: 400;">(Opsional)</span>
                </label>
                <input type="text" class="dark-form-control" id="designatorRumus" placeholder='Contoh: =IF($F12="AC-OF-SM-ADSS-12D",$E12,0)' autocomplete="off" style="font-family: 'JetBrains Mono', monospace;">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-topbar-pill" data-bs-dismiss="modal">
              <i class="bi bi-x"></i>
              <span>Batal</span>
            </button>
            <button type="button" class="btn-telkom-red" id="saveDesignatorBtn">
              <i class="bi bi-check-lg"></i>
              <span id="saveBtnText">Simpan Data</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Konfirmasi Hapus (Dark Theme - Matching Route Matrix) -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content dark-theme-modal text-center p-2">
          <div class="modal-body pt-4">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(239, 68, 68, 0.15); color: #EF4444; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 16px auto; border: 1px solid rgba(239, 68, 68, 0.3);">
              <i class="bi bi-trash3-fill"></i>
            </div>
            <h5 class="fw-bold mb-2">Hapus Designator?</h5>
            <p class="mb-0" style="color: #D1D5DB; font-size: 0.88rem;" id="deleteConfirmText">
              Tindakan ini akan menghapus data designator secara permanen dari database.
            </p>
          </div>
          <div class="modal-footer justify-content-center border-0 pt-1 pb-3">
            <button type="button" class="btn-topbar-pill px-3" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn-telkom-red px-3" id="confirmDeleteBtn">
              <i class="bi bi-trash-fill"></i>
              <span>Ya, Hapus</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== MODAL 1: UPLOAD FILE KML KE DATABASE ===== -->
    <div class="modal fade" id="uploadKmlModal" tabindex="-1" aria-labelledby="uploadKmlModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content dark-theme-modal">
          <div class="modal-header">
            <div>
              <h5 class="modal-title" id="uploadKmlModalLabel">
                <i class="bi bi-cloud-arrow-up-fill me-2 text-danger"></i>
                <span>Upload & Simpan Berkas KML</span>
              </h5>
              <p class="modal-subtitle">Impor data placemark & rute KML langsung ke database tampungan</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="uploadKmlForm" onsubmit="event.preventDefault(); submitUploadKml();">
              <div class="mb-3">
                <label for="kmlProjectName" class="dark-form-label">
                  Nama Proyek / Rute <span class="text-danger">*</span>
                </label>
                <input type="text" class="dark-form-control" id="kmlProjectName" placeholder="Contoh: Rute Distribusi ODP-GTL Cluster A" required autocomplete="off">
              </div>

              <div class="mb-3">
                <label for="kmlArea" class="dark-form-label">
                  Area / Witel / Sub-Witel <span class="text-danger">*</span>
                </label>
                <input type="text" class="dark-form-control" id="kmlArea" placeholder="Contoh: Witel Gorontalo" required autocomplete="off">
              </div>

              <div class="mb-3">
                <label for="kmlTanggalSurvei" class="dark-form-label">
                  Tanggal Survei <span class="text-danger">*</span>
                </label>
                <input type="date" class="dark-form-control" id="kmlTanggalSurvei" required>
              </div>

              <div class="mb-3">
                <label for="kmlFileInput" class="dark-form-label">
                  Pilih File KML (.kml / .xml) <span class="text-danger">*</span>
                </label>
                <input type="file" class="dark-form-control" id="kmlFileInput" accept=".kml,.xml" required style="padding: 7px 12px;">
                <div class="form-text" style="color: #9CA3AF; font-size: 0.76rem; margin-top: 5px;">
                  Sistem akan otomatis mengekstrak placemark, koordinat, dan menghitung jarak bentangan kabel.
                </div>
              </div>

              <div id="uploadErrorMessage" class="dark-invalid-feedback" style="display: none; margin-bottom: 12px;"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-topbar-pill" data-bs-dismiss="modal">
              <i class="bi bi-x"></i>
              <span>Batal</span>
            </button>
            <button type="button" class="btn-telkom-red" id="submitUploadKmlBtn" onclick="submitUploadKml()">
              <i class="bi bi-check-lg"></i>
              <span id="submitUploadBtnText">Unggah ke Database</span>
            </button>
          </div>
        </div>
      </div>
    </div>


    <!-- ===== MODAL EDIT PROYEK KML ===== -->
    <div class="modal fade" id="editKmlModal" tabindex="-1" aria-labelledby="editKmlModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content dark-theme-modal">
          <div class="modal-header">
            <div>
              <h5 class="modal-title" id="editKmlModalLabel">
                <i class="bi bi-pencil-square me-2 text-warning"></i>
                <span>Edit Data Proyek KML</span>
              </h5>
              <p class="modal-subtitle">Perbarui nama proyek, wilayah/area, atau tanggal survei</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editKmlForm" onsubmit="event.preventDefault(); saveEditKml();">
              <input type="hidden" id="editKmlId">

              <div class="mb-3">
                <label for="editKmlName" class="dark-form-label">
                  Nama Proyek / Rute <span class="text-danger">*</span>
                </label>
                <input type="text" class="dark-form-control" id="editKmlName" placeholder="Contoh: Rute Feeder ODC Cluster B" required autocomplete="off">
              </div>

              <div class="mb-3">
                <label for="editKmlArea" class="dark-form-label">
                  Area / Witel / Sub-Witel <span class="text-danger">*</span>
                </label>
                <input type="text" class="dark-form-control" id="editKmlArea" placeholder="Contoh: Witel Gorontalo" required autocomplete="off">
              </div>

              <div class="mb-3">
                <label for="editKmlTanggalSurvei" class="dark-form-label">
                  Tanggal Survei <span class="text-danger">*</span>
                </label>
                <input type="date" class="dark-form-control" id="editKmlTanggalSurvei" required>
              </div>

              <div class="mb-3">
                <label for="editKmlFile" class="dark-form-label d-flex justify-content-between align-items-center">
                  <span>Ganti Berkas KML (Opsional)</span>
                  <span class="badge bg-secondary text-light font-monospace" style="font-size: 0.72rem;">.kml / .xml</span>
                </label>
                <input type="file" class="dark-form-control" id="editKmlFile" accept=".kml,.xml" style="padding: 7px 12px;">
                <div class="d-flex align-items-center gap-1 mt-1 text-muted" style="font-size: 0.78rem;">
                  <i class="bi bi-info-circle"></i>
                  <span>Berkas saat ini: <strong id="editKmlCurrentFileName" class="text-light">-</strong>. Kosongkan jika tidak ingin mengganti berkas KML.</span>
                </div>
              </div>

              <div id="editKmlErrorMessage" class="dark-invalid-feedback" style="display: none; margin-top: 10px;"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-topbar-pill" data-bs-dismiss="modal">
              <i class="bi bi-x"></i>
              <span>Batal</span>
            </button>
            <button type="button" class="btn-telkom-red" id="saveEditKmlBtn" onclick="saveEditKml()">
              <i class="bi bi-check-lg"></i>
              <span id="saveEditKmlBtnText">Simpan Perubahan</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== MODAL 3: KONFIRMASI HAPUS KML ===== -->
    <div class="modal fade" id="deleteKmlConfirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content dark-theme-modal text-center p-2">
          <div class="modal-body pt-4">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(239, 68, 68, 0.15); color: #EF4444; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 16px auto; border: 1px solid rgba(239, 68, 68, 0.3);">
              <i class="bi bi-trash3-fill"></i>
            </div>
            <h5 class="fw-bold mb-2">Hapus Proyek KML?</h5>
            <p class="mb-0" style="color: #D1D5DB; font-size: 0.88rem;" id="deleteKmlConfirmText">
              Hapus proyek ini secara permanen?
            </p>
          </div>
          <div class="modal-footer justify-content-center border-0 pt-1 pb-3">
            <button type="button" class="btn-topbar-pill px-3" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn-telkom-red px-3" id="confirmDeleteKmlBtn" onclick="executeDeleteKml()">
              <i class="bi bi-trash-fill"></i>
              <span>Ya, Hapus</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Designator Management Core Engine -->
    <script>
      // Auth permissions
      const userRole = @json(Auth::check() ? Auth::user()->role : 'guest');
      const canManageDesignators = @json(Auth::check() ? Auth::user()->canManageDesignators() : false);

      // State
      let designators = [];
      let filteredDesignators = [];
      let currentPage = 1;
      let entriesPerPage = 10;
      let editingId = null;
      let pendingDeleteId = null;
      let designatorModal;
      let deleteModal;

      // Toast Notification Helper
      function showToast(type, title, message) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const icons = {
          success: 'bi-check-circle-fill',
          error: 'bi-x-circle-fill',
          warning: 'bi-exclamation-triangle-fill',
          info: 'bi-info-circle-fill'
        };

        const toast = document.createElement('div');
        toast.className = `toast-dark toast-${type}`;
        toast.innerHTML = `
          <i class="bi ${icons[type] || 'bi-info-circle-fill'} toast-icon"></i>
          <div class="toast-body-text">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
          </div>
          <button type="button" class="toast-close-btn" onclick="this.parentElement.remove()">
            <i class="bi bi-x-lg"></i>
          </button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
          toast.style.opacity = '0';
          toast.style.transform = 'translateY(10px)';
          setTimeout(() => toast.remove(), 300);
        }, 4500);
      }

      // Load data from API
      async function loadDesignators() {
        try {
          const response = await fetch('/api/designators');
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          
          designators = await response.json();
          const badgeEl = document.getElementById('badgeDesignatorCount');
          if (badgeEl) badgeEl.textContent = designators.length;
          applySearch();
        } catch (error) {
          console.error('Error loading designators:', error);
          showToast('error', 'Gagal Memuat Data', 'Tidak dapat mengambil data dari database: ' + error.message);
        }
      }

      // Apply Search Filter
      function applySearch() {
        const searchInput = document.getElementById('searchInput');
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

        if (searchTerm) {
          filteredDesignators = designators.filter(d => 
            (d.nama_designator && d.nama_designator.toLowerCase().includes(searchTerm)) ||
            (d.rumus && d.rumus.toLowerCase().includes(searchTerm))
          );
        } else {
          filteredDesignators = [...designators];
        }

        currentPage = 1;
        renderTable();
      }

      // Render Table Data & Pagination
      function renderTable() {
        const tbody = document.getElementById('designatorTableBody');
        const tableInfo = document.getElementById('tableInfo');
        const paginationControls = document.getElementById('paginationControls');
        if (!tbody) return;

        const totalItems = filteredDesignators.length;
        const isAll = entriesPerPage === 'all';
        const perPage = isAll ? (totalItems || 1) : parseInt(entriesPerPage);
        const totalPages = isAll ? 1 : Math.ceil(totalItems / perPage) || 1;

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = isAll ? 0 : (currentPage - 1) * perPage;
        const endIndex = isAll ? totalItems : Math.min(startIndex + perPage, totalItems);
        const pageData = filteredDesignators.slice(startIndex, endIndex);

        // Empty state
        if (totalItems === 0) {
          const colspan = canManageDesignators ? 4 : 3;
          tbody.innerHTML = `
            <tr>
              <td colspan="${colspan}">
                <div class="table-empty-state">
                  <i class="bi bi-inbox empty-icon"></i>
                  <div class="empty-text-main">Tidak Ada Data Designator</div>
                  <div class="empty-text-sub">
                    ${document.getElementById('searchInput')?.value ? 'Tidak ada data yang cocok dengan pencarian Anda.' : 'Belum ada designator yang ditambahkan ke database.'}
                  </div>
                </div>
              </td>
            </tr>
          `;
          if (tableInfo) tableInfo.textContent = 'Menampilkan 0 dari 0 data';
          if (paginationControls) paginationControls.innerHTML = '';
          return;
        }

        // Populate Rows
        let rowsHtml = '';
        pageData.forEach((item, idx) => {
          const rowNumber = startIndex + idx + 1;
          const rumusHtml = item.rumus && item.rumus.trim() !== ''
            ? `<span class="rumus-code-badge">${escapeHtml(item.rumus)}</span>`
            : `<span class="rumus-empty">- Tidak ada rumus -</span>`;

          const actionHtml = canManageDesignators ? `
            <td style="text-align: center;">
              <div class="action-btn-group">
                <button type="button" class="action-pill-btn action-edit" onclick="openEditModal(${item.id})" title="Edit Designator">
                  <i class="bi bi-pencil-fill"></i>
                </button>
                <button type="button" class="action-pill-btn action-delete" onclick="openDeleteModal(${item.id})" title="Hapus Designator">
                  <i class="bi bi-trash3-fill"></i>
                </button>
              </div>
            </td>
          ` : '';

          rowsHtml += `
            <tr>
              <td class="td-number">${rowNumber}</td>
              <td>
                <div class="designator-chip">
                  <i class="bi bi-tag-fill designator-tag-icon"></i>
                  <span>${escapeHtml(item.nama_designator)}</span>
                </div>
              </td>
              <td>${rumusHtml}</td>
              ${actionHtml}
            </tr>
          `;
        });

        tbody.innerHTML = rowsHtml;

        // Update Info Text
        if (tableInfo) {
          tableInfo.textContent = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari total ${totalItems} data`;
        }

        // Render Pagination
        renderPagination(totalPages);
      }

      // Render Pagination Buttons
      function renderPagination(totalPages) {
        const container = document.getElementById('paginationControls');
        if (!container) return;

        if (totalPages <= 1) {
          container.innerHTML = '';
          return;
        }

        let html = '';

        // Previous button
        html += `
          <button type="button" class="page-nav-btn" onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
            <i class="bi bi-chevron-left"></i>
            <span>Prev</span>
          </button>
        `;

        // Page numbers
        const maxVisible = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);

        if (endPage - startPage + 1 < maxVisible) {
          startPage = Math.max(1, endPage - maxVisible + 1);
        }

        if (startPage > 1) {
          html += `<button type="button" class="page-number-pill" onclick="goToPage(1)">1</button>`;
          if (startPage > 2) {
            html += `<span class="pagination-ellipsis">&hellip;</span>`;
          }
        }

        for (let p = startPage; p <= endPage; p++) {
          html += `
            <button type="button" class="page-number-pill ${p === currentPage ? 'active' : ''}" onclick="goToPage(${p})">
              ${p}
            </button>
          `;
        }

        if (endPage < totalPages) {
          if (endPage < totalPages - 1) {
            html += `<span class="pagination-ellipsis">&hellip;</span>`;
          }
          html += `<button type="button" class="page-number-pill" onclick="goToPage(${totalPages})">${totalPages}</button>`;
        }

        // Next button
        html += `
          <button type="button" class="page-nav-btn" onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
            <span>Next</span>
            <i class="bi bi-chevron-right"></i>
          </button>
        `;

        container.innerHTML = html;
      }

      function goToPage(page) {
        currentPage = page;
        renderTable();
        const scrollContainer = document.querySelector('.matrix-scroll-container');
        if (scrollContainer) scrollContainer.scrollTop = 0;
      }

      // Save Designator (Add or Edit)
      async function saveDesignator() {
        const nameInput = document.getElementById('designatorName');
        const rumusInput = document.getElementById('designatorRumus');
        const errorEl = document.getElementById('errorMessage');
        const saveBtn = document.getElementById('saveDesignatorBtn');

        const name = nameInput.value.trim();
        const rumus = rumusInput.value.trim();

        // Reset error
        nameInput.classList.remove('is-invalid');
        errorEl.style.display = 'none';

        if (!name) {
          nameInput.classList.add('is-invalid');
          errorEl.textContent = 'Nama designator wajib diisi!';
          errorEl.style.display = 'block';
          nameInput.focus();
          return;
        }

        // Client-side duplicate check (case-insensitive)
        const nameLower = name.toLowerCase();
        if (!editingId) {
          const exists = designators.some(d => d.nama_designator.toLowerCase() === nameLower);
          if (exists) {
            nameInput.classList.add('is-invalid');
            errorEl.textContent = `Designator "${name}" sudah terdaftar di database!`;
            errorEl.style.display = 'block';
            return;
          }
        } else {
          const exists = designators.some(d => d.id !== editingId && d.nama_designator.toLowerCase() === nameLower);
          if (exists) {
            nameInput.classList.add('is-invalid');
            errorEl.textContent = `Designator "${name}" sudah digunakan oleh entri lain!`;
            errorEl.style.display = 'block';
            return;
          }
        }

        // Disable button while saving
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

        try {
          let response;
          if (editingId) {
            response = await fetch(`/api/designators/${editingId}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ nama_designator: name, rumus: rumus || null })
            });
          } else {
            response = await fetch('/api/designators', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ nama_designator: name, rumus: rumus || null })
            });
          }

          if (!response.ok) {
            const errorData = await response.json();
            if (errorData.errors && errorData.errors.nama_designator) {
              nameInput.classList.add('is-invalid');
              errorEl.textContent = errorData.errors.nama_designator[0];
              errorEl.style.display = 'block';
              return;
            }
            throw new Error(errorData.message || 'Gagal menyimpan designator');
          }

          const result = await response.json();
          designatorModal.hide();
          showToast('success', 'Berhasil', result.message || 'Designator berhasil disimpan!');
          await loadDesignators();
        } catch (error) {
          console.error('Save error:', error);
          showToast('error', 'Gagal Menyimpan', error.message);
        } finally {
          saveBtn.disabled = false;
          saveBtn.innerHTML = '<i class="bi bi-check-lg"></i><span>Simpan Data</span>';
        }
      }

      // Open Edit Modal
      function openEditModal(id) {
        if (!canManageDesignators) return;

        const designator = designators.find(d => d.id === id);
        if (!designator) {
          showToast('error', 'Error', 'Data designator tidak ditemukan!');
          return;
        }

        editingId = id;
        document.getElementById('modalTitleText').textContent = 'Edit Designator';
        const subEl = document.getElementById('modalSubtitleText');
        if (subEl) subEl.textContent = 'Perbarui nama designator atau formula perhitungan';
        document.getElementById('designatorName').value = designator.nama_designator;
        document.getElementById('designatorRumus').value = designator.rumus || '';

        // Clear error
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('designatorName').classList.remove('is-invalid');

        designatorModal.show();
      }

      // Open Delete Modal
      function openDeleteModal(id) {
        if (!canManageDesignators) return;
        pendingDeleteId = id;
        const item = designators.find(d => d.id === id) || filteredDesignators.find(d => d.id === id);
        const name = item ? item.nama_designator : '';
        document.getElementById('deleteConfirmText').innerHTML = `Hapus designator <strong>"${escapeHtml(name)}"</strong> secara permanen?`;
        if (!deleteModal) {
          const deleteModalEl = document.getElementById('deleteConfirmModal');
          if (deleteModalEl) deleteModal = new bootstrap.Modal(deleteModalEl);
        }
        if (deleteModal) deleteModal.show();
      }

      // Confirm Delete
      async function executeDelete() {
        if (!pendingDeleteId) return;

        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';

        try {
          const response = await fetch(`/api/designators/${pendingDeleteId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });

          const result = await response.json().catch(() => ({}));
          if (!response.ok) throw new Error(result.message || 'Gagal menghapus designator dari database');

          if (deleteModal) {
            deleteModal.hide();
          } else {
            const m = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            if (m) m.hide();
          }

          showToast('success', 'Berhasil', result.message || 'Designator berhasil dihapus.');
          await loadDesignators();
        } catch (error) {
          console.error('Delete error:', error);
          showToast('error', 'Gagal Menghapus', error.message);
        } finally {
          confirmBtn.disabled = false;
          confirmBtn.innerHTML = '<i class="bi bi-trash-fill"></i><span>Ya, Hapus</span>';
          pendingDeleteId = null;
        }
      }

      // Escape HTML helper
      function escapeHtml(text) {
        if (!text) return '';
        const map = {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
      }

      // Initialize on DOM Ready
      document.addEventListener('DOMContentLoaded', function() {
        // Init modals
        const modalEl = document.getElementById('designatorModal');
        if (modalEl) designatorModal = new bootstrap.Modal(modalEl);

        const deleteModalEl = document.getElementById('deleteConfirmModal');
        if (deleteModalEl) deleteModal = new bootstrap.Modal(deleteModalEl);

        // Load data
        loadDesignators();

        // Add button
        const addBtn = document.getElementById('addDesignatorBtn');
        if (addBtn) {
          addBtn.addEventListener('click', function() {
            editingId = null;
            document.getElementById('modalTitleText').textContent = 'Tambah Designator Baru';
            const subEl = document.getElementById('modalSubtitleText');
            if (subEl) subEl.textContent = 'Masukkan rincian item material kabel dan formula perhitungan';
            document.getElementById('designatorForm').reset();

            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('designatorName').classList.remove('is-invalid');

            designatorModal.show();
          });
        }

        // Save & Delete buttons
        document.getElementById('saveDesignatorBtn').addEventListener('click', saveDesignator);
        document.getElementById('confirmDeleteBtn').addEventListener('click', executeDelete);

        // Search event (debounced)
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
          clearTimeout(searchTimeout);
          searchTimeout = setTimeout(applySearch, 200);
        });

        // Entries select
        document.getElementById('showEntries').addEventListener('change', function() {
          entriesPerPage = this.value === 'all' ? 'all' : parseInt(this.value);
          currentPage = 1;
          renderTable();
        });

        // Clear error on input
        document.getElementById('designatorName').addEventListener('input', function() {
          this.classList.remove('is-invalid');
          document.getElementById('errorMessage').style.display = 'none';
        });

        // Init KML modals
        const uploadModalEl = document.getElementById('uploadKmlModal');
        if (uploadModalEl) uploadKmlModal = new bootstrap.Modal(uploadModalEl);

        const delKmlModalEl = document.getElementById('deleteKmlConfirmModal');
        if (delKmlModalEl) deleteKmlConfirmModal = new bootstrap.Modal(delKmlModalEl);

        const editKmlModalEl = document.getElementById('editKmlModal');
        if (editKmlModalEl) editKmlModal = new bootstrap.Modal(editKmlModalEl);

        // Open Upload KML button
        const openUploadBtn = document.getElementById('openUploadKmlBtn');
        if (openUploadBtn) {
          openUploadBtn.addEventListener('click', function() {
            document.getElementById('uploadKmlForm').reset();
            const tglEl = document.getElementById('kmlTanggalSurvei');
            if (tglEl) {
              tglEl.value = new Date().toISOString().split('T')[0];
            }
            document.getElementById('uploadErrorMessage').style.display = 'none';
            document.getElementById('kmlProjectName').classList.remove('is-invalid');
            document.getElementById('kmlFileInput').classList.remove('is-invalid');
            uploadKmlModal.show();
          });
        }

        // Clear error on input / change for KML upload
        const kmlProjNameInput = document.getElementById('kmlProjectName');
        const kmlAreaInput = document.getElementById('kmlArea');
        const kmlTglInput = document.getElementById('kmlTanggalSurvei');
        const kmlFileInp = document.getElementById('kmlFileInput');
        const uploadErrEl = document.getElementById('uploadErrorMessage');

        if (kmlProjNameInput) {
          kmlProjNameInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (uploadErrEl) uploadErrEl.style.display = 'none';
          });
        }

        if (kmlAreaInput) {
          kmlAreaInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (uploadErrEl) uploadErrEl.style.display = 'none';
          });
        }

        if (kmlTglInput) {
          kmlTglInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (uploadErrEl) uploadErrEl.style.display = 'none';
          });
        }

        if (kmlFileInp) {
          kmlFileInp.addEventListener('change', function() {
            this.classList.remove('is-invalid');
            if (uploadErrEl) uploadErrEl.style.display = 'none';
          });
        }

        // Clear error on input for KML edit
        const editKmlNameInput = document.getElementById('editKmlName');
        const editKmlAreaInput = document.getElementById('editKmlArea');
        const editKmlTglInput = document.getElementById('editKmlTanggalSurvei');
        const editKmlFileInput = document.getElementById('editKmlFile');
        const editKmlErrEl = document.getElementById('editKmlErrorMessage');

        if (editKmlNameInput) {
          editKmlNameInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (editKmlErrEl) editKmlErrEl.style.display = 'none';
          });
        }

        if (editKmlAreaInput) {
          editKmlAreaInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (editKmlErrEl) editKmlErrEl.style.display = 'none';
          });
        }

        if (editKmlTglInput) {
          editKmlTglInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (editKmlErrEl) editKmlErrEl.style.display = 'none';
          });
        }

        if (editKmlFileInput) {
          editKmlFileInput.addEventListener('change', function() {
            this.classList.remove('is-invalid');
            if (editKmlErrEl) editKmlErrEl.style.display = 'none';
          });
        }

        // KML Search & Filter events
        let kmlSearchTimeout;
        const searchKmlEl = document.getElementById('searchKmlInput');
        if (searchKmlEl) {
          searchKmlEl.addEventListener('input', function() {
            clearTimeout(kmlSearchTimeout);
            kmlSearchTimeout = setTimeout(applyKmlFilterAndSearch, 200);
          });
        }

        const showKmlEntriesEl = document.getElementById('showKmlEntries');
        if (showKmlEntriesEl) {
          showKmlEntriesEl.addEventListener('change', function() {
            kmlEntriesPerPage = this.value === 'all' ? 'all' : parseInt(this.value);
            currentKmlPage = 1;
            renderKmlTable();
          });
        }

        // Check URL hash or query param for default tab
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        if (window.location.hash === '#kml' || tabParam === 'kml') {
          switchDataTab('kml');
        } else {
          // Pre-fetch KML count for the badge
          loadKmlProjects();
        }
      });

      // ===== KML STATE & ENGINE =====
      let kmlProjects = [];
      let filteredKmlProjects = [];
      let currentKmlPage = 1;
      let kmlEntriesPerPage = 10;
      let currentActiveTab = 'designator';
      let uploadKmlModal;
      let editKmlModal;
      let deleteKmlConfirmModal;
      let pendingDeleteKmlId = null;

      // Switch Data Manager Tab (Designator vs KML)
      function switchDataTab(tabName) {
        currentActiveTab = tabName;
        const btnDesignator = document.getElementById('tabBtnDesignator');
        const btnKml = document.getElementById('tabBtnKml');
        const panelDesignator = document.getElementById('panelDesignator');
        const panelKml = document.getElementById('panelKml');
        const pageTitleIcon = document.getElementById('pageTitleIcon');
        const pageTitleHeading = document.getElementById('pageTitleHeading');
        const pageTitleSubheading = document.getElementById('pageTitleSubheading');

        if (tabName === 'designator') {
          if (btnDesignator) btnDesignator.classList.add('active');
          if (btnKml) btnKml.classList.remove('active');
          if (panelDesignator) panelDesignator.style.display = 'block';
          if (panelKml) panelKml.style.display = 'none';

          if (pageTitleIcon) pageTitleIcon.innerHTML = '<i class="bi bi-grid-1x2-fill"></i>';
          if (pageTitleHeading) pageTitleHeading.textContent = 'Master Data Designator';
          if (pageTitleSubheading) pageTitleSubheading.textContent = 'Kelola basis data master designator & rumus kalkulasi kabel fiber optik';

          history.replaceState(null, null, '#designator');
        } else if (tabName === 'kml') {
          if (btnDesignator) btnDesignator.classList.remove('active');
          if (btnKml) btnKml.classList.add('active');
          if (panelDesignator) panelDesignator.style.display = 'none';
          if (panelKml) panelKml.style.display = 'block';

          if (pageTitleIcon) pageTitleIcon.innerHTML = '<i class="bi bi-geo-alt-fill"></i>';
          if (pageTitleHeading) pageTitleHeading.textContent = 'Database Data KML';
          if (pageTitleSubheading) pageTitleSubheading.textContent = 'Tampungan berkas KML & proyek rute fiber optik yang telah dibuat/disimpan';

          history.replaceState(null, null, '#kml');
          loadKmlProjects();
        }
      }

      // Load KML projects from API
      async function loadKmlProjects() {
        const tbody = document.getElementById('kmlTableBody');
        try {
          const response = await fetch('/api/kml-projects');
          if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

          const result = await response.json();
          kmlProjects = result.data || [];

          // Update statistics
          const stats = result.stats || {};
          const statTotal = document.getElementById('statKmlTotal');
          const statTitik = document.getElementById('statKmlTitik');
          const statJarak = document.getElementById('statKmlJarak');
          const statValidated = document.getElementById('statKmlValidated');
          const badgeKml = document.getElementById('badgeKmlCount');

          if (statTotal) statTotal.textContent = stats.total_projects || 0;
          if (statTitik) statTitik.textContent = stats.total_placemarks || 0;
          if (statJarak) statJarak.textContent = (stats.total_distance_km || 0) + ' km';
          if (statValidated) statValidated.textContent = (stats.status_counts?.validated || 0);
          if (badgeKml) badgeKml.textContent = kmlProjects.length;

          applyKmlFilterAndSearch();
        } catch (error) {
          console.error('Error loading KML projects:', error);
          if (tbody) {
            tbody.innerHTML = `
              <tr>
                <td colspan="9" class="text-center py-5">
                  <div class="text-danger mb-2"><i class="bi bi-exclamation-triangle-fill fs-3"></i></div>
                  <span style="color: #F87171; font-size: 0.9rem;">Gagal memuat database KML: ${error.message}</span>
                </td>
              </tr>
            `;
          }
          showToast('error', 'Gagal Memuat KML', error.message);
        }
      }

      // Filter and Search KML Projects
      function applyKmlFilterAndSearch() {
        const searchInput = document.getElementById('searchKmlInput');
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

        filteredKmlProjects = kmlProjects.filter(item => {
          return !searchTerm || 
            (item.nama_project && item.nama_project.toLowerCase().includes(searchTerm)) ||
            (item.area && item.area.toLowerCase().includes(searchTerm)) ||
            (item.created_by && item.created_by.toLowerCase().includes(searchTerm)) ||
            (item.file_name && item.file_name.toLowerCase().includes(searchTerm));
        });

        currentKmlPage = 1;
        renderKmlTable();
      }

      // Render KML Table
      function renderKmlTable() {
        const tbody = document.getElementById('kmlTableBody');
        const tableInfo = document.getElementById('kmlTableInfo');
        const paginationControls = document.getElementById('kmlPaginationControls');
        if (!tbody) return;

        const totalItems = filteredKmlProjects.length;
        const isAll = kmlEntriesPerPage === 'all';
        const perPage = isAll ? (totalItems || 1) : parseInt(kmlEntriesPerPage);
        const totalPages = isAll ? 1 : Math.ceil(totalItems / perPage) || 1;

        if (currentKmlPage > totalPages) currentKmlPage = totalPages;
        if (currentKmlPage < 1) currentKmlPage = 1;

        const startIndex = isAll ? 0 : (currentKmlPage - 1) * perPage;
        const endIndex = isAll ? totalItems : Math.min(startIndex + perPage, totalItems);
        const pageData = filteredKmlProjects.slice(startIndex, endIndex);

        // Empty state
        if (totalItems === 0) {
          tbody.innerHTML = `
            <tr>
              <td colspan="6">
                <div class="table-empty-state">
                  <i class="bi bi-folder2-open empty-icon"></i>
                  <div class="empty-text-main">Belum Ada Proyek KML Tersimpan</div>
                  <div class="empty-text-sub">
                    ${document.getElementById('searchKmlInput')?.value ? 'Tidak ada data KML yang sesuai dengan pencarian Anda.' : 'Gunakan tombol "Upload File KML" untuk menambahkan berkas KML pertama atau simpan dari Workspace Map.'}
                  </div>
                </div>
              </td>
            </tr>
          `;
          if (tableInfo) tableInfo.textContent = 'Menampilkan 0 dari 0 data KML';
          if (paginationControls) paginationControls.innerHTML = '';
          return;
        }

        let rowsHtml = '';
        pageData.forEach((item, index) => {
          const rowNumber = startIndex + index + 1;

          const rawDate = item.tanggal_survei || item.created_at;
          const surveyDate = rawDate ? new Date(rawDate).toLocaleDateString('id-ID', {
            day: '2-digit', month: 'short', year: 'numeric'
          }) : '-';

          rowsHtml += `
            <tr>
              <td style="text-align: center; color: #9CA3AF; font-weight: 600;">${rowNumber}</td>
              <td>
                <div style="font-weight: 700; color: #FFFFFF; font-size: 0.92rem;">${escapeHtml(item.nama_project)}</div>
                <div style="font-size: 0.78rem; color: #9CA3AF; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                  <i class="bi bi-file-earmark-code"></i> ${escapeHtml(item.file_name || 'kml_data.kml')}
                </div>
              </td>
              <td>
                <span style="font-size: 0.85rem; color: #E5E7EB; font-weight: 500;">
                  <i class="bi bi-geo-alt text-danger me-1"></i>${escapeHtml(item.area || 'Witel Regional')}
                </span>
              </td>
              <td style="color: #9CA3AF; font-size: 0.82rem;">${surveyDate}</td>
              <td>
                <span style="color: #E5E7EB; font-size: 0.85rem;">
                  <i class="bi bi-person-fill text-muted me-1"></i>${escapeHtml(item.created_by || 'Pegawai')}
                </span>
              </td>
              <td style="text-align: center;">
                <div class="action-btn-group" style="justify-content: center;">
                  @auth
                    @if(Auth::user()->canManageDesignators())
                      <button type="button" class="action-pill-btn action-edit" title="Ubah Data Proyek KML" onclick="openEditKmlModal(${item.id})">
                        <i class="bi bi-pencil-fill"></i>
                      </button>
                      <button type="button" class="action-pill-btn action-delete" title="Hapus Data KML" onclick="openDeleteKmlModal(${item.id})">
                        <i class="bi bi-trash3-fill"></i>
                      </button>
                    @else
                      <span style="color: #6B7280; font-size: 0.82rem;">-</span>
                    @endif
                  @else
                    <span style="color: #6B7280; font-size: 0.82rem;">-</span>
                  @endauth
                </div>
              </td>
            </tr>
          `;
        });

        tbody.innerHTML = rowsHtml;

        // Info text
        if (tableInfo) {
          tableInfo.textContent = `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalItems} data KML`;
        }

        // Pagination controls
        if (paginationControls) {
          if (totalPages <= 1) {
            paginationControls.innerHTML = '';
          } else {
            let pagHtml = `
              <button type="button" class="page-btn" ${currentKmlPage === 1 ? 'disabled' : ''} onclick="goToKmlPage(${currentKmlPage - 1})">
                <i class="bi bi-chevron-left"></i>
              </button>
            `;

            for (let i = 1; i <= totalPages; i++) {
              pagHtml += `
                <button type="button" class="page-btn ${i === currentKmlPage ? 'active' : ''}" onclick="goToKmlPage(${i})">${i}</button>
              `;
            }

            pagHtml += `
              <button type="button" class="page-btn" ${currentKmlPage === totalPages ? 'disabled' : ''} onclick="goToKmlPage(${currentKmlPage + 1})">
                <i class="bi bi-chevron-right"></i>
              </button>
            `;
            paginationControls.innerHTML = pagHtml;
          }
        }
      }

      function goToKmlPage(page) {
        currentKmlPage = page;
        renderKmlTable();
      }



      // Open Edit KML Modal
      function openEditKmlModal(id) {
        const item = kmlProjects.find(p => p.id === id) || filteredKmlProjects.find(p => p.id === id);
        if (!item) {
          showToast('error', 'Error', 'Data proyek KML tidak ditemukan.');
          return;
        }

        document.getElementById('editKmlId').value = item.id;
        document.getElementById('editKmlName').value = item.nama_project || '';
        document.getElementById('editKmlArea').value = item.area || '';

        const rawDate = item.tanggal_survei || item.created_at;
        let dateStr = '';
        if (rawDate) {
          try {
            dateStr = new Date(rawDate).toISOString().split('T')[0];
          } catch (e) {
            dateStr = '';
          }
        }
        document.getElementById('editKmlTanggalSurvei').value = dateStr;

        // Reset file input dan tampilkan nama berkas saat ini
        const fileInput = document.getElementById('editKmlFile');
        if (fileInput) fileInput.value = '';
        const currentFileEl = document.getElementById('editKmlCurrentFileName');
        if (currentFileEl) {
          currentFileEl.textContent = item.file_name || '(Tidak ada berkas)';
        }

        const errEl = document.getElementById('editKmlErrorMessage');
        if (errEl) errEl.style.display = 'none';

        if (!editKmlModal) {
          const editModalEl = document.getElementById('editKmlModal');
          if (editModalEl) editKmlModal = new bootstrap.Modal(editModalEl);
        }
        if (editKmlModal) editKmlModal.show();
      }

      // Save Edit KML
      async function saveEditKml() {
        const id = document.getElementById('editKmlId').value;
        const nameInput = document.getElementById('editKmlName');
        const areaInput = document.getElementById('editKmlArea');
        const dateInput = document.getElementById('editKmlTanggalSurvei');
        const fileInput = document.getElementById('editKmlFile');
        const errEl = document.getElementById('editKmlErrorMessage');
        const saveBtn = document.getElementById('saveEditKmlBtn');
        const saveBtnText = document.getElementById('saveEditKmlBtnText');

        const name = nameInput.value.trim();
        const area = areaInput.value.trim();
        const tgl = dateInput.value;

        nameInput.classList.remove('is-invalid');
        if (fileInput) fileInput.classList.remove('is-invalid');

        if (!name) {
          nameInput.classList.add('is-invalid');
          if (errEl) {
            errEl.textContent = 'Nama proyek tidak boleh kosong.';
            errEl.style.display = 'block';
          }
          nameInput.focus();
          return;
        }

        // Cek duplikasi nama proyek KML pada entri lain (case-insensitive)
        const nameLower = name.toLowerCase();
        const duplicateProject = kmlProjects.find(p => p.id != id && p.nama_project && p.nama_project.toLowerCase() === nameLower);
        if (duplicateProject) {
          nameInput.classList.add('is-invalid');
          if (errEl) {
            errEl.textContent = `Data KML "${name}" sudah terdaftar di database!`;
            errEl.style.display = 'block';
          }
          nameInput.focus();
          return;
        }

        // Cek duplikasi berkas KML pada entri lain jika user memilih file baru
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
          const fn = fileInput.files[0].name.trim();
          const duplicateFile = kmlProjects.find(p => p.id != id && p.file_name && p.file_name.toLowerCase() === fn.toLowerCase());
          if (duplicateFile) {
            fileInput.classList.add('is-invalid');
            if (errEl) {
              errEl.textContent = `Data KML "${fn}" sudah terdaftar di database!`;
              errEl.style.display = 'block';
            }
            fileInput.focus();
            return;
          }
        }

        saveBtn.disabled = true;
        saveBtnText.textContent = 'Menyimpan...';
        if (errEl) errEl.style.display = 'none';

        try {
          const formData = new FormData();
          formData.append('_method', 'PUT');
          formData.append('nama_project', name);
          formData.append('area', area);
          if (tgl) formData.append('tanggal_survei', tgl);
          if (fileInput && fileInput.files && fileInput.files.length > 0) {
            formData.append('kml_file', fileInput.files[0]);
          }

          const response = await fetch(`/api/kml-projects/${id}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: formData
          });

          const result = await response.json();
          if (!response.ok) {
            throw new Error(result.message || 'Gagal memperbarui data proyek KML');
          }

          if (editKmlModal) {
            editKmlModal.hide();
          } else {
            const m = bootstrap.Modal.getInstance(document.getElementById('editKmlModal'));
            if (m) m.hide();
          }

          showToast('success', 'Berhasil', 'Data proyek KML berhasil diperbarui!');
          await loadKmlProjects();
        } catch (error) {
          console.error('Save edit KML error:', error);
          if (errEl) {
            errEl.textContent = error.message;
            errEl.style.display = 'block';
          } else {
            showToast('error', 'Gagal Memperbarui', error.message);
          }
        } finally {
          saveBtn.disabled = false;
          saveBtnText.textContent = 'Simpan Perubahan';
        }
      }

      // Open Delete KML Modal
      function openDeleteKmlModal(id) {
        pendingDeleteKmlId = id;
        const item = kmlProjects.find(p => p.id === id) || filteredKmlProjects.find(p => p.id === id);
        const name = item ? item.nama_project : 'Data KML';
        const confirmText = document.getElementById('deleteKmlConfirmText');
        if (confirmText) {
          confirmText.innerHTML = `Hapus proyek <strong>"${escapeHtml(name)}"</strong> secara permanen?`;
        }
        if (!deleteKmlConfirmModal) {
          const delKmlModalEl = document.getElementById('deleteKmlConfirmModal');
          if (delKmlModalEl) deleteKmlConfirmModal = new bootstrap.Modal(delKmlModalEl);
        }
        if (deleteKmlConfirmModal) deleteKmlConfirmModal.show();
      }

      // Execute Delete KML
      async function executeDeleteKml() {
        if (!pendingDeleteKmlId) return;
        const confirmBtn = document.getElementById('confirmDeleteKmlBtn');
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';

        try {
          const response = await fetch(`/api/kml-projects/${pendingDeleteKmlId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });

          const result = await response.json().catch(() => ({}));
          if (!response.ok) throw new Error(result.message || 'Gagal menghapus proyek KML dari database');

          if (deleteKmlConfirmModal) {
            deleteKmlConfirmModal.hide();
          } else {
            const m = bootstrap.Modal.getInstance(document.getElementById('deleteKmlConfirmModal'));
            if (m) m.hide();
          }

          showToast('success', 'Berhasil', result.message || 'Proyek KML berhasil dihapus dari database.');
          await loadKmlProjects();
        } catch (error) {
          console.error('Delete error:', error);
          showToast('error', 'Gagal Menghapus', error.message);
        } finally {
          confirmBtn.disabled = false;
          confirmBtn.innerHTML = '<i class="bi bi-trash-fill"></i><span>Ya, Hapus</span>';
          pendingDeleteKmlId = null;
        }
      }

      // Submit Upload KML File
      async function submitUploadKml() {
        const form = document.getElementById('uploadKmlForm');
        const fileInput = document.getElementById('kmlFileInput');
        const projectNameInput = document.getElementById('kmlProjectName');
        const areaInput = document.getElementById('kmlArea');
        const tglSurveiInput = document.getElementById('kmlTanggalSurvei');
        const errorMsg = document.getElementById('uploadErrorMessage');
        const submitBtn = document.getElementById('submitUploadKmlBtn');
        const submitBtnText = document.getElementById('submitUploadBtnText');

        // Reset error state
        projectNameInput.classList.remove('is-invalid');
        fileInput.classList.remove('is-invalid');
        errorMsg.style.display = 'none';

        const projectName = projectNameInput.value.trim();
        const area = areaInput.value.trim();

        if (!projectName) {
          projectNameInput.classList.add('is-invalid');
          errorMsg.textContent = 'Nama proyek tidak boleh kosong.';
          errorMsg.style.display = 'block';
          projectNameInput.focus();
          return;
        }

        if (!fileInput.files || fileInput.files.length === 0) {
          fileInput.classList.add('is-invalid');
          errorMsg.textContent = 'Harap pilih berkas KML terlebih dahulu.';
          errorMsg.style.display = 'block';
          fileInput.focus();
          return;
        }

        const selectedFile = fileInput.files[0];
        const selectedFileName = selectedFile.name.trim();

        // 1. Deteksi duplikasi berkas KML yang sama (case-insensitive)
        const fileNameLower = selectedFileName.toLowerCase();
        const duplicateFile = kmlProjects.find(p => p.file_name && p.file_name.toLowerCase() === fileNameLower);
        if (duplicateFile) {
          fileInput.classList.add('is-invalid');
          errorMsg.textContent = `Data KML "${selectedFileName}" sudah terdaftar di database!`;
          errorMsg.style.display = 'block';
          fileInput.focus();
          return;
        }

        // 2. Deteksi duplikasi nama proyek KML (case-insensitive)
        const projectNameLower = projectName.toLowerCase();
        const duplicateProject = kmlProjects.find(p => p.nama_project && p.nama_project.toLowerCase() === projectNameLower);
        if (duplicateProject) {
          projectNameInput.classList.add('is-invalid');
          errorMsg.textContent = `Data KML "${projectName}" sudah terdaftar di database!`;
          errorMsg.style.display = 'block';
          projectNameInput.focus();
          return;
        }

        const formData = new FormData();
        formData.append('kml_file', selectedFile);
        formData.append('nama_project', projectName);
        formData.append('area', area);
        if (tglSurveiInput && tglSurveiInput.value) {
          formData.append('tanggal_survei', tglSurveiInput.value);
        }

        submitBtn.disabled = true;
        submitBtnText.textContent = 'Memproses KML...';
        errorMsg.style.display = 'none';

        try {
          const response = await fetch('/api/kml-projects', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: formData
          });

          let result;
          try {
            result = await response.json();
          } catch (jsonErr) {
            const rawText = await response.text();
            throw new Error(rawText ? 'Terjadi kesalahan sistem saat memproses berkas KML.' : 'Respon server tidak valid.');
          }

          if (!response.ok) {
            let errMsg = result.message || 'Gagal mengunggah berkas KML';
            if (result.errors) {
              const errList = Object.values(result.errors).flat();
              if (errList.length > 0) errMsg = errList.join(', ');
            }
            if (errMsg.includes('sudah terdaftar')) {
              fileInput.classList.add('is-invalid');
              projectNameInput.classList.add('is-invalid');
            }
            throw new Error(errMsg);
          }

          uploadKmlModal.hide();
          form.reset();
          showToast('success', 'KML Berhasil Diunggah', result.message || 'Berkas KML berhasil disimpan!');
          await loadKmlProjects();
        } catch (error) {
          console.error('Upload KML error:', error);
          errorMsg.textContent = error.message;
          errorMsg.style.display = 'block';
        } finally {
          submitBtn.disabled = false;
          submitBtnText.textContent = 'Unggah ke Database';
        }
      }
    </script>
  </body>
  <!--end::Body-->
</html>
