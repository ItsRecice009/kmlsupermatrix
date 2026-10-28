<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Telkom Dashboard - KML Super Matrix</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Leaflet CSS for geospatial distance calculations -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js for Statistics Visuals -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <!-- Custom Telkom Red Glassmorphism Theme -->
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

      .user-avatar-btn::after {
        display: none !important;
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

      /* ========== WORKSPACE CONTAINER & GRID ========== */
      .network-workspace-container {
        flex: 1;
        padding: 16px;
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

      .matrix-workspace-wrapper {
        width: 100%;
        height: 100%;
        min-height: 0;
        max-height: 100%;
        flex: 1;
        display: flex;
        box-sizing: border-box;
      }

      .network-workspace-grid {
        display: flex;
        gap: 16px;
        align-items: stretch;
        width: 100%;
        height: 100%;
        min-height: 0;
        max-height: 100%;
        box-sizing: border-box;
      }

      @media (max-width: 900px) {
        .matrix-workspace-wrapper,
        .network-workspace-grid {
          height: auto;
          min-height: auto;
          max-height: none;
          flex-direction: column;
        }
      }

      /* LEFT PANEL - DARK CARD */
      .chain-steps-panel {
        width: 290px;
        min-width: 290px;
        max-width: 310px;
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 0;
      }

      .clean-chain-card {
        background-color: #2B2B36;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(229, 231, 235, 0.12);
      }

      .clean-chain-header {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.4) 0%, rgba(43, 43, 54, 0.95) 100%);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
      }

      .chain-header-title {
        color: #FFFFFF;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: -0.2px;
      }

      .chain-collapse-icon {
        color: #9CA3AF;
        font-size: 1rem;
        cursor: pointer;
        transition: color 0.2s;
      }

      .chain-collapse-icon:hover {
        color: #FFFFFF;
      }

      .clean-chain-body {
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
        min-height: 0;
        overflow-y: auto;
      }

      /* KML Dropzone - Dark */
      .upload-dropzone-card {
        background-color: #111827;
        border: 1.5px dashed #374151;
        border-radius: 12px;
        padding: 16px 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
      }

      .upload-dropzone-card:hover {
        border-color: #DC2626;
        background-color: #1A1F2C;
      }

      .dropzone-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.35rem;
        color: #FFFFFF;
      }

      .dropzone-main-text {
        color: #FFFFFF;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 4px;
      }

      .dropzone-sub-text {
        color: #9CA3AF;
        font-size: 0.775rem;
      }

      /* Badges & Labels - Dark */
      .step-label {
        color: #FFFFFF;
        font-size: 0.88rem;
        font-weight: 600;
        margin-bottom: 0;
      }

      .badge-telkom-red {
        background-color: #DC2626;
        color: #FFFFFF;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 9999px;
        letter-spacing: 0.2px;
      }

      .step-dropdown-toggle {
        background-color: #111827;
        border: 1px solid #374151;
        color: #CBD5E1;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
      }

      .step-dropdown-toggle:hover:not(:disabled) {
        border-color: #4B5563;
        color: #FFFFFF;
      }

      .step-dropdown-toggle:focus, .step-dropdown-toggle[aria-expanded="true"] {
        border-color: #DC2626;
        color: #FFFFFF;
        outline: none;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25);
      }

      .step-dropdown-toggle:disabled {
        opacity: 0.85;
        color: #94A3B8;
        border-color: #2D3748;
        cursor: not-allowed;
      }

      /* Placeholder text styling pada tombol dropdown (Titik Awal, Titik Akhir, Jalur Kabel) */
      #startPointText,
      #endPointText,
      #cableRouteText {
        color: #94A3B8;
        transition: color 0.2s ease;
      }

      .step-dropdown-toggle:not(:disabled) #startPointText,
      .step-dropdown-toggle:not(:disabled) #endPointText,
      .step-dropdown-toggle:not(:disabled) #cableRouteText {
        color: #CBD5E1;
      }

      .step-dropdown-toggle:hover:not(:disabled) #startPointText,
      .step-dropdown-toggle:hover:not(:disabled) #endPointText,
      .step-dropdown-toggle:hover:not(:disabled) #cableRouteText {
        color: #FFFFFF;
      }

      .dark-dropdown-menu {
        background-color: #1E1E24;
        border: 1px solid #374151;
        border-radius: 10px;
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.5);
        max-height: 280px;
        z-index: 1050;
        padding: 6px;
      }

      .dark-search-input {
        background-color: #111827;
        border: 1px solid #374151;
        color: #FFFFFF;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 7px 10px;
      }

      /* Placeholder styling pada input pencarian dropdown (Cari titik awal, Cari titik akhir, Cari jalur kabel) */
      .dark-search-input::placeholder {
        color: #94A3B8 !important;
        opacity: 0.85;
      }
      .dark-search-input::-webkit-input-placeholder {
        color: #94A3B8 !important;
        opacity: 0.85;
      }
      .dark-search-input::-moz-placeholder {
        color: #94A3B8 !important;
        opacity: 0.85;
      }
      .dark-search-input:-ms-input-placeholder {
        color: #94A3B8 !important;
        opacity: 0.85;
      }

      .dark-search-input:focus {
        border-color: #DC2626;
        color: #FFFFFF;
        background-color: #111827;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.3);
        outline: none;
      }

      .dropdown-item-dark,
      .dark-dropdown-menu .dropdown-item {
        color: #E5E7EB !important;
        padding: 8px 12px;
        font-size: 0.82rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
        display: block;
        background: transparent;
      }

      .dropdown-item-dark:hover,
      .dark-dropdown-menu .dropdown-item:hover,
      .dark-dropdown-menu .dropdown-item:focus {
        background-color: rgba(220, 38, 38, 0.25) !important;
        color: #FFFFFF !important;
      }

      .dark-dropdown-menu .dropdown-item.text-muted {
        color: #9CA3AF !important;
      }

      /* Global text-muted override for dark mode contrast */
      .network-app-wrapper .text-muted,
      .modal-content .text-muted,
      .dropdown-menu .text-muted {
        color: #9CA3AF !important;
      }

      .dropdown-item-dark.active {
        background-color: #DC2626;
        color: #FFFFFF;
      }

      /* Advanced Settings Card - Dark */
      .advanced-settings-card {
        background-color: transparent;
        border: none;
        margin-top: 4px;
      }

      .advanced-collapse-header {
        background: transparent;
        border: none;
        color: #E5E7EB;
        font-size: 0.88rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding: 6px 0;
        cursor: pointer;
        transition: color 0.2s;
      }

      .advanced-collapse-header:hover {
        color: #FFFFFF;
      }

      .accordion-chevron {
        transition: transform 0.2s ease;
      }

      .advanced-collapse-header[aria-expanded="true"] .accordion-chevron {
        transform: rotate(180deg);
      }

      .rose-switch {
        width: 44px;
        height: 22px;
        cursor: pointer;
        background-color: #374151;
        border-color: #374151;
      }

      .rose-switch:checked {
        background-color: #E06D6D !important;
        border-color: #E06D6D !important;
      }

      .rose-switch:focus {
        box-shadow: 0 0 0 2px rgba(224, 109, 109, 0.35);
      }

      .btn-process-red {
        background-color: #DC2626;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
      }

      .btn-process-red:hover:not(:disabled) {
        background-color: #B91C1C;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.5);
      }

      .btn-process-red:disabled {
        opacity: 0.45;
        cursor: not-allowed;
        box-shadow: none;
      }

      /* RIGHT PANEL - MATRIX TABLE & BARS (DARK) */
      .matrix-table-panel {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 0;
      }

      .matrix-card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
        height: 100%;
        min-height: 0;
      }

      /* TOP TOOLBAR - DARK */
      .matrix-top-bar {
        background-color: #2B2B36;
        border-radius: 12px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid rgba(229, 231, 235, 0.1);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        min-height: 44px;
        flex-shrink: 0;
      }

      .topbar-label {
        color: #FFFFFF;
        font-size: 0.88rem;
        font-weight: 600;
      }

      .topbar-pill-btn {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #E5E7EB;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.2s;
      }

      .topbar-pill-btn:hover:not(:disabled) {
        background-color: #24242F;
        color: #FFFFFF;
        border-color: #4B5563;
      }

      .topbar-pill-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
      }

      .badge-rows-counter {
        background-color: #DC2626;
        color: #FFFFFF;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 9999px;
        letter-spacing: 0.2px;
      }

      /* EDIT MODE SWITCH & TOPBAR BUTTONS */
      .pill-switch-btn {
        background-color: #1E1E24;
        border: 1px solid rgba(229, 231, 235, 0.18);
        color: #E5E7EB;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
      }

      .pill-switch-btn:hover {
        background-color: #282833;
        border-color: rgba(229, 231, 235, 0.3);
        color: #FFFFFF;
      }

      .pill-switch-btn.active {
        background: linear-gradient(135deg, #2563EB, #1D4ED8) !important;
        border-color: #3B82F6 !important;
        color: #FFFFFF !important;
        box-shadow: 0 0 14px rgba(37, 99, 235, 0.45);
      }

      .topbar-edit-btn {
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
      }

      .btn-mode-select-all {
        background-color: #1E1E24;
        border-color: rgba(229, 231, 235, 0.18);
        color: #E5E7EB;
      }

      .btn-mode-select-all:hover {
        background-color: #2D3748;
        border-color: #4A5568;
        color: #FFFFFF;
      }

      .btn-mode-edit {
        background-color: #2563EB;
        border-color: #3B82F6;
        color: #FFFFFF;
      }

      .btn-mode-edit:hover {
        background-color: #1D4ED8;
        box-shadow: 0 0 12px rgba(37, 99, 235, 0.4);
      }

      .btn-mode-delete {
        background-color: #DC2626;
        border-color: #EF4444;
        color: #FFFFFF;
      }

      .btn-mode-delete:hover {
        background-color: #B91C1C;
        box-shadow: 0 0 12px rgba(220, 38, 38, 0.4);
      }

      /* ROW SELECTION & CHECKBOX COLUMN IN EDIT MODE */
      .col-checkbox {
        display: none !important;
        width: 44px !important;
        min-width: 44px !important;
        max-width: 48px !important;
        text-align: center !important;
        vertical-align: middle !important;
        padding: 6px 4px !important;
      }

      #previewTable.is-edit-mode .col-checkbox {
        display: table-cell !important;
      }

      .edit-master-checkbox,
      .row-checkbox {
        width: 17px !important;
        height: 17px !important;
        background-color: #1E1E24 !important;
        border: 1.5px solid rgba(229, 231, 235, 0.35) !important;
        border-radius: 4px !important;
        cursor: pointer;
        transition: all 0.15s ease;
        vertical-align: middle;
        margin: 0 auto;
        display: inline-block;
      }

      .edit-master-checkbox:hover,
      .row-checkbox:hover {
        border-color: #3B82F6 !important;
        box-shadow: 0 0 6px rgba(59, 130, 246, 0.4) !important;
      }

      .edit-master-checkbox:checked,
      .row-checkbox:checked {
        background-color: #2563EB !important;
        border-color: #3B82F6 !important;
      }

      #previewTable.is-edit-mode tbody tr {
        cursor: pointer;
      }

      #previewTable tbody tr.row-selected,
      .matrix-clean-table tbody tr.row-selected {
        background-color: rgba(37, 99, 235, 0.22) !important;
        box-shadow: inset 3px 0 0 #3B82F6;
      }

      #previewTable tbody tr.row-selected td,
      .matrix-clean-table tbody tr.row-selected td {
        background-color: transparent !important;
      }

      /* ROW INSERT INDICATOR (SEAM HIGHLIGHT IN EDIT MODE) */
      .row-insert-indicator {
        position: absolute;
        left: 0;
        height: 24px;
        transform: translateY(-50%);
        z-index: 12;
        pointer-events: auto;
        display: none;
        align-items: center;
        cursor: pointer;
      }

      .row-insert-line {
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 2px;
        background-color: #22C55E;
        box-shadow: 0 0 8px rgba(34, 197, 94, 0.75);
        pointer-events: none;
      }

      .row-insert-btn {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: #18181F;
        border: 2px solid #22C55E;
        color: #22C55E;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        pointer-events: auto;
        box-shadow: 0 0 10px rgba(34, 197, 94, 0.6), 0 2px 4px rgba(0, 0, 0, 0.5);
        transition: transform 0.15s ease, background-color 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        padding: 0;
        outline: none;
      }

      .row-insert-btn:hover {
        background-color: #22C55E;
        color: #FFFFFF;
        transform: translate(-50%, -50%) scale(1.22);
        box-shadow: 0 0 16px rgba(34, 197, 94, 0.95);
      }

      /* DESIGNATOR BATCH EDIT PANEL (MODERN DARK THEME) */
      .designator-edit-panel {
        background: #1E1E24;
        border: 1px solid rgba(229, 231, 235, 0.18);
        border-radius: 12px;
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.45);
        padding: 16px 20px;
        margin-bottom: 12px;
        animation: fadeInDown 0.2s ease-out;
      }

      @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
      }

      .designator-edit-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
      }

      .designator-edit-header h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #F3F4F6;
        display: flex;
        align-items: center;
      }

      .btn-close-panel {
        background: transparent;
        border: none;
        color: #9CA3AF;
        font-size: 1rem;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        transition: color 0.15s;
      }

      .btn-close-panel:hover {
        color: #FFFFFF;
      }

      .designator-edit-body {
        margin-bottom: 12px;
      }

      .search-input-wrapper {
        position: relative;
      }

      .search-input-wrapper .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 0.85rem;
        pointer-events: none;
      }

      .form-control-dark {
        width: 100%;
        background-color: #2B2B36;
        border: 1px solid rgba(229, 231, 235, 0.15);
        color: #F3F4F6;
        border-radius: 8px;
        padding: 8px 12px 8px 36px;
        font-size: 0.85rem;
        transition: border-color 0.15s;
      }

      .form-control-dark:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
      }

      .form-control-dark::placeholder {
        color: #94A3B8;
        opacity: 0.9;
      }

      .designator-scroll-list {
        max-height: 200px;
        overflow-y: auto;
        background-color: #2B2B36;
        border: 1px solid rgba(229, 231, 235, 0.1);
        border-radius: 8px;
        margin-top: 8px;
      }

      .designator-list-item {
        padding: 9px 14px;
        font-size: 0.85rem;
        color: #D1D5DB;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        transition: all 0.15s ease;
      }

      .designator-list-item:last-child {
        border-bottom: none;
      }

      .designator-list-item:hover {
        background-color: #353542;
        color: #FFFFFF;
      }

      .designator-list-item.active {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.25), rgba(30, 64, 175, 0.35)) !important;
        border-left: 3px solid #3B82F6;
        color: #60A5FA !important;
        font-weight: 700;
      }

      .designator-list-item .check-icon {
        display: none;
        color: #60A5FA;
      }

      .designator-list-item.active .check-icon {
        display: inline-block;
      }

      .designator-edit-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid rgba(229, 231, 235, 0.1);
      }

      .selected-designator-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
      }

      .badge-designator-pill {
        background-color: #DC2626;
        color: #FFFFFF;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.3px;
      }

      .btn-panel-action {
        border-radius: 7px;
        padding: 6px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.15s ease;
      }

      .btn-panel-apply {
        background-color: #DC2626;
        color: #FFFFFF;
      }

      .btn-panel-apply:hover:not(:disabled) {
        background-color: #B91C1C;
        box-shadow: 0 0 10px rgba(220, 38, 38, 0.4);
      }

      .btn-panel-apply:disabled {
        opacity: 0.4;
        cursor: not-allowed;
      }

      .btn-panel-cancel {
        background-color: #374151;
        color: #E5E7EB;
      }

      .btn-panel-cancel:hover {
        background-color: #4B5563;
        color: #FFFFFF;
      }

      /* MATRIX TABLE CARD - FULL DARK */
      .matrix-table-card {
        background-color: #2B2B36;
        border-radius: 14px;
        overflow: hidden;
        border: 1.5px solid rgba(229, 231, 235, 0.15);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
        flex: 1;
        display: flex !important;
        flex-direction: column;
        min-height: 0;
        height: 100%;
      }

      .matrix-scroll-container {
        position: relative;
        overflow-y: auto;
        overflow-x: auto;
        flex: 1;
        height: 100%;
        min-height: 0;
        background-color: #2B2B36;
      }

      .matrix-clean-table,
      #previewTable {
        --bs-table-bg: transparent !important;
        --bs-table-accent-bg: transparent !important;
        --bs-table-striped-bg: transparent !important;
        --bs-table-hover-bg: #353542 !important;
        --bs-table-color: #E5E7EB !important;
        --bs-table-border-color: rgba(229, 231, 235, 0.08) !important;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
        background-color: #2B2B36 !important;
        color: #E5E7EB !important;
      }

      .matrix-clean-table > :not(caption) > * > *,
      #previewTable > :not(caption) > * > * {
        background-color: transparent !important;
        box-shadow: none !important;
      }

      .matrix-clean-table thead,
      #previewTable thead {
        position: sticky;
        top: 0;
        z-index: 25;
        background-color: #1E1E24;
      }

      .matrix-clean-table th.th-clean, #previewTable thead th {
        background-color: #1E1E24 !important;
        background-image: none !important;
        color: #FFFFFF !important;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.4px;
        padding: 10px 12px !important;
        border: 1px solid rgba(229, 231, 235, 0.12) !important;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        box-shadow: none !important;
      }

      /* Vertical Headers */
      #previewTable thead .th-vertical,
      .th-vertical {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        text-orientation: mixed;
        white-space: nowrap;
        height: 120px;
        width: 44px;
        min-width: 44px;
        max-width: 48px;
        padding: 8px 4px !important;
        font-size: 0.75rem;
        font-weight: 800;
        color: #FFFFFF !important;
        text-align: center;
        vertical-align: middle;
        border: 1px solid rgba(229, 231, 235, 0.12) !important;
        background-color: #1E1E24 !important;
        box-shadow: none !important;
      }

      .matrix-clean-table th.th-sub {
        font-size: 0.75rem;
        font-weight: 700;
        color: #9CA3AF !important;
        background-color: #18181F !important;
        border: 1px solid rgba(229, 231, 235, 0.12) !important;
        box-shadow: none !important;
      }

      #previewTable thead .th-dynamic-designator {
        background-color: #1E1E24 !important;
        color: #FFFFFF !important;
        border-color: rgba(229, 231, 235, 0.12) !important;
        box-shadow: none !important;
      }

      /* Table Body - Dark Rows */
      .matrix-clean-table tbody tr, #previewTable tbody tr {
        transition: background 0.15s;
        background-color: #2B2B36 !important;
      }

      .matrix-clean-table tbody tr:hover, #previewTable tbody tr:hover {
        background-color: #353542 !important;
      }

      .matrix-clean-table tbody tr:nth-child(even), #previewTable tbody tr:nth-child(even) {
        background-color: #24242F !important;
      }

      .matrix-clean-table tbody td, #previewTable tbody td {
        padding: 8px 10px !important;
        font-size: 0.82rem;
        color: #E5E7EB !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: 1px solid rgba(229, 231, 235, 0.08) !important;
        vertical-align: middle;
      }

      #previewTable td[data-col="no"] {
        font-weight: 600;
        color: #9CA3AF !important;
        width: 44px;
        text-align: center;
        background-color: #1E1E24 !important;
      }

      #previewTable tbody td.dynamic-designator-cell {
        width: 44px;
        min-width: 42px;
        max-width: 48px;
        text-align: center;
        padding: 6px 2px !important;
        background-color: transparent !important;
        color: #E5E7EB !important;
      }

      /* Editable cell styling in Dark Mode */
      #previewTable td[contenteditable="true"] {
        background-color: transparent !important;
        color: #E5E7EB !important;
        transition: all 0.2s ease;
        outline: none;
        cursor: text;
      }

      #previewTable td[contenteditable="true"]:hover {
        background-color: rgba(220, 38, 38, 0.15) !important;
        color: #FFFFFF !important;
      }

      #previewTable td[contenteditable="true"]:focus {
        background-color: #111827 !important;
        color: #FFFFFF !important;
        outline: 2px solid #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.3) !important;
      }

      /* Designator Cell Autocomplete Dropdown - Dark Theme */
      #designatorAutocomplete {
        position: absolute;
        background-color: #1E1E24;
        border: 1.5px solid #DC2626;
        border-radius: 6px;
        max-height: 220px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 99999;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.65), 0 0 0 1px rgba(220, 38, 38, 0.25);
        box-sizing: border-box;
      }

      #designatorAutocomplete::-webkit-scrollbar {
        width: 6px;
      }
      #designatorAutocomplete::-webkit-scrollbar-track {
        background: #18181F;
        border-radius: 4px;
      }
      #designatorAutocomplete::-webkit-scrollbar-thumb {
        background: #374151;
        border-radius: 4px;
      }
      #designatorAutocomplete::-webkit-scrollbar-thumb:hover {
        background: #4B5563;
      }

      .designator-autocomplete-item {
        padding: 8px 12px;
        cursor: pointer;
        font-size: 0.82rem;
        font-weight: 500;
        color: #E5E7EB;
        transition: background-color 0.15s ease, color 0.15s ease;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        user-select: none;
      }

      .designator-autocomplete-item:last-child {
        border-bottom: none;
      }

      .designator-autocomplete-item:hover,
      .designator-autocomplete-item.is-hovered {
        background-color: rgba(220, 38, 38, 0.28) !important;
        color: #FFFFFF !important;
      }

      .designator-autocomplete-item.is-selected {
        background-color: rgba(220, 38, 38, 0.4) !important;
        color: #FFFFFF !important;
        font-weight: 700;
      }

      .designator-autocomplete-empty {
        padding: 10px 12px;
        color: #9CA3AF;
        font-size: 0.82rem;
        text-align: center;
        font-style: italic;
      }

      /* GRAND TOTAL ROW - DARK THEME */
      #previewTable tfoot {
        position: sticky;
        bottom: 0;
        z-index: 25;
      }

      #previewTable tfoot tr#grandTotalRow {
        background-color: #18181F !important;
        border-top: 2px solid #DC2626 !important;
        border-bottom: 2px solid #DC2626 !important;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.45);
      }

      #grandTotalRow td.grand-total-cell {
        padding: 9px 8px !important;
        font-size: 0.82rem;
        color: #9CA3AF !important;
        vertical-align: middle;
        background-color: #18181F !important;
        border: 1px solid rgba(229, 231, 235, 0.12) !important;
      }

      #grandTotalRow td.grand-total-label {
        color: #DC2626 !important;
        font-weight: 800;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        font-size: 0.85rem;
      }

      #grandTotalRow td.grand-total-dynamic-cell {
        font-weight: 700;
        color: #FFFFFF !important;
        background-color: rgba(220, 38, 38, 0.12) !important;
      }

      /* BOTTOM TOOLBAR - DARK */
      .matrix-bottom-bar {
        background-color: #2B2B36;
        border-radius: 12px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid rgba(229, 231, 235, 0.1);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        min-height: 48px;
        flex-shrink: 0;
        position: relative !important;
        z-index: 50 !important;
        pointer-events: auto !important;
      }

      .bottom-pill-btn {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #E5E7EB;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.2s;
      }

      .bottom-pill-btn:hover:not(:disabled) {
        background-color: #24242F;
        color: #FFFFFF;
        border-color: #4B5563;
      }

      .bottom-pill-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
      }

      .btn-download-green {
        background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer !important;
        display: flex;
        align-items: center;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.35);
        position: relative !important;
        z-index: 51 !important;
        pointer-events: auto !important;
      }

      .btn-download-green:hover:not(:disabled):not(.is-disabled) {
        background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(22, 163, 74, 0.45);
      }

      .btn-download-green.is-disabled,
      .btn-download-green:disabled {
        background: #374151 !important;
        opacity: 0.55 !important;
        cursor: pointer !important;
        pointer-events: auto !important;
        box-shadow: none !important;
        transform: none !important;
      }

      .btn-download-pdf {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer !important;
        display: flex;
        align-items: center;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        position: relative !important;
        z-index: 51 !important;
        pointer-events: auto !important;
      }

      .btn-download-pdf:hover:not(:disabled):not(.is-disabled) {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.45);
      }

      .btn-download-pdf.is-disabled,
      .btn-download-pdf:disabled {
        background: #374151 !important;
        opacity: 0.55 !important;
        cursor: pointer !important;
        pointer-events: auto !important;
        box-shadow: none !important;
        transform: none !important;
      }

      /* Custom scrollbars - Dark */
      ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
      }

      ::-webkit-scrollbar-track {
        background: #1E1E24;
        border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb {
        background: #374151;
        border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #4B5563;
      }

      /* ========== MAP: ADD PLACEMARK FEATURE ========== */
      #mapPemetaanContainer {
        width: 100% !important;
        height: 100% !important;
        flex: 1 1 auto !important;
        min-height: 400px !important;
        position: relative !important;
        background: #14171f !important;
      }
      #mapPemetaanContainer .leaflet-container,
      .leaflet-container {
        width: 100% !important;
        height: 100% !important;
        min-height: 400px !important;
        background: #14171f !important;
      }
      #mapPemetaanContainer .leaflet-container,
      .leaflet-container {
        width: 100% !important;
        height: 100% !important;
        background: #14171f !important;
      }
      #pmToolbar {
        position: static !important;
        top: auto !important;
        right: auto !important;
        bottom: auto !important;
        left: auto !important;
        z-index: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 16px 22px !important;
        box-sizing: border-box !important;
      }
      .pm-tool-btn {
        height: 36px;
        padding: 0 14px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        letter-spacing: 0.2px;
      }
      .pm-tool-btn.add-btn {
        background: linear-gradient(135deg, #38A169, #2F855A);
        color: #fff;
      }
      .pm-tool-btn.add-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(47,133,90,0.5);
      }
      .pm-tool-btn.add-btn.active {
        background: linear-gradient(135deg, #E53E3E, #C53030);
        box-shadow: 0 0 0 3px rgba(229,62,62,0.35);
        animation: pmPulse 1.5s infinite;
      }
      .pm-tool-btn.list-btn {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.3);
      }
      .pm-tool-btn.list-btn:hover {
        background: rgba(255,255,255,0.28);
      }
      .pm-tool-btn.export-btn {
        background: linear-gradient(135deg, #3182CE, #2C5282);
        color: #fff;
      }
      .pm-tool-btn.export-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(49,130,206,0.5);
      }
      .pm-tool-btn.cable-btn {
        background: linear-gradient(135deg, #805AD5, #6B46C1);
        color: #fff;
      }
      .pm-tool-btn.cable-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(107,70,193,0.5);
      }
      .pm-tool-btn.cable-btn.active {
        background: linear-gradient(135deg, #E53E3E, #C53030);
        box-shadow: 0 0 0 3px rgba(229,62,62,0.35);
        animation: pmPulse 1.5s infinite;
      }
      @keyframes pmPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
      }
      /* Crosshair cursor saat mode add / draw kabel aktif */
      #mapPemetaanContainer.adding-placemark,
      #mapPemetaanContainer.drawing-cable {
        cursor: crosshair !important;
      }
      #mapPemetaanContainer.adding-placemark .leaflet-container,
      #mapPemetaanContainer.drawing-cable .leaflet-container {
        cursor: crosshair !important;
      }
      /* Popup form add placemark & add cable (Dark Glassmorphism matching Informasi Pemetaan KML Baru) */
      #pmFormPopup, #cableFormPopup {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1200;
        background: #25252D;
        border-radius: 14px;
        box-shadow: 0 16px 48px rgba(0,0,0,0.6);
        width: 320px;
        display: none;
        border: 1px solid rgba(255,255,255,0.1);
        animation: pmSlideIn 0.2s ease-out;
        overflow: hidden;
        box-sizing: border-box;
      }
      #cableFormPopup {
        width: 340px;
        border-color: rgba(139, 92, 246, 0.25);
      }
      @keyframes pmSlideIn {
        from { opacity: 0; transform: scale(0.92) translateY(6px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
      }
      .pm-popup-header {
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .pm-header-green {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.35) 0%, rgba(37, 37, 45, 0.98) 100%);
        border-bottom: 1px solid rgba(16, 185, 129, 0.25);
      }
      .pm-header-purple {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.45) 0%, rgba(37, 37, 45, 0.98) 100%);
        border-bottom: 1px solid rgba(139, 92, 246, 0.3);
      }
      .pm-popup-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #FFFFFF;
        margin: 0;
        display: flex;
        align-items: center;
      }
      .pm-popup-subtitle {
        font-size: 0.72rem;
        color: #9CA3AF;
        margin: 2px 0 0;
        line-height: 1.25;
      }
      .pm-popup-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 8px !important;
        padding: 7px !important;
        background-size: 9px !important;
        opacity: 0.85;
        transition: all 0.2s ease;
      }
      .pm-popup-header .btn-close:hover {
        opacity: 1;
        border-color: rgba(255, 255, 255, 0.45) !important;
        transform: scale(1.05);
      }
      .btn-reset-defaults {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 6px;
        color: #E5E7EB;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 4px 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 4px;
      }
      .btn-reset-defaults:hover {
        background: rgba(255,255,255,0.18);
        color: #FFFFFF;
      }
      .pm-popup-body {
        padding: 16px 18px 18px;
      }
      .pm-label, #pmFormPopup label, #cableFormPopup label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #E5E7EB;
        margin-bottom: 5px;
        display: block;
      }
      #pmFormPopup input:not([type="color"]), #pmFormPopup select, #pmFormPopup textarea,
      #cableFormPopup input:not([type="color"]), #cableFormPopup select, #cableFormPopup textarea {
        width: 100%;
        border: 1px solid #374151;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.83rem;
        outline: none;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
        margin-bottom: 11px;
        color: #FFFFFF;
        background-color: #111827;
        box-sizing: border-box;
      }
      #pmFormPopup input::placeholder, #pmFormPopup textarea::placeholder,
      #cableFormPopup input::placeholder, #cableFormPopup textarea::placeholder {
        color: #9CA3AF !important;
        opacity: 1 !important;
      }
      #pmFormPopup select, #cableFormPopup select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
        cursor: pointer;
      }
      #pmFormPopup input:not([type="color"]):focus, #pmFormPopup select:focus, #pmFormPopup textarea:focus {
        border-color: #10B981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
      }
      #cableFormPopup input:not([type="color"]):focus, #cableFormPopup select:focus, #cableFormPopup textarea:focus {
        border-color: #8B5CF6;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.3);
      }
      .pm-coords-display, #cableLengthDisplay {
        display: flex;
        align-items: center;
        gap: 7px;
        background: rgba(139, 92, 246, 0.15);
        border: 1px solid rgba(139, 92, 246, 0.35);
        color: #DDD6FE;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.79rem;
        font-weight: 600;
        margin-bottom: 12px;
      }
      /* Autocomplete Dropdown untuk Input Placemark */
      .pm-ac-wrapper {
        position: relative;
        margin-bottom: 10px;
      }
      .pm-ac-wrapper input {
        margin-bottom: 0 !important;
      }
      #pmNameAutocomplete {
        position: absolute;
        top: calc(100% + 3px);
        left: 0;
        right: 0;
        background: #181820;
        border: 1px solid #374151;
        border-radius: 8px;
        max-height: 185px;
        overflow-y: auto;
        z-index: 1300;
        box-shadow: 0 12px 28px rgba(0,0,0,0.6);
        display: none;
      }
      #pmNameAutocomplete::-webkit-scrollbar { width: 5px; }
      #pmNameAutocomplete::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
      .pm-ac-item {
        padding: 8px 12px;
        font-size: 0.82rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #E5E7EB;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        transition: background 0.15s ease;
      }
      .pm-ac-item:last-child { border-bottom: none; }
      .pm-ac-item:hover, .pm-ac-item.active {
        background: rgba(16, 185, 129, 0.18);
        color: #34D399;
        font-weight: 600;
      }
      .pm-ac-item .badge {
        font-size: 0.65rem;
        padding: 3px 6px;
      }
      .pm-ac-empty {
        padding: 10px 12px;
        font-size: 0.78rem;
        color: #9CA3AF;
        text-align: center;
        font-style: italic;
      }
      #pmFormPopup textarea { resize: vertical; min-height: 56px; }
      /* Shape Selector (Triangle / Donut / Square) */
      .pm-shape-group {
        display: flex;
        gap: 7px;
        margin-bottom: 10px;
      }
      .pm-shape-btn {
        flex: 1;
        height: 58px;
        border: 1.5px solid #374151;
        border-radius: 8px;
        background: #181820;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: all 0.18s ease;
        font-size: 0.7rem;
        font-weight: 600;
        color: #9CA3AF;
        padding: 4px;
      }
      .pm-shape-icon-wrap {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        filter: drop-shadow(0 2px 5px rgba(0,0,0,0.5));
      }
      .pm-shape-icon-wrap svg {
        display: block;
      }
      .pm-shape-btn:hover {
        border-color: #10B981;
        background: rgba(16, 185, 129, 0.1);
        color: #34D399;
      }
      .pm-shape-btn.active {
        border-color: #10B981;
        background: rgba(16, 185, 129, 0.18);
        color: #10B981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
      }
      /* Color Picker Row */
      .pm-color-row {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
      }
      .pm-color-cell {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
      }
      .pm-color-cell label {
        font-size: 0.73rem;
        font-weight: 600;
        color: #D1D5DB;
        margin-bottom: 0;
      }
      .pm-color-input-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #374151;
        border-radius: 8px;
        padding: 5px 8px;
        background: #111827;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
      }
      .pm-color-input-wrap:hover {
        border-color: #10B981;
        background: #181820;
      }
      #pmFormPopup input[type="color"],
      #cableFormPopup input[type="color"],
      .pm-color-input-wrap input[type="color"] {
        width: 26px !important;
        height: 26px !important;
        min-width: 26px !important;
        max-width: 26px !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        border-radius: 6px !important;
        padding: 0 !important;
        cursor: pointer !important;
        background: transparent !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
        -webkit-appearance: none !important;
        appearance: none !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        box-sizing: border-box !important;
      }
      #pmFormPopup input[type="color"]::-webkit-color-swatch-wrapper,
      #cableFormPopup input[type="color"]::-webkit-color-swatch-wrapper,
      .pm-color-input-wrap input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0 !important;
        border-radius: 5px;
      }
      #pmFormPopup input[type="color"]::-webkit-color-swatch,
      #cableFormPopup input[type="color"]::-webkit-color-swatch,
      .pm-color-input-wrap input[type="color"]::-webkit-color-swatch {
        border: none !important;
        border-radius: 5px !important;
      }
      #pmFormPopup input[type="color"]::-moz-color-swatch,
      #cableFormPopup input[type="color"]::-moz-color-swatch,
      .pm-color-input-wrap input[type="color"]::-moz-color-swatch {
        border: none !important;
        border-radius: 5px !important;
      }
      .pm-color-hex-label {
        font-size: 0.74rem;
        font-weight: 600;
        color: #E5E7EB;
        font-family: 'JetBrains Mono', Consolas, monospace;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      #pmFormPopup .pm-form-actions, #cableFormPopup .pm-form-actions {
        display: flex;
        gap: 8px;
        margin-top: 6px;
      }
      #pmFormPopup .pm-form-actions button, #cableFormPopup .pm-form-actions button {
        flex: 1;
        height: 36px;
        border: none;
        border-radius: 8px;
        font-size: 0.81rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.18s ease;
      }
      #pmFormPopup .pm-save-btn {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
      }
      #pmFormPopup .pm-save-btn:hover {
        filter: brightness(1.08);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.45);
      }
      #pmFormPopup .pm-save-btn:active {
        transform: translateY(0);
      }
      #cableFormPopup .pm-save-btn, .pm-save-purple {
        background: linear-gradient(135deg, #8B5CF6, #6D28D9) !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.35) !important;
      }
      #cableFormPopup .pm-save-btn:hover, .pm-save-purple:hover {
        filter: brightness(1.08) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 14px rgba(139, 92, 246, 0.45) !important;
      }
      #cableFormPopup .pm-save-btn:active, .pm-save-purple:active {
        transform: translateY(0) !important;
      }
      #pmFormPopup .pm-cancel-btn, #cableFormPopup .pm-cancel-btn {
        background: #374151;
        color: #E5E7EB;
      }
      #pmFormPopup .pm-cancel-btn:hover, #cableFormPopup .pm-cancel-btn:hover {
        background: #4B5563;
        color: #FFFFFF;
      }
      /* Panel daftar placemark */
      #pmListPanel {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 320px;
        max-width: 90%;
        background: #1E1E24;
        backdrop-filter: blur(16px);
        z-index: 1200;
        display: none;
        flex-direction: column;
        border-left: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: -8px 0 28px rgba(0, 0, 0, 0.5);
        transition: all 0.25s ease;
      }
      #pmListPanel.open { display: flex !important; }
      #pmListPanel .pm-panel-header {
        padding: 14px 16px 12px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
      }
      #pmListPanel .pm-panel-header span {
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
      }
      #pmListPanel .pm-panel-close {
        width: 28px; height: 28px;
        border: 1.5px solid rgba(255,255,255,0.2);
        background: transparent;
        border-radius: 6px;
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        font-size: 0.9rem;
        display: flex; align-items: center; justify-content: center;
      }
      #pmListPanel .pm-panel-close:hover { background: rgba(255,255,255,0.12); color: #fff; }
      #pmListScroll {
        flex: 1;
        overflow-y: auto;
        padding: 8px 10px;
      }
      #pmListScroll::-webkit-scrollbar { width: 5px; }
      #pmListScroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.04); }
      #pmListScroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.18); border-radius: 4px; }
      .pm-list-item {
        background: rgba(255,255,255,0.06);
        border-radius: 8px;
        padding: 10px 12px;
        margin-bottom: 7px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        transition: background 0.15s;
      }
      .pm-list-item:hover { background: rgba(255,255,255,0.1); }
      .pm-list-icon {
        width: 30px; height: 30px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        margin-top: 2px;
      }
      .pm-list-icon i { transform: rotate(45deg); font-size: 13px; color: #fff; }
      .pm-list-info { flex: 1; min-width: 0; }
      .pm-list-name {
        font-size: 0.82rem;
        font-weight: 700;
        color: #fff;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 2px;
      }
      .pm-list-cat {
        font-size: 0.7rem;
        color: rgba(255,255,255,0.5);
        margin-bottom: 2px;
      }
      .pm-list-coords {
        font-size: 0.68rem;
        color: rgba(255,255,255,0.35);
        font-family: monospace;
      }
      .pm-list-delete {
        background: transparent;
        border: 1.5px solid rgba(229,62,62,0.35);
        color: rgba(229,62,62,0.7);
        width: 26px; height: 26px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
        transition: all 0.15s;
      }
      .pm-list-delete:hover { background: rgba(229,62,62,0.15); color: #E53E3E; border-color: #E53E3E; }
      .pm-empty-state {
        color: rgba(255,255,255,0.3);
        font-size: 0.8rem;
        text-align: center;
        padding: 40px 20px;
      }
      .pm-empty-state i { font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.4; }
      #pmListPanel .pm-panel-footer {
        padding: 12px 14px;
        background: rgba(0, 0, 0, 0.28);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        box-sizing: border-box;
      }
      .pm-clear-row {
        display: flex;
        gap: 8px;
        width: 100%;
        box-sizing: border-box;
      }
      .pm-btn-clear {
        height: 38px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
        outline: none;
        box-sizing: border-box;
      }
      .pm-btn-clear:hover {
        transform: translateY(-1px);
      }
      .pm-btn-clear:active {
        transform: translateY(0);
      }
      .pm-btn-clear-points {
        flex: 1;
        background: rgba(239, 68, 68, 0.14);
        color: #F87171;
        border: 1px solid rgba(239, 68, 68, 0.38);
      }
      .pm-btn-clear-points:hover {
        background: rgba(239, 68, 68, 0.26);
        color: #FFFFFF;
        border-color: #EF4444;
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.35);
      }
      .pm-btn-clear-cables {
        flex: 1;
        background: rgba(139, 92, 246, 0.14);
        color: #C4B5FD;
        border: 1px solid rgba(139, 92, 246, 0.38);
      }
      .pm-btn-clear-cables:hover {
        background: rgba(139, 92, 246, 0.26);
        color: #FFFFFF;
        border-color: #8B5CF6;
        box-shadow: 0 2px 10px rgba(139, 92, 246, 0.35);
      }
      .pm-btn-clear-all {
        width: 100%;
        background: rgba(220, 38, 38, 0.2);
        color: #FCA5A5;
        border: 1px solid rgba(220, 38, 38, 0.5);
        font-weight: 700;
      }
      .pm-btn-clear-all:hover {
        background: rgba(220, 38, 38, 0.38);
        color: #FFFFFF;
        border-color: #DC2626;
        box-shadow: 0 3px 12px rgba(220, 38, 38, 0.45);
      }
    
      /* ========== DASHBOARD STATS & EXECUTIVE OVERVIEW ========== */
      .landing-view-container {
        width: 100%;
        height: 100%;
        min-height: 0;
        flex: 1;
        display: flex;
        box-sizing: border-box;
      }

      .dashboard-stats-grid {
        width: 100%;
        height: 100%;
        min-height: 0;
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 16px;
        align-items: stretch;
      }

      @media (max-width: 1100px) {
        .dashboard-stats-grid {
          grid-template-columns: 1fr 300px;
        }
      }

      @media (max-width: 900px) {
        .dashboard-stats-grid {
          grid-template-columns: 1fr;
        }
        .landing-view-container {
          height: auto;
          min-height: auto;
        }
      }

      /* Left Column: Top 3 KPI Cards, Bottom Trend Chart */
      .dashboard-left-col {
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-width: 0;
        min-height: 0;
        height: 100%;
      }

      /* Right Column: Top Upload KML, Bottom Pemetaan Baru */
      .dashboard-right-col {
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-height: 0;
        height: 100%;
      }

      /* KPI Stat Cards Grid */
      .stats-kpi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
      }

      @media (max-width: 768px) {
        .stats-kpi-grid {
          grid-template-columns: 1fr;
        }
      }

      .kpi-stat-card {
        background-color: #2B2B36;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, border-color 0.2s ease;
      }

      .kpi-stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.16);
      }

      .kpi-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
      }

      .kpi-icon-red {
        background: rgba(220, 38, 38, 0.15);
        color: #EF4444;
        border: 1px solid rgba(220, 38, 38, 0.3);
      }

      .kpi-icon-blue {
        background: rgba(59, 130, 246, 0.15);
        color: #60A5FA;
        border: 1px solid rgba(59, 130, 246, 0.3);
      }

      .kpi-icon-green {
        background: rgba(16, 185, 129, 0.15);
        color: #34D399;
        border: 1px solid rgba(16, 185, 129, 0.3);
      }

      .kpi-content {
        flex: 1;
        min-width: 0;
      }

      .kpi-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #9CA3AF;
        margin-bottom: 2px;
      }

      .kpi-value-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 8px;
      }

      .kpi-number {
        font-size: 1.45rem;
        font-weight: 800;
        color: #FFFFFF;
        letter-spacing: -0.5px;
      }

      .kpi-badge {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 6px;
      }

      .badge-red {
        background: rgba(220, 38, 38, 0.18);
        color: #FCA5A5;
      }

      .badge-blue {
        background: rgba(59, 130, 246, 0.18);
        color: #93C5FD;
      }

      .badge-green {
        background: rgba(16, 185, 129, 0.18);
        color: #A7F3D0;
      }

      /* Chart Card (Fills remaining height in Left Column) */
      .dashboard-left-col .chart-card {
        flex: 1;
        background-color: #2B2B36;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.28);
        min-height: 0;
      }

      .chart-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        gap: 8px;
        flex-wrap: wrap;
      }

      .chart-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #FFFFFF;
      }

      .filter-item-group {
        display: flex;
        align-items: center;
        gap: 6px;
      }

      .filter-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #D1D5DB;
        margin-bottom: 0;
      }

      .stats-filter-select {
        background-color: #1E1E24;
        border: 1px solid #374151;
        color: #F3F4F6;
        font-size: 0.78rem;
        font-weight: 500;
        border-radius: 8px;
        padding: 5px 12px;
        outline: none;
        transition: all 0.2s;
        cursor: pointer;
      }

      .stats-filter-select:focus {
        border-color: #DC2626;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.25);
      }

      .btn-stats-reset {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid #374151;
        color: #9CA3AF;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.2s;
      }

      .btn-stats-reset:hover {
        background-color: rgba(220, 38, 38, 0.15);
        color: #EF4444;
        border-color: #DC2626;
      }

      .chart-card-body {
        flex: 1 1 0;
        position: relative;
        min-height: 0;
        width: 100%;
        height: 100%;
      }

      .chart-card-body canvas {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
      }

      /* Launchpad Cards (Right Column) */
      .dashboard-right-col .launchpad-card {
        flex: 1;
        background-color: #2B2B36;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.28);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        min-height: 0;
      }

      .launchpad-card-red {
        border: 1.5px solid rgba(220, 38, 38, 0.25);
      }

      .launchpad-card-red:hover {
        border-color: #DC2626;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(220, 38, 38, 0.2);
      }

      .launchpad-card-green {
        border: 1.5px solid rgba(16, 185, 129, 0.25);
      }

      .launchpad-card-green:hover {
        border-color: #10B981;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(16, 185, 129, 0.2);
      }

      .launchpad-card-header {
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      }

      .launchpad-card-red .launchpad-card-header {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.3) 0%, rgba(43, 43, 54, 0.95) 100%);
      }

      .launchpad-card-green .launchpad-card-header {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.3) 0%, rgba(43, 43, 54, 0.95) 100%);
      }

      .launchpad-header-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #FFFFFF;
      }

      .launchpad-card-body {
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        flex: 1;
        justify-content: space-between;
      }

      .launchpad-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-bottom: 6px;
      }

      .launchpad-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 4px;
      }

      .launchpad-desc {
        font-size: 0.75rem;
        color: #9CA3AF;
        margin-bottom: 12px;
        line-height: 1.35;
      }

      .launchpad-action-btn {
        width: 100%;
        padding: 8px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        margin-top: auto;
      }


      .landing-card {
        background-color: #2B2B36;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      }

      .landing-card-red {
        border: 1.5px solid rgba(220, 38, 38, 0.25);
      }

      .landing-card-red:hover {
        border-color: #DC2626;
        transform: translateY(-3px);
        box-shadow: 0 14px 36px rgba(220, 38, 38, 0.2), 0 0 20px rgba(220, 38, 38, 0.15);
      }

      .landing-card-green {
        border: 1.5px solid rgba(16, 185, 129, 0.25);
      }

      .landing-card-green:hover {
        border-color: #10B981;
        transform: translateY(-3px);
        box-shadow: 0 14px 36px rgba(16, 185, 129, 0.2), 0 0 20px rgba(16, 185, 129, 0.15);
      }

      .landing-card-header {
        padding: 15px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      }

      .landing-card-red .landing-card-header {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.35) 0%, rgba(43, 43, 54, 0.95) 100%);
      }

      .landing-card-green .landing-card-header {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.35) 0%, rgba(43, 43, 54, 0.95) 100%);
      }

      .landing-header-title {
        font-size: 0.94rem;
        font-weight: 700;
        color: #FFFFFF;
        letter-spacing: 0.2px;
      }

      .landing-header-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
      }

      .dot-red {
        background-color: #DC2626;
        box-shadow: 0 0 8px #DC2626;
      }

      .dot-green {
        background-color: #10B981;
        box-shadow: 0 0 8px #10B981;
      }

      .landing-badge-red {
        background: rgba(220, 38, 38, 0.18);
        color: #FCA5A5;
        border: 1px solid rgba(220, 38, 38, 0.35);
        font-size: 0.74rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
      }

      .landing-badge-green {
        background: rgba(16, 185, 129, 0.18);
        color: #6EE7B7;
        border: 1px solid rgba(16, 185, 129, 0.35);
        font-size: 0.74rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
      }

      .landing-card-body {
        padding: 28px 26px 26px;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .landing-icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 18px;
        transition: transform 0.25s ease;
      }

      .landing-card:hover .landing-icon-circle {
        transform: scale(1.06);
      }

      .icon-circle-red {
        background: rgba(220, 38, 38, 0.12);
        color: #EF4444;
        border: 1.5px solid rgba(220, 38, 38, 0.3);
        box-shadow: 0 0 22px rgba(220, 38, 38, 0.2);
      }

      .icon-circle-green {
        background: rgba(16, 185, 129, 0.12);
        color: #10B981;
        border: 1.5px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 0 22px rgba(16, 185, 129, 0.2);
      }

      .landing-title {
        font-size: 1.28rem;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 10px;
        letter-spacing: -0.2px;
      }

      .landing-desc {
        font-size: 0.86rem;
        color: #9CA3AF;
        line-height: 1.6;
        max-width: 390px;
        margin: 0 auto 24px;
      }

      .landing-meta-box {
        background-color: #111827;
        border: 1px solid rgba(229, 231, 235, 0.1);
        border-radius: 11px;
        padding: 9px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        width: 100%;
        max-width: 380px;
        justify-content: center;
      }

      .landing-meta-box .meta-item {
        font-size: 0.76rem;
        color: #D1D5DB;
        display: flex;
        align-items: center;
      }

      .landing-action-btn {
        width: 100%;
        max-width: 300px;
        height: 45px;
        padding: 0 22px;
        border-radius: 11px;
        font-size: 0.9rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
      }

      .btn-landing-red {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        color: #FFFFFF;
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.4);
      }

      .btn-landing-red:hover {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.55);
      }

      .btn-landing-green {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: #FFFFFF;
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
      }

      .btn-landing-green:hover {
        background: linear-gradient(135deg, #34D399 0%, #10B981 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.55);
      }

      /* ========== PEMETAAN WORKSPACE (MIRRORED LAYOUT: MAP LEFT, CONTROLS RIGHT) ========== */
      .pemetaan-workspace-grid {
        display: flex;
        gap: 18px;
        height: 100%;
        min-height: 0;
        max-height: 100%;
        width: 100%;
        flex: 1;
        box-sizing: border-box;
      }

      .pemetaan-map-panel {
        flex: 1;
        min-width: 0;
        height: 100%;
        min-height: 0;
        display: flex;
        flex-direction: column;
        background-color: #14171F;
        border-radius: 14px;
        overflow: hidden;
        border: 1.5px solid rgba(229, 231, 235, 0.15);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
        position: relative;
      }

      .pemetaan-map-topbar {
        height: 48px;
        background-color: #1E1E24;
        border-bottom: 1px solid rgba(229, 231, 235, 0.12);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
        z-index: 10;
        flex-shrink: 0;
      }

      .map-topbar-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: rgba(16, 185, 129, 0.2);
        color: #10B981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
      }

      .map-topbar-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #FFFFFF;
        line-height: 1.2;
      }

      .map-topbar-meta {
        font-size: 0.74rem;
        color: #9CA3AF;
      }

      .btn-map-back {
        background-color: #2B2B36;
        border: 1px solid #374151;
        color: #E5E7EB;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
      }

      .btn-map-back:hover {
        background-color: #374151;
        border-color: #9CA3AF;
        color: #FFFFFF;
      }

      .pemetaan-control-panel {
        width: 310px;
        min-width: 310px;
        height: 100%;
        min-height: 0;
        display: flex;
        flex-direction: column;
      }

      .pemetaan-control-card {
        background-color: #2B2B36;
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(16, 185, 129, 0.22);
      }

      .pemetaan-control-header {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.35) 0%, rgba(43, 43, 54, 0.95) 100%);
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      }

      .control-header-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #FFFFFF;
        letter-spacing: 0.2px;
      }

      .pemetaan-control-body {
        padding: 16px 22px !important;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
        overflow-y: auto;
        box-sizing: border-box !important;
      }

      .pemetaan-tool-card {
        width: 100%;
        box-sizing: border-box !important;
        background-color: #1E1E24;
        border: 1px solid #374151;
        border-radius: 12px;
        padding: 11px 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: #FFFFFF;
        outline: none;
      }

      .pemetaan-tool-card:hover {
        background-color: #24242F;
        border-color: #4B5563;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      }

      .tool-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
      }

      .icon-placemark {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
      }

      .icon-cable {
        background: rgba(139, 92, 246, 0.15);
        color: #A78BFA;
        border: 1px solid rgba(139, 92, 246, 0.3);
      }

      .icon-list {
        background: rgba(59, 130, 246, 0.15);
        color: #60A5FA;
        border: 1px solid rgba(59, 130, 246, 0.3);
      }

      .icon-export {
        background: rgba(245, 158, 11, 0.15);
        color: #FBBF24;
        border: 1px solid rgba(245, 158, 11, 0.3);
      }

      .tool-info-wrap {
        flex: 1;
        text-align: left;
      }

      .tool-main-name {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #FFFFFF;
        line-height: 1.25;
      }

      .tool-sub-desc {
        display: block;
        font-size: 0.71rem;
        color: #9CA3AF;
        margin-top: 2px;
      }

      .tool-badge-counter {
        background-color: #10B981;
        color: #FFFFFF;
        font-size: 0.74rem;
        font-weight: 700;
        border-radius: 20px;
        padding: 2px 8px;
        min-width: 24px;
        text-align: center;
        margin-left: auto;
      }

      .pemetaan-tool-card.active.btn-tool-placemark {
        background: rgba(16, 185, 129, 0.2) !important;
        border-color: #10B981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.35) !important;
      }

      .pemetaan-tool-card.active.btn-tool-cable {
        background: rgba(139, 92, 246, 0.2) !important;
        border-color: #8B5CF6 !important;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.35) !important;
      }

      .pemetaan-stats-box {
        background-color: #111827;
        border: 1px solid rgba(229, 231, 235, 0.08);
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: auto;
      }

      .stats-box-header {
        font-size: 0.78rem;
        font-weight: 700;
        color: #E5E7EB;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
      }

      .stats-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.74rem;
        margin-bottom: 4px;
      }

      .stats-label {
        color: #9CA3AF;
      }

      .stats-val {
        color: #FFFFFF;
        font-weight: 600;
      }

      /* Dark Modals Styling */
      .modal-content.dark-theme-modal {
        background-color: #2B2B36 !important;
        border: 1px solid rgba(229, 231, 235, 0.15) !important;
        color: #FFFFFF !important;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.5) !important;
      }

      .dark-theme-modal .form-control {
        background-color: #111827 !important;
        border: 1px solid #374151 !important;
        color: #FFFFFF !important;
      }

      .dark-theme-modal .form-control::placeholder {
        color: #9CA3AF !important;
        opacity: 1 !important;
      }

      .dark-theme-modal .form-control:focus {
        border-color: #10B981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25) !important;
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

      /* ===== Unified Dark Floating Toast System ===== */
      .toast-container-custom {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
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
        max-width: 440px;
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
      .toast-title   { font-size: 0.85rem; font-weight: 700; margin-bottom: 2px; }
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
        to   { transform: translateY(0);   opacity: 1; }
      }

    </style>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="network-routing-body">
    <!--begin::App Wrapper-->
    <div class="network-app-wrapper">
      <!-- Header & Navbar -->
      @include('partials.navbar')

      <!-- Main Layout: Sidebar Rail + Workspace -->
      <div class="network-main-layout">
        <!-- Far Left Mini Rail Sidebar -->
        @include('partials.sidebar')

        <!-- Workspace Container (Framed in soft rose border) -->
        <main class="network-workspace-container">

          <!-- VIEW 1: BERANDA AWAL (DASHBOARD STATISTIK & ACTION LAUNCHPAD) -->
          <div id="viewLandingCards" class="landing-view-container">
            <div class="dashboard-stats-grid">
              
              <!-- LEFT COLUMN: Top 3 KPI Cards, Bottom Trend Chart -->
              <div class="dashboard-left-col">
                <!-- 1. KPI Stat Cards (Total, Titik, Cakupan) -->
                <div class="stats-kpi-grid">
                  <div class="kpi-stat-card">
                    <div class="kpi-icon-wrap kpi-icon-red">
                      <i class="bi bi-folder2-open"></i>
                    </div>
                    <div class="kpi-content">
                      <span class="kpi-label">Total Proyek KML</span>
                      <div class="kpi-value-row">
                        <span class="kpi-number" id="kpiTotalProjects">...</span>
                        <span class="kpi-badge badge-red">Tersurvei</span>
                      </div>
                    </div>
                  </div>

                  <div class="kpi-stat-card">
                    <div class="kpi-icon-wrap kpi-icon-blue">
                      <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="kpi-content">
                      <span class="kpi-label">Titik Terpetakan</span>
                      <div class="kpi-value-row">
                        <span class="kpi-number" id="kpiTotalPoints">...</span>
                        <span class="kpi-badge badge-blue">ODC / ODP / Tiang</span>
                      </div>
                    </div>
                  </div>

                  <div class="kpi-stat-card">
                    <div class="kpi-icon-wrap kpi-icon-green">
                      <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div class="kpi-content">
                      <span class="kpi-label">Cakupan Wilayah</span>
                      <div class="kpi-value-row">
                        <span class="kpi-number" id="kpiTotalAreas">...</span>
                        <span class="kpi-badge badge-green">Regional / Witel</span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 2. Grafik Tren Aktivitas Bulanan -->
                <div class="chart-card">
                  <div class="chart-card-header">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-bar-chart-fill text-danger"></i>
                      <span class="chart-title">Tren Aktivitas Proyek Bulanan</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <div class="filter-item-group">
                        <label for="filterYear" class="filter-label"><i class="bi bi-calendar3 me-1"></i>Tahun:</label>
                        <select id="filterYear" class="stats-filter-select">
                          <option value="2026">2026</option>
                        </select>
                      </div>
                      <div class="filter-item-group">
                        <label for="filterMonth" class="filter-label"><i class="bi bi-calendar-event me-1"></i>Bulan:</label>
                        <select id="filterMonth" class="stats-filter-select">
                          <option value="all">Semua Bulan</option>
                          <option value="1">Januari</option>
                          <option value="2">Februari</option>
                          <option value="3">Maret</option>
                          <option value="4">April</option>
                          <option value="5">Mei</option>
                          <option value="6">Juni</option>
                          <option value="7">Juli</option>
                          <option value="8">Agustus</option>
                          <option value="9">September</option>
                          <option value="10">Oktober</option>
                          <option value="11">November</option>
                          <option value="12">Desember</option>
                        </select>
                      </div>
                      <button type="button" id="btnResetFilter" class="btn-stats-reset" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                      </button>
                    </div>
                  </div>
                  <div class="chart-card-body">
                    <canvas id="monthlyTrendChart"></canvas>
                  </div>
                </div>
              </div>

              <!-- RIGHT COLUMN: Top Upload KML, Bottom Pemetaan Baru -->
              <div class="dashboard-right-col">
                <!-- Kotak Atas: Upload File KML -->
                <div class="launchpad-card launchpad-card-red" id="cardUploadKml">
                  <div class="launchpad-card-header">
                    <div class="d-flex align-items-center gap-2">
                      <span class="landing-header-dot dot-red"></span>
                      <span class="launchpad-header-title">Upload File KML</span>
                    </div>
                    <span class="landing-badge-red">Existing</span>
                  </div>
                  <div class="launchpad-card-body">
                    <div class="launchpad-icon-circle icon-circle-red">
                      <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                    <h4 class="launchpad-title">Upload File KML</h4>
                    <p class="launchpad-desc">Unggah file KML untuk visualisasi jalur, routing matrix, dan validasi designator.</p>
                    <button type="button" class="launchpad-action-btn btn-landing-red" id="btnLandingUpload">
                      <i class="bi bi-folder2-open me-2"></i>Pilih File KML
                    </button>
                  </div>
                </div>

                <!-- Kotak Bawah: Pemetaan KML Baru -->
                <div class="launchpad-card launchpad-card-green" id="cardPemetaanKml">
                  <div class="launchpad-card-header">
                    <div class="d-flex align-items-center gap-2">
                      <span class="landing-header-dot dot-green"></span>
                      <span class="launchpad-header-title">Pemetaan Baru</span>
                    </div>
                    <span class="landing-badge-green">Interactive</span>
                  </div>
                  <div class="launchpad-card-body">
                    <div class="launchpad-icon-circle icon-circle-green">
                      <i class="bi bi-map-fill"></i>
                    </div>
                    <h4 class="launchpad-title">Pemetaan KML Baru</h4>
                    <p class="launchpad-desc">Rancang pemetaan langsung di peta satelit, tempatkan koordinat ODC & tarik jalur FO.</p>
                    <button type="button" class="launchpad-action-btn btn-landing-green" id="btnLandingPemetaan">
                      <i class="bi bi-bezier2 me-2"></i>Buat Pemetaan
                    </button>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- VIEW 2: MODE KML SUPER MATRIX (Workspace Eksisting) -->
          <div id="viewMatrixWorkspace" class="matrix-workspace-wrapper" style="display: none; width: 100%; height: 100%;">
            <div class="network-workspace-grid">
              
              <!-- LEFT PANEL: "Existing" Card -->
              <div class="chain-steps-panel">
                <div class="clean-chain-card">
                  <!-- Card Header -->
                  <div class="clean-chain-header">
                    <span class="chain-header-title">Existing</span>
                  </div>

                  <div class="clean-chain-body">
                    <!-- Upload KML File Dropzone -->
                    <div class="upload-dropzone-card" id="kmlDropzoneArea">
                      <input type="file" id="fileInput" class="file-input" accept=".kml" style="display:none;" />
                      <button type="button" id="selectFileBtn" style="display:none;"></button>

                      <div class="dropzone-inner" id="dropzoneDefaultState">
                        <div class="dropzone-icon-wrap">
                          <i class="bi bi-upload"></i>
                        </div>
                        <div class="dropzone-main-text">Upload KML File</div>
                        <div class="dropzone-sub-text">Drop zone area bar here</div>
                      </div>

                      <!-- File Info Badge when selected -->
                      <div id="fileInfoWrapper" style="display:none;">
                        <div class="d-flex align-items-center justify-content-between p-2">
                          <div class="d-flex align-items-center gap-2 text-truncate me-2">
                            <i class="bi bi-file-earmark-check-fill text-danger" style="font-size: 1.3rem;"></i>
                            <div class="text-truncate text-start">
                              <span id="fileInfo" class="fw-semibold text-white d-block text-truncate" style="font-size: 0.85rem;"></span>
                              <small class="text-success" style="font-size: 0.72rem;">File KML Siap</small>
                            </div>
                          </div>
                          <button type="button" class="btn btn-sm btn-outline-danger p-1 border-0" id="clearFileBtn" title="Hapus file" disabled>
                            <i class="bi bi-trash3-fill" style="font-size: 1rem;"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- Dropdowns Section (Titik Awal, Titik Akhir, Jalur Kabel, Advanced Settings, Proses) -->
                    <div id="dropdownsSection" style="display: block;">
                      <!-- Step 1: Titik Awal -->
                      <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <label class="step-label">Titik Awal</label>
                        </div>
                        <div class="dropdown">
                          <button class="step-dropdown-toggle dropdown-toggle w-100" type="button" id="startPointBtn" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                            <span id="startPointText" class="text-truncate">Pilih Titik Awal</span>
                          </button>
                          <div class="dropdown-menu dark-dropdown-menu w-100 p-0" id="startPointMenu" style="background: #1E1E24; border: 1px solid #374151; border-radius: 10px; overflow: hidden;">
                            <div class="p-2 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.08) !important;">
                              <input type="text" class="form-control form-control-sm dark-search-input" id="searchStartPoint" placeholder="Cari titik awal..." onclick="event.stopPropagation()">
                            </div>
                            <ul class="dropdown-items-scroll list-unstyled mb-0" id="startPointList" style="max-height: 200px; overflow-y: auto; padding: 4px;">
                            </ul>
                          </div>
                        </div>
                      </div>

                      <!-- Step 2: Titik Akhir -->
                      <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <label class="step-label">Titik Akhir</label>
                        </div>
                        <div class="dropdown">
                          <button class="step-dropdown-toggle dropdown-toggle w-100" type="button" id="endPointBtn" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                            <span id="endPointText" class="text-truncate">Pilih Titik Akhir</span>
                          </button>
                          <div class="dropdown-menu dark-dropdown-menu w-100 p-0" id="endPointMenu" style="background: #1E1E24; border: 1px solid #374151; border-radius: 10px; overflow: hidden;">
                            <div class="p-2 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.08) !important;">
                              <input type="text" class="form-control form-control-sm dark-search-input" id="searchEndPoint" placeholder="Cari titik akhir..." onclick="event.stopPropagation()">
                            </div>
                            <ul class="dropdown-items-scroll list-unstyled mb-0" id="endPointList" style="max-height: 200px; overflow-y: auto; padding: 4px;">
                            </ul>
                          </div>
                        </div>
                      </div>

                      <!-- Step 3: Jalur Kabel (Pemilihan Kabel) -->
                      <div class="mt-3" id="cableRouteSection">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <label class="step-label">Jalur Kabel</label>
                        </div>
                        <div class="dropdown">
                          <button class="step-dropdown-toggle dropdown-toggle w-100" type="button" id="cableRouteBtn" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                            <span id="cableRouteText" class="text-truncate">Pilih Jalur Kabel</span>
                          </button>
                          <div class="dropdown-menu dark-dropdown-menu w-100 p-0" id="cableRouteMenu" style="background: #1E1E24; border: 1px solid #374151; border-radius: 10px; overflow: hidden;">
                            <div class="p-2 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.08) !important;">
                              <input type="text" class="form-control form-control-sm dark-search-input" id="searchCableRoute" placeholder="Cari jalur kabel..." onclick="event.stopPropagation()">
                            </div>
                            <ul class="dropdown-items-scroll list-unstyled mb-0" id="cableRouteList" style="max-height: 200px; overflow-y: auto; padding: 4px;">
                            </ul>
                          </div>
                        </div>
                      </div>

                      <!-- Advanced Settings Card Accordion -->
                      <div class="advanced-settings-card mt-3">
                        <button class="advanced-collapse-header" type="button" data-bs-toggle="collapse" data-bs-target="#advancedSettingsBody" aria-expanded="false">
                          <span><i class="bi bi-chevron-down chevron-collapse me-2"></i>Advanced Settings</span>
                        </button>

                        <div class="collapse" id="advancedSettingsBody">
                          <div class="pt-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                              <div>
                                <span class="text-white d-block" style="font-size: 0.82rem; font-weight: 600;">Gunakan Jalur Kabel</span>
                                <small class="text-muted" style="font-size: 0.72rem;">Route via line string KML</small>
                              </div>
                              <div class="form-check form-switch p-0 m-0">
                                <input class="form-check-input rose-switch m-0" type="checkbox" id="useCableCheckbox" checked>
                              </div>
                            </div>

                            <div class="mb-2">
                              <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-white" style="font-size: 0.82rem; font-weight: 600;">Scan Range</span>
                                <span class="text-danger fw-bold" id="scanRangeValue" style="font-size: 0.8rem;">100m</span>
                              </div>
                              <input type="range" class="form-range" id="scanRangeSlider" min="10" max="1000" step="10" value="100">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Tombol Proses Data -->
                      <div class="mt-4">
                        <button type="button" class="btn-process-red w-100" id="processBtn" disabled>
                          <i class="bi bi-gear-fill me-2"></i>Proses Data
                        </button>
                      </div>

                      <!-- Notifikasi Inline -->
                      <div id="notificationWrapper" style="display:none; margin-top: 15px;">
                        <div id="notificationContent"></div>
                      </div>
                    </div><!-- /#dropdownsSection -->
                  </div>
                </div>
              </div>

              <!-- RIGHT PANEL: Table & Action Toolbars -->
              <div class="matrix-table-panel">
                <div class="matrix-card-wrapper">
                  
                  <!-- TOP TOOLBAR -->
                  <div class="matrix-top-bar">
                    <!-- Left: Kembali to Landing & Undo Button -->
                    <div class="d-flex align-items-center gap-2">
                      <button type="button" class="topbar-pill-btn" id="btnBackToLandingFromMatrix" onclick="switchWorkspaceView('landing')" title="Kembali ke Beranda Awal">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                      </button>
                      <button id="undoBtn" class="topbar-pill-btn" onclick="undo()" disabled title="Undo perubahan terakhir">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Undo
                      </button>
                    </div>

                    <!-- Center: Edit Mode Switch & Action Buttons -->
                    <div class="d-flex align-items-center gap-2" id="editModeToolbar">
                      <button type="button" class="topbar-pill-btn pill-switch-btn" id="selectModeBtn" onclick="toggleEditMode()" title="Toggle Mode Edit">
                        <i class="bi bi-pencil-square me-1"></i><span>Edit Mode</span>
                      </button>

                      <div id="editModeButtons" class="d-flex align-items-center gap-2" style="display: none !important;">
                        <button type="button" class="topbar-edit-btn btn-mode-edit" id="editSelectedBtn" onclick="showEditDropdown()" title="Ubah Designator Baris Terpilih">
                          <i class="bi bi-pencil-fill"></i><span>Ubah</span>
                        </button>
                        <button type="button" class="topbar-edit-btn btn-mode-delete" id="deleteSelectedBtn" onclick="deleteSelected()" title="Hapus Baris Terpilih">
                          <i class="bi bi-trash-fill"></i><span>Hapus</span>
                        </button>
                      </div>
                    </div>

                    <!-- Right: Row Count Badge -->
                    <div class="d-flex align-items-center gap-2">
                      <span class="topbar-label">Row Count</span>
                      <span class="badge-rows-counter" id="rowCountBadge">Rows: 0</span>
                    </div>
                  </div>

                  <!-- BATCH DESIGNATOR EDIT PANEL -->
                  <div id="designatorDropdownSection" class="designator-edit-panel" style="display: none;">
                    <div class="designator-edit-header">
                      <h6><i class="bi bi-tags-fill me-2" style="color: #60A5FA;"></i>Pilih Designator Pengganti:</h6>
                      <button type="button" class="btn-close-panel" onclick="hideEditDropdown()" title="Tutup">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                    <div class="designator-edit-body">
                      <div class="search-input-wrapper mb-2">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="searchDesignator" class="form-control-dark" placeholder="Cari designator...">
                      </div>
                      <div id="designatorList" class="designator-scroll-list">
                        <!-- Populated dynamically via JS -->
                      </div>
                    </div>
                    <div class="designator-edit-footer">
                      <div id="selectedDesignatorDisplay" class="selected-designator-info" style="display: none;">
                        <span style="color: #94A3B8; font-size: 0.85rem;">Designator terpilih:</span>
                        <span id="selectedDesignatorBadge" class="badge-designator-pill"></span>
                      </div>
                      <div class="d-flex align-items-center gap-2 ms-auto">
                        <button type="button" class="btn-panel-action btn-panel-apply" id="applyDesignatorBtn" onclick="applyDesignatorChange()" disabled>
                          <i class="bi bi-check-lg me-1"></i>Terapkan
                        </button>
                        <button type="button" class="btn-panel-action btn-panel-cancel" onclick="hideEditDropdown()">
                          Tutup
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- MAIN TABLE CONTAINER -->
                  <div class="matrix-table-card" id="previewSection">
                    <div class="table-responsive matrix-scroll-container">
                      <!-- ROW INSERT HIGHLIGHT INDICATOR (SEAM HIGHLIGHT IN EDIT MODE) -->
                      <div id="rowInsertIndicator" class="row-insert-indicator" style="display: none;">
                        <div class="row-insert-line"></div>
                        <button type="button" class="row-insert-btn" id="btnInsertRow" title="Tambah baris baru di sini">
                          <i class="bi bi-plus-lg"></i>
                        </button>
                      </div>

                      <table class="table mb-0 matrix-clean-table" id="previewTable">
                        <thead>
                          <tr id="previewHeaderRow1">
                            <th rowspan="2" class="th-clean col-checkbox" id="thCheckbox" title="Pilih Semua">
                              <input type="checkbox" class="form-check-input edit-master-checkbox" id="masterRowCheckbox" onchange="toggleSelectAllFromMaster(this)">
                            </th>
                            <th rowspan="2" class="th-clean th-no">NO</th>
                            <th rowspan="2" class="th-clean th-placemark">PLACEMARK</th>
                            <th colspan="2" class="th-clean th-span text-center">SPAN</th>
                            <th rowspan="2" class="th-clean th-length">LENGTH</th>
                            <th rowspan="2" class="th-clean th-designator" id="thDesignator">DESIGNATOR</th>
                          </tr>
                          <tr id="previewHeaderRow2">
                            <th class="th-clean th-sub">FCR</th>
                            <th class="th-clean th-sub">ODP</th>
                          </tr>
                        </thead>
                        <tbody id="previewTableBody">
                        </tbody>
                        <tfoot id="previewTableFoot" style="display: none;">
                          <tr id="grandTotalRow">
                            <td class="grand-total-cell text-center col-checkbox"></td>
                            <td class="grand-total-cell text-center" data-col="no"></td>
                            <td class="grand-total-cell grand-total-label text-center">GRAND TOTAL</td>
                            <td class="grand-total-cell text-center" data-col="spanFcr">-</td>
                            <td class="grand-total-cell text-center" data-col="spanOdp">-</td>
                            <td class="grand-total-cell text-center" data-col="length">-</td>
                            <td class="grand-total-cell text-center" data-col="designator">-</td>
                            <!-- dynamic designator total cells will be inserted here -->
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>

                  <!-- BOTTOM TOOLBAR -->
                  <div class="matrix-bottom-bar justify-content-end">
                    <!-- Right: Direct Download Buttons -->
                    <div class="d-flex align-items-center gap-2">
                      <button type="button" class="btn-download-pdf is-disabled" id="btnDownloadPdf" aria-disabled="true" title="Export data rute ke format PDF (Landscape)">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i><span>Download PDF</span>
                      </button>
                      <button type="button" class="btn-download-green is-disabled" id="btnDownloadExcel" aria-disabled="true" title="Export data rute langsung ke template Excel (Rumus & 212 Designator Preserved)">
                        <i class="bi bi-file-earmark-excel-fill me-2"></i><span>Download Excel</span>
                      </button>
                    </div>
                  </div>

                  <!-- Hidden Preserved Container for backward compatibility -->
                  <div id="excelTemplateCard" style="display:none;"></div>

                </div>
              </div>

            </div>
          </div>

          <!-- VIEW 3: MODE PEMETAAN KML (MIRRORED LAYOUT: PETA DI KIRI, KOTAK KONTROL DI KANAN) -->
          <div id="mapPemetaanOverlay" class="pemetaan-workspace-grid" style="display: none;">
            
            <!-- SISI KIRI: Peta Leaflet Interaktif (Ukuran fleksibel setara tabel) -->
            <div class="pemetaan-map-panel">
              <div class="pemetaan-map-topbar">
                <div class="d-flex align-items-center gap-2">
                  <div class="map-topbar-icon">
                    <i class="bi bi-map-fill"></i>
                  </div>
                  <div>
                    <div id="mapPlanTitle" class="map-topbar-title">Pemetaan Baru</div>
                    <div id="mapPlanMeta" class="map-topbar-meta">Mode: Lihat Peta</div>
                  </div>
                </div>
                <button type="button" id="btnTutupMap" class="btn-map-back" onclick="switchWorkspaceView('landing')" title="Kembali ke Beranda Awal">
                  <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </button>
              </div>

              <!-- Kontainer Leaflet Peta & Floating Overlays -->
              <div id="mapPemetaanContainer" style="flex: 1 1 auto; width: 100%; height: calc(100% - 48px); min-height: 0; position: relative;">
                @include('partials.map.placemark-controls')
              </div>
            </div>

            <!-- SISI KANAN: Kotak Kontrol Pemetaan (Ukuran 290px setara panel Clean chain steps) -->
            <div class="pemetaan-control-panel">
              <div class="pemetaan-control-card">
                <div class="pemetaan-control-header">
                  <span class="control-header-title">
                    <i class="bi bi-sliders2-vertical me-2" style="color: #10B981;"></i>Interactive
                  </span>
                </div>
                <div class="pemetaan-control-body" id="pmToolbar">
                  
                  <!-- Tombol 1: Tambah Placemark -->
                  <button id="btnAddPlacemark" class="pemetaan-tool-card btn-tool-placemark" type="button" title="Aktifkan mode tambah placemark lalu klik di peta">
                    <div class="tool-icon-wrap icon-placemark">
                      <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="tool-info-wrap">
                      <span id="btnAddPlacemarkLabel" class="tool-main-name">Tambah Placemark</span>
                      <span class="tool-sub-desc">Tambah titik ODP / ODC / Tiang</span>
                    </div>
                  </button>

                  <!-- Tombol 2: Tarik Kabel -->
                  <button id="btnAddCable" class="pemetaan-tool-card btn-tool-cable" type="button" title="Mulai menarik jalur kabel di peta">
                    <div class="tool-icon-wrap icon-cable">
                      <i class="bi bi-bezier2"></i>
                    </div>
                    <div class="tool-info-wrap">
                      <span id="btnAddCableLabel" class="tool-main-name">Tarik Kabel</span>
                      <span class="tool-sub-desc">Tarik jalur serat optik</span>
                    </div>
                  </button>

                  <!-- Tombol 3: Daftar KML & Kabel -->
                  <button id="btnTogglePmList" class="pemetaan-tool-card btn-tool-list" type="button" 
                    onclick="if(window.togglePmListPanel){window.togglePmListPanel(event);}"
                    title="Lihat daftar titik dan kabel yang telah dipetakan">
                    <div class="tool-icon-wrap icon-list">
                      <i class="bi bi-list-ul"></i>
                    </div>
                    <div class="tool-info-wrap">
                      <span class="tool-main-name">Daftar Titik & Kabel</span>
                      <span class="tool-sub-desc">Kelola elemen pemetaan</span>
                    </div>
                    <span id="pmCountBadge" class="tool-badge-counter">0</span>
                  </button>

                  <!-- Tombol 4: Export KML -->
                  <button id="btnExportPmKml" class="pemetaan-tool-card btn-tool-export" type="button" title="Export data ke berkas KML standar Google Earth">
                    <div class="tool-icon-wrap icon-export">
                      <i class="bi bi-download"></i>
                    </div>
                    <div class="tool-info-wrap">
                      <span class="tool-main-name">Export KML</span>
                      <span class="tool-sub-desc">Unduh berkas .kml</span>
                    </div>
                  </button>


                  <!-- Tombol 5: Simpan ke Database -->
                  <button id="btnSaveToDatabase" class="pemetaan-tool-card btn-tool-save" type="button" title="Simpan hasil pemetaan ke basis data Data Manager">
                    <div class="tool-icon-wrap icon-save" style="background: rgba(220, 38, 38, 0.2); color: #EF4444; border: 1px solid rgba(220, 38, 38, 0.4);">
                      <i class="bi bi-database-fill-up"></i>
                    </div>
                    <div class="tool-info-wrap">
                      <span class="tool-main-name">Simpan ke DB</span>
                      <span class="tool-sub-desc">Simpan ke Data Manager</span>
                    </div>
                  </button>

                  <!-- Status Mini Card -->
                  <div class="pemetaan-stats-box mt-auto">
                    <div class="stats-box-header">
                      <i class="bi bi-info-circle me-1 text-success"></i> Status Pemetaan
                    </div>
                    <div class="stats-row">
                      <span class="stats-label">Proyek:</span>
                      <span class="stats-val text-truncate" style="max-width: 150px;" id="pemetaanSummaryProject">-</span>
                    </div>
                    <div class="stats-row">
                      <span class="stats-label">Total Titik:</span>
                      <span class="stats-val" id="pemetaanSummaryPoints">0 titik</span>
                    </div>
                    <div class="stats-row">
                      <span class="stats-label">Total Kabel:</span>
                      <span class="stats-val" id="pemetaanSummaryCables">0 m</span>
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>

        </main>
      </div>

      <!-- Preserved Plan New Trigger Elements for DOM Compatibility -->
      

      <div id="planNewCol" style="display:none;">
        <div id="planNewCard">
          <button type="button" id="btnBuatPlanNew"></button>
        </div>
      </div>

      <!-- Preserved LeftCol dummy id if any querySelector refers to it -->
      <div id="leftCol" style="display:none;"></div>

      <!-- Footer omitted for clean border-to-border dashboard design -->
    </div>
    <!--end::App Wrapper-->

    <!-- ===== MODAL: Pilih Sumber File KML ===== -->
    <!-- ===== MODAL: Pilih Sumber File KML (DARK THEME) ===== -->
    <div class="modal fade" id="kmlSourceModal" tabindex="-1" aria-labelledby="kmlSourceModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content dark-theme-modal" style="border-radius: 18px; overflow: hidden; border: 1px solid rgba(220, 38, 38, 0.3) !important;">

          <!-- Modal Header -->
          <div class="modal-header" style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.4) 0%, rgba(43, 43, 54, 0.95) 100%); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 20px 24px;">
            <div>
              <h5 class="modal-title" id="kmlSourceModalLabel" style="color: white; font-weight: 700; font-size: 1.05rem; margin-bottom: 4px;">
                <i class="bi bi-folder2-open me-2 text-danger"></i>Pilih Sumber File KML
              </h5>
              <p style="color: #9CA3AF; margin: 0; font-size: 0.82rem;">Tentukan direktori untuk memuat file KML</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body" style="padding: 24px;">
            <div class="row g-3">

              <!-- Opsi 1: Dari Direktori PC (AKTIF) -->
              <div class="col-6">
                <div id="kmlFromPcOption" onclick="if(typeof triggerKmlFromPc==='function') triggerKmlFromPc();"
                  style="border: 2px solid rgba(220, 38, 38, 0.35); border-radius: 14px; padding: 22px 14px; text-align: center; cursor: pointer; transition: all 0.25s ease; background: #1E1E24;"
                  onmouseover="this.style.borderColor='#DC2626';this.style.background='#24242F';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(220, 38, 38, 0.25)'"
                  onmouseout="this.style.borderColor='rgba(220, 38, 38, 0.35)';this.style.background='#1E1E24';this.style.transform='translateY(0)';this.style.boxShadow='none'">
                  <div style="width:52px;height:52px;background:linear-gradient(135deg,#DC2626,#991B1B);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 4px 14px rgba(220, 38, 38, 0.4);">
                    <i class="bi bi-laptop" style="font-size:1.5rem;color:white;"></i>
                  </div>
                  <h6 style="font-weight:700;margin-bottom:6px;font-size:0.92rem;color:#FFFFFF;">Direktori PC</h6>
                  <p style="font-size:0.77rem;color:#9CA3AF;margin:0 0 10px;">Upload file .kml lokal dari komputer Anda</p>
                  <span style="background:rgba(220,38,38,0.2);color:#FCA5A5;border-radius:20px;padding:3px 12px;font-size:0.72rem;font-weight:600;border:1px solid rgba(220,38,38,0.3);">.kml lokal</span>
                </div>
              </div>

              <!-- Opsi 2: Dari Database Cloud (AKTIF) -->
              <div class="col-6">
                <div id="kmlFromDbOption" onclick="if(typeof openSelectKmlFromDbModal==='function') openSelectKmlFromDbModal();"
                  style="border: 2px solid rgba(59, 130, 246, 0.35); border-radius: 14px; padding: 22px 14px; text-align: center; cursor: pointer; transition: all 0.25s ease; background: #1E1E24;"
                  onmouseover="this.style.borderColor='#3B82F6';this.style.background='#24242F';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(59, 130, 246, 0.25)'"
                  onmouseout="this.style.borderColor='rgba(59, 130, 246, 0.35)';this.style.background='#1E1E24';this.style.transform='translateY(0)';this.style.boxShadow='none'">
                  <div style="width:52px;height:52px;background:linear-gradient(135deg,#2563EB,#1D4ED8);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 4px 14px rgba(37, 99, 235, 0.4);">
                    <i class="bi bi-database-fill" style="font-size:1.5rem;color:white;"></i>
                  </div>
                  <h6 style="font-weight:700;margin-bottom:6px;font-size:0.92rem;color:#FFFFFF;">Database Cloud</h6>
                  <p style="font-size:0.77rem;color:#9CA3AF;margin:0 0 10px;">Pilih proyek KML tersimpan dari database sistem</p>
                  <span style="background:rgba(37, 99, 235, 0.2);color:#93C5FD;border-radius:20px;padding:3px 12px;font-size:0.72rem;font-weight:600;border:1px solid rgba(37, 99, 235, 0.3);">Database Aktif</span>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- ===== END MODAL: Pilih Sumber File KML ===== -->

    <!-- ===== MODAL: Pilih Proyek KML dari Database (DARK THEME) ===== -->
    <div class="modal fade" id="modalSelectKmlFromDb" tabindex="-1" aria-labelledby="modalSelectKmlFromDbLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content dark-theme-modal" style="border-radius: 18px; overflow: hidden; border: 1px solid rgba(59, 130, 246, 0.35) !important; background: #25252D; color: #FFFFFF;">
          <div class="modal-header" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.4) 0%, rgba(43, 43, 54, 0.95) 100%); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 20px 24px;">
            <div>
              <h5 class="modal-title" id="modalSelectKmlFromDbLabel" style="color: white; font-weight: 700; font-size: 1.05rem; margin-bottom: 4px;">
                <i class="bi bi-database-fill me-2 text-primary"></i>Pilih Proyek KML dari Database
              </h5>
              <p style="color: #9CA3AF; margin: 0; font-size: 0.82rem;">Pilih proyek KML untuk diproses ke tabel matriks rute atau peta kerja</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="padding: 20px 24px; max-height: 480px; overflow-y: auto;">
            <!-- Search in Modal -->
            <div class="mb-3">
              <input type="text" class="form-control" id="searchKmlDbInput" placeholder="Cari nama proyek atau area..." 
                style="background: #111827; border: 1px solid #374151; color: #FFFFFF; border-radius: 8px; font-size: 0.85rem; padding: 8px 14px;"
                oninput="if(typeof filterKmlDbList==='function') filterKmlDbList(this.value);">
            </div>
            <div id="kmlDbListContainer">
              <div class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                <div>Memuat daftar proyek KML...</div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="background: #1E1E24; border-top: 1px solid rgba(255,255,255,0.08); padding: 14px 24px;">
            <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="border-radius: 8px; background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #D1D5DB; font-size: 0.82rem; padding: 6px 14px; display:inline-flex; align-items:center; gap:6px;"><i class="bi bi-x-lg" style="font-size:0.75rem;"></i> Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== END MODAL: Pilih Proyek KML dari Database ===== -->

    <!-- ===== MODAL: Buat Plan Baru ===== -->
    <!-- ===== MODAL: Buat Plan Baru (DARK THEME) ===== -->
    <div class="modal fade" id="planNewModal" tabindex="-1" aria-labelledby="planNewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content dark-theme-modal" style="border-radius: 18px; overflow: hidden; border: 1px solid rgba(16, 185, 129, 0.3) !important;">

          <!-- Modal Header -->
          <div class="modal-header" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.35) 0%, rgba(43, 43, 54, 0.95) 100%); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 20px 24px;">
            <div>
              <h5 class="modal-title" id="planNewModalLabel" style="color: white; font-weight: 700; font-size: 1.05rem; margin: 0;">
                <i class="bi bi-map-fill me-2 text-success"></i>Informasi Pemetaan KML Baru
              </h5>
              <small style="color: #9CA3AF; font-size: 0.8rem;">Isi informasi dasar pemetaan</small>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body" style="padding: 24px;">

            <!-- Nama Proyek -->
            <div class="mb-3">
              <label for="planNamaProyek" class="form-label text-white fw-semibold" style="font-size: 0.85rem;">
                Nama Proyek <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="planNamaProyek"
                placeholder="Nama proyek"
                style="border-radius: 8px;">
            </div>

            <!-- Tanggal Pengerjaan -->
            <div class="mb-3">
              <label for="planTanggal" class="form-label text-white fw-semibold" style="font-size: 0.85rem;">
                Tanggal Pengerjaan <span class="text-danger">*</span>
              </label>
              <input type="date" class="form-control" id="planTanggal"
                style="border-radius: 8px;">
            </div>

            <!-- Dibuat Oleh -->
            <div class="mb-3">
              <label for="planDibuatOleh" class="form-label text-white fw-semibold" style="font-size: 0.85rem;">
                Dibuat Oleh
              </label>
              <div class="input-group">
                <span class="input-group-text" style="background: #181820; border-color: #374151; border-right: none; border-radius: 8px 0 0 8px; color: #10B981;">
                  <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" id="planDibuatOleh"
                  value="{{ auth()->user()->name ?? '-' }}"
                  readonly
                  style="background: #181820 !important; border-left: none; border-color: #374151; border-radius: 0 8px 8px 0; color: #9CA3AF !important; font-weight: 600;">
              </div>
            </div>

            <!-- Area / Lokasi -->
            <div class="mb-3">
              <label for="planArea" class="form-label text-white fw-semibold" style="font-size: 0.85rem;">
                Area / Lokasi <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="planArea"
                placeholder="Lokasi / wilayah"
                style="border-radius: 8px;">
            </div>

            <!-- Keterangan -->
            <div class="mb-2">
              <label for="planKeterangan" class="form-label text-white fw-semibold" style="font-size: 0.85rem;">
                Keterangan
              </label>
              <textarea class="form-control" id="planKeterangan" rows="2"
                placeholder="Catatan (opsional)"
                style="border-radius: 8px; resize: none;"></textarea>
            </div>

          </div><!-- /.modal-body -->

          <!-- Modal Footer -->
          <div class="modal-footer" style="background: #24242F; border-top: 1px solid rgba(255,255,255,0.08); padding: 16px 24px; gap: 10px;">
            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal"
              style="border-radius: 8px; font-weight: 600; color: #9CA3AF; border-color: #4B5563;">
              <i class="bi bi-x-circle me-2"></i>Batal
            </button>
            <button type="button" class="btn px-4" id="btnMulaiPemetaan" onclick="if(typeof startPemetaanProcess==='function') startPemetaanProcess();"
              style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; border: none; border-radius: 8px; font-weight: 700; box-shadow: 0 4px 14px rgba(16,185,129,0.35); transition: all 0.2s ease;">
              <i class="bi bi-map-fill me-2"></i>Mulai Pemetaan
            </button>
          </div>

        </div>
      </div>
    </div>
    <!-- ===== END MODAL: Buat Plan Baru ===== -->

    <!-- ===== MODAL: Konfirmasi Hapus Baris Preview (Dark Theme - Matching Route Matrix) ===== -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content dark-theme-modal text-center p-3" style="border-radius: 18px; border: 1px solid rgba(239, 68, 68, 0.35) !important; background: #25252D; box-shadow: 0 20px 50px rgba(0,0,0,0.6);">
          <div class="modal-body pt-3 pb-2 px-2">
            <div id="deleteConfirmModalIcon" style="width: 58px; height: 58px; border-radius: 50%; background: rgba(239, 68, 68, 0.15); color: #EF4444; display: flex; align-items: center; justify-content: center; font-size: 1.85rem; margin: 0 auto 16px auto; border: 1px solid rgba(239, 68, 68, 0.35); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.2);">
              <i class="bi bi-trash3-fill"></i>
            </div>
            <h5 class="fw-bold mb-2 text-white" id="deleteConfirmModalTitle" style="font-size: 1.1rem; letter-spacing: -0.01em;">Hapus Baris?</h5>
            <p class="mb-2" style="color: #D1D5DB; font-size: 0.88rem; line-height: 1.5;" id="deleteConfirmModalText">
              Apakah Anda yakin ingin menghapus 1 baris yang dipilih?
            </p>
            <div id="deleteConfirmModalSubtext" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; padding: 8px 12px; margin-top: 10px;">
              <small style="color: #9CA3AF; font-size: 0.76rem; display: block;">
                <i class="bi bi-info-circle me-1 text-danger"></i>Baris yang dihapus dapat dipulihkan melalui tombol <strong>Undo</strong>.
              </small>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-0 pt-2 pb-2 px-2" style="gap: 10px;">
            <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600; color: #9CA3AF; border-color: #4B5563; font-size: 0.85rem; padding-top: 8px; padding-bottom: 8px; transition: all 0.2s ease;">
              Batal
            </button>
            <button type="button" class="btn px-3" id="confirmDeleteActionBtn" style="background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; padding-top: 8px; padding-bottom: 8px; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
              <i class="bi bi-trash3-fill"></i>
              <span id="confirmDeleteActionBtnText">Ya, Hapus</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== END MODAL: Konfirmasi Hapus Baris Preview ===== -->

    
    
    <!--begin::Script-->
    <!-- Bootstrap 5 Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS for geospatial distance calculations -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>

    <!-- ExcelJS Library for Excel handling dengan format preservation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>

    <!-- jsPDF & AutoTable for high-quality Vector PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

    <!-- ===== Unified Toast System (early definition) ===== -->
    <script>
      function showToast(type, title, message, duration) {
        // Container may not be in DOM yet — try, or queue for DOMContentLoaded
        function _render() {
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
        if (document.getElementById('toastContainer')) {
          _render();
        } else {
          document.addEventListener('DOMContentLoaded', _render);
        }
      }
      window.showToast = showToast;

      // Unified Dark Theme Confirmation Modal Helper (Pengganti alert/confirm jadul bawaan browser)
      let _darkConfirmCallback = null;
      function showDarkConfirm(options = {}) {
        const title = options.title || 'Hapus Baris?';
        const message = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        const subtext = options.subtext || '';
        const confirmText = options.confirmText || 'Ya, Hapus';
        const onConfirm = options.onConfirm || null;

        const modalEl = document.getElementById('deleteConfirmModal');
        if (!modalEl) {
          if (typeof onConfirm === 'function') onConfirm();
          return;
        }

        const titleEl = document.getElementById('deleteConfirmModalTitle');
        const textEl = document.getElementById('deleteConfirmModalText');
        const subtextWrapper = document.getElementById('deleteConfirmModalSubtext');
        const btnTextEl = document.getElementById('confirmDeleteActionBtnText');

        if (titleEl) titleEl.textContent = title;
        if (textEl) textEl.innerHTML = message;
        if (subtextWrapper) {
          if (subtext) {
            subtextWrapper.style.display = 'block';
            subtextWrapper.innerHTML = `<small style="color: #9CA3AF; font-size: 0.76rem; display: block;"><i class="bi bi-info-circle me-1 text-danger"></i>${subtext}</small>`;
          } else {
            subtextWrapper.style.display = 'none';
          }
        }
        if (btnTextEl) btnTextEl.textContent = confirmText;

        _darkConfirmCallback = onConfirm;

        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        modalInstance.show();
      }
      window.showDarkConfirm = showDarkConfirm;

      // Event listener tombol konfirmasi modal
      function setupDarkConfirmListener() {
        const confirmBtn = document.getElementById('confirmDeleteActionBtn');
        if (confirmBtn && !confirmBtn._hasConfirmBinding) {
          confirmBtn._hasConfirmBinding = true;
          confirmBtn.addEventListener('click', function() {
            const modalEl = document.getElementById('deleteConfirmModal');
            if (modalEl) {
              const instance = bootstrap.Modal.getInstance(modalEl);
              if (instance) instance.hide();
            }
            if (typeof _darkConfirmCallback === 'function') {
              const cb = _darkConfirmCallback;
              _darkConfirmCallback = null;
              cb();
            }
          });
        }
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupDarkConfirmListener);
      } else {
        setupDarkConfirmListener();
      }
    </script>

    <!-- Session Auto-Logout Script -->
    <script>
      // Auto-logout after 6 hours (21600000 milliseconds)
      const SESSION_LIFETIME = 6 * 60 * 60 * 1000; // 6 hours in milliseconds
      const LOGIN_TIME = {{ session('login_time', now()->timestamp) }} * 1000; // Convert to milliseconds
      
      function checkSessionExpiry() {
        const currentTime = Date.now();
        const elapsedTime = currentTime - LOGIN_TIME;
        
        if (elapsedTime >= SESSION_LIFETIME) {
          // Session expired - logout
          showToast('error', 'Sesi Berakhir', 'Sesi Anda telah berakhir setelah 6 jam. Anda akan diarahkan ke halaman login.');
          setTimeout(() => { window.location.href = '/logout'; }, 3000);
        } else {
          // Calculate remaining time
          const remainingTime = SESSION_LIFETIME - elapsedTime;
          
          // Show warning 5 minutes before expiry
          if (remainingTime <= 5 * 60 * 1000 && remainingTime > 4 * 60 * 1000) {
            showToast('warning', 'Sesi Hampir Berakhir', 'Sesi Anda akan berakhir dalam 5 menit. Silakan simpan pekerjaan Anda.');
          }
        }
      }
      
      // Check session every minute
      setInterval(checkSessionExpiry, 60000);
      
      // Check immediately after DOM is ready (so toast container is available)
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkSessionExpiry);
      } else {
        checkSessionExpiry();
      }
      
      // Track if user is navigating within the same site
      let isInternalNavigation = false;
      
      // Detect internal navigation (same origin)
      document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href) {
          try {
            const linkUrl = new URL(link.href);
            const currentOrigin = window.location.origin;
            
            // Check if it's internal navigation (same domain)
            if (linkUrl.origin === currentOrigin) {
              isInternalNavigation = true;
            }
          } catch (err) {
            // If URL parsing fails, assume internal navigation
            isInternalNavigation = true;
          }
        }
      });
      
      // Auto-logout ONLY when browser/tab is actually closed (not internal navigation)
      window.addEventListener('beforeunload', function(e) {
        // Only logout if NOT navigating within the same site
        if (!isInternalNavigation) {
          // Send logout request when user closes browser/tab or navigates to external site
          navigator.sendBeacon('/api/session-close');
        }
        // Reset flag for next navigation
        isInternalNavigation = false;
      });
      
      // Detect when user switches tabs (visibility API) - just check session, don't logout
      document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
          // Tab is visible again - check if session is still valid
          checkSessionExpiry();
        }
      });
    </script>

    <!-- KML Super Matrix Script -->
    <script>
      const fileInput = document.getElementById('fileInput');
      const selectFileBtn = document.getElementById('selectFileBtn');
      const fileInfo = document.getElementById('fileInfo');
      const clearFileBtn = document.getElementById('clearFileBtn');
      const dropdownsSection = document.getElementById('dropdownsSection');
      const startPointList = document.getElementById('startPointList');
      const endPointList = document.getElementById('endPointList');
      const searchStartPoint = document.getElementById('searchStartPoint');
      const searchEndPoint = document.getElementById('searchEndPoint');
      const startPointText = document.getElementById('startPointText');
      const endPointText = document.getElementById('endPointText');
      const startPointBtn = document.getElementById('startPointBtn');
      const endPointBtn = document.getElementById('endPointBtn');
      const processBtn = document.getElementById('processBtn');
      const notificationContent = document.getElementById('notificationContent');
      const previewSection = document.getElementById('previewSection');
      const previewTableBody = document.getElementById('previewTableBody');
      const cableRouteList = document.getElementById('cableRouteList');
      const searchCableRoute = document.getElementById('searchCableRoute');
      const cableRouteText = document.getElementById('cableRouteText');
      const cableRouteBtn = document.getElementById('cableRouteBtn');

      // ========== EXCEL DESIGNATOR COLUMN ORDER ==========
      // Urutan kolom designator vertikal sesuai MATRIKX PT3 NODEB-EPS643-Desa Langge.xlsx (Kolom G s.d. selesai)
      const EXCEL_DESIGNATOR_ORDER = ["SLACK-12CORE", "SLACK-24CORE", "SLACK-48CORE", "SLACK-96CORE", "Slack Support HH", "HH-PIT-80", "AC-OF-SM-12D", "AC-OF-SM-24D", "AC-OF-SM-48D", "AC-OF-SM-96D", "AC-OF-SM-ADSS-12D", "AC-OF-SM-12-SC", "AC-OF-SM-24-SC", "AC-OF-SM-48-SC", "AC-OF-SM-96-SC", "DC-OF-SM-144D", "DC-OF-SM-288D", "SC-OF-SM-288", "SC-OF-SM-12", "SC-OF-SM-48", "SC-OF-SM-96", "SC-OF-SM-144", "OS-SM-1", "AB-OF-SM-2D", "AB-OF-SM-4D", "AB-OF-SM-8D", "AB-OF-SM-12D", "AB-OF-SM-24D", "AB-OF-SM-48D", "AB-OF-SM-72D", "AB-OF-SM-96D", "AB-OF-SM-144D", "AB-OF-SM-288D", "DC-OF-SM-1A", "DC-OF-SM-2A", "DC-OF-SM-1B", "DC-OF-SM-2B", "AC-OF-SM-1B", "AC-OF-SM-2B", "PC-APC-657-2", "PC-APC-657-A1", "PC-UPC-657-2", "PC-UPC-657-A1", "PC-APC-655-2", "PC-APC-655-A1", "PC-UPC-655-2", "PC-UPC-655-A1", "PC-APC-652-2", "PC-APC-652-A1", "PIGTAIL", "PC-UPC-652-2", "PC-APC/UPC-652-A1", "ODC-C-48", "ODC-C-144", "ODC-C-288", "ODC-PROT-144", "ODC-PROT-288", "ODP-CA-8", "ODP-CA-16", "ODP-A-8", "ODP-Solid-PB-8", "ODP-Solid-PB-16", "ODP-Solid-PB-8 AS", "ODP-Solid-PB-16 AS", "ODP-PL-16", "TC-SM-12", "TC-SM-48", "TC-SM-96", "FTB-SM-144SA", "TR-FTM-HIGH CAP", "RS-IN-SC-1P", "RS-IN-SC-2P", "PS-1-2-ODC", "TC-SM-144", "PS-1-4-ODC", "PS-1-8-ODP", "PS-1-16-ODP", "PS-2-2-ODC", "PS-2-4-ODC", "SITAC", "PU-S7.0-140", "PU-S7.0-400NM", "PU-S9.0-140", "PU-C7.0-250", "PU-C9.0-300", "GU-G", "PU-AS-SC", "PU-AS-HL", "PU-AS", "GB-G1", "GB-G3", "GB-G-INTG", "TC-02-ODC", "PP-OF-IN", "PP-OF-OUT", "DD-S3-1", "DD-S3-2", "DD-S3-3", "DD-V4-1", "DD-V4-2", "DD-V5-1", "DD-V5-2", "DD-DA-S1", "DD-DA-S2", "DD-DA-S4", "DD-BSS-S1", "DD-BSS-S2", "DD-BTS-S1", "DD-BTS-S2", "DD-BTS-S4", "HB-PS-1", "HB-PS-2", "HB-PS-4", "HB-PC-2", "HB-PC-4", "DD-BMR-1", "DD-BMR-2", "DD-BMR-4", "DC-SD-28-1", "DC-SD-28-3", "DC-SD-33-1", "DC-SD-33-2", "DC-SD-43-1", "DC-SD-43-2", "DCD-PVC-1", "DD-BM-100-1", "DD-BM-100-2", "DD-BM-50-1", "DD-BM-50-2", "DD-BM-HDPE-40-1", "DD-BM-HDPE-40-2", "DD-BM-HDPE-50-1", "DD-BM-HDPE-50-2", "DD-HDPE-40-1", "DD-HDPE-40-2", "DD-HDPE-50-1", "DD-HDPE-50-2", "DD-HDPE-40-1C", "DD-HDPE-40-2C", "DD-ROD", "DD-RV-1", "DD-RV-CONCRETE", "DD-DS-S1", "DD-DS-COD1-M", "BC-TR-0.4", "BC-TR-0.6", "BC-TR-1", "BC-TR-2", "BC-TR-3", "BC-TR-4", "BC-TR-5", "BCTR-ROCK", "BD-SK", "SMD-ABS-2A", "SMD-ABS-3A", "SMD-ABS-4A", "SMD-ABS-6A", "DD-MDSC-5/3.5", "DD-MDSC-10/8", "DD-MDSC-12/10", "DD-MDDI-1A", "DD-MDDI-2A", "DD-MDDI-4A", "DD-MDDI-7A", "DD-MDDI-12A", "DD-MDDI-19A", "DD-MDDI-24A", "DD-MDDI-1B", "DD-MDDI-2B", "DD-MDDI-4B", "DD-MDDI-7B", "DD-MDDI-1C", "DD-MDDI-2C", "DD-MDDI-4C", "DD-MDDI-7C", "DD-MDDB-1A", "DD-MDDB-2A", "DD-MDDB-4A", "DD-MDDB-7A", "DD-MDDB-12A", "DD-MDDB-19A", "DD-MDDB-24A", "DD-MDDB-1B", "DD-MDDB-2B", "DD-MDDB-4B", "DD-MDDB-7B", "DD-MDDB-1C", "DD-MDDB-2C", "DD-MDDB-4C", "DD-MDDB-7C", "DD-MDEC-5/3.5", "DD-MDEC-10/8", "DD-MDEC-12/10", "Manhole, Perbaikan dan Modifikasi", "MH-HH1", "MH-HH2", "HH-PIT-P-ODC", "MH-CA", "CO-OF", "OTDR"];

      const EXCEL_DESIGNATOR_MAP = new Map();
      EXCEL_DESIGNATOR_ORDER.forEach((name, idx) => {
        EXCEL_DESIGNATOR_MAP.set(name.trim().toUpperCase(), { originalName: name, orderIndex: idx });
      });

      // ========== DATABASE DESIGNATOR FORMULAS ==========
      // Master formulas dari MATRIKX PT3 NODEB-EPS643-Desa Langge.xlsx
      const DEFAULT_DESIGNATOR_FORMULAS = {"SLACK-12CORE": "=IF($F12=\"SLACK-12CORE\",$E12,0)", "SLACK-96CORE": "=IF($F12=\"SLACK-96CORE\",$E12,0)", "SLACK SUPPORT HH": "=IF($F12=\"Slack Support HH\",$E12,0)", "AC-OF-SM-ADSS-12D": "=IF($F12=\"AC-OF-SM-ADSS-12D\",$E12,0)", "AC-OF-SM-12-SC": "=IF($F12=\"AC-OF-SM-12-SC\",$E12,0)", "AC-OF-SM-96-SC": "=IF($F12=\"AC-OF-SM-96-SC\",$E12,0)", "DC-OF-SM-288D": "=IF($F12=\"DC-OF-SM-288D\",$E12,0)", "SC-OF-SM-12": "=IF($F12=\"SC-OF-SM-12\",1,0)", "SC-OF-SM-144": "=IF($F12=\"SC-OF-SM-144\",1,0)", "OS-SM-1": "=IF($F12=\"OS-SM-1\",$E12,0)", "AB-OF-SM-4D": "=IF($F12=\"AB-OF-SM-4D\",$E12,0)", "AB-OF-SM-8D": "=IF($F12=\"AB-OF-SM-8D\",$E12,0)", "AB-OF-SM-12D": "=IF($F12=\"AB-OF-SM-12D\",$E12,0)", "AB-OF-SM-24D": "=IF($F12=\"AB-OF-SM-24D\",$E12,0)", "AB-OF-SM-48D": "=IF($F12=\"AB-OF-SM-48D\",$E12,0)", "AB-OF-SM-72D": "=IF($F12=\"AB-OF-SM-72D\",$E12,0)", "AB-OF-SM-96D": "=IF($F12=\"AB-OF-SM-96D\",$E12,0)", "AB-OF-SM-144D": "=IF($F12=\"AB-OF-SM-144D\",$E12,0)", "AB-OF-SM-288D": "=IF($F12=\"AB-OF-SM-288D\",$E12,0)", "DC-OF-SM-1A": "=IF($F12=\"DC-OF-SM-1A\",$E12,0)", "DC-OF-SM-2A": "=IF($F12=\"DC-OF-SM-2A\",$E12,0)", "DC-OF-SM-1B": "=IF($F12=\"DC-OF-SM-1B\",$E12,0)", "DC-OF-SM-2B": "=IF($F12=\"DC-OF-SM-2B\",$E12,0)", "AC-OF-SM-1B": "=IF($F12=\"AC-OF-SM-1B\",$E12,0)", "PC-APC-657-2": "=IF($F12=\"PC-APC-657-2\",$E12,0)", "PC-APC-657-A1": "=IF($F12=\"PC-APC-657-A1\",$E12,0)", "PC-APC-655-2": "=IF($F12=\"PC-APC-655-2\",$E12,0)", "PC-APC-655-A1": "=IF($F12=\"PC-APC-655-A1\",$E12,0)", "PC-UPC-655-2": "=IF($F12=\"PC-UPC-655-2\",$E12,0)", "PC-UPC-655-A1": "=IF($F12=\"PC-UPC-655-A1\",$E12,0)", "PC-APC-652-2": "=IF($F12=\"PC-APC-652-2\",$E12,0)", "PC-APC-652-A1": "=IF($F12=\"PC-APC-652-A1\",$E12,0)", "PIGTAIL": "=IF($F12=\"PIGTAIL\",$E12,0)", "PC-UPC-652-2": "=IF($F12=\"PC-UPC-652-2\",$E12,0)", "PC-APC/UPC-652-A1": "=IF($F12=\"PC-APC/UPC-652-A1\",$E12,0)", "ODC-C-48": "=IF($F12=\"ODC-C-48\",$E12,0)", "ODC-C-288": "=IF($F12=\"ODC-C-288\",1,0)", "ODC-PROT-288": "=IF($F12=\"ODC-PROT-288\",1,0)", "ODP-SOLID-PB-8": "=IF($F12=\"ODP-Solid-PB-8\",1,0)", "ODP-SOLID-PB-16": "=IF($F12=\"ODP-Solid-PB-16\",1,0)", "ODP-SOLID-PB-8 AS": "=IF($F12=\"ODP-Solid-PB-8 AS\",1,0)", "ODP-PL-16": "=IF($F12=\"ODP-PL-16\",1,0)", "TC-SM-12": "=IF($F12=\"TC-SM-12\",1,0)", "TC-SM-96": "=IF($F12=\"TC-SM-96\",1,0)", "FTB-SM-144SA": "=IF($F12=\"FTB-SM-144SA\",1,0)", "TR-FTM-HIGH CAP": "=IF($F12=\"TR-FTM-HIGH CAP\",1,0)", "RS-IN-SC-1P": "=IF($F12=\"RS-IN-SC-1P\",1,0)", "RS-IN-SC-2P": "=IF($F12=\"RS-IN-SC-2P\",1,0)", "PS-1-2-ODC": "=IF($F12=\"PS-1-2-ODC\",1,0)", "TC-SM-144": "=IF($F12=\"TC-SM-144\",1,0)", "PS-1-4-ODC": "=IF($F12=\"PS-1-4-ODC\",$E12,0)", "PS-1-16-ODP": "=IF($F12=\"PS-1-16-ODP\",1,0)", "PS-2-2-ODC": "=IF($F12=\"PS-2-2-ODC\",1,0)", "PU-S7.0-140": "=IF($F12=\"PU-S7.0-140\",1,0)", "PU-C7.0-250": "=IF($F12=\"PU-C7.0-250\",1,0)", "PU-C9.0-300": "=IF($F12=\"PU-C9.0-300\",1,0)", "PU-AS-SC": "=IF($F12=\"PU-AS-SC\",1,0)", "PU-AS-HL": "=IF($F12=\"PU-AS-HL\",1,0)", "PU-AS": "=IF($F12=\"PU-AS\",1,0)", "GB-G3": "=IF($F12=\"GB-G3\",1,0)", "GB-G-INTG": "=IF($F12=\"GB-G-INTG\",1,0)", "TC-02-ODC": "=IF($F12=\"TC-02-ODC\",$E12,0)", "PP-OF-OUT": "=IF($F12=\"PP-OF-OUT\",$E12,0)", "DD-S3-1": "=IF($F12=\"DD-S3-1\",$E12,0)", "DD-S3-3": "=IF($F12=\"DD-S3-3\",$E12,0)", "DD-V4-1": "=IF($F12=\"DD-V4-1\",$E12,0)", "DD-V4-2": "=IF($F12=\"DD-V4-2\",$E12,0)", "DD-V5-1": "=IF($F12=\"DD-V5-1\",$E12,0)", "DD-V5-2": "=IF($F12=\"DD-V5-2\",$E12,0)", "DD-DA-S1": "=IF($F12=\"DD-DA-S1\",$E12,0)", "DD-DA-S2": "=IF($F12=\"DD-DA-S2\",$E12,0)", "DD-DA-S4": "=IF($F12=\"DD-DA-S4\",$E12,0)", "DD-BSS-S1": "=IF($F12=\"DD-BSS-S1\",$E12,0)", "DD-BSS-S2": "=IF($F12=\"DD-BSS-S2\",$E12,0)", "DD-BTS-S1": "=IF($F12=\"DD-BTS-S1\",$E12,0)", "DD-BTS-S2": "=IF($F12=\"DD-BTS-S2\",$E12,0)", "DD-BTS-S4": "=IF($F12=\"DD-BTS-S4\",$E12,0)", "HB-PS-4": "=IF($F12=\"HB-PS-4\",$E12,0)", "HB-PC-2": "=IF($F12=\"HB-PC-2\",$E12,0)", "DD-BMR-1": "=IF($F12=\"DD-BMR-1\",$E12,0)", "DD-BMR-2": "=IF($F12=\"DD-BMR-2\",$E12,0)", "DC-SD-28-1": "=IF($F12=\"DC-SD-28-1\",$E12,0)", "DC-SD-28-3": "=IF($F12=\"DC-SD-28-3\",$E12,0)", "DC-SD-33-1": "=IF($F12=\"DC-SD-33-1\",$E12,0)", "DC-SD-33-2": "=IF($F12=\"DC-SD-33-2\",$E12,0)", "DC-SD-43-1": "=IF($F12=\"DC-SD-43-1\",$E12,0)", "DD-BM-100-1": "=IF($F12=\"DD-BM-100-1\",$E12,0)", "DD-BM-100-2": "=IF($F12=\"DD-BM-100-2\",$E12,0)", "DD-BM-50-1": "=IF($F12=\"DD-BM-50-1\",$E12,0)", "DD-BM-HDPE-40-1": "=IF($F12=\"DD-BM-HDPE-40-1\",$E12,0)", "DD-BM-HDPE-40-2": "=IF($F12=\"DD-BM-HDPE-40-2\",$E12,0)", "DD-BM-HDPE-50-1": "=IF($F12=\"DD-BM-HDPE-50-1\",$E12,0)", "DD-BM-HDPE-50-2": "=IF($F12=\"DD-BM-HDPE-50-2\",$E12,0)", "DD-HDPE-40-1": "=IF($F12=\"DD-HDPE-40-1\",$E12,0)", "DD-HDPE-40-1C": "=IF($F12=\"DD-HDPE-40-1C\",$E12,0)", "DD-HDPE-40-2C": "=IF($F12=\"DD-HDPE-40-2C\",$E12,0)", "DD-ROD": "=IF($F12=\"DD-ROD\",$E12,0)", "DD-DS-S1": "=IF($F12=\"DD-DS-S1\",1,0)", "DD-DS-COD1-M": "=IF($F12=\"DD-DS-COD1-M\",1,0)", "BC-TR-0.4": "=IF($F12=\"BC-TR-0.4\",$E12,0)", "BC-TR-0.6": "=IF($F12=\"BC-TR-0.6\",$E12,0)", "BC-TR-1": "=IF($F12=\"BC-TR-1\",$E12,0)", "BC-TR-2": "=IF($F12=\"BC-TR-2\",$E12,0)", "BC-TR-3": "=IF($F12=\"BC-TR-3\",$E12,0)", "SMD-ABS-2A": "=IF($F12=\"SMD-ABS-2A\",1,0)", "SMD-ABS-3A": "=IF($F12=\"SMD-ABS-3A\",1,0)", "SMD-ABS-4A": "=IF($F12=\"SMD-ABS-4A\",1,0)", "SMD-ABS-6A": "=IF($F12=\"SMD-ABS-6A\",1,0)", "DD-MDSC-5/3.5": "=IF($F12=\"DD-MDSC-5/3.5\",$E12,0)", "DD-MDSC-10/8": "=IF($F12=\"DD-MDSC-10/8\",$E12,0)", "DD-MDDI-1A": "=IF($F12=\"DD-MDDI-1A\",$E12,0)", "DD-MDDI-2A": "=IF($F12=\"DD-MDDI-2A\",$E12,0)", "DD-MDDI-4A": "=IF($F12=\"DD-MDDI-4A\",$E12,0)", "DD-MDDI-7A": "=IF($F12=\"DD-MDDI-7A\",$E12,0)", "DD-MDDI-12A": "=IF($F12=\"DD-MDDI-12A\",$E12,0)", "DD-MDDI-19A": "=IF($F12=\"DD-MDDI-19A\",$E12,0)", "DD-MDDI-24A": "=IF($F12=\"DD-MDDI-24A\",$E12,0)", "DD-MDDI-1B": "=IF($F12=\"DD-MDDI-1B\",$E12,0)", "DD-MDDI-2B": "=IF($F12=\"DD-MDDI-2B\",$E12,0)", "DD-MDDI-4B": "=IF($F12=\"DD-MDDI-4B\",$E12,0)", "DD-MDDI-7B": "=IF($F12=\"DD-MDDI-7B\",$E12,0)", "DD-MDDI-1C": "=IF($F12=\"DD-MDDI-1C\",$E12,0)", "DD-MDDI-2C": "=IF($F12=\"DD-MDDI-2C\",$E12,0)", "DD-MDDI-4C": "=IF($F12=\"DD-MDDI-4C\",$E12,0)", "DD-MDDI-7C": "=IF($F12=\"DD-MDDI-7C\",$E12,0)", "DD-MDDB-1A": "=IF($F12=\"DD-MDDB-1A\",$E12,0)", "DD-MDDB-2A": "=IF($F12=\"DD-MDDB-2A\",$E12,0)", "DD-MDDB-4A": "=IF($F12=\"DD-MDDB-4A\",$E12,0)", "DD-MDDB-7A": "=IF($F12=\"DD-MDDB-7A\",$E12,0)", "DD-MDDB-12A": "=IF($F12=\"DD-MDDB-12A\",$E12,0)", "DD-MDDB-19A": "=IF($F12=\"DD-MDDB-19A\",$E12,0)", "DD-MDDB-24A": "=IF($F12=\"DD-MDDB-24A\",$E12,0)", "DD-MDDB-1B": "=IF($F12=\"DD-MDDB-1B\",$E12,0)", "DD-MDDB-2B": "=IF($F12=\"DD-MDDB-2B\",$E12,0)", "DD-MDDB-4B": "=IF($F12=\"DD-MDDB-4B\",$E12,0)", "DD-MDDB-7B": "=IF($F12=\"DD-MDDB-7B\",$E12,0)", "DD-MDDB-1C": "=IF($F12=\"DD-MDDB-1C\",$E12,0)", "DD-MDDB-2C": "=IF($F12=\"DD-MDDB-2C\",$E12,0)", "OTDR": "=IF($F12=\"OTDR\",1,0)"};

      let databaseDesignatorFormulas = new Map(Object.entries(DEFAULT_DESIGNATOR_FORMULAS));

      // Dapatkan rumus untuk designator tertentu dari Map database
      function getDesignatorFormula(name) {
        if (!name) return '';
        return databaseDesignatorFormulas.get(name.trim().toUpperCase()) || '';
      }

      // Evaluasi rumus designator untuk suatu baris preview
      function evaluateDesignatorFormula(formula, rowDesignator, rowLength) {
        if (!formula || typeof formula !== 'string') return '-';
        const trimmed = formula.trim();
        if (!trimmed.startsWith('=')) return '-';

        // Format standar: =IF(condition, true_val, false_val)
        const match = trimmed.match(/^=\s*IF\s*\(\s*(.+?)\s*,\s*(.+?)\s*,\s*(.+?)\s*\)$/i);
        if (!match) return '-';

        const condPart = match[1].trim();
        const truePart = match[2].trim();
        const falsePart = match[3].trim();

        // Cek kondisi perbandingan kolom F: e.g. $F12="AC-OF-SM-ADSS-12D"
        let conditionMet = false;
        const quoteMatch = condPart.match(/["']([^"']+)["']/);
        if (quoteMatch) {
          const targetName = quoteMatch[1].trim().toUpperCase();
          const currentName = (rowDesignator || '').trim().toUpperCase();
          conditionMet = (currentName === targetName);
        }

        const chosenExpr = conditionMet ? truePart : falsePart;

        // Jika ekspresi merujuk kolom E (Length) e.g. $E12
        if (/\$E\d*/i.test(chosenExpr)) {
          const rawLen = (rowLength !== null && rowLength !== undefined) ? String(rowLength).trim() : '';
          if (rawLen === '' || rawLen === '-' || rawLen === '0') {
            return '-';
          }
          const num = parseFloat(rawLen);
          if (isNaN(num) || num === 0) {
            return '-';
          }
          return num;
        }

        // Jika ekspresi berupa angka konstan (e.g. 1, 0)
        const numVal = parseFloat(chosenExpr);
        if (!isNaN(numVal)) {
          if (numVal === 0) return '-';
          return numVal;
        }

        // Jika ekspresi berupa teks dalam tanda kutip
        const strMatch = chosenExpr.match(/^["']([^"']*)["']$/);
        if (strMatch) {
          const s = strMatch[1];
          return (s === '0' || s === '') ? '-' : s;
        }

        if (chosenExpr === '0') return '-';
        return chosenExpr || '-';
      }

      // Helper untuk memindai seluruh baris data dan menentukan baris awal serta akhir dari PU-AS-HL
      function getPuAsHlBoundaryRows() {
        const allDataRows = Array.from(previewTableBody.querySelectorAll('tr[data-index]'))
          .filter(r => r.style.display !== 'none' && !r.closest('tfoot'));

        const puAsHlRows = [];
        allDataRows.forEach(r => {
          const desCell = r.querySelector('td[data-field="description"], td[data-field="cableName"]');
          const des = desCell ? desCell.textContent.trim().toUpperCase() : '';
          if (des === 'PU-AS-HL') {
            puAsHlRows.push(r);
          }
        });

        return {
          firstRow: puAsHlRows.length > 0 ? puAsHlRows[0] : null,
          lastRow: puAsHlRows.length > 0 ? puAsHlRows[puAsHlRows.length - 1] : null,
          total: puAsHlRows.length
        };
      }

      // Hitung ulang seluruh cell kolom dinamis pada sebuah baris
      function recalculateRowDesignatorFormulas(row, hlBoundaries = null) {
        if (!row || row.dataset.index === undefined) return;

        const desCell = row.querySelector('td[data-field="description"], td[data-field="cableName"]');
        const lenCell = row.querySelector('td[data-field="length"], td[data-field="cableLength"]');

        const rowDes = desCell ? desCell.textContent.trim() : '';
        const rowLen = lenCell ? lenCell.textContent.trim() : '';

        if (!hlBoundaries) {
          hlBoundaries = getPuAsHlBoundaryRows();
        }

        const dynamicCells = row.querySelectorAll('td.dynamic-designator-cell');
        dynamicCells.forEach(cell => {
          const colDes = cell.dataset.dynamicCol;
          const formula = getDesignatorFormula(colDes);
          let val = evaluateDesignatorFormula(formula, rowDes, rowLen);

          // Pengecualian khusus untuk PU-AS-HL:
          // Deretan awal dan akhir bernilai 1.
          // Deretan di antara awal dan akhir (tengah / kabel bolak-balik) bernilai 2.
          if (colDes && colDes.toUpperCase() === 'PU-AS-HL' && rowDes.toUpperCase() === 'PU-AS-HL') {
            if (hlBoundaries.total > 0) {
              const isBoundary = (row === hlBoundaries.firstRow || row === hlBoundaries.lastRow);
              val = isBoundary ? 1 : 2;
            }
          }

          cell.textContent = (val === 0 || val === '0' || val === '' || val === undefined || val === null) ? '-' : val;
        });
        if (typeof updateGrandTotalRow === 'function') {
          updateGrandTotalRow();
        }
      }

      // Hitung ulang seluruh baris data di tabel preview
      function recalculateAllDesignatorFormulas() {
        const hlBoundaries = getPuAsHlBoundaryRows();
        const allRows = previewTableBody.querySelectorAll('tr[data-index]');
        allRows.forEach(row => recalculateRowDesignatorFormulas(row, hlBoundaries));
        if (typeof updateGrandTotalRow === 'function') {
          updateGrandTotalRow();
        }
      }

      // Hitung dan update baris GRAND TOTAL pada bagian paling bawah tabel preview
      function updateGrandTotalRow() {
        const tfoot = document.getElementById('previewTableFoot');
        if (!tfoot) return;

        const allDataRows = Array.from(previewTableBody.querySelectorAll('tr[data-index]'));
        if (allDataRows.length === 0) {
          tfoot.style.display = 'none';
          return;
        }

        tfoot.style.display = '';

        const grandTotalRow = document.getElementById('grandTotalRow');
        if (!grandTotalRow) return;

        // Hapus cell dinamis grand total sebelumnya
        grandTotalRow.querySelectorAll('.grand-total-dynamic-cell').forEach(cell => cell.remove());

        const activeList = (currentActiveDesignators && currentActiveDesignators.length > 0) 
          ? currentActiveDesignators 
          : (typeof getActiveDesignatorsFromTable === 'function' ? getActiveDesignatorsFromTable() : []);

        // Hitung total nilai untuk setiap kolom designator aktif
        activeList.forEach(des => {
          let sum = 0;
          allDataRows.forEach(row => {
            const cell = row.querySelector(`.dynamic-designator-cell[data-dynamic-col="${des}"]`);
            if (cell) {
              const text = cell.textContent.trim();
              if (text && text !== '-') {
                const num = parseFloat(text);
                if (!isNaN(num)) {
                  sum += num;
                }
              }
            }
          });

          const td = document.createElement('td');
          td.className = 'grand-total-cell grand-total-dynamic-cell text-center';
          td.dataset.dynamicCol = des;
          const formatted = Number.isInteger(sum) ? sum : parseFloat(sum.toFixed(2));
          td.textContent = formatted;
          td.title = `Total ${des}: ${formatted}`;

          grandTotalRow.appendChild(td);
        });
      }

      // Menghitung otomatis kolom SPAN (FCR) dan SPAN (ODP) untuk seluruh baris tabel preview
      function calculateSpanFcrAndOdp() {
        const allRows = Array.from(previewTableBody.querySelectorAll('tr[data-index]'));
        if (allRows.length === 0) return;

        // 1. Cari index placemark pertama di tabel preview (misalnya GTO / index 0)
        let firstPlacemarkIndex = null;
        for (const row of allRows) {
          if (row.dataset.itemType === 'placemark' && row.dataset.index !== undefined) {
            firstPlacemarkIndex = parseInt(row.dataset.index);
            break;
          }
        }
        if (firstPlacemarkIndex === null) return;

        // 2. Tentukan nilai awal SPAN dari baris SLACK-12CORE pada placemark pertama (GTO)
        let initialSlackValue = null;
        let slackFound = false;

        allRows.forEach(row => {
          const index = parseInt(row.dataset.index);
          const itemType = row.dataset.itemType;
          if (index === firstPlacemarkIndex && itemType === 'placemark') {
            const desCell = row.querySelector('td[data-field="description"]');
            const lenCell = row.querySelector('td[data-field="length"]');
            const des = desCell ? desCell.textContent.trim().toUpperCase() : '';

            if (des === 'SLACK-12CORE' || des.startsWith('SLACK-') || des === 'SLACK') {
              slackFound = true;
              const lenVal = lenCell ? lenCell.textContent.trim() : '';
              const parsed = parseFloat(lenVal);
              if (!isNaN(parsed) && parsed > 0) {
                initialSlackValue = parsed;
              }
            }
          }
        });

        // Helper format agar nilai 0 / kosong benar-benar kosong ("") bukan "0" atau "-"
        const formatSpan = (val) => {
          if (val === '' || val === null || val === undefined || val === 0 || val === '0' || val === '-') {
            return '';
          }
          return String(val);
        };

        // 3. Jika SLACK belum diisi atau bernilai <= 0, kosongkan seluruh kolom SPAN (hanya yang belum diedit manual)
        if (initialSlackValue === null) {
          allRows.forEach(row => {
            const fcrCell = row.querySelector('td[data-field="spanFcr"], td[data-field="cableSpanFcr"]');
            const odpCell = row.querySelector('td[data-field="spanOdp"], td[data-field="cableSpanOdp"]');
            if (fcrCell && fcrCell.dataset.userEdited !== 'true') fcrCell.textContent = '';
            if (odpCell && odpCell.dataset.userEdited !== 'true') odpCell.textContent = '';

            const index = parseInt(row.dataset.index);
            const itemType = row.dataset.itemType;
            if (itemType === 'cable') {
              if (fcrCell) customCableSpanFcr.set(index, fcrCell.textContent.trim());
              if (odpCell) customCableSpanOdp.set(index, odpCell.textContent.trim());
            } else if (allRoutePlacemarks[index]) {
              if (fcrCell) allRoutePlacemarks[index].spanFcr = fcrCell.textContent.trim();
              if (odpCell) allRoutePlacemarks[index].spanOdp = odpCell.textContent.trim();
            }
          });
          return;
        }

        // 4. Kosongkan SPAN (FCR) dan SPAN (ODP) pada placemark pertama (GTO, hanya jika belum diedit manual)
        allRows.forEach(row => {
          const index = parseInt(row.dataset.index);
          const itemType = row.dataset.itemType;
          if (index === firstPlacemarkIndex && itemType === 'placemark') {
            const fcrCell = row.querySelector('td[data-field="spanFcr"]');
            const odpCell = row.querySelector('td[data-field="spanOdp"]');
            if (fcrCell && fcrCell.dataset.userEdited !== 'true') fcrCell.textContent = '';
            if (odpCell && odpCell.dataset.userEdited !== 'true') odpCell.textContent = '';
            if (allRoutePlacemarks[firstPlacemarkIndex]) {
              if (fcrCell) allRoutePlacemarks[firstPlacemarkIndex].spanFcr = fcrCell.textContent.trim();
              if (odpCell) allRoutePlacemarks[firstPlacemarkIndex].spanOdp = odpCell.textContent.trim();
            }
          }
        });

        // 5. Iterasi mulai dari baris setelah placemark pertama
        let currentRunningSpan = initialSlackValue;

        allRows.forEach(row => {
          const index = parseInt(row.dataset.index);
          const itemType = row.dataset.itemType;

          // Lewati seluruh baris placemark pertama
          if (index === firstPlacemarkIndex && itemType === 'placemark') {
            return;
          }

          const fcrCell = row.querySelector('td[data-field="spanFcr"], td[data-field="cableSpanFcr"]');
          const odpCell = row.querySelector('td[data-field="spanOdp"], td[data-field="cableSpanOdp"]');
          const lenCell = row.querySelector('td[data-field="length"], td[data-field="cableLength"]');

          if (!fcrCell || !odpCell) return;

          const rawLen = lenCell ? lenCell.textContent.trim() : '';
          const hasLength = rawLen !== '' && rawLen !== '-' && !isNaN(parseFloat(rawLen));
          const numLen = hasLength ? parseFloat(rawLen) : 0;

          // SPAN (FCR): Jika diedit manual oleh user, jangan ditimpa rumus
          let fcrVal = currentRunningSpan;
          if (fcrCell.dataset.userEdited === 'true') {
            const userFcr = fcrCell.textContent.trim();
            if (userFcr !== '' && !isNaN(parseFloat(userFcr))) {
              fcrVal = parseFloat(userFcr);
              currentRunningSpan = fcrVal;
            }
          } else {
            fcrCell.textContent = formatSpan(fcrVal);
          }

          // SPAN (ODP): Jika diedit manual oleh user, jangan ditimpa rumus
          let odpVal;
          if (hasLength && numLen > 0) {
            // Ada penjumlahan: SPAN (ODP) = SPAN (FCR) + LENGTH
            odpVal = Number((fcrVal + numLen).toFixed(2));
            currentRunningSpan = odpVal;
          } else {
            // Tidak ada penjumlahan: LENGTH kosong/0 -> nilai kembar masuk ke kedua kolom
            odpVal = fcrVal;
          }

          if (odpCell.dataset.userEdited === 'true') {
            const userOdp = odpCell.textContent.trim();
            if (userOdp !== '' && !isNaN(parseFloat(userOdp))) {
              currentRunningSpan = parseFloat(userOdp);
            }
          } else {
            odpCell.textContent = formatSpan(odpVal);
          }

          // Sinkronkan ke struktur data internal
          const finalFcr = fcrCell.textContent.trim();
          const finalOdp = odpCell.textContent.trim();
          if (itemType === 'cable') {
            customCableSpanFcr.set(index, finalFcr);
            customCableSpanOdp.set(index, finalOdp);
          } else if (allRoutePlacemarks[index]) {
            allRoutePlacemarks[index].spanFcr = finalFcr;
            allRoutePlacemarks[index].spanOdp = finalOdp;
          }
        });

        // Pastikan cell vertikal SLACK-12CORE ikut terupdate jika length baru saja diubah
        if (slackFound) {
          const firstPmRows = allRows.filter(r => parseInt(r.dataset.index) === firstPlacemarkIndex && r.dataset.itemType === 'placemark');
          firstPmRows.forEach(r => recalculateRowDesignatorFormulas(r));
        }
      }

      let currentActiveDesignators = [];

      // Dapatkan daftar designator unik yang aktif di tabel preview, diurutkan sesuai urutan Excel
      function getActiveDesignatorsFromTable() {
        const foundKeys = new Set();
        const activeList = [];
        
        const allRows = previewTableBody.querySelectorAll('tr[data-index]');
        allRows.forEach(row => {
          if (row.style.display === 'none') return;
          
          const desCell = row.querySelector('td[data-field="description"], td[data-field="cableName"]');
          if (!desCell) return;
          
          const rawVal = desCell.textContent.trim();
          if (!rawVal || rawVal === '-' || rawVal.startsWith('⚠️')) return;
          
          const upperKey = rawVal.toUpperCase();
          if (!foundKeys.has(upperKey)) {
            foundKeys.add(upperKey);
            
            const mapping = EXCEL_DESIGNATOR_MAP.get(upperKey);
            const displayName = mapping ? mapping.originalName : rawVal;
            const sortOrder = mapping ? mapping.orderIndex : (10000 + activeList.length);
            
            activeList.push({
              key: upperKey,
              name: displayName,
              order: sortOrder
            });
          }
        });
        
        activeList.sort((a, b) => a.order - b.order);
        return activeList.map(item => item.name);
      }

      // Update header tabel preview dengan kolom-kolom designator yang aktif
      function updatePreviewTableHeaders(designatorNames) {
        const headerRow1 = document.getElementById('previewHeaderRow1');
        if (!headerRow1) return;

        // Hapus header dinamis lama
        headerRow1.querySelectorAll('.th-dynamic-designator').forEach(el => el.remove());

        // Sisipkan header dinamis baru di akhir headerRow1
        designatorNames.forEach(des => {
          const th = document.createElement('th');
          th.rowSpan = 2;
          th.className = 'th-vertical th-dynamic-designator';
          th.dataset.dynamicHeader = des;
          th.title = des;
          th.textContent = des;
          headerRow1.appendChild(th);
        });

        // Sesuaikan min-width tabel agar tidak terhimpit saat kolom bertambah banyak
        const table = document.getElementById('previewTable');
        if (table) {
          table.style.minWidth = (680 + (designatorNames.length * 44)) + 'px';
        }
      }

      // Sinkronisasi kolom-kolom dinamis designator di thead dan seluruh baris tbody
      function syncDynamicDesignatorColumns(force = false) {
        const activeDesignators = getActiveDesignatorsFromTable();
        
        // Optimasi: jika kolom tidak berubah dan tidak dipaksa re-render, lewati
        const isSame = !force && 
          activeDesignators.length === currentActiveDesignators.length &&
          activeDesignators.every((val, idx) => val === currentActiveDesignators[idx]);
        
        if (isSame) {
          recalculateAllDesignatorFormulas();
          updateGrandTotalRow();
          return;
        }
        
        currentActiveDesignators = activeDesignators;
        updatePreviewTableHeaders(activeDesignators);

        const hlBoundaries = getPuAsHlBoundaryRows();
        const allRows = previewTableBody.querySelectorAll('tr');
        allRows.forEach(row => {
          // Kasus 1: Baris placeholder kosong ("Belum ada data")
          if (row.children.length === 1 && row.firstElementChild.hasAttribute('colspan')) {
            row.firstElementChild.setAttribute('colspan', 7 + activeDesignators.length);
            return;
          }

          // Kasus 2: Missing cable row
          if (row.dataset.itemType === 'missing-cable') {
            const warningCell = row.querySelector('td[colspan]');
            if (warningCell) {
              warningCell.setAttribute('colspan', 5 + activeDesignators.length);
            }
            return;
          }

          // Kasus 3: Baris data (placemark atau cable)
          if (row.dataset.index !== undefined) {
            // Hapus cell dinamis lama jika ada
            row.querySelectorAll('.dynamic-designator-cell').forEach(cell => cell.remove());

            // Ambil designator dan length baris ini untuk kalkulasi rumus
            const desCell = row.querySelector('td[data-field="description"], td[data-field="cableName"]');
            const lenCell = row.querySelector('td[data-field="length"], td[data-field="cableLength"]');

            const rowDes = desCell ? desCell.textContent.trim() : '';
            const rowLen = lenCell ? lenCell.textContent.trim() : '';

            // Sisipkan cell untuk setiap designator aktif di akhir row dengan evaluasi rumus
            activeDesignators.forEach(des => {
              const td = document.createElement('td');
              td.className = 'dynamic-designator-cell';
              td.dataset.dynamicCol = des;
              
              // Evaluasi rumus dari database designator
              const formula = getDesignatorFormula(des);
              let cellValue = evaluateDesignatorFormula(formula, rowDes, rowLen);

              // Pengecualian khusus untuk PU-AS-HL:
              if (des && des.toUpperCase() === 'PU-AS-HL' && rowDes.toUpperCase() === 'PU-AS-HL') {
                if (hlBoundaries.total > 0) {
                  const isBoundary = (row === hlBoundaries.firstRow || row === hlBoundaries.lastRow);
                  cellValue = isBoundary ? 1 : 2;
                }
              }

              td.textContent = (cellValue === 0 || cellValue === '0' || cellValue === '' || cellValue === undefined || cellValue === null) ? '-' : cellValue;

              row.appendChild(td);
            });
          }
        });
        updateGrandTotalRow();
      }

      // ========== UTILITY FUNCTIONS (Menghilangkan Duplikasi) ==========

      // Utility: Create dropdown item
      function createDropdownItem(text, onClickHandler) {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.className = 'dropdown-item';
        a.href = '#';
        a.textContent = text;
        a.addEventListener('click', onClickHandler);
        li.appendChild(a);
        return li;
      }

      // Utility: Extract cable type information (mendukung AC-, DC-, Kabel-FO, atau nama kabel kustom)
      function extractCableTypeInfo(cables) {
        const cableTypesMap = new Map();
        
        for (let cable of cables) {
          const description = (cable.description || cable.name || '').trim();
          let cableType = null;

          // 1. Cek pola standar Telkom: AC-OF-SM-XXX atau DC-OF-SM-XXX
          const standardMatch = description.match(/(?:AC|DC)-[A-Z0-9\-]+/i);
          if (standardMatch) {
            cableType = standardMatch[0].toUpperCase();
          } else {
            // 2. Cek pola kabel umum: Kabel-FO-XXX, FO-XXX, dsb
            const generalMatch = description.match(/(?:Kabel[-_\s]?(?:FO[-_\s]?)?[A-Z0-9]+|FO[-_\s]?[A-Z0-9]+)/i);
            if (generalMatch) {
              cableType = generalMatch[0].toUpperCase();
            } else if (cable.name && cable.name.trim()) {
              // 3. Fallback ke nama kabel langsung jika ada
              cableType = cable.name.trim();
            } else if (description) {
              // 4. Fallback ke ringkasan deskripsi (ambil baris pertama)
              cableType = description.split('\n')[0].replace(/(\d+(?:\.\d+)?)\s*m(?:eter)?/i, '').trim() || 'Jalur Kabel';
            }
          }

          if (cableType) {
            const meterPatterns = [
              /(\d+(?:\.\d+)?)\s*m(?:eter)?s?(?!\w)/i,
              /(\d+(?:\.\d+)?)\s*M(?:ETER)?S?(?!\w)/
            ];
            
            let meterValue = null;
            for (let pattern of meterPatterns) {
              const meterMatch = description.match(pattern);
              if (meterMatch) {
                meterValue = meterMatch[1];
                break;
              }
            }
            
            if (!cableTypesMap.has(cableType)) {
              cableTypesMap.set(cableType, []);
            }
            if (meterValue) {
              cableTypesMap.get(cableType).push(meterValue);
            }
          }
        }
        
        return cableTypesMap;
      }

      // Utility: Format cable types for display
      function formatCableTypesForDisplay(cableTypesMap) {
        const cableTypesArray = [];
        cableTypesMap.forEach((meters, cableType) => {
          let displayText = cableType;
          if (meters.length > 0) {
            const uniqueMeters = [...new Set(meters)].sort((a, b) => parseFloat(a) - parseFloat(b));
            displayText = `${cableType} (${uniqueMeters.join('m, ')}m)`;
          }
          cableTypesArray.push({
            type: cableType,
            display: displayText
          });
        });
        return cableTypesArray.sort((a, b) => a.type.localeCompare(b.type));
      }

      // Utility: Setup search filter with debounce (optimized)
      function setupSearchFilter(searchInput, getItems, filterFn, displayFn, resetBtn) {
        searchInput.addEventListener('input', function(e) {
          const searchTerm = e.target.value.toLowerCase();
          const items = getItems();
          const filtered = items.filter(item => filterFn(item, searchTerm));
          displayFn(filtered);
        });
        
        // Prevent dropdown close when clicking search
        searchInput.addEventListener('click', (e) => e.stopPropagation());
        
        // Reset search when dropdown opens
        if (resetBtn) {
          resetBtn.addEventListener('click', () => {
            searchInput.value = '';
            displayFn(getItems());
          });
        }
      }

      // Utility: Strip HTML tags from string
      function stripHtmlTags(str) {
        if (!str || typeof str !== 'string') return str;
        
        // Create a temporary div to parse HTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = str;
        
        // Get text content (automatically strips all HTML tags)
        return tempDiv.textContent || tempDiv.innerText || '';
      }

      // Utility: Resolve KML BalloonStyle $[schema/field] template variables with actual ExtendedData values
      // In KML, BalloonStyle <text> can contain $[fieldName] or $[schemaName/fieldName] tokens
      // These must be replaced with values from <ExtendedData> before use as description
      function resolveBalloonVariables(text, extendedDataMap) {
        if (!text || !extendedDataMap || extendedDataMap.size === 0) {
          // No ExtendedData available — strip all unresolved $[...] tokens entirely
          return text.replace(/\$\[[^\]]*\]/g, '').replace(/\s{2,}/g, ' ').trim();
        }
        // Replace every $[schema/field] or $[field] with actual value from extendedDataMap
        // Key lookup: try full "schema/field" first, then just "field" (last segment)
        const resolved = text.replace(/\$\[([^\]]+)\]/g, function(match, fullKey) {
          // Try exact key first
          if (extendedDataMap.has(fullKey)) return extendedDataMap.get(fullKey);
          // Try last segment only (e.g. "Site ID/Site_ID" → "Site_ID")
          const segments = fullKey.split('/');
          const fieldName = segments[segments.length - 1].trim();
          if (extendedDataMap.has(fieldName)) return extendedDataMap.get(fieldName);
          // Unresolved — remove token rather than leave garbage
          return '';
        });
        return resolved.replace(/\s{2,}/g, ' ').trim();
      }

      // ========== END UTILITY FUNCTIONS ==========

      let placemarks = [];
      let cableRoutes = []; // Daftar jalur kabel
      let selectedCableRoute = null;
      let selectedStartPoint = null;
      let selectedEndPoint = null;
      let kmlData = [];
      let kmlDataNonDonut = []; // Data placemark NON msn_donut di jalur
      let allPlacemarksData = []; // Semua placemark dengan koordinat
      let cableLines = []; // LineString (jalur kabel)
      let allRoutePlacemarks = []; // Semua placemark di jalur (gabungan donut + non-donut, terurut)
      let databaseDesignators = []; // Designators dari database
      let balloonStyleMapping = new Map(); // Mapping styleId -> balloon text dari <BalloonStyle><text>
      let styleMapMap = new Map(); // Mapping styleMapId -> actualStyleId (untuk resolve StyleMap chain)
      let isEditMode = false; // Track edit mode status
      let selectedRows = new Set(); // Track selected row identifiers
      let selectedDesignatorValue = null; // Track selected designator for batch replace
      let deletedCables = new Set(); // Track deleted cable rows (format: "fromIndex-toIndex")
      let deletedDesignators = new Set(); // Track deleted designators (format: "index-designatorName")
      let deletedPlacemarks = new Set(); // Track deleted placemarks by index
      let customCableNames = new Map(); // Track custom cable names (key: index, value: custom name)
      let customCablePlacemark = new Map();
      let customCableSpanFcr = new Map();
      let customCableSpanOdp = new Map();
      let customCableLength = new Map();
      let undoStack = []; // Stack snapshot HTML tabel untuk fitur undo
      const maxUndoSize = 30; // Maksimum jumlah state undo
      let tableHtmlBeforeCellEdit = null; // Snapshot sementara sebelum sel diedit
      let useCableRoute = true; // Track if cable route feature is enabled
      let userMaxScanRange = null; // null = auto (progressive search), number = user override (meters)
      let resolvedDesignatorCache = new Map(); // Cache hasil resolusi designator dari preview → dipakai saat export

      // =============================================================
      // Fungsi kontrol Jangkauan Scan Kabel
      // =============================================================
      function resetScanRange() {
        userMaxScanRange = null;
        const slider = document.getElementById('scanRangeSlider');
        const display = document.getElementById('scanRangeDisplay');
        const badge = document.getElementById('scanRangeBadge');
        const resetBtn = document.getElementById('resetScanRangeBtn');
        if (slider) slider.value = 0;
        if (display) display.textContent = 'Otomatis';
        if (badge) {
          badge.textContent = 'Otomatis';
          badge.style.background = 'linear-gradient(135deg, #38A169, #2F855A)';
        }
        if (resetBtn) resetBtn.style.display = 'none';
      }

      document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('scanRangeSlider');
        if (!slider) return;
        slider.addEventListener('input', function() {
          const val = parseInt(this.value);
          const display = document.getElementById('scanRangeDisplay');
          const badge = document.getElementById('scanRangeBadge');
          const resetBtn = document.getElementById('resetScanRangeBtn');
          if (val === 0) {
            userMaxScanRange = null;
            display.textContent = 'Otomatis';
            badge.textContent = 'Otomatis';
            badge.style.background = 'linear-gradient(135deg, #38A169, #2F855A)';
            resetBtn.style.display = 'none';
          } else {
            userMaxScanRange = val;
            display.textContent = val + ' meter';
            badge.textContent = val + 'm';
            badge.style.background = 'linear-gradient(135deg, #3182CE, #2C5282)';
            resetBtn.style.display = 'inline-block';
          }
        });
      });

      // Excel variables
      let excelWorkbook = null; // Stored Excel workbook object
      let excelFileName = ''; // Original Excel filename
      let excelSheetNames = []; // Sheet names in Excel

      // Load designators from database on page load
      async function loadDesignatorsFromDatabase() {
        try {
          const response = await fetch('/api/designators');
          if (response.ok) {
            const data = await response.json();
            databaseDesignators = data.map(d => d.nama_designator.toLowerCase().trim());
            data.forEach(d => {
              if (d.nama_designator && d.rumus) {
                databaseDesignatorFormulas.set(d.nama_designator.trim().toUpperCase(), d.rumus.trim());
              }
            });
            console.log(`✅ Loaded ${databaseDesignators.length} designators and ${databaseDesignatorFormulas.size} formulas from database`);
            recalculateAllDesignatorFormulas();
          }
        } catch (error) {
          console.error('Error loading designators:', error);
        }
      }

      // Auto-insert new designator to database
      async function autoInsertDesignator(designatorName) {
        try {
          const response = await fetch('/api/designators', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              nama_designator: designatorName
            })
          });

          if (response.ok) {
            const result = await response.json();
            console.log('✅ Auto-inserted designator:', designatorName);
            return true;
          } else {
            console.log('⚠️ Failed to auto-insert:', designatorName);
            return false;
          }
        } catch (error) {
          console.error('Error auto-inserting designator:', error);
          return false;
        }
      }

      // Extract potential cable designators from description using patterns
      // Mendeteksi SEMUA jenis designator (Cable, ODP, ODC, Tiang, Equipment, dll)
      function extractDesignatorsFromDescription(description) {
        if (!description || description === '-') return [];
        
        // Strip HTML tags if any
        const cleanDescription = stripHtmlTags(description);
        
        const potentialDesignators = [];
        
        // Pattern 1: AC-OF-SM-XXX (kabel udara)
        // Contoh: AC-OF-SM-24FO, AC-OF-SM-48FO, AC-OF-SM-96FO, AC-OF-SM-ADSS-12D
        const acOfSmPattern = /AC-OF-SM-[A-Z0-9\-]+/gi;
        const acOfSmMatches = cleanDescription.match(acOfSmPattern);
        if (acOfSmMatches) {
          potentialDesignators.push(...acOfSmMatches.map(m => m.toUpperCase()));
        }
        
        // Pattern 2: ODP-XXX (Optical Distribution Point)
        // Contoh: ODP-GTL-FCB/072, ODP-SOLID-PB-8
        const odpPattern = /ODP-[A-Z0-9\/\-]+/gi;
        const odpMatches = cleanDescription.match(odpPattern);
        if (odpMatches) {
          potentialDesignators.push(...odpMatches.map(m => m.toUpperCase()));
        }
        
        // Pattern 3: ODC-XXX (Optical Distribution Cabinet)
        // Contoh: ODC-C-144, ODC-ISM-FAS
        const odcPattern = /ODC-[A-Z0-9\/\-]+/gi;
        const odcMatches = cleanDescription.match(odcPattern);
        if (odcMatches) {
          potentialDesignators.push(...odcMatches.map(m => m.toUpperCase()));
        }
        
        // Pattern 4: Infrastructure (POLE, TOWER, TIANG, HELICAL)
        // Contoh: POLE-001, TOWER-A, TIANG-12, HELICAL-24
        const infraPattern = /(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+/gi;
        const infraMatches = cleanDescription.match(infraPattern);
        if (infraMatches) {
          potentialDesignators.push(...infraMatches.map(m => m.toUpperCase()));
        }
        
        // Pattern 5: Equipment (TE, TC, TS, OS, DD, TM, BRACKET, CLAMP)
        // Contoh: TC-SM-12, OS-SM-1, DD-HDPE-40-1, TE, BRACKET-A
        const equipPattern = /(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+/gi;
        const equipMatches = cleanDescription.match(equipPattern);
        if (equipMatches) {
          potentialDesignators.push(...equipMatches.map(m => m.toUpperCase()));
        }
        
        // Pattern 6: Designator umum (kata-kata yang mungkin designator)
        // Cari kata yang dipisahkan spasi, koma, newline, dll
        const tokens = cleanDescription.split(/[\s\n,;:]+/).map(t => t.trim()).filter(t => t.length > 0);
        
        // Filter token yang mungkin designator (huruf kapital, mengandung angka/dash, dll)
        const wordPattern = /^[A-Z][A-Z0-9\-\/]*$/i;
        tokens.forEach(token => {
          if (wordPattern.test(token) && token.length >= 2) {
            potentialDesignators.push(token.toUpperCase());
          }
        });
        
        // Remove duplicates
        const uniqueDesignators = [...new Set(potentialDesignators)];
        
        // CRITICAL FIX: Remove substring duplicates
        // Sort dari terpanjang ke terpendek, lalu filter out yang merupakan substring
        const sortedByLength = uniqueDesignators.sort((a, b) => b.length - a.length);
        const filtered = [];
        
        for (let designator of sortedByLength) {
          // Cek apakah designator ini adalah substring dari designator yang sudah ada di filtered
          const isSubstring = filtered.some(existing => 
            existing !== designator && existing.includes(designator)
          );
          
          if (!isSubstring) {
            filtered.push(designator);
          }
        }
        
        return filtered;
      }

      // Extract recognized designators per line (used for endpoint multiline merge)
      function extractRecognizedDesignatorLines(description) {
        if (!description || description === '-') return [];

        const cleanDesc = stripHtmlTags(description);
        const lines = cleanDesc.split(/\r?\n/).map(line => line.trim()).filter(line => line && line !== '-');
        if (lines.length === 0) return [];

        const validDesignators = [];
        lines.forEach(line => {
          const isRecognizedPattern =
            /^AC-OF-SM-[A-Z0-9\-]+$/i.test(line) ||
            /^ODP-[A-Z0-9\/\-]+$/i.test(line) ||
            /^ODC-[A-Z0-9\/\-]+$/i.test(line) ||
            /^(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+$/i.test(line) ||
            /^(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+$/i.test(line) ||
            /^[A-Z]{2,6}(-[A-Z0-9]+){1,4}$/i.test(line) ||
            (line.length <= 30 && /^[A-Z0-9][A-Z0-9\-\/]+$/i.test(line));

          if (isRecognizedPattern) {
            validDesignators.push(line);
          }
        });

        return validDesignators;
      }

      // Check if description contains any database designator
      // Returns array of all matched designators
      // Auto-inserts new CABLE designators (AC-OF-SM-XXX) to database if not found
      async function findAllDesignatorsInDescription(description, placemarkName = '') {
        if (!description || description === '-') {
          // Jika description kosong, cek apakah placemark name ada di database
          if (placemarkName && placemarkName !== '-') {
            const nameLower = placemarkName.toLowerCase();
            const existsInDb = databaseDesignators.some(db => db === nameLower);
            if (existsInDb) {
              console.log('✅ Placemark name found in database:', placemarkName);
              return [nameLower];
            }
          }
          return [];
        }
        
        // CRITICAL: Strip HTML tags first before parsing
        const cleanDescription = stripHtmlTags(description);
        
        console.log('🔍 Parsing placemark:', {
          name: placemarkName,
          description: cleanDescription.substring(0, 150)
        });
        
        const foundDesignators = [];
        const newDesignatorsToInsert = [];
        
        // Step 1: Cek nama placemark apakah ada di database
        if (placemarkName && placemarkName !== '-') {
          const nameLower = placemarkName.toLowerCase();
          const existsInDb = databaseDesignators.some(db => db === nameLower);
          if (existsInDb) {
            foundDesignators.push(nameLower);
            console.log('✅ Placemark name matched in database:', placemarkName);
          }
        }
        
        // Step 2: Cari semua designator dari database dalam description
        // Gunakan substring matching agar lebih fleksibel
        // IMPORTANT: Sort dari TERPANJANG ke TERPENDEK untuk avoid substring duplicates
        const sortedDesignators = [...databaseDesignators].sort((a, b) => b.length - a.length);
        
        for (let designator of sortedDesignators) {
          // CRITICAL FIX: Skip jika designator ini adalah SUBSTRING dari designator yang sudah ditemukan
          // Contoh: Skip "PU-AS" jika "PU-AS-SC" sudah ada
          const isSubstringOfFound = foundDesignators.some(found => 
            found !== designator.toLowerCase() && found.includes(designator.toLowerCase())
          );
          
          if (isSubstringOfFound) {
            console.log(`⏭️ Skipping "${designator}" (substring of longer designator already found)`);
            continue;
          }
          
          // Case-insensitive substring search
          const designatorPattern = designator.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // Escape regex chars
          const regex = new RegExp(designatorPattern, 'gi');
          const matched = regex.test(cleanDescription);
          
          if (matched) {
            const designatorLower = designator.toLowerCase();
            if (!foundDesignators.includes(designatorLower)) {
              foundDesignators.push(designatorLower);
              console.log('✅ Matched designator from database:', designator);
            }
          }
        }
        
        // Step 3: Ekstrak potential designators dari description
        const potentialDesignators = extractDesignatorsFromDescription(cleanDescription);
        
        // Step 4: Validasi potential designators terhadap database
        for (let potentialDes of potentialDesignators) {
          const potentialDesLower = potentialDes.toLowerCase();
          
          // CRITICAL FIX: Skip jika designator ini adalah SUBSTRING dari designator yang sudah ditemukan
          const isSubstringOfFound = foundDesignators.some(found => 
            found !== potentialDesLower && found.includes(potentialDesLower)
          );
          
          if (isSubstringOfFound) {
            console.log(`⏭️ Skipping potential "${potentialDes}" (substring of longer designator already found)`);
            continue;
          }
          
          // Cek apakah sudah ada di database
          const existsInDatabase = databaseDesignators.some(db => db === potentialDesLower);
          
          if (!existsInDatabase) {
            // Auto-insert untuk designator yang mengikuti pattern valid
            const isAutoInsertPattern = 
              // Specific patterns (Cable, ODP, ODC)
              /^AC-OF-SM-[A-Z0-9\-]+$/i.test(potentialDes) ||      // Cable: AC-OF-SM-ADSS-12D
              /^ODP-[A-Z0-9\/\-]+$/i.test(potentialDes) ||         // ODP: ODP-GTL-FCB/072
              /^ODC-[A-Z0-9\/\-]+$/i.test(potentialDes) ||         // ODC: ODC-C-144, ODC-ISM-FAS
              
              // Infrastructure patterns (Tiang, Pole, Tower, Helical)
              /^(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+$/i.test(potentialDes) ||  // POLE-001, TOWER-A, HELICAL-24
              
              // Equipment patterns (Terminal, Closure, Splice, etc)
              /^(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+$/i.test(potentialDes) ||  // TC-SM-12, OS-SM-1, DD-HDPE-40-1
              
              // Generic structured code (2-6 huruf, minimal 1 dash, diikuti angka/huruf)
              // Contoh: OS-SM-1, TC-02-ODC, PU-AS-SC, etc.
              (/^[A-Z]{2,6}-[A-Z0-9]+(-[A-Z0-9]+)*$/i.test(potentialDes) && potentialDes.length >= 4 && potentialDes.length <= 30);
            
            if (isAutoInsertPattern) {
              // Belum ada di database, tandai untuk auto-insert
              const alreadyMarked = newDesignatorsToInsert.some(n => n.toLowerCase() === potentialDesLower);
              
              if (!alreadyMarked) {
                newDesignatorsToInsert.push(potentialDes);
                if (!foundDesignators.includes(potentialDesLower)) {
                  foundDesignators.push(potentialDesLower);
                }
              }
            }
            // Jika bukan pattern yang di-auto-insert, skip (tidak otomatis insert)
          } else {
            // Sudah ada di database, tambahkan ke foundDesignators
            if (!foundDesignators.includes(potentialDesLower)) {
              foundDesignators.push(potentialDesLower);
            }
          }
        }
        
        // Step 5: Auto-insert designators baru ke database (semua pattern valid)
        if (newDesignatorsToInsert.length > 0) {
          console.log(`🔄 Auto-inserting ${newDesignatorsToInsert.length} new designator(s):`, newDesignatorsToInsert);
          
          for (let newDes of newDesignatorsToInsert) {
            const inserted = await autoInsertDesignator(newDes);
            if (inserted) {
              // Tambahkan ke local cache agar tidak insert lagi
              databaseDesignators.push(newDes.toLowerCase());
              console.log(`✅ Successfully added to database: ${newDes}`);
            } else {
              console.log(`⚠️ Failed to insert: ${newDes}`);
            }
          }
        }
        
        console.log('📋 Final matched designators:', foundDesignators);
        return foundDesignators;
      }

      // Check if process button should be enabled
      function checkProcessButton() {
        if (useCableRoute) {
          // Cable mode: need start, end, AND cable route
          processBtn.disabled = !(selectedStartPoint && selectedEndPoint && selectedCableRoute);
        } else {
          // Non-cable mode: only need start and end
          processBtn.disabled = !(selectedStartPoint && selectedEndPoint);
        }
      }

      // Load designators when page loads
      loadDesignatorsFromDatabase();

      // Cable checkbox toggle handler
      const useCableCheckbox = document.getElementById('useCableCheckbox');
      useCableCheckbox.addEventListener('change', function() {
        useCableRoute = this.checked;
        
        if (useCableRoute) {
          // Enable cable route dropdown
          cableRouteBtn.disabled = false;
          cableRouteBtn.classList.remove('btn-secondary');
          cableRouteBtn.classList.add('btn-outline-secondary');
          
          showToast('info', 'Mode Kabel Aktif', 'Pilih jalur kabel untuk memproses file KML.');
        } else {
          // Disable cable route dropdown
          cableRouteBtn.disabled = true;
          cableRouteBtn.classList.remove('btn-outline-secondary');
          cableRouteBtn.classList.add('btn-secondary');
          cableRouteText.textContent = 'Tidak digunakan';
          selectedCableRoute = null;
          
          showToast('warning', 'Mode Tanpa Kabel', 'Sistem akan memproses file KML tanpa informasi jalur kabel.');
        }
        
        // Update process button state
        checkProcessButton();
      });

      // ========== EXCEL & PDF DIRECT EXPORT HANDLING ==========

      let isExportingExcel = false;
      let isExportingPdf = false;

      const btnDownloadExcel = document.getElementById('btnDownloadExcel');
      const btnDownloadPdf = document.getElementById('btnDownloadPdf');

      if (btnDownloadExcel) {
        btnDownloadExcel.addEventListener('click', function(e) { exportToExcelDirect(e); });
      }

      if (btnDownloadPdf) {
        btnDownloadPdf.addEventListener('click', function(e) { exportToPdfDirect(e); });
      }

      // Helper: Tampilkan peringatan jelas jika tombol download diklik sebelum rute diproses
      function showNoDataWarning(exportType) {
        const typeName = exportType === 'excel' ? 'Excel' : 'PDF';

        // Tampilkan toast seragam
        showToast('warning', `Belum Bisa Mengunduh ${typeName}!`,
          `Tabel rute masih kosong. Tentukan Titik Awal, Titik Akhir, dan Jalur Kabel, lalu klik "Proses Data" terlebih dahulu.`);

        // Tampilkan notifikasi di panel kiri jika tersedia
        const notifContent = document.getElementById('notificationContent');
        const notifWrapper = document.getElementById('notificationWrapper');
        if (notifContent && notifWrapper) {
          notifContent.innerHTML = `
            <div class="alert alert-warning mb-0" role="alert" style="background: rgba(245, 158, 11, 0.15); border: 1px solid #F59E0B; color: #FCD34D; border-radius: 8px;">
              <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5 mt-1" style="color: #F59E0B;"></i>
                <div>
                  <strong style="color: #FFFFFF;">Belum Bisa Mengunduh ${typeName}!</strong>
                  <p class="mb-0 mt-1" style="font-size: 0.8rem; line-height: 1.4;">
                    Silakan tentukan <strong>Titik Awal</strong>, <strong>Titik Akhir</strong>, dan <strong>Jalur Kabel</strong> pada dropdown di atas, lalu klik tombol <strong>"Proses Data"</strong> untuk menghasilkan tabel matriks rute.
                  </p>
                </div>
              </div>
            </div>
          `;
          notifWrapper.style.display = 'block';
        }

        // Highlight tombol Proses Data dan scroll
        const processBtn = document.getElementById('processBtn');
        if (processBtn) {
          processBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
          processBtn.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
          processBtn.style.transform = 'scale(1.06)';
          processBtn.style.boxShadow = '0 0 18px rgba(220, 38, 38, 0.9)';
          setTimeout(() => {
            processBtn.style.transform = 'none';
            processBtn.style.boxShadow = '';
          }, 1500);
        }
      }

      // Check if export buttons should be enabled
      function checkExportButton() {
        const hasData = (allRoutePlacemarks && allRoutePlacemarks.length > 0) || 
          (previewTableBody && previewTableBody.querySelectorAll('tr[data-index], tr').length > 0);
        if (btnDownloadExcel) {
          btnDownloadExcel.classList.toggle('is-disabled', !hasData);
          btnDownloadExcel.setAttribute('aria-disabled', String(!hasData));
        }
        if (btnDownloadPdf) {
          btnDownloadPdf.classList.toggle('is-disabled', !hasData);
          btnDownloadPdf.setAttribute('aria-disabled', String(!hasData));
        }
      }

      // Disable export buttons (when no preview data)
      function disableExcelUpload() {
        if (btnDownloadExcel) {
          btnDownloadExcel.classList.add('is-disabled');
          btnDownloadExcel.setAttribute('aria-disabled', 'true');
        }
        if (btnDownloadPdf) {
          btnDownloadPdf.classList.add('is-disabled');
          btnDownloadPdf.setAttribute('aria-disabled', 'true');
        }
      }

      // Enable export buttons (when preview data exists)
      function enableExcelUpload() {
        if (btnDownloadExcel) {
          btnDownloadExcel.classList.remove('is-disabled');
          btnDownloadExcel.setAttribute('aria-disabled', 'false');
        }
        if (btnDownloadPdf) {
          btnDownloadPdf.classList.remove('is-disabled');
          btnDownloadPdf.setAttribute('aria-disabled', 'false');
        }
      }

      // Convert column index (1-based) to Excel column letter (e.g. 1 -> A, 27 -> AA)
      function getExcelColumnLetter(colIndex) {
        let letter = '';
        let temp = colIndex;
        while (temp > 0) {
          const mod = (temp - 1) % 26;
          letter = String.fromCharCode(65 + mod) + letter;
          temp = Math.floor((temp - mod) / 26);
        }
        return letter;
      }

      // Direct Export to Excel (Full Formulas, 212 Designators Preserved, Non-active Hidden)
      async function exportToExcelDirect(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();

        // Cegah klik ganda / eksekusi paralel yang menyebabkan file terdownload 2 kali
        if (isExportingExcel) {
          console.warn('⚠️ Export to Excel sedang berjalan, mengabaikan klik ganda.');
          return;
        }

        const allRows = Array.from(previewTableBody.querySelectorAll('tr[data-index], tr'))
          .filter(r => r.style.display !== 'none' && !r.closest('tfoot'));

        if (allRows.length === 0) {
          showNoDataWarning('excel');
          return;
        }

        isExportingExcel = true;
        console.log('⚡ exportToExcelDirect called');

        const btnExcel = document.getElementById('btnDownloadExcel');
        const defaultExcelBtnHtml = '<i class="bi bi-file-earmark-excel-fill me-2"></i><span>Download Excel</span>';
        if (btnExcel) {
          btnExcel.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengunduh Excel...';
          btnExcel.style.pointerEvents = 'none';
        }

        try {
          // Force save all active contenteditable edits
          saveAllActiveEdits();

          // Fetch template otomatis dengan fallback path
          let res = null;
          const templateUrls = [
            "{{ asset('templates/template_matriks.xlsx') }}",
            '/templates/template_matriks.xlsx',
            'templates/template_matriks.xlsx'
          ];
          for (const tUrl of templateUrls) {
            try {
              const tryRes = await fetch(tUrl);
              if (tryRes.ok) {
                res = tryRes;
                break;
              }
            } catch(e) {}
          }

          if (!res || !res.ok) {
            throw new Error('Gagal memuat berkas template template_matriks.xlsx dari server.');
          }
          const arrayBuffer = await res.arrayBuffer();

          if (!window.ExcelJS) {
            throw new Error('Library ExcelJS belum siap atau gagal dimuat.');
          }

          const workbook = new ExcelJS.Workbook();
          await workbook.xlsx.load(arrayBuffer);

          workbook.creator = 'Telkom Route Matrix';
          workbook.lastModifiedBy = 'Telkom Route Matrix';
          workbook.created = new Date();
          workbook.modified = new Date();
          workbook.calcProperties = { fullCalcOnLoad: true };

          const worksheet = workbook.getWorksheet('Matrix FCR') || workbook.getWorksheet('Matriks FCR') || workbook.worksheets[0];
          if (!worksheet) {
            throw new Error('Sheet "Matrix FCR" tidak ditemukan dalam template!');
          }

          // Pastikan excel yang dihasilkan hanya memiliki satu sheet yaitu Matrix FCR (hapus BOQ, Sheet1, dll)
          const sheetsToRemove = [];
          workbook.eachSheet((ws) => {
            if (ws.id !== worksheet.id) {
              sheetsToRemove.push(ws.id);
            }
          });
          sheetsToRemove.forEach(id => workbook.removeWorksheet(id));

          // Extract data from preview table
          const exportData = [];
          allRows.forEach((row, rIdx) => {
            const noCell = row.querySelector('td[data-col="no"]');
            const nameCell = row.querySelector('td[data-field="name"], td[data-field="cablePlacemark"]');
            const spanFcrCell = row.querySelector('td[data-field="spanFcr"], td[data-field="cableSpanFcr"]');
            const spanOdpCell = row.querySelector('td[data-field="spanOdp"], td[data-field="cableSpanOdp"]');
            const lengthCell = row.querySelector('td[data-field="length"], td[data-field="cableLength"]');
            const desCell = row.querySelector('td[data-field="description"], td[data-field="cableName"]');

            const no = noCell ? noCell.textContent.trim() : (rIdx + 1);
            const colB = nameCell ? nameCell.textContent.trim() : '';
            const colC = spanFcrCell ? spanFcrCell.textContent.trim() : '';
            const colD = spanOdpCell ? spanOdpCell.textContent.trim() : '';
            const colE = lengthCell ? lengthCell.textContent.trim() : '';
            const colF = desCell ? desCell.textContent.trim() : '';

            exportData.push({ no, colB, colC, colD, colE, colF });
          });

          // Active designators from preview table
          const activeDesignators = (currentActiveDesignators && currentActiveDesignators.length > 0)
            ? currentActiveDesignators
            : getActiveDesignatorsFromTable();
          const activeKeys = new Set(activeDesignators.map(d => d.trim().toUpperCase()));

          const startRow = 12;
          const templateRowCount = 23; // Baris 12 s.d. 34
          const totalRowsNeeded = exportData.length;

          // Bersihkan merge lama dari template (row 12 ke bawah) agar tidak rusak saat pergeseran baris
          if (worksheet._merges) {
            Object.keys(worksheet._merges).forEach(k => {
              const range = worksheet._merges[k];
              if (range && range.model && range.model.top >= 12) {
                delete worksheet._merges[k];
              }
            });
          }

          // Tambah baris jika data lebih banyak dari slot template (23 baris)
          if (totalRowsNeeded > templateRowCount) {
            const diff = totalRowsNeeded - templateRowCount;
            worksheet.duplicateRow(34, diff, true);
          }

          // Bersihkan merge sisa pergeseran duplicateRow pada row >= 12
          if (worksheet._merges) {
            Object.keys(worksheet._merges).forEach(k => {
              const range = worksheet._merges[k];
              if (range && range.model && range.model.top >= 12) {
                delete worksheet._merges[k];
              }
            });
          }

          const finalLastDataRow = 11 + Math.max(totalRowsNeeded, templateRowCount);
          const maxCol = Math.max(worksheet.columnCount, 212);

          // Tentukan visibilitas kolom designator aktif terlebih dahulu agar border hanya dipasang pada kolom tampak
          const seenUnhidden = new Set();
          const visibleDesigCols = [];
          for (let c = 7; c <= maxCol; c++) {
            const headerVal = worksheet.getRow(8).getCell(c).value;
            const headerKey = headerVal ? String(headerVal).trim().toUpperCase() : '';
            const col = worksheet.getColumn(c);
            if (headerKey && activeKeys.has(headerKey) && !seenUnhidden.has(headerKey)) {
              col.hidden = false;
              seenUnhidden.add(headerKey);
              visibleDesigCols.push(c);
            } else {
              col.hidden = true;
            }
          }

          // Border standar tipis (Batas Biasa / Semua Batas)
          const thinBorder = {
            top: { style: 'thin', color: { argb: 'FF000000' } },
            bottom: { style: 'thin', color: { argb: 'FF000000' } },
            left: { style: 'thin', color: { argb: 'FF000000' } },
            right: { style: 'thin', color: { argb: 'FF000000' } }
          };

          // Visibilitas Baris: 1..7 disembunyikan, 8 tampil, 9..11 disembunyikan
          for (let r = 1; r <= 7; r++) {
            worksheet.getRow(r).hidden = true;
          }
          worksheet.getRow(8).hidden = false;
          for (let r = 9; r <= 11; r++) {
            worksheet.getRow(r).hidden = true;
          }

          // Format header baris 8 (batas tipis biasa)
          for (let c = 2; c <= 6; c++) {
            worksheet.getRow(8).getCell(c).border = thinBorder;
          }
          for (let c = 7; c <= maxCol; c++) {
            if (!worksheet.getColumn(c).hidden) {
              worksheet.getRow(8).getCell(c).border = thinBorder;
            }
          }

          // Cache formula asli template pada baris 12 sebelum baris di-overwrite
          const templateFormulasByCol = new Map();
          for (let c = 7; c <= maxCol; c++) {
            const rawCell = worksheet.getRow(12).getCell(c);
            let rawFormula = '';
            if (rawCell && rawCell.value) {
              if (typeof rawCell.value === 'object' && rawCell.value.formula) {
                rawFormula = rawCell.value.formula;
              } else if (typeof rawCell.value === 'string' && rawCell.value.startsWith('=')) {
                rawFormula = rawCell.value;
              }
            }
            if (rawFormula) {
              templateFormulasByCol.set(c, rawFormula);
            }
          }

          // Pindai indeks deretan baris untuk PU-AS-HL agar dapat membedakan awal & akhir (1) dan tengah (2)
          const puAsHlExportIndices = [];
          exportData.forEach((item, idx) => {
            if (String(item.colF || '').trim().toUpperCase() === 'PU-AS-HL') {
              puAsHlExportIndices.push(idx);
            }
          });
          const firstHlExportIdx = puAsHlExportIndices.length > 0 ? puAsHlExportIndices[0] : -1;
          const lastHlExportIdx = puAsHlExportIndices.length > 0 ? puAsHlExportIndices[puAsHlExportIndices.length - 1] : -1;

          // Helper penentu apakah designator bernilai kuantitas 1 (pcs/unit/buah) atau panjang meter ($E)
          const getFormulaTrueValue = (cleanDes, unitVal, colIdx, rowNum, rowIdx = null) => {
            const desUpper = cleanDes.toUpperCase();

            // Pengecualian khusus untuk PU-AS-HL:
            // Deretan awal dan akhir bernilai 1.
            // Deretan di antara awal dan akhir (tengah / kabel bolak-balik) bernilai 2.
            if (desUpper === 'PU-AS-HL') {
              if (puAsHlExportIndices.length > 0 && rowIdx !== null && rowIdx !== undefined) {
                const isBoundary = (rowIdx === firstHlExportIdx || rowIdx === lastHlExportIdx);
                return isBoundary ? '1' : '2';
              }
              return '1';
            }

            const u = unitVal ? String(unitVal).trim().toLowerCase() : '';
            // 1. Cek unit eksplisit (pcs, unit, buah, bh, btg, set, node)
            if (['pcs', 'unit', 'buah', 'bh', 'btg', 'set', 'node', 'titik'].includes(u)) {
              return '1';
            }
            if (['mtr', 'm', 'meter', 'km'].includes(u)) {
              return `IF(ISNUMBER($E${rowNum}),$E${rowNum},0)`;
            }

            // 2. Cek formula dari master database / DEFAULT_DESIGNATOR_FORMULAS
            const dbFormula = getDesignatorFormula(cleanDes);
            if (dbFormula) {
              const cleanedDbF = dbFormula.replace(/\s+/g, '');
              if (cleanedDbF.endsWith(',1,0)') || cleanedDbF.endsWith(',1.0,0)') || cleanedDbF.endsWith(',"1",0)')) {
                return '1';
              }
              if (cleanedDbF.includes('$E')) {
                return `IF(ISNUMBER($E${rowNum}),$E${rowNum},0)`;
              }
            }

            // 3. Cek formula asli baris 12 template Excel
            const tmplF = templateFormulasByCol.get(colIdx);
            if (tmplF) {
              const cleanedTmplF = tmplF.replace(/\s+/g, '');
              if (cleanedTmplF.endsWith(',1,0)') || cleanedTmplF.endsWith(',1.0,0)')) {
                return '1';
              }
              if (cleanedTmplF.includes('$E') || cleanedTmplF.includes('E12')) {
                return `IF(ISNUMBER($E${rowNum}),$E${rowNum},0)`;
              }
            }

            // 4. Pola nama designator kategori hardware / aksesoris tiang / ODP / ODC / closure
            if (
              desUpper.startsWith('PU-') ||
              desUpper.startsWith('ODP-') ||
              desUpper.startsWith('ODC-') ||
              desUpper.startsWith('TC-') ||
              desUpper.startsWith('SC-OF-SM-') ||
              desUpper.startsWith('POLE') ||
              desUpper.startsWith('TIANG') ||
              desUpper.startsWith('TOWER') ||
              desUpper.startsWith('HELICAL') ||
              desUpper.startsWith('GB-') ||
              desUpper.startsWith('RS-') ||
              desUpper.startsWith('PS-') ||
              desUpper.startsWith('FTB-') ||
              desUpper.startsWith('TR-FTM') ||
              desUpper.startsWith('SMD-') ||
              desUpper === 'OTDR' ||
              desUpper === 'STAINLESS BELT'
            ) {
              return '1';
            }

            // Default panjang kabel
            return `IF(ISNUMBER($E${rowNum}),$E${rowNum},0)`;
          };

          // Isi baris data preview (baris 12 s.d. finalLastDataRow)
          exportData.forEach((item, idx) => {
            const r = startRow + idx;
            const row = worksheet.getRow(r);
            row.hidden = false;

            const cellA = row.getCell(1);
            const cellB = row.getCell(2);
            const cellC = row.getCell(3);
            const cellD = row.getCell(4);
            const cellE = row.getCell(5);
            const cellF = row.getCell(6);

            cellA.value = item.no ? (isNaN(item.no) ? item.no : Number(item.no)) : (idx + 1);
            cellB.value = String(item.colB || '');
            cellC.value = (item.colC !== undefined && item.colC !== null && String(item.colC).trim() !== '' && !isNaN(item.colC)) ? Number(item.colC) : (item.colC ? String(item.colC) : null);
            cellD.value = (item.colD !== undefined && item.colD !== null && String(item.colD).trim() !== '' && !isNaN(item.colD)) ? Number(item.colD) : (item.colD ? String(item.colD) : null);
            cellE.value = (item.colE !== undefined && item.colE !== null && String(item.colE).trim() !== '' && !isNaN(item.colE)) ? Number(item.colE) : null;
            cellF.value = String(item.colF || '');

            for (let c = 2; c <= 6; c++) {
              row.getCell(c).border = thinBorder;
            }

            for (let c = 7; c <= maxCol; c++) {
              const cell = row.getCell(c);
              const isHidden = worksheet.getColumn(c).hidden;
              const headerDesig = worksheet.getRow(8).getCell(c).value;
              if (headerDesig) {
                const cleanDes = String(headerDesig).trim();
                const unitCell = worksheet.getRow(9).getCell(c).value;
                const trueVal = getFormulaTrueValue(cleanDes, unitCell, c, r, idx);
                cell.value = {
                  formula: `IF($F${r}="${cleanDes}",${trueVal},0)`
                };
              } else {
                cell.value = null;
              }
              cell.numFmt = '_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)';

              if (!isHidden) {
                cell.border = thinBorder;
              }
            }
          });

          // Kosongkan baris template yang tidak terpakai jika data < 23
          if (totalRowsNeeded < templateRowCount) {
            for (let r = startRow + totalRowsNeeded; r <= finalLastDataRow; r++) {
              const row = worksheet.getRow(r);
              row.hidden = false;
              for (let c = 1; c <= 6; c++) {
                row.getCell(c).value = null;
                if (c >= 2) row.getCell(c).border = thinBorder;
              }
              for (let c = 7; c <= maxCol; c++) {
                const cell = row.getCell(c);
                const isHidden = worksheet.getColumn(c).hidden;
                const headerDesig = worksheet.getRow(8).getCell(c).value;
                if (headerDesig) {
                  const cleanDes = String(headerDesig).trim();
                  const unitCell = worksheet.getRow(9).getCell(c).value;
                  const trueVal = getFormulaTrueValue(cleanDes, unitCell, c, r, null);
                  cell.value = {
                    formula: `IF($F${r}="${cleanDes}",${trueVal},0)`
                  };
                } else {
                  cell.value = null;
                }
                cell.numFmt = '_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)';
                if (!isHidden) {
                  cell.border = thinBorder;
                }
              }
            }
          }

          // Baris GRAND TOTAL (2 Baris: gtRow1 dan gtRow2)
          const gtRow1 = finalLastDataRow + 1;
          const gtRow2 = finalLastDataRow + 2;
          worksheet.getRow(gtRow1).hidden = false;
          worksheet.getRow(gtRow2).hidden = false;

          for (let c = 1; c <= 6; c++) {
            worksheet.getRow(gtRow1).getCell(c).value = null;
            worksheet.getRow(gtRow2).getCell(c).value = null;
          }

          for (let r = gtRow1; r <= gtRow2; r++) {
            const row = worksheet.getRow(r);
            for (let c = 1; c <= 6; c++) {
              row.getCell(c).border = {
                top: { style: (r === gtRow1 ? 'medium' : 'thin'), color: { argb: 'FF000000' } },
                bottom: { style: (r === gtRow2 ? 'medium' : 'thin'), color: { argb: 'FF000000' } },
                left: { style: (c === 1 ? 'medium' : 'thin'), color: { argb: 'FF000000' } },
                right: { style: (c === 6 ? 'medium' : 'thin'), color: { argb: 'FF000000' } }
              };
            }
          }

          const gtCell = worksheet.getCell(`A${gtRow1}`);
          gtCell.value = 'GRAND TOTAL';
          gtCell.font = { name: 'Arial', size: 13.5, bold: true };
          gtCell.alignment = { horizontal: 'center', vertical: 'middle' };
          worksheet.mergeCells(`A${gtRow1}:F${gtRow2}`);

          gtCell.border = {
            top: { style: 'medium', color: { argb: 'FF000000' } },
            bottom: { style: 'medium', color: { argb: 'FF000000' } },
            left: { style: 'medium', color: { argb: 'FF000000' } },
            right: { style: 'medium', color: { argb: 'FF000000' } }
          };

          for (let c = 7; c <= maxCol; c++) {
            const colLetter = getExcelColumnLetter(c);
            const c1 = worksheet.getRow(gtRow1).getCell(c);
            const c2 = worksheet.getRow(gtRow2).getCell(c);
            const isHidden = worksheet.getColumn(c).hidden;

            if (c <= 210) {
              c1.value = { formula: `SUM(${colLetter}12:${colLetter}${finalLastDataRow})` };
            } else {
              c1.value = null;
            }
            c1.numFmt = '_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)';
            c1.font = { name: 'Arial', size: 9, bold: true };
            c1.alignment = { horizontal: 'right', vertical: 'middle' };

            c2.value = null;
            c2.numFmt = '_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)';

            if (!isHidden) {
              c1.border = {
                top: { style: 'medium', color: { argb: 'FF000000' } },
                bottom: { style: 'thin', color: { argb: 'FF000000' } },
                left: { style: 'medium', color: { argb: 'FF000000' } },
                right: { style: 'medium', color: { argb: 'FF000000' } }
              };

              c2.border = {
                top: { style: 'thin', color: { argb: 'FF000000' } },
                bottom: { style: 'medium', color: { argb: 'FF000000' } },
                left: { style: 'medium', color: { argb: 'FF000000' } },
                right: { style: 'medium', color: { argb: 'FF000000' } }
              };
            }
          }

          const maxRows = Math.max(worksheet.rowCount, gtRow2 + 10);
          for (let r = gtRow2 + 1; r <= maxRows; r++) {
            worksheet.getRow(r).hidden = true;
          }

          worksheet.getColumn(1).hidden = true;
          for (let c = 2; c <= 6; c++) {
            worksheet.getColumn(c).hidden = false;
          }

          worksheet.views = [
            {
              state: 'normal',
              showGridLines: true,
              activeCell: 'B8',
              topLeftCell: 'B8'
            }
          ];

          const buffer = await workbook.xlsx.writeBuffer({
            useStyles: true,
            useSharedStrings: true
          });

          const blob = new Blob([buffer], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
          });

          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          const timeStr = new Date().toISOString().replace(/[:.]/g, '-').substring(0, 19);
          const fileName = `ROUTE_MATRIX_${timeStr}.xlsx`;

          a.href = url;
          a.download = fileName;
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);

          console.log('✅ Export to Excel success:', fileName);

        } catch (error) {
          console.error('Error exporting to Excel:', error);
          showToast('error', 'Gagal Export Excel', error.message);
        } finally {
          isExportingExcel = false;
          if (btnExcel) {
            btnExcel.innerHTML = defaultExcelBtnHtml;
            btnExcel.style.pointerEvents = 'auto';
          }
        }
      }

      // Direct Export to PDF (Crisp Vector Landscape Table with AutoTable)
      async function exportToPdfDirect(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();

        // Cegah klik ganda / eksekusi paralel yang menyebabkan file terdownload 2 kali
        if (isExportingPdf) {
          console.warn('⚠️ Export to PDF sedang berjalan, mengabaikan klik ganda.');
          return;
        }

        const allDataRows = Array.from(previewTableBody.querySelectorAll('tr[data-index], tr'))
          .filter(r => r.style.display !== 'none' && !r.closest('tfoot'));

        if (allDataRows.length === 0) {
          showNoDataWarning('pdf');
          return;
        }

        isExportingPdf = true;
        console.log('⚡ exportToPdfDirect called');

        const btnPdf = document.getElementById('btnDownloadPdf');
        const defaultPdfBtnHtml = '<i class="bi bi-file-earmark-pdf-fill me-2"></i><span>Download PDF</span>';
        if (btnPdf) {
          btnPdf.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengunduh PDF...';
          btnPdf.style.pointerEvents = 'none';
        }

        try {
          saveAllActiveEdits();

          const activeDesignators = (currentActiveDesignators && currentActiveDesignators.length > 0)
            ? currentActiveDesignators
            : getActiveDesignatorsFromTable();

          const jspdfModule = window.jspdf || {};
          const jsPDFClass = jspdfModule.jsPDF || window.jsPDF;
          if (!jsPDFClass) {
            throw new Error('Library jsPDF belum selesai dimuat.');
          }

          const isA3 = activeDesignators.length > 8;
          const doc = new jsPDFClass({
            orientation: 'landscape',
            unit: 'pt',
            format: isA3 ? 'a3' : 'a4'
          });

          // Header 2 Baris
          const headRow1 = [
            { content: 'NO', rowSpan: 2, styles: { halign: 'center', valign: 'middle' } },
            { content: 'PLACEMARK', rowSpan: 2, styles: { halign: 'center', valign: 'middle' } },
            { content: 'SPAN', colSpan: 2, styles: { halign: 'center', valign: 'middle' } },
            { content: 'LENGTH', rowSpan: 2, styles: { halign: 'center', valign: 'middle' } },
            { content: 'DESIGNATOR', rowSpan: 2, styles: { halign: 'center', valign: 'middle' } }
          ];

          activeDesignators.forEach(des => {
            headRow1.push({
              content: des,
              rowSpan: 2,
              styles: { halign: 'center', valign: 'middle', fontStyle: 'bold' }
            });
          });

          const headRow2 = [
            { content: 'FCR', styles: { halign: 'center', valign: 'middle' } },
            { content: 'ODP', styles: { halign: 'center', valign: 'middle' } }
          ];

          // Data rows
          const bodyData = [];
          allDataRows.forEach((row, idx) => {
            const noCell = row.querySelector('td[data-col="no"]');
            const nameCell = row.querySelector('td[data-field="name"], td[data-field="cablePlacemark"]');
            const spanFcrCell = row.querySelector('td[data-field="spanFcr"], td[data-field="cableSpanFcr"]');
            const spanOdpCell = row.querySelector('td[data-field="spanOdp"], td[data-field="cableSpanOdp"]');
            const lengthCell = row.querySelector('td[data-field="length"], td[data-field="cableLength"]');
            const desCell = row.querySelector('td[data-field="description"], td[data-field="cableName"]');

            const no = noCell ? noCell.textContent.trim() : String(idx + 1);
            const name = nameCell ? nameCell.textContent.trim() : '';
            const spanFcr = spanFcrCell ? spanFcrCell.textContent.trim() : '';
            const spanOdp = spanOdpCell ? spanOdpCell.textContent.trim() : '';
            const length = lengthCell ? lengthCell.textContent.trim() : '';
            const des = desCell ? desCell.textContent.trim() : '';

            const rowData = [no, name, spanFcr, spanOdp, length, des];

            activeDesignators.forEach(desName => {
              const dynCell = row.querySelector(`td.dynamic-designator-cell[data-dynamic-col="${desName}"]`);
              const val = dynCell ? dynCell.textContent.trim() : '-';
              rowData.push(val);
            });

            bodyData.push(rowData);
          });

          // Baris Footer (GRAND TOTAL)
          const footRow = [
            { content: '', styles: { halign: 'center' } },
            { content: 'GRAND TOTAL', styles: { halign: 'center', fontStyle: 'bold' } },
            { content: '-', styles: { halign: 'center' } },
            { content: '-', styles: { halign: 'center' } },
            { content: '-', styles: { halign: 'center' } },
            { content: '-', styles: { halign: 'center' } }
          ];

          const tfoot = document.getElementById('previewTableFoot');
          activeDesignators.forEach(desName => {
            const totalCell = tfoot ? tfoot.querySelector(`.grand-total-dynamic[data-designator-total="${desName}"]`) : null;
            const totalVal = totalCell ? totalCell.textContent.trim() : '-';
            footRow.push({
              content: totalVal,
              styles: { halign: 'center', fontStyle: 'bold' }
            });
          });

          // Judul Dokumen
          doc.setFontSize(14);
          doc.setTextColor(30, 41, 59);
          doc.text('TELKOM NETWORK ROUTE MATRIX', 40, 30);
          
          doc.setFontSize(9);
          doc.setTextColor(100, 116, 139);
          const timestamp = new Date().toLocaleString('id-ID');
          doc.text(`Waktu Export: ${timestamp}  |  Total Rute: ${allDataRows.length} baris  |  Kolom Aktif: ${activeDesignators.length} designator`, 40, 45);

          const autoTableOptions = {
            head: [headRow1, headRow2],
            body: bodyData,
            foot: [footRow],
            startY: 55,
            theme: 'grid',
            styles: {
              fontSize: activeDesignators.length > 10 ? 6.5 : 8,
              cellPadding: 3,
              valign: 'middle',
              lineColor: [203, 213, 225],
              lineWidth: 0.5
            },
            headStyles: {
              fillColor: [30, 41, 59],
              textColor: [255, 255, 255],
              fontStyle: 'bold',
              fontSize: activeDesignators.length > 10 ? 7 : 8.5
            },
            footStyles: {
              fillColor: [241, 245, 249],
              textColor: [15, 23, 42],
              fontStyle: 'bold',
              fontSize: activeDesignators.length > 10 ? 7 : 8.5
            },
            alternateRowStyles: {
              fillColor: [248, 250, 252]
            },
            columnStyles: {
              0: { halign: 'center', cellWidth: 28 },
              1: { halign: 'left' },
              2: { halign: 'center', cellWidth: 35 },
              3: { halign: 'center', cellWidth: 35 },
              4: { halign: 'center', cellWidth: 40 },
              5: { halign: 'left' }
            },
            margin: { top: 55, bottom: 30, left: 30, right: 30 },
            didDrawPage: function(data) {
              const pageCount = doc.internal.getNumberOfPages();
              doc.setFontSize(8);
              doc.setTextColor(148, 163, 184);
              const pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();
              const pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
              doc.text(`Halaman ${data.pageNumber} dari ${pageCount}`, pageWidth - 100, pageHeight - 15);
            }
          };

          if (typeof doc.autoTable === 'function') {
            doc.autoTable(autoTableOptions);
          } else if (typeof jspdfModule.autoTable === 'function') {
            jspdfModule.autoTable(doc, autoTableOptions);
          } else {
            throw new Error('Plugin jsPDF AutoTable belum selesai dimuat.');
          }

          const timeStr = new Date().toISOString().replace(/[:.]/g, '-').substring(0, 19);
          const pdfFileName = `ROUTE_MATRIX_${timeStr}.pdf`;
          doc.save(pdfFileName);

          console.log('✅ Export to PDF success:', pdfFileName);

        } catch (error) {
          console.error('Error exporting to PDF:', error);
          showToast('error', 'Gagal Export PDF', error.message);
        } finally {
          isExportingPdf = false;
          if (btnPdf) {
            btnPdf.innerHTML = defaultPdfBtnHtml;
            btnPdf.style.pointerEvents = 'auto';
          }
        }
      }

      // Expose to window scope agar dapat diakses dari inline onclick attribute
      window.exportToExcelDirect = exportToExcelDirect;
      window.exportToPdfDirect = exportToPdfDirect;
      window.showNoDataWarning = showNoDataWarning;
      window.checkExportButton = checkExportButton;
      window.enableExcelUpload = enableExcelUpload;
      window.disableExcelUpload = disableExcelUpload;

      // ========== END EXCEL & PDF DIRECT EXPORT HANDLING ==========

      // ========== FITUR UNDO MURNI TABEL PREVIEW ==========

      // Simpan snapshot HTML baris tabel ke dalam undoStack
      function saveState() {
        if (!previewTableBody) return;
        const currentHtml = previewTableBody.innerHTML;
        if (!currentHtml || currentHtml.trim() === '') return;

        // Cegah duplikasi snapshot yang identik
        if (undoStack.length > 0 && undoStack[undoStack.length - 1] === currentHtml) {
          return;
        }

        undoStack.push(currentHtml);
        if (undoStack.length > maxUndoSize) {
          undoStack.shift();
        }
        updateUndoButton();
      }

      // Update status disabled/enabled tombol undo di topbar
      function updateUndoButton() {
        const undoBtn = document.getElementById('undoBtn');
        if (undoBtn) {
          undoBtn.disabled = (undoStack.length === 0);
        }
      }

      // Kembalikan kondisi tabel ke snapshot sebelum perubahan terakhir
      function undo() {
        if (undoStack.length === 0) {
          showToast('info', 'Tidak Ada Perubahan', 'Tidak ada perubahan yang dapat di-undo.');
          return;
        }

        // Ambil snapshot sebelumnya
        const previousHtml = undoStack.pop();
        previewTableBody.innerHTML = previousHtml;

        // Bersihkan centang yang mungkin tersimpan pada snapshot
        previewTableBody.querySelectorAll('.row-checkbox').forEach(cb => {
          cb.checked = false;
        });
        previewTableBody.querySelectorAll('tr.row-selected').forEach(r => {
          r.classList.remove('row-selected');
        });
        updateMasterCheckboxState();

        // Hubungkan kembali event listener ke sel-sel yang baru direstore
        bindEditableCellEvents(previewTableBody);

        // Rekalkulasi nomor baris, kolom dinamis, dan total
        reindexTableRows();
        syncDynamicDesignatorColumns(true);
        calculateSpanFcrAndOdp();
        updateUndoButton();

        showToast('info', 'Undo Berhasil', 'Perubahan terakhir telah dibatalkan.');
      }

      // Helper listener untuk semua cell contenteditable (mendukung restore via innerHTML)
      function bindEditableCellEvents(container = previewTableBody) {
        if (!container) return;
        const editableCells = container.querySelectorAll('[contenteditable="true"]');
        editableCells.forEach(cell => {
          if (cell._hasEditBindings) return;
          cell._hasEditBindings = true;

          // Saat sel difokuskan, rekam kondisi tabel sebelum diedit
          cell.addEventListener('focus', function() {
            tableHtmlBeforeCellEdit = previewTableBody.innerHTML;
            this.dataset.initialValue = this.textContent.trim();
            const field = this.dataset.field;
            if (field === 'description' || field === 'cableName') {
              showDesignatorDropdown(this);
            }
          });

          // Saat teks sel berubah (input)
          cell.addEventListener('input', function() {
            const field = this.dataset.field;
            if (field === 'description' || field === 'cableName') {
              recalculateAllDesignatorFormulas();
            } else if (field === 'length' || field === 'cableLength') {
              const row = this.closest('tr');
              if (row) recalculateRowDesignatorFormulas(row);
              calculateSpanFcrAndOdp();
            }
          });

          // Saat selesai mengedit (blur)
          cell.addEventListener('blur', function() {
            const field = this.dataset.field;
            const newValue = this.textContent.trim();
            const oldValue = this.dataset.initialValue !== undefined ? this.dataset.initialValue : '';

            if (newValue !== oldValue) {
              if (tableHtmlBeforeCellEdit) {
                undoStack.push(tableHtmlBeforeCellEdit);
                if (undoStack.length > maxUndoSize) undoStack.shift();
                updateUndoButton();
                tableHtmlBeforeCellEdit = null;
              }

              // Tandai manual override jika field adalah span FCR atau ODP agar tidak ditimpa rumus otomatis
              if (field === 'spanFcr' || field === 'spanOdp' || field === 'cableSpanFcr' || field === 'cableSpanOdp') {
                this.dataset.userEdited = 'true';
              }

              // Update data cable maps jika field terkait kabel
              const index = parseInt(this.dataset.index);
              if (!isNaN(index) && field.startsWith('cable')) {
                if (field === 'cableName') customCableNames.set(index, newValue);
                else if (field === 'cablePlacemark') customCablePlacemark.set(index, newValue);
                else if (field === 'cableSpanFcr') customCableSpanFcr.set(index, newValue);
                else if (field === 'cableSpanOdp') customCableSpanOdp.set(index, newValue);
                else if (field === 'cableLength') customCableLength.set(index, newValue);
              }

              syncDynamicDesignatorColumns();
              calculateSpanFcrAndOdp();
            }
          });

          cell.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
              e.preventDefault();
              this.blur();
            }
          });
        });
      }

      // Click button to select file — tampilkan modal pilih sumber KML dulu
      selectFileBtn.addEventListener('click', function() {
        const kmlModal = new bootstrap.Modal(document.getElementById('kmlSourceModal'));
        kmlModal.show();
      });

      // Handler opsi: Dari Direktori PC
      window.triggerKmlFromPc = function() {
        const modalEl = document.getElementById('kmlSourceModal');
        if (modalEl) {
          try {
            const instance = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
            if (instance) instance.hide();
          } catch(e) {}
          modalEl.classList.remove('show');
          modalEl.style.display = 'none';
          modalEl.setAttribute('aria-hidden', 'true');
        }
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';

        const fi = document.getElementById('fileInput');
        if (fi) {
          fi.value = '';
          fi.click();
        }
      };

      const kmlFromPcOpt = document.getElementById('kmlFromPcOption');
      if (kmlFromPcOpt) {
        kmlFromPcOpt.addEventListener('click', window.triggerKmlFromPc);
      }

      // Tombol Buat Plan New — buka modal form plan
      document.getElementById('btnBuatPlanNew').addEventListener('click', function() {
        // Reset semua field form setiap kali dibuka
        document.getElementById('planNamaProyek').value = '';
        document.getElementById('planTanggal').value = '';
        document.getElementById('planArea').value = '';
        document.getElementById('planKeterangan').value = '';
        // Tampilkan modal
        const planModal = new bootstrap.Modal(document.getElementById('planNewModal'));
        planModal.show();
      });

    </script>

    <!-- ===== PETA INTERAKTIF: PLAN NEW (LEAFLET, PLACEMARK, KABEL, EXPORT KML) ===== -->
    <script src="{{ asset('js/pemetaan-map.js') }}?v={{ time() }}"></script>

    <script>

      // File input change
      fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
          displayFileInfo(e.target.files[0]);
        }
      });

      // Clear file button
      clearFileBtn.addEventListener('click', function() {
        clearFile();
      });

      // Display file information
      function displayFileInfo(file) {
        // Validasi ekstensi SEBELUM berpindah view
        if (!file.name.endsWith('.kml')) {
          showToast('error', 'Format File Tidak Valid', 'Hanya file berformat .kml yang diperbolehkan!');
          fileInput.value = '';
          return; // Tetap di view saat ini, jangan pindah ke preview/matrix
        }

        // File valid — baru pindah ke tampilan matrix/preview
        window.switchWorkspaceView('matrix');

        fileInfo.innerHTML = `
          <span style="color: #FFFFFF;">${file.name}</span>
        `;
        
        const dropzoneDefaultState = document.getElementById('dropzoneDefaultState');
        const fileInfoWrapper = document.getElementById('fileInfoWrapper');
        if (dropzoneDefaultState && fileInfoWrapper) {
          dropzoneDefaultState.style.display = 'none';
          fileInfoWrapper.style.display = 'block';
        }

        clearFileBtn.disabled = false;

        // Parse KML file
        parseKMLFile(file);
      }
      window.displayFileInfo = displayFileInfo;
      window.clearFile = clearFile;

      // Clear file
      function clearFile() {
        fileInput.value = '';
        fileInfo.innerHTML = '<span>Belum ada file yang dipilih</span>';
        clearFileBtn.disabled = true;

        const dropzoneDefaultState = document.getElementById('dropzoneDefaultState');
        const fileInfoWrapper = document.getElementById('fileInfoWrapper');
        if (dropzoneDefaultState && fileInfoWrapper) {
          dropzoneDefaultState.style.display = 'block';
          fileInfoWrapper.style.display = 'none';
        }

        // Tetap tampilkan area dropdown dengan tombol disabled
        if (dropdownsSection) dropdownsSection.style.display = 'block';
        if (startPointBtn) startPointBtn.disabled = true;
        if (endPointBtn) endPointBtn.disabled = true;
        if (cableRouteBtn) cableRouteBtn.disabled = true;
        if (processBtn) processBtn.disabled = true;
        placemarks = [];
        selectedStartPoint = null;
        selectedEndPoint = null;
        selectedCableRoute = null;
        
        // Reset cable checkbox to default (enabled)
        if (useCableCheckbox) useCableCheckbox.checked = true;
        useCableRoute = true;
        resetScanRange(); // Reset jangkauan scan ke otomatis
        cableRoutes = [];
        if (startPointText) startPointText.textContent = 'Pilih Titik Awal';
        if (endPointText) endPointText.textContent = 'Pilih Titik Akhir';
        if (cableRouteText) cableRouteText.textContent = 'Pilih Jalur Kabel';
        if (startPointList) startPointList.innerHTML = '';
        if (endPointList) endPointList.innerHTML = '';
        if (cableRouteList) cableRouteList.innerHTML = '';
        if (notificationContent) notificationContent.innerHTML = '';
        document.getElementById('notificationWrapper').style.display = 'none';
        // Sembunyikan Excel card dan reset layout kolom
        hideExcelSection();
        previewSection.style.display = 'none';
        updatePreviewTableHeaders([]);
        currentActiveDesignators = [];
        const tfoot = document.getElementById('previewTableFoot');
        if (tfoot) tfoot.style.display = 'none';
        previewTableBody.innerHTML = '';
        kmlData = [];
        kmlDataNonDonut = [];
        allRoutePlacemarks = [];
        deletedCables.clear();
        deletedDesignators.clear();
        deletedPlacemarks.clear();
        resolvedDesignatorCache.clear();
        customCableNames.clear();
        customCablePlacemark.clear();
        customCableSpanFcr.clear();
        customCableSpanOdp.clear();
        customCableLength.clear();
        undoStack = [];
        tableHtmlBeforeCellEdit = null;
        updateUndoButton();
        
        // Disable Excel upload section (no preview data)
        disableExcelUpload();
      }

      // Parse KML File
      function parseKMLFile(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const parser = new DOMParser();
          const xmlDoc = parser.parseFromString(e.target.result, 'text/xml');
          
          // STEP 1: Parse Style definitions untuk mengetahui icon type DAN balloon text
          const styleMap = new Map(); // styleId -> iconType (donut, square, circle, etc)
          balloonStyleMapping.clear(); // Reset balloon style mapping
          
          // Parse semua Style
          const styles = xmlDoc.getElementsByTagName('Style');
          for (let style of styles) {
            const styleId = style.getAttribute('id');
            if (styleId) {
              // Parse Icon untuk icon type
              const iconNode = style.getElementsByTagName('Icon')[0];
              if (iconNode) {
                const hrefNode = iconNode.getElementsByTagName('href')[0];
                if (hrefNode) {
                  const href = hrefNode.textContent.trim();
                  let iconType = 'unknown';
                  
                  if (href.includes('donut.png')) {
                    iconType = 'donut';
                  } else if (href.includes('square.png')) {
                    iconType = 'square';
                  } else if (href.includes('placemark_circle') || href.includes('ylw-circle') || href.includes('circle.png')) {
                    iconType = 'circle';
                  } else if (href.includes('dollar.png')) {
                    iconType = 'dollar';
                  }
                  
                  styleMap.set(styleId, iconType);
                  styleMap.set('#' + styleId, iconType); // dengan hash
                }
              }
              
              // Parse BalloonStyle untuk balloon text
              const balloonStyleNode = style.getElementsByTagName('BalloonStyle')[0];
              if (balloonStyleNode) {
                const textNode = balloonStyleNode.getElementsByTagName('text')[0];
                if (textNode) {
                  const balloonText = textNode.textContent.trim();
                  if (balloonText) {
                    console.log(`  📋 BalloonStyle for styleId="${styleId}": "${balloonText.substring(0, 100)}${balloonText.length > 100 ? '...' : ''}"`);
                    balloonStyleMapping.set('#' + styleId, balloonText);
                    balloonStyleMapping.set(styleId, balloonText);
                  }
                }
              }
            }
          }
          
          // Parse gx:CascadingStyle (Google Earth Pro format)
          // Use multiple methods to find CascadingStyle elements (browser compatibility)
          let cascadingStyles = xmlDoc.querySelectorAll('CascadingStyle, gx\\:CascadingStyle');
          // Fallback: getElementsByTagNameNS for stricter namespace-aware lookup
          if (cascadingStyles.length === 0) {
            cascadingStyles = xmlDoc.getElementsByTagNameNS('http://www.google.com/kml/ext/2.2', 'CascadingStyle');
          }
          // Fallback: getElementsByTagName with qualified name
          if (cascadingStyles.length === 0) {
            cascadingStyles = xmlDoc.getElementsByTagName('gx:CascadingStyle');
          }
          console.log('🔍 Found', cascadingStyles.length, 'CascadingStyle elements');
          for (let cascadingStyle of cascadingStyles) {
            // Try multiple ways to get the ID attribute (kml:id, id, etc)
            let styleId = cascadingStyle.getAttribute('id') || 
                         cascadingStyle.getAttribute('kml:id') ||
                         cascadingStyle.getAttributeNS('http://www.opengis.net/kml/2.2', 'id');
            
            // Fallback: iterate attributes to find any with localName 'id'
            if (!styleId && cascadingStyle.attributes) {
              for (let attr of cascadingStyle.attributes) {
                if (attr.localName === 'id' || attr.name === 'kml:id') {
                  styleId = attr.value;
                  break;
                }
              }
            }
            
            console.log('  CascadingStyle styleId:', styleId);
            
            if (styleId) {
              // Parse nested Style
              const nestedStyles = cascadingStyle.getElementsByTagName('Style');
              if (nestedStyles.length > 0) {
                const nestedStyle = nestedStyles[0];
                
                // Parse Icon untuk icon type
                const iconNode = nestedStyle.getElementsByTagName('Icon')[0];
                if (iconNode) {
                  const hrefNode = iconNode.getElementsByTagName('href')[0];
                  if (hrefNode) {
                    const href = hrefNode.textContent.trim();
                    let iconType = 'unknown';
                    
                    if (href.includes('donut.png')) {
                      iconType = 'donut';
                    } else if (href.includes('square.png')) {
                      iconType = 'square';
                    } else if (href.includes('placemark_circle') || href.includes('ylw-circle') || href.includes('circle.png')) {
                      iconType = 'circle';
                    } else if (href.includes('dollar.png')) {
                      iconType = 'dollar';
                    }
                    
                    styleMap.set('#' + styleId, iconType);
                    styleMap.set(styleId, iconType);
                  }
                }
                
                // Parse BalloonStyle untuk balloon text
                const balloonStyleNode = nestedStyle.getElementsByTagName('BalloonStyle')[0];
                if (balloonStyleNode) {
                  const textNode = balloonStyleNode.getElementsByTagName('text')[0];
                  if (textNode) {
                    const balloonText = textNode.textContent.trim();
                    if (balloonText) {
                      console.log(`  📋 CascadingStyle BalloonStyle for styleId="${styleId}": "${balloonText.substring(0, 100)}${balloonText.length > 100 ? '...' : ''}"`);
                      balloonStyleMapping.set('#' + styleId, balloonText);
                      balloonStyleMapping.set(styleId, balloonText);
                    }
                  }
                }
              }
            }
          }
          
          // Parse StyleMap (mapping dari styleUrl ke actual style)
          styleMapMap.clear(); // Reset style map mapping
          const styleMaps = xmlDoc.getElementsByTagName('StyleMap');
          for (let styleMapNode of styleMaps) {
            const styleMapId = styleMapNode.getAttribute('id');
            if (styleMapId) {
              const pairs = styleMapNode.getElementsByTagName('Pair');
              for (let pair of pairs) {
                const keyNode = pair.getElementsByTagName('key')[0];
                if (keyNode && keyNode.textContent === 'normal') {
                  const styleUrlNode = pair.getElementsByTagName('styleUrl')[0];
                  if (styleUrlNode) {
                    const actualStyleId = styleUrlNode.textContent.trim();
                    styleMapMap.set('#' + styleMapId, actualStyleId);
                    break;
                  }
                }
              }
            }
          }
          
          console.log('=== STYLE PARSING COMPLETE ===');
          console.log('Parsed styles:', styleMap.size);
          console.log('Parsed style maps:', styleMapMap.size);
          console.log('Parsed balloon styles:', balloonStyleMapping.size);
          if (balloonStyleMapping.size > 0) {
            console.log('Balloon styles found:', Array.from(balloonStyleMapping.entries()));
          }
          
          // ============================================================
          // REGEX FALLBACK: Parse CascadingStyle + StyleMap dari raw XML
          // Handles semua kasus dimana DOM namespace resolution gagal
          // ============================================================
          const rawXml = e.target.result;
          
          // Fallback 1: Parse gx:CascadingStyle kml:id + BalloonStyle text + Icon type
          const cascRegex = /<gx:CascadingStyle[^>]*?kml:id="([^"]+)"[^>]*?>[\s\S]*?<\/gx:CascadingStyle>/gi;
          let cascMatch;
          while ((cascMatch = cascRegex.exec(rawXml)) !== null) {
            const csId = cascMatch[1];
            const csBlock = cascMatch[0];
            
            // Parse BalloonStyle text
            const balloonMatch = csBlock.match(/<BalloonStyle>\s*<text>([\s\S]*?)<\/text>\s*<\/BalloonStyle>/i);
            if (balloonMatch) {
              const bText = balloonMatch[1].trim();
              if (bText && !balloonStyleMapping.has('#' + csId)) {
                console.log(`  📋 [REGEX] CascadingStyle BalloonStyle for "${csId}": "${bText.substring(0, 100)}"`);
                balloonStyleMapping.set('#' + csId, bText);
                balloonStyleMapping.set(csId, bText);
              }
            }
            
            // Parse Icon type
            const iconMatch = csBlock.match(/<Icon>\s*<href>([^<]+)<\/href>/i);
            if (iconMatch && !styleMap.has('#' + csId)) {
              const href = iconMatch[1].trim();
              let iconType = 'unknown';
              if (href.includes('donut.png')) iconType = 'donut';
              else if (href.includes('square.png')) iconType = 'square';
              else if (href.includes('placemark_circle') || href.includes('circle.png')) iconType = 'circle';
              else if (href.includes('dollar.png')) iconType = 'dollar';
              else if (href.includes('triangle.png')) iconType = 'triangle';
              else if (href.includes('picnic.png')) iconType = 'picnic';
              styleMap.set('#' + csId, iconType);
              styleMap.set(csId, iconType);
            }
          }
          
          // Fallback 2: Parse StyleMap id + normal pair styleUrl
          const smRegex = /<StyleMap\s+id="([^"]+)">([\s\S]*?)<\/StyleMap>/gi;
          let smMatch;
          while ((smMatch = smRegex.exec(rawXml)) !== null) {
            const smId = smMatch[1];
            const smBlock = smMatch[2];
            const normalMatch = smBlock.match(/<Pair>\s*<key>normal<\/key>\s*<styleUrl>([^<]+)<\/styleUrl>\s*<\/Pair>/i);
            if (normalMatch && !styleMapMap.has('#' + smId)) {
              styleMapMap.set('#' + smId, normalMatch[1].trim());
            }
          }
          
          console.log('=== AFTER REGEX FALLBACK ===');
          console.log('Total styles:', styleMap.size);
          console.log('Total style maps:', styleMapMap.size);
          console.log('Total balloon styles:', balloonStyleMapping.size);
          if (balloonStyleMapping.size > 0) {
            console.log('All balloon styles:', Array.from(balloonStyleMapping.entries()));
          }
          
          // Extract visible placemarks
          placemarks = [];
          const placemarksNodes = xmlDoc.getElementsByTagName('Placemark');
          const seenPlacemarks = new Map(); // Track unique placemarks by name+coordinates
          
          for (let i = 0; i < placemarksNodes.length; i++) {
            const placemark = placemarksNodes[i];
            
            // Check visibility
            const visibilityNode = placemark.getElementsByTagName('visibility')[0];
            const isVisible = !visibilityNode || visibilityNode.textContent !== '0';
            
            if (isVisible) {
              const nameNode = placemark.getElementsByTagName('name')[0];
              const name = nameNode ? nameNode.textContent.trim() : `Placemark ${i + 1}`;
              
              // Get coordinates
              let coordinates = '';
              const coordsNode = placemark.getElementsByTagName('coordinates')[0];
              if (coordsNode) {
                coordinates = coordsNode.textContent.trim();
              }
              
              // Create unique key: name + first coordinate point
              const firstCoord = coordinates.split(/[\s,]+/).slice(0, 2).join(',');
              const uniqueKey = `${name}|${firstCoord}`;
              
              // Only add if not seen before (same name and same coordinates)
              if (!seenPlacemarks.has(uniqueKey)) {
                seenPlacemarks.set(uniqueKey, true);
                
                // Check if there's another placemark with same name but different coords
                const sameNameCount = Array.from(seenPlacemarks.keys()).filter(key => 
                  key.startsWith(name + '|')
                ).length;
                
                const displayName = sameNameCount > 1 ? `${name} (${sameNameCount})` : name;
                
                placemarks.push({
                  index: i,
                  name: displayName,
                  originalName: name,
                  coordinates: coordinates
                });
              }
            }
          }

          // Store all placemarks with coordinates (untuk routing)
          allPlacemarksData = [];
          cableLines = [];
          
          for (let i = 0; i < placemarksNodes.length; i++) {
            const placemark = placemarksNodes[i];
            const visibilityNode = placemark.getElementsByTagName('visibility')[0];
            const isVisible = !visibilityNode || visibilityNode.textContent !== '0';
            
            if (isVisible) {
              const nameNode = placemark.getElementsByTagName('name')[0];
              const name = nameNode ? nameNode.textContent.trim() : `Placemark ${i + 1}`;
              
              const descNode = placemark.getElementsByTagName('description')[0];
              let description = descNode ? descNode.textContent.trim() : '-';
              
              const styleUrlNode = placemark.getElementsByTagName('styleUrl')[0];
              const styleUrl = styleUrlNode ? styleUrlNode.textContent.trim() : '';
              
              // Parse <ExtendedData> untuk mendapatkan nilai nyata field KML
              // Digunakan untuk resolve $[schema/field] template variables di BalloonStyle
              const extendedDataMap = new Map();
              const extendedDataNode = placemark.getElementsByTagName('ExtendedData')[0];
              if (extendedDataNode) {
                // Parse <SchemaData><SimpleData name="...">value</SimpleData></SchemaData>
                const schemaDataNodes = extendedDataNode.getElementsByTagName('SchemaData');
                for (let schemaData of schemaDataNodes) {
                  const simpleDataNodes = schemaData.getElementsByTagName('SimpleData');
                  for (let simpleData of simpleDataNodes) {
                    const fieldName = simpleData.getAttribute('name');
                    const fieldValue = simpleData.textContent.trim();
                    if (fieldName) extendedDataMap.set(fieldName, fieldValue);
                  }
                }
                // Parse <Data name="..."><value>...</value></Data>
                const dataNodes = extendedDataNode.getElementsByTagName('Data');
                for (let dataNode of dataNodes) {
                  const fieldName = dataNode.getAttribute('name');
                  const valueNode = dataNode.getElementsByTagName('value')[0];
                  if (fieldName && valueNode) extendedDataMap.set(fieldName, valueNode.textContent.trim());
                }
              }
              
              // Resolve $[...] variables pada description jika ada (dari <description> langsung)
              if (description && description !== '-' && description.includes('$[')) {
                description = resolveBalloonVariables(description, extendedDataMap);
                if (!description) description = '-';
              }
              
              // Tentukan icon type berdasarkan styleUrl DULU (sebelum balloon text processing)
              let iconType = 'unknown';
              
              // Cek di styleMapMap dulu (jika styleUrl adalah StyleMap)
              let actualStyleId = styleUrl;
              if (styleMapMap.has(styleUrl)) {
                actualStyleId = styleMapMap.get(styleUrl);
              }
              
              // Deteksi icon type
              if (styleMap.has(actualStyleId)) {
                iconType = styleMap.get(actualStyleId);
              }
              
              // Gabungkan description dengan balloon text dari style (jika ada)
              // Cek balloon text dari styleUrl original ATAU dari actualStyleId
              let balloonText = balloonStyleMapping.get(styleUrl) || balloonStyleMapping.get(actualStyleId) || '';
              if (balloonText) {
                // SKIP balloon text yang mengandung $[...] template variables
                // Template seperti "$[Site ID/Site_ID]" adalah format display Google Earth Pro
                // untuk menampilkan koordinat/metadata — bukan designator telekomunikasi.
                // Hanya gunakan balloon text yang merupakan string statis (designators)
                if (balloonText.includes('$[')) {
                  console.log(`  ⏭️ Skipping template balloon for "${name}" (contains \$[...] placeholders)`);
                } else {
                  // Balloon text statis (SEMUA placemark diproses, tidak peduli icon type)
                  // Database matching dilakukan oleh findAllDesignatorsInDescription()
                  // Strip HTML jika ada (PRESERVE NEWLINES!)
                  const cleanBalloon = stripHtmlTags(balloonText);
                  // Trim hanya whitespace di awal dan akhir, tapi preserve newline internal
                  const trimmedBalloon = cleanBalloon.replace(/^\s+|\s+$/g, '');
                  if (trimmedBalloon) {
                    // Jika description kosong/dash, gunakan balloon text langsung
                    // Jika description ada, gabungkan dengan newline separator (bukan spasi!)
                    const combinedText = (description === '-' || !description) 
                      ? trimmedBalloon 
                      : `${description}\n${trimmedBalloon}`;
                    console.log(`  🎈 Static balloon text for "${name}": "${trimmedBalloon}" → Combined: "${combinedText}"`);
                    description = combinedText;
                  }
                }
              } else {
                // Debug: Log when no balloon text found
                console.log(`  ℹ️ No balloon text for "${name}": styleUrl=${styleUrl}, actualStyle=${actualStyleId}`);
              }
              
              console.log(`Placemark "${name}": styleUrl=${styleUrl}, actualStyle=${actualStyleId}, iconType=${iconType}`);
              
              // Check untuk Point (titik seperti tiang, ODC, ODP)
              const pointNode = placemark.getElementsByTagName('Point')[0];
              if (pointNode) {
                const coordsNode = pointNode.getElementsByTagName('coordinates')[0];
                if (coordsNode) {
                  const coord = coordsNode.textContent.trim();
                  const parts = coord.split(',');
                  if (parts.length >= 2) {
                    allPlacemarksData.push({
                      name: name,
                      longitude: parseFloat(parts[0]),
                      latitude: parseFloat(parts[1]),
                      description: description,
                      styleUrl: styleUrl,
                      iconType: iconType, // Tambahkan icon type
                      type: 'point'
                    });
                  }
                }
              }
              
              // Check untuk LineString (jalur kabel)
              const lineStringNode = placemark.getElementsByTagName('LineString')[0];
              if (lineStringNode) {
                const coordsNode = lineStringNode.getElementsByTagName('coordinates')[0];
                if (coordsNode) {
                  const coordsText = coordsNode.textContent.trim();
                  const coordsArray = coordsText.split(/[\s\n]+/).map(coord => {
                    const parts = coord.split(',');
                    if (parts.length >= 2) {
                      return {
                        lng: parseFloat(parts[0]),
                        lat: parseFloat(parts[1])
                      };
                    }
                    return null;
                  }).filter(c => c !== null);
                  
                  if (coordsArray.length > 0) {
                    cableLines.push({
                      name: name,
                      coordinates: coordsArray,
                      description: description
                    });
                  }
                }
              }
            }
          }

          // JIKA KML TIDAK MEMILIKI LineString EKSPLISIT (misal berkas lama / export data hanya titik):
          // Bentuk kabel sintesis otomatis dari urutan koordinat placemark yang ada!
          if (cableLines.length === 0 && allPlacemarksData.length >= 2) {
            const validCoords = allPlacemarksData
              .filter(p => p.latitude && p.longitude && (Math.abs(parseFloat(p.latitude)) > 0.0001 || Math.abs(parseFloat(p.longitude)) > 0.0001))
              .map(p => ({ lat: parseFloat(p.latitude), lng: parseFloat(p.longitude) }));

            if (validCoords.length >= 2) {
              // Cek apakah ada designator kabel dari deskripsi/nama placemark
              let defaultCableType = 'AC-OF-SM-48D';
              for (let p of allPlacemarksData) {
                const desc = (p.description || '') + ' ' + (p.name || '');
                if (/(?:AC|DC)-[A-Z0-9\-]+/i.test(desc)) {
                  const m = desc.match(/(?:AC|DC)-[A-Z0-9\-]+/i);
                  if (m) { defaultCableType = m[0].toUpperCase(); break; }
                } else if (/Kabel-FO-[A-Z0-9]+/i.test(desc)) {
                  const m = desc.match(/Kabel-FO-[A-Z0-9]+/i);
                  if (m) { defaultCableType = m[0].toUpperCase(); break; }
                }
              }
              cableLines.push({
                name: 'Jalur Kabel Distribusi',
                coordinates: validCoords,
                description: `${defaultCableType} 150m`
              });
            }
          }

          // Populate dropdowns
          populateDropdowns();
          populateCableRoutes();
          
          // Tampilkan area dropdown (tersembunyi saat tidak ada file)
          if (dropdownsSection) dropdownsSection.style.display = 'block';

          // Enable dropdowns
          if (startPointBtn) startPointBtn.disabled = false;
          if (endPointBtn) endPointBtn.disabled = false;
          
          // Enable cable route dropdown jika ada jalur kabel
          if (cableLines && cableLines.length > 0) {
            useCableRoute = true;
            if (useCableCheckbox) useCableCheckbox.checked = true;
            if (cableRouteBtn) {
              cableRouteBtn.disabled = false;
              cableRouteBtn.classList.remove('btn-secondary');
              cableRouteBtn.classList.add('btn-outline-secondary');
            }
          } else {
            if (useCableCheckbox) useCableCheckbox.checked = false;
            useCableRoute = false;
            if (cableRouteBtn) cableRouteBtn.disabled = true;
          }

          // Auto-select DINONAKTIFKAN untuk semua alur input KML.
          // User wajib memilih Titik Awal, Titik Akhir, dan Jalur Kabel secara manual.
          // (Sebelumnya hanya Alur 2 & 3 yang skip via flag _kmlFromDbNoAutoSelect,
          //  sekarang Alur 1 (upload PC) juga tidak auto-select agar perilaku konsisten.)

          // Auto-select jalur kabel DINONAKTIFKAN untuk semua alur.
          // User wajib memilih Jalur Kabel secara manual.

          // Reset flag setelah digunakan
          window._kmlFromDbNoAutoSelect = false;

          if (typeof checkProcessButton === 'function') {
            checkProcessButton();
          }
        };
        reader.readAsText(file);
      }

      // HELPER: Cari kabel dengan jarak scan tertentu (digunakan oleh progressive & manual)
      function findCableWithRange(pm1, pm2, cables, scanRange) {
        let bestCable = null;
        let minTotalDistance = Infinity;

        for (let cable of cables) {
          if (selectedCableRoute) {
            const description = cable.description || cable.name || '';
            if (!description.toUpperCase().includes(selectedCableRoute.toUpperCase())) continue;
          }

          let minDist1 = Infinity;
          let minDist2 = Infinity;

          for (let point of cable.coordinates) {
            const dist1 = calculateDistance(pm1.latitude, pm1.longitude, point.lat, point.lng);
            const dist2 = calculateDistance(pm2.latitude, pm2.longitude, point.lat, point.lng);
            if (dist1 < minDist1) minDist1 = dist1;
            if (dist2 < minDist2) minDist2 = dist2;
          }

          if (minDist1 < scanRange && minDist2 < scanRange) {
            const totalDist = minDist1 + minDist2;
            if (totalDist < minTotalDistance) {
              minTotalDistance = totalDist;
              bestCable = cable;
            }
          }
        }
        return bestCable;
      }

      // PROGRESSIVE SEARCH: Mulai dari jarak kecil, perlahan diperluas sampai kabel ditemukan
      function findCableProgressive(pm1, pm2, cables) {
        const distanceBetween = getDistanceInMeters(pm1.latitude, pm1.longitude, pm2.latitude, pm2.longitude);

        // Batas aman: 60% dari jarak antar placemark, minimal 30m, maksimal 300m
        const safetyMax = Math.min(Math.max(distanceBetween * 0.6, 30), 300);

        // Langkah pencarian bertahap (meter)
        const steps = [10, 20, 35, 55, 80, 120, Math.round(safetyMax)];

        for (let radius of steps) {
          const found = findCableWithRange(pm1, pm2, cables, radius);
          if (found) {
            console.log(`🔍 [Auto] Kabel ditemukan pada jangkauan ${radius}m (jarak antar titik: ${distanceBetween.toFixed(1)}m)`);
            return found;
          }
        }

        console.warn(`⚠️ [Auto] Kabel tidak ditemukan hingga jangkauan ${Math.round(safetyMax)}m (jarak: ${distanceBetween.toFixed(1)}m)`);
        return null;
      }

      // MAIN: Dispatcher — pakai jangkauan manual jika user set, atau otomatis (progressive)
      function findCableBetweenPlacemarks(pm1, pm2, cables) {
        if (!useCableRoute) return null;

        if (userMaxScanRange !== null) {
          // Mode manual: jangkauan ditentukan user
          const result = findCableWithRange(pm1, pm2, cables, userMaxScanRange);
          if (result) {
            console.log(`🎯 [Manual ${userMaxScanRange}m] Kabel ditemukan: ${result.name || result.description?.split('\n')[0]}`);
          } else {
            console.warn(`⚠️ [Manual ${userMaxScanRange}m] Kabel tidak ditemukan`);
          }
          return result;
        }

        // Mode otomatis: progressive expanding search
        return findCableProgressive(pm1, pm2, cables);
      }

      // ========== LAYOUT HELPER FUNCTIONS ==========
      function showExcelSection() {
        const card = document.getElementById('excelTemplateCard');
        if (card) card.style.display = 'block';
      }

      function hideExcelSection() {
        const card = document.getElementById('excelTemplateCard');
        if (card) card.style.display = 'none';
      }

      // MutationObserver: auto-show/hide notificationWrapper saat content berubah
      document.addEventListener('DOMContentLoaded', function() {
        const notifDiv     = document.getElementById('notificationContent');
        const notifWrapper = document.getElementById('notificationWrapper');
        if (notifDiv && notifWrapper) {
          new MutationObserver(function() {
            notifWrapper.style.display = notifDiv.innerHTML.trim() ? 'block' : 'none';
          }).observe(notifDiv, { childList: true, subtree: true, characterData: true });
        }
      });
      // ========== END LAYOUT HELPER FUNCTIONS ==========

      // Display preview table
      async function displayPreview() {
        if (allRoutePlacemarks.length === 0) {
          previewSection.style.display = 'none';
          hideExcelSection();
          return;
        }
        // Tampilkan Excel card dan switch ke 2-kolom
        showExcelSection();

        previewTableBody.innerHTML = '';
        let currentRowNo = 1;
        
        // Render berdasarkan urutan routing (dari titik awal ke titik akhir)
        for (let i = 0; i < allRoutePlacemarks.length; i++) {
          const item = allRoutePlacemarks[i];
          
          console.log(`\n📌 Processing placemark ${i}:`, {
            name: item.name,
            type: item.type,
            description: item.description?.substring(0, 150),
            styleUrl: item.styleUrl,
            deleted: deletedPlacemarks.has(i)
          });
          
          // FALLBACK: Jika description masih '-' tapi placemark punya styleUrl,
          // coba resolve balloon text dari balloonStyleMapping secara langsung.
          // Ini menangani kasus dimana balloon text gagal di-combine saat parsing KML.
          if ((!item.description || item.description === '-') && item.styleUrl) {
            let resolvedStyleId = item.styleUrl;
            if (styleMapMap.has(item.styleUrl)) {
              resolvedStyleId = styleMapMap.get(item.styleUrl);
            }
            const fallbackBalloon = balloonStyleMapping.get(item.styleUrl) || balloonStyleMapping.get(resolvedStyleId) || '';
            if (fallbackBalloon && !fallbackBalloon.includes('$[')) {
              const cleanBalloon = stripHtmlTags(fallbackBalloon);
              const trimmedBalloon = cleanBalloon.replace(/^\s+|\s+$/g, '');
              if (trimmedBalloon) {
                item.description = trimmedBalloon;
                console.log(`  🔄 FALLBACK balloon text resolved for "${item.name}": "${trimmedBalloon}"`);
              }
            }
          }
          
          // Render placemark rows (skip if deleted)
          if (!deletedPlacemarks.has(i)) {
            let leftColumnText = '';
            let matchedDesignators = [];
            
            if (item.type === 'nonDonut') {
              // Cari semua designator di database yang cocok dengan description DAN name (async auto-insert)
              matchedDesignators = await findAllDesignatorsInDescription(item.description, item.name);
              
              // Tentukan apakah nama placemark harus ditampilkan di kolom kiri
              const nameLower = item.name ? item.name.toLowerCase() : '';
              
              // Cek apakah nama sama dengan salah satu designator yang ditemukan
              const nameMatchesDesignator = matchedDesignators.some(d => d.toLowerCase() === nameLower);
              
              if (nameMatchesDesignator) {
                // Nama sama dengan designator yang ditemukan - kolom kiri KOSONG
                // Contoh: name="TE", matchedDesignators=['TE'] → kolom kiri kosong
                leftColumnText = '';
              } else {
                // Nama berbeda dengan designator - tampilkan nama di kolom kiri
                // Contoh: name="ODP-GTL-FCB/072", matchedDesignators=['AC-OF-SM-12-SC']
                leftColumnText = item.name;
              }
              
              // Jika tidak ada designator yang match dari database,
              // tampilkan description yang sudah di-clean (strip HTML)
              if (matchedDesignators.length === 0) {
                let cleanDesc = stripHtmlTags(item.description || '');
                cleanDesc = cleanDesc.trim();
                
                // Jika description kosong atau hanya "-", gunakan name sebagai fallback
                if (cleanDesc && cleanDesc !== '-') {
                  // MULTI-LINE SUPPORT: Split by newline untuk handle BalloonStyle multi-line
                  const lines = cleanDesc.split(/\r?\n/).map(line => line.trim()).filter(line => line && line !== '-');
                  
                  if (lines.length > 1) {
                    // Multi-line description - treat each line sebagai designator terpisah
                    const validDesignators = [];
                    lines.forEach(line => {
                      // Validasi setiap baris apakah mengikuti pattern designator
                      const isRecognizedPattern = 
                        // Specific patterns
                        /^AC-OF-SM-[A-Z0-9\-]+$/i.test(line) ||                      // Cable
                        /^ODP-[A-Z0-9\/\-]+$/i.test(line) ||                        // ODP
                        /^ODC-[A-Z0-9\/\-]+$/i.test(line) ||                        // ODC
                        /^(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+$/i.test(line) || // Infrastructure
                        /^(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+$/i.test(line) || // Equipment
                        // Generic patterns
                        /^[A-Z]{2,6}(-[A-Z0-9]+){1,4}$/i.test(line) ||               // Kode terstruktur
                        (line.length <= 30 && /^[A-Z0-9][A-Z0-9\-\/]+$/i.test(line)); // Kode singkat
                      
                      if (isRecognizedPattern) {
                        validDesignators.push(line);
                      }
                    });
                    
                    matchedDesignators = validDesignators.length > 0 ? validDesignators : [''];
                  } else {
                    // Single-line description - existing logic
                    const isRecognizedPattern = 
                      // Specific patterns
                      /^AC-OF-SM-[A-Z0-9\-]+$/i.test(cleanDesc) ||                      // Cable
                      /^ODP-[A-Z0-9\/\-]+$/i.test(cleanDesc) ||                        // ODP
                      /^ODC-[A-Z0-9\/\-]+$/i.test(cleanDesc) ||                        // ODC
                      /^(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+$/i.test(cleanDesc) || // Infrastructure
                      /^(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+$/i.test(cleanDesc) || // Equipment
                      // Generic patterns
                      /^[A-Z]{2,6}(-[A-Z0-9]+){1,4}$/i.test(cleanDesc) ||               // Kode terstruktur
                      (cleanDesc.length <= 30 && /^[A-Z0-9][A-Z0-9\-\/]+$/i.test(cleanDesc)); // Kode singkat
                    
                    if (isRecognizedPattern) {
                      matchedDesignators = [cleanDesc];
                    } else {
                      // Teks bebas / metadata → abaikan, kolom kanan dikosongkan
                      matchedDesignators = [''];
                    }
                  }
                } else if (item.name && item.name !== '-') {
                  // Jika leftColumnText sudah berisi nama (nameMatchesDesignator=false),
                  // nama TETAP di kolom kiri — kolom kanan dikosongkan
                  // Jika leftColumnText kosong (nameMatchesDesignator=true),
                  // nama dipindahkan ke kolom kanan sebagai designator
                  if (leftColumnText === '' || leftColumnText === undefined) {
                    matchedDesignators = [item.name];
                    // leftColumnText sudah '' — nama pindah ke kolom kanan
                  } else {
                    matchedDesignators = ['']; // Nama sudah di kiri, kanan kosong
                  }
                } else {
                  matchedDesignators = [''];
                }
              }
            } else if (item.type === 'donut') {
              // Donut: KOLOM KIRI SELALU KOSONG
              leftColumnText = '';
              
              // Cari semua designator di database yang cocok dengan description DAN name (async auto-insert)
              matchedDesignators = await findAllDesignatorsInDescription(item.description, item.name);
              
              // Jika tidak ada designator yang match dari database, 
              // tampilkan description yang sudah di-clean (strip HTML) atau name sebagai fallback
              if (matchedDesignators.length === 0) {
                let cleanDesc = stripHtmlTags(item.description || '');
                cleanDesc = cleanDesc.trim();
                
                if (cleanDesc && cleanDesc !== '-') {
                  // MULTI-LINE SUPPORT: Split by newline untuk handle BalloonStyle multi-line
                  const lines = cleanDesc.split(/\r?\n/).map(line => line.trim()).filter(line => line && line !== '-');
                  
                  if (lines.length > 1) {
                    // Multi-line description - treat each line sebagai designator terpisah
                    const validDesignators = [];
                    lines.forEach(line => {
                      // Validasi setiap baris apakah mengikuti pattern designator
                      const isRecognizedPattern = 
                        // Specific patterns
                        /^AC-OF-SM-[A-Z0-9\-]+$/i.test(line) ||                      // Cable
                        /^ODP-[A-Z0-9\/\-]+$/i.test(line) ||                        // ODP
                        /^ODC-[A-Z0-9\/\-]+$/i.test(line) ||                        // ODC
                        /^(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+$/i.test(line) || // Infrastructure
                        /^(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+$/i.test(line) || // Equipment
                        // Generic patterns
                        /^[A-Z]{2,6}(-[A-Z0-9]+){1,4}$/i.test(line) ||               // Kode terstruktur
                        (line.length <= 30 && /^[A-Z0-9][A-Z0-9\-\/]+$/i.test(line)); // Kode singkat
                      
                      if (isRecognizedPattern) {
                        validDesignators.push(line);
                      }
                    });
                    
                    matchedDesignators = validDesignators.length > 0 ? validDesignators : [item.name];
                  } else {
                    // Single-line description - existing logic
                    const isRecognizedPattern = 
                      // Specific patterns
                      /^AC-OF-SM-[A-Z0-9\-]+$/i.test(cleanDesc) ||                      // Cable
                      /^ODP-[A-Z0-9\/\-]+$/i.test(cleanDesc) ||                        // ODP
                      /^ODC-[A-Z0-9\/\-]+$/i.test(cleanDesc) ||                        // ODC
                      /^(POLE|TOWER|TIANG|HELICAL)-[A-Z0-9\-\/]+$/i.test(cleanDesc) || // Infrastructure
                      /^(TE|TC|TS|OS|DD|TM|BRACKET|CLAMP)-[A-Z0-9\-\/]+$/i.test(cleanDesc) || // Equipment
                      // Generic patterns
                      /^[A-Z]{2,6}(-[A-Z0-9]+){1,4}$/i.test(cleanDesc) ||               // Kode terstruktur
                      (cleanDesc.length <= 30 && /^[A-Z0-9][A-Z0-9\-\/]+$/i.test(cleanDesc)); // Kode singkat
                    
                    if (isRecognizedPattern) {
                      matchedDesignators = [cleanDesc];
                    } else {
                      matchedDesignators = [item.name]; // Fallback ke nama placemark
                    }
                  }
                } else {
                  matchedDesignators = [item.name];
                }
              }
            }

            // Endpoint safeguard: always merge recognized multiline designators from description
            // with DB matches so endpoint does not lose valid lines when DB already matched partially.
            const isEndPointRow = i === allRoutePlacemarks.length - 1;
            if (isEndPointRow) {
              const endpointLines = extractRecognizedDesignatorLines(item.description || '');

              if (endpointLines.length > 0) {
                const mergedDesignators = [...matchedDesignators, ...endpointLines]
                  .map(d => (d || '').trim())
                  .filter(Boolean);

                const dedupMap = new Map();
                mergedDesignators.forEach(des => {
                  const key = des.toLowerCase();
                  if (!dedupMap.has(key)) {
                    dedupMap.set(key, des);
                  }
                });

                matchedDesignators = Array.from(dedupMap.values());
                console.log(`📌 Endpoint merged designators (${matchedDesignators.length}):`, matchedDesignators);
              }
            }
            
            // Simpan ke cache — export akan membaca dari sini agar hasilnya identik dengan preview
            resolvedDesignatorCache.set(i, {
              leftColumn: leftColumnText,
              designators: [...matchedDesignators]
            });

            // Buat baris untuk setiap designator yang ditemukan
            let visibleDesignatorIndex = 0; // Track visible designators for UI purposes
            matchedDesignators.forEach((designator, designatorIndex) => {
              // Check if this designator has been deleted
              const designatorId = `${i}-${designator.toLowerCase()}`;
              if (deletedDesignators.has(designatorId)) {
                return; // Skip rendering this designator
              }
              
              const row = document.createElement('tr');
              row.dataset.index = i;
              row.dataset.itemType = 'placemark';
              row.dataset.designator = designator.toLowerCase();
              
              // Uppercase designator jika ada di database
              const displayDesignator = databaseDesignators.includes(designator.toLowerCase()) 
                ? designator.toUpperCase() 
                : designator;
              
              const spanFcrVal = (item.spanFcr && item.spanFcr !== '0' && item.spanFcr !== '-') ? item.spanFcr : '';
              const spanOdpVal = (item.spanOdp && item.spanOdp !== '0' && item.spanOdp !== '-') ? item.spanOdp : '';
              const lengthVal = item.length || '';

              // Baris pertama menampilkan leftColumnText di kolom kiri
              if (visibleDesignatorIndex === 0) {
                row.innerHTML = `
                  <td class="col-checkbox">
                    <input type="checkbox" class="form-check-input row-checkbox" onchange="toggleRowCheckbox(this)">
                  </td>
                  <td style="text-align: center;" data-col="no">${currentRowNo}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="name">${leftColumnText}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="spanFcr">${spanFcrVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="spanOdp">${spanOdpVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="length">${lengthVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="description" data-designator-index="${designatorIndex}">${displayDesignator}</td>
                `;
              } else {
                row.innerHTML = `
                  <td class="col-checkbox">
                    <input type="checkbox" class="form-check-input row-checkbox" onchange="toggleRowCheckbox(this)">
                  </td>
                  <td style="text-align: center;" data-col="no">${currentRowNo}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="name"></td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="spanFcr">${spanFcrVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="spanOdp">${spanOdpVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="length">${lengthVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="description" data-designator-index="${designatorIndex}">${displayDesignator}</td>
                `;
              }
              
              visibleDesignatorIndex++;
              currentRowNo++;
              
              previewTableBody.appendChild(row);
            });
          }
          
          // Render cable row independently - kabel tetap ditampilkan meskipun salah satu placemark dihapus
          // SKIP CABLE RENDERING if useCableRoute is disabled
          if (useCableRoute && i < allRoutePlacemarks.length - 1) {
            const nextItem = allRoutePlacemarks[i + 1];
            
            // Skip cable rendering if current or next item is empty (manually added row)
            const isCurrentEmpty = !item.name && !item.description;
            const isNextEmpty = !nextItem.name && !nextItem.description;
            
            // Check if this cable has been deleted
            const cableId = `${i}-${i + 1}`;
            if (!deletedCables.has(cableId) && !isCurrentEmpty && !isNextEmpty) {
              // Konversi koordinat dari string ke float untuk item saat ini
              const currentPm = {
                latitude: parseFloat(item.latitude),
                longitude: parseFloat(item.longitude)
              };
              
              const nextPm = {
                latitude: parseFloat(nextItem.latitude),
                longitude: parseFloat(nextItem.longitude)
              };
              
              // Cari kabel yang menghubungkan placemark ini dengan placemark berikutnya
              const connectingCable = findCableBetweenPlacemarks(currentPm, nextPm, cableLines);
              
              if (connectingCable) {
                const cableRow = document.createElement('tr');
                cableRow.dataset.index = i;
                cableRow.dataset.itemType = 'cable';
                const cableDesc = connectingCable.description || connectingCable.name;
                // Ambil hanya nama kabel (baris pertama)
                let cableNameOnly = cableDesc.split('\n')[0].trim();
                
                // Check if there's a custom cable name for this index
                if (customCableNames.has(i)) {
                  cableNameOnly = customCableNames.get(i);
                }
                
                const cablePlacemarkVal = customCablePlacemark.get(i) || '';
                const cableSpanFcrVal = (customCableSpanFcr.get(i) && customCableSpanFcr.get(i) !== '0' && customCableSpanFcr.get(i) !== '-') ? customCableSpanFcr.get(i) : '';
                const cableSpanOdpVal = (customCableSpanOdp.get(i) && customCableSpanOdp.get(i) !== '0' && customCableSpanOdp.get(i) !== '-') ? customCableSpanOdp.get(i) : '';
                const cableLengthVal = customCableLength.get(i) || '';
                
                cableRow.innerHTML = `
                  <td class="col-checkbox">
                    <input type="checkbox" class="form-check-input row-checkbox" onchange="toggleRowCheckbox(this)">
                  </td>
                  <td style="text-align: center;" data-col="no">${currentRowNo}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="cablePlacemark">${cablePlacemarkVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="cableSpanFcr">${cableSpanFcrVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="cableSpanOdp">${cableSpanOdpVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="cableLength">${cableLengthVal}</td>
                  <td style="text-align: center; cursor: text; padding: 6px 8px;" 
                      contenteditable="true" data-index="${i}" data-field="cableName">${cableNameOnly}</td>
                `;
                currentRowNo++;
                previewTableBody.appendChild(cableRow);
              } else {
                // FALLBACK: Jika kabel tidak ditemukan, tampilkan warning row
                const warningRow = document.createElement('tr');
                warningRow.dataset.index = i;
                warningRow.dataset.itemType = 'missing-cable';
                warningRow.style.backgroundColor = 'rgba(255, 193, 7, 0.15)';
                
                warningRow.innerHTML = `
                  <td class="col-checkbox">
                    <input type="checkbox" class="form-check-input row-checkbox" onchange="toggleRowCheckbox(this)">
                  </td>
                  <td style="text-align: center;" data-col="no">${currentRowNo}</td>
                  <td colspan="5" style="text-align: center; padding: 8px; color: #856404; font-weight: 600; font-style: italic;">
                    ⚠️ MISSING CABLE (check threshold or route filter)
                  </td>
                `;
                currentRowNo++;
                previewTableBody.appendChild(warningRow);
              }
            }
          }
        }

        previewSection.style.display = 'block';
        
        // Bersihkan notifikasi setelah preview berhasil tampil
        notificationContent.innerHTML = '';
        const notifWrapper = document.getElementById('notificationWrapper');
        if (notifWrapper) notifWrapper.style.display = 'none';
        
        // Enable Excel upload section (preview data is now available)
        enableExcelUpload();
        
        // Hubungkan event listeners ke semua cell yang dapat diedit
        bindEditableCellEvents(previewTableBody);

        // Reset undo stack untuk sesi preview baru
        undoStack = [];
        tableHtmlBeforeCellEdit = null;
        updateUndoButton();

        // Sinkronisasi kolom dinamis designator sesuai data baris preview
        syncDynamicDesignatorColumns(true);
        calculateSpanFcrAndOdp();
        
        // Check if export button should be enabled (if Excel template is uploaded)
        checkExportButton();

        // Update class edit mode pada previewTable jika sedang aktif
        const previewTableEl = document.getElementById('previewTable');
        if (previewTableEl) {
          previewTableEl.classList.toggle('is-edit-mode', isEditMode);
        }
        updateMasterCheckboxState();
        hideRowInsertIndicator();
      }

      // Helper: Re-number the NO column
      function reindexTableRows() {
        const allRows = previewTableBody.querySelectorAll('tr');
        let counter = 1;
        allRows.forEach(row => {
          const noCell = row.querySelector('td[data-col="no"]');
          if (noCell) {
            noCell.textContent = counter++;
          }
        });
      }

      // ========== EDIT MODE & BATCH ACTIONS (SEMUA, UBAH, HAPUS - ROW INDEPENDENT) ==========
      
      // Update status visual per baris saat checkbox dicentang/dibatalkan
      function toggleRowCheckbox(checkbox) {
        const row = checkbox.closest('tr');
        if (row) {
          row.classList.toggle('row-selected', checkbox.checked);
        }
        updateMasterCheckboxState();
      }

      // Toggle pilih semua baris dari master checkbox di thead
      function toggleSelectAllFromMaster(masterCheckbox) {
        const isChecked = masterCheckbox.checked;
        const allCbs = previewTableBody.querySelectorAll('.row-checkbox');
        allCbs.forEach(cb => {
          cb.checked = isChecked;
          const r = cb.closest('tr');
          if (r) r.classList.toggle('row-selected', isChecked);
        });
      }

      // Sinkronkan status master checkbox (thead) berdasarkan baris-baris
      function updateMasterCheckboxState() {
        const checkboxes = Array.from(previewTableBody.querySelectorAll('.row-checkbox'));
        const masterCb = document.getElementById('masterRowCheckbox');
        if (!masterCb || checkboxes.length === 0) return;

        const checkedCount = checkboxes.filter(cb => cb.checked).length;
        masterCb.checked = checkedCount > 0 && checkedCount === checkboxes.length;
        masterCb.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
      }

      // Toggle edit mode switch (menampilkan/menyembunyikan kolom centang)
      function toggleEditMode() {
        saveAllActiveEdits();
        
        isEditMode = !isEditMode;
        
        const selectModeBtn = document.getElementById('selectModeBtn');
        const editModeButtons = document.getElementById('editModeButtons');
        const previewTableEl = document.getElementById('previewTable');
        const masterCb = document.getElementById('masterRowCheckbox');
        
        if (isEditMode) {
          if (selectModeBtn) selectModeBtn.classList.add('active');
          if (editModeButtons) editModeButtons.style.setProperty('display', 'flex', 'important');
          if (previewTableEl) previewTableEl.classList.add('is-edit-mode');
        } else {
          if (selectModeBtn) selectModeBtn.classList.remove('active');
          if (editModeButtons) editModeButtons.style.setProperty('display', 'none', 'important');
          if (previewTableEl) previewTableEl.classList.remove('is-edit-mode');
          hideEditDropdown();
          hideRowInsertIndicator();

          // Reset centang saat keluar dari mode edit
          const allCbs = previewTableBody.querySelectorAll('.row-checkbox');
          allCbs.forEach(cb => {
            cb.checked = false;
            const r = cb.closest('tr');
            if (r) r.classList.remove('row-selected');
          });
          if (masterCb) {
            masterCb.checked = false;
            masterCb.indeterminate = false;
          }
        }
      }

      // ========== FITUR TAMBAH BARIS DINAMIS (ROW INSERT INDICATOR) ==========
      let currentInsertTarget = null; // { targetRow, position: 'before' | 'after' }
      let isMouseOverIndicator = false;

      function hideRowInsertIndicator() {
        const indicator = document.getElementById('rowInsertIndicator');
        if (indicator) {
          indicator.style.display = 'none';
        }
        currentInsertTarget = null;
      }

      function insertNewTableRow() {
        if (!currentInsertTarget || !currentInsertTarget.targetRow) return;

        // 1. Simpan kondisi tabel saat ini ke Undo Stack
        saveState();

        const targetRow = currentInsertTarget.targetRow;
        const position = currentInsertTarget.position;
        const targetIndex = (targetRow && targetRow.dataset.index !== undefined) ? parseInt(targetRow.dataset.index) : 0;

        // 2. Buat elemen baris <tr> baru
        const newRow = document.createElement('tr');
        newRow.dataset.index = targetIndex;
        newRow.dataset.itemType = 'placemark';
        newRow.dataset.designator = '';

        newRow.innerHTML = `
          <td class="col-checkbox">
            <input type="checkbox" class="form-check-input row-checkbox" onchange="toggleRowCheckbox(this)">
          </td>
          <td style="text-align: center;" data-col="no"></td>
          <td style="text-align: center; cursor: text; padding: 6px 8px;" 
              contenteditable="true" data-index="${targetIndex}" data-field="name"></td>
          <td style="text-align: center; cursor: text; padding: 6px 8px;" 
              contenteditable="true" data-index="${targetIndex}" data-field="spanFcr"></td>
          <td style="text-align: center; cursor: text; padding: 6px 8px;" 
              contenteditable="true" data-index="${targetIndex}" data-field="spanOdp"></td>
          <td style="text-align: center; cursor: text; padding: 6px 8px;" 
              contenteditable="true" data-index="${targetIndex}" data-field="length"></td>
          <td style="text-align: center; cursor: text; padding: 6px 8px;" 
              contenteditable="true" data-index="${targetIndex}" data-field="description"></td>
        `;

        // 3. Sisipkan elemen ke dalam tbody
        if (position === 'before') {
          targetRow.parentNode.insertBefore(newRow, targetRow);
        } else {
          targetRow.parentNode.insertBefore(newRow, targetRow.nextSibling);
        }

        // 4. Sembunyikan indikator
        hideRowInsertIndicator();

        // 5. Hubungkan event listeners ke cell-cell baru
        bindEditableCellEvents(newRow);

        // 6. Sinkronisasi nomor baris, kolom dinamis designator & kalkulasi
        reindexTableRows();
        syncDynamicDesignatorColumns(true);
        calculateSpanFcrAndOdp();
        updateMasterCheckboxState();

        // 7. Auto-focus ke kolom PLACEMARK pada baris baru
        const nameCell = newRow.querySelector('td[data-field="name"]');
        if (nameCell) {
          nameCell.focus();
        }

        showToast('success', 'Baris Ditambahkan', 'Baris baru berhasil disisipkan.');
      }

      function setupRowInsertHover() {
        const scrollContainer = document.querySelector('.matrix-scroll-container');
        const previewTable = document.getElementById('previewTable');
        const indicator = document.getElementById('rowInsertIndicator');
        const insertBtn = document.getElementById('btnInsertRow');
        if (!scrollContainer || !previewTable || !indicator) return;

        indicator.addEventListener('mouseenter', () => {
          isMouseOverIndicator = true;
        });

        indicator.addEventListener('mouseleave', () => {
          isMouseOverIndicator = false;
        });

        if (insertBtn) {
          insertBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            insertNewTableRow();
          });
        }

        indicator.addEventListener('click', (e) => {
          e.stopPropagation();
          insertNewTableRow();
        });

        // Hover deteksi di sepanjang previewTable
        scrollContainer.addEventListener('mousemove', (e) => {
          if (!isEditMode) {
            hideRowInsertIndicator();
            return;
          }

          if (isMouseOverIndicator) {
            return;
          }

          const rows = Array.from(previewTableBody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
          if (rows.length === 0) {
            hideRowInsertIndicator();
            return;
          }

          const mouseY = e.clientY;
          const containerRect = scrollContainer.getBoundingClientRect();
          const tableRect = previewTable.getBoundingClientRect();

          // Mouse harus berada dalam area horizontal tabel
          if (e.clientX < tableRect.left - 20 || e.clientX > tableRect.right + 20) {
            hideRowInsertIndicator();
            return;
          }

          // Dapatkan batas sticky thead dan sticky tfoot (Grand Total)
          const thead = previewTable.querySelector('thead');
          const tfoot = document.getElementById('previewTableFoot');
          const theadBottom = thead ? thead.getBoundingClientRect().bottom : containerRect.top;
          const tfootTop = (tfoot && tfoot.style.display !== 'none') ? tfoot.getBoundingClientRect().top : containerRect.bottom;

          // Jangan pernah tampilkan indikator jika mouse berada di atas sticky thead atau sticky tfoot!
          if (mouseY <= theadBottom + 4 || mouseY >= tfootTop - 4) {
            hideRowInsertIndicator();
            return;
          }

          const threshold = 9;
          let closestBoundary = null;
          let minDistance = Infinity;

          // Periksa semua batas baris yang benar-benar TERLIHAT (di antara theadBottom dan tfootTop)
          for (let i = 0; i < rows.length; i++) {
            const rowRect = rows[i].getBoundingClientRect();

            // 1. Batas atas baris ini (insert before) - hanya jika tampak di viewport
            if (rowRect.top >= theadBottom - 2 && rowRect.top <= tfootTop + 2) {
              const distTop = Math.abs(mouseY - rowRect.top);
              if (distTop < minDistance) {
                minDistance = distTop;
                closestBoundary = {
                  y: rowRect.top,
                  targetRow: rows[i],
                  position: 'before'
                };
              }
            }

            // 2. Batas bawah baris ini (insert after) - hanya jika tampak di viewport
            if (rowRect.bottom >= theadBottom - 2 && rowRect.bottom <= tfootTop + 2) {
              const distBot = Math.abs(mouseY - rowRect.bottom);
              if (distBot < minDistance) {
                minDistance = distBot;
                closestBoundary = {
                  y: rowRect.bottom,
                  targetRow: rows[i],
                  position: 'after'
                };
              }
            }
          }

          if (minDistance <= threshold && closestBoundary) {
            currentInsertTarget = closestBoundary;

            const relativeY = closestBoundary.y - containerRect.top + scrollContainer.scrollTop;
            indicator.style.top = `${relativeY}px`;
            indicator.style.width = `${previewTable.scrollWidth || previewTable.offsetWidth}px`;
            indicator.style.display = 'flex';

            const mouseRelativeX = e.clientX - containerRect.left + scrollContainer.scrollLeft;
            const clampedX = Math.max(70, Math.min(mouseRelativeX, (previewTable.scrollWidth || previewTable.offsetWidth) - 70));
            if (insertBtn) {
              insertBtn.style.left = `${clampedX}px`;
            }
          } else {
            hideRowInsertIndicator();
          }
        });

        scrollContainer.addEventListener('mouseleave', () => {
          if (!isMouseOverIndicator) {
            hideRowInsertIndicator();
          }
        });

        scrollContainer.addEventListener('scroll', () => {
          hideRowInsertIndicator();
        }, { passive: true });
      }

      // Buka panel popup pilih designator pengganti
      function showEditDropdown() {
        const selectedCbs = Array.from(previewTableBody.querySelectorAll('.row-checkbox:checked'));
        if (selectedCbs.length === 0) {
          showToast('warning', 'Tidak Ada Baris Dipilih', 'Centang minimal satu baris pada tabel terlebih dahulu!');
          return;
        }
        
        selectedDesignatorValue = null;
        const applyBtn = document.getElementById('applyDesignatorBtn');
        if (applyBtn) applyBtn.disabled = true;
        const displayEl = document.getElementById('selectedDesignatorDisplay');
        if (displayEl) displayEl.style.display = 'none';
        const searchInput = document.getElementById('searchDesignator');
        if (searchInput) searchInput.value = '';
        
        populateDesignatorList(databaseDesignators);
        
        const panel = document.getElementById('designatorDropdownSection');
        if (panel) {
          panel.style.display = 'block';
          setTimeout(() => {
            if (searchInput) searchInput.focus();
          }, 100);
        }
      }

      // Render daftar designator di panel
      function populateDesignatorList(designators) {
        const designatorList = document.getElementById('designatorList');
        if (!designatorList) return;
        designatorList.innerHTML = '';
        
        if (!designators || designators.length === 0) {
          designatorList.innerHTML = '<div style="padding: 16px; text-align: center; color: #94A3B8; font-size: 0.85rem;"><i class="bi bi-info-circle me-1"></i>Tidak ada designator yang cocok</div>';
          return;
        }
        
        designators.forEach(des => {
          const item = document.createElement('div');
          const isSelected = selectedDesignatorValue && selectedDesignatorValue.toLowerCase() === des.toLowerCase();
          item.className = `designator-list-item ${isSelected ? 'active' : ''}`;
          item.innerHTML = `<span>${des.toUpperCase()}</span><i class="bi bi-check-circle-fill check-icon"></i>`;
          
          item.addEventListener('click', function(e) {
            e.preventDefault();
            selectDesignator(des);
          });
          
          designatorList.appendChild(item);
        });
      }

      // Pilih salah satu designator dari daftar
      function selectDesignator(designator) {
        selectedDesignatorValue = designator;
        
        const badge = document.getElementById('selectedDesignatorBadge');
        if (badge) badge.textContent = designator.toUpperCase();
        const displayEl = document.getElementById('selectedDesignatorDisplay');
        if (displayEl) displayEl.style.display = 'flex';
        
        const applyBtn = document.getElementById('applyDesignatorBtn');
        if (applyBtn) applyBtn.disabled = false;
        
        const allItems = document.querySelectorAll('#designatorList .designator-list-item');
        allItems.forEach(item => {
          const textSpan = item.querySelector('span');
          const itemText = textSpan ? textSpan.textContent.trim() : item.textContent.trim();
          if (itemText.toLowerCase() === designator.toLowerCase()) {
            item.classList.add('active');
          } else {
            item.classList.remove('active');
          }
        });
      }

      // Tutup panel pilih designator
      function hideEditDropdown() {
        const panel = document.getElementById('designatorDropdownSection');
        if (panel) panel.style.display = 'none';
        selectedDesignatorValue = null;
        const searchInput = document.getElementById('searchDesignator');
        if (searchInput) searchInput.value = '';
        const displayEl = document.getElementById('selectedDesignatorDisplay');
        if (displayEl) displayEl.style.display = 'none';
        const applyBtn = document.getElementById('applyDesignatorBtn');
        if (applyBtn) applyBtn.disabled = true;
      }

      // Terapkan perubahan designator massal pada baris terpilih
      function applyDesignatorChange() {
        const newDesignator = selectedDesignatorValue;
        if (!newDesignator) {
          showToast('warning', 'Designator Belum Dipilih', 'Pilih designator pengganti terlebih dahulu!');
          return;
        }
        
        saveAllActiveEdits();
        saveState();
        const newDesignatorUpper = newDesignator.toUpperCase();
        
        const selectedCbs = Array.from(previewTableBody.querySelectorAll('.row-checkbox:checked'));
        const count = selectedCbs.length;
        
        selectedCbs.forEach(cb => {
          const row = cb.closest('tr');
          if (!row) return;

          const descCell = row.querySelector('td[data-field="description"], td[data-field="cableName"]');
          if (descCell) {
            descCell.textContent = newDesignatorUpper;
          }
          row.dataset.designator = newDesignator.toLowerCase();
          cb.checked = false;
          row.classList.remove('row-selected');
        });
        
        hideEditDropdown();
        updateMasterCheckboxState();
        
        syncDynamicDesignatorColumns();
        calculateSpanFcrAndOdp();
        
        showToast('success', 'Berhasil Diubah', `Designator pada ${count} baris telah diubah menjadi ${newDesignatorUpper}.`);
      }

      // Hapus HANYA baris-baris yang dipilih (murni independen per baris)
      function deleteSelected() {
        const selectedCbs = Array.from(previewTableBody.querySelectorAll('.row-checkbox:checked'));
        if (selectedCbs.length === 0) {
          showToast('warning', 'Tidak Ada Baris Dipilih', 'Centang minimal satu baris pada tabel terlebih dahulu!');
          return;
        }

        const count = selectedCbs.length;
        const msg = count === 1
          ? 'Apakah Anda yakin ingin menghapus <strong>1 baris</strong> yang dipilih?'
          : `Apakah Anda yakin ingin menghapus <strong>${count} baris</strong> yang dipilih?`;

        showDarkConfirm({
          title: 'Hapus Baris?',
          message: msg,
          subtext: 'Baris yang dihapus dapat dipulihkan melalui tombol <strong>Undo</strong>.',
          confirmText: 'Ya, Hapus',
          onConfirm: function() {
            saveAllActiveEdits();
            saveState();

            // Hapus murni hanya elemen baris (<tr>) yang dicentang — tidak ada efek domino ke baris lain
            selectedCbs.forEach(cb => {
              const row = cb.closest('tr');
              if (row) {
                row.remove();
              }
            });

            updateMasterCheckboxState();
            reindexTableRows();
            syncDynamicDesignatorColumns();
            calculateSpanFcrAndOdp();

            showToast('warning', 'Data Dihapus', `${count} baris telah dihapus dari preview.`);
          }
        });
      }

      // Update cell value in data structure (hanya untuk data kabel)
      function updateCellValue(index, field, newValue) {
        if (field.startsWith('cable')) {
          if (field === 'cableName') customCableNames.set(index, newValue);
          else if (field === 'cablePlacemark') customCablePlacemark.set(index, newValue);
          else if (field === 'cableSpanFcr') customCableSpanFcr.set(index, newValue);
          else if (field === 'cableSpanOdp') customCableSpanOdp.set(index, newValue);
          else if (field === 'cableLength') customCableLength.set(index, newValue);
        }
      }

      // Helper function: Force save all active contenteditable cells by blurring
      function saveAllActiveEdits() {
        const focusedElement = document.activeElement;
        if (focusedElement && focusedElement.contentEditable === 'true') {
          focusedElement.blur();
        }
      }

      // Show designator dropdown when editing cell
      let activeDropdown = null;
      let activeCell = null;

      function updateDropdownPosition() {
        if (!activeDropdown || !activeCell) return;
        const rect = activeCell.getBoundingClientRect();
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        activeDropdown.style.left = (rect.left + scrollLeft) + 'px';
        activeDropdown.style.top = (rect.bottom + scrollTop + 2) + 'px';
        activeDropdown.style.width = rect.width + 'px';
        activeDropdown.style.minWidth = rect.width + 'px';
      }

      function getAllDesignatorOptions() {
        const set = new Set();
        if (Array.isArray(databaseDesignators) && databaseDesignators.length > 0) {
          databaseDesignators.forEach(d => {
            if (d) set.add(d.trim().toUpperCase());
          });
        }
        if (typeof DEFAULT_DESIGNATOR_FORMULAS === 'object' && DEFAULT_DESIGNATOR_FORMULAS) {
          Object.keys(DEFAULT_DESIGNATOR_FORMULAS).forEach(k => {
            if (k) set.add(k.trim().toUpperCase());
          });
        }
        return Array.from(set).sort((a, b) => a.localeCompare(b));
      }

      function populateDropdownOptions(dropdown, cell) {
        dropdown.innerHTML = '';
        const currentText = (cell.textContent || '').trim().toUpperCase();
        const allOptions = getAllDesignatorOptions();

        let filtered = allOptions;
        if (currentText) {
          filtered = allOptions.filter(opt => opt.includes(currentText));
        }

        if (filtered.length === 0) {
          const empty = document.createElement('div');
          empty.className = 'designator-autocomplete-empty';
          empty.textContent = 'Tidak ada designator yang cocok';
          dropdown.appendChild(empty);
          return;
        }

        let matchedSelected = null;

        filtered.forEach(des => {
          const item = document.createElement('div');
          item.className = 'designator-autocomplete-item';
          if (des === currentText) {
            item.classList.add('is-selected');
            matchedSelected = item;
          }

          const labelSpan = document.createElement('span');
          labelSpan.textContent = des;
          labelSpan.style.overflow = 'hidden';
          labelSpan.style.textOverflow = 'ellipsis';
          item.appendChild(labelSpan);

          if (des === currentText) {
            const checkIcon = document.createElement('i');
            checkIcon.className = 'bi bi-check2 text-danger ms-2';
            item.appendChild(checkIcon);
          }

          item.title = des;

          // Prevent mousedown from blurring the cell
          item.addEventListener('mousedown', function(e) {
            e.preventDefault();
          });

          item.addEventListener('click', function() {
            cell.textContent = des;

            const index = parseInt(cell.dataset.index);
            const field = cell.dataset.field;
            updateCellValue(index, field, des);

            hideDesignatorDropdown();
            cell.blur();
          });

          dropdown.appendChild(item);
        });

        // If an item matches current text, scroll it into view
        if (matchedSelected) {
          setTimeout(() => {
            if (matchedSelected && matchedSelected.scrollIntoView) {
              matchedSelected.scrollIntoView({ block: 'nearest' });
            }
          }, 30);
        }
      }

      function showDesignatorDropdown(cell) {
        hideDesignatorDropdown();

        activeCell = cell;

        const dropdown = document.createElement('div');
        dropdown.id = 'designatorAutocomplete';

        // Prevent mousedown on dropdown scrollbar from blurring the cell
        dropdown.addEventListener('mousedown', function(e) {
          e.preventDefault();
        });

        activeDropdown = dropdown;
        updateDropdownPosition();

        populateDropdownOptions(dropdown, cell);

        document.body.appendChild(dropdown);

        cell.addEventListener('input', updateDropdownFilter);
        cell.addEventListener('keydown', handleDropdownKeydown);
        document.addEventListener('click', handleOutsideClick);
        window.addEventListener('resize', updateDropdownPosition);
        window.addEventListener('scroll', updateDropdownPosition, true);
      }

      function updateDropdownFilter(e) {
        const cell = e.target;
        if (!activeDropdown) return;
        updateDropdownPosition();
        populateDropdownOptions(activeDropdown, cell);
      }

      function handleDropdownKeydown(e) {
        if (e.key === 'Escape' || e.key === 'Enter') {
          hideDesignatorDropdown();
        }
      }

      function handleOutsideClick(e) {
        if (activeDropdown && !activeDropdown.contains(e.target) && e.target !== activeCell) {
          hideDesignatorDropdown();
        }
      }

      function hideDesignatorDropdown() {
        if (activeDropdown) {
          activeDropdown.remove();
          activeDropdown = null;
        }

        if (activeCell) {
          activeCell.removeEventListener('input', updateDropdownFilter);
          activeCell.removeEventListener('keydown', handleDropdownKeydown);
          activeCell = null;
        }

        document.removeEventListener('click', handleOutsideClick);
        window.removeEventListener('resize', updateDropdownPosition);
        window.removeEventListener('scroll', updateDropdownPosition, true);
      }

      // Populate dropdowns
      function populateDropdowns() {
        populateDropdownList(startPointList, placemarks, 'start');
        populateDropdownList(endPointList, placemarks, 'end');
      }

      // Populate dropdown list (OPTIMIZED)
      function populateDropdownList(container, items, type) {
        container.innerHTML = '';
        
        if (items.length === 0) {
          container.innerHTML = '<li class="dropdown-item text-muted">Tidak ada data</li>';
          return;
        }

        items.forEach(item => {
          container.appendChild(createDropdownItem(item.name, function(e) {
            e.preventDefault();
            if (type === 'start') {
              selectedStartPoint = item;
              startPointText.textContent = item.name;
            } else {
              selectedEndPoint = item;
              endPointText.textContent = item.name;
            }
            checkProcessButton();
          }));
        });
      }

      // Search functionality for start point
      if (searchStartPoint) {
        searchStartPoint.addEventListener('input', function(e) {
          const searchTerm = e.target.value.toLowerCase();
          const filtered = placemarks.filter(p => p.name.toLowerCase().includes(searchTerm));
          populateDropdownList(startPointList, filtered, 'start');
        });
      }

      // Search functionality for end point
      if (searchEndPoint) {
        searchEndPoint.addEventListener('input', function(e) {
          const searchTerm = e.target.value.toLowerCase();
          const filtered = placemarks.filter(p => p.name.toLowerCase().includes(searchTerm));
          populateDropdownList(endPointList, filtered, 'end');
        });
      }

      // Search functionality for cable route (OPTIMIZED)
      if (searchCableRoute && cableRouteList) {
        searchCableRoute.addEventListener('input', function(e) {
          const searchTerm = e.target.value.toLowerCase();
          const cableTypesMap = extractCableTypeInfo(cableLines);
          const cableTypesArray = formatCableTypesForDisplay(cableTypesMap);
          const displayRoutes = cableTypesArray.filter(item => item.display.toLowerCase().includes(searchTerm));
          
          cableRouteList.innerHTML = '';
          
          if (displayRoutes.length === 0) {
            cableRouteList.innerHTML = '<li><span class="dropdown-item text-muted">Tidak ditemukan</span></li>';
            return;
          }
          
          displayRoutes.forEach(item => {
            cableRouteList.appendChild(createDropdownItem(item.display, function(e) {
              e.preventDefault();
              selectedCableRoute = item.type;
              if (cableRouteText) cableRouteText.textContent = item.display;
              checkProcessButton();
            }));
          });
        });
      }

      // Search functionality for batch designator dropdown (edit mode)
      const searchDesignatorInput = document.getElementById('searchDesignator');
      if (searchDesignatorInput) {
        searchDesignatorInput.addEventListener('input', function(e) {
          const searchTerm = e.target.value.toLowerCase();
          const filtered = databaseDesignators.filter(des => des.toLowerCase().includes(searchTerm));
          populateDesignatorList(filtered);
        });
      }

      // Prevent dropdown from closing when clicking on search input (OPTIMIZED)
      [searchStartPoint, searchEndPoint, searchCableRoute].forEach(input => {
        if (input) input.addEventListener('click', (e) => e.stopPropagation());
      });

      // Reset search when dropdown is opened (OPTIMIZED)
      if (startPointBtn) {
        startPointBtn.addEventListener('click', () => {
          if (searchStartPoint) {
            searchStartPoint.value = '';
            populateDropdownList(startPointList, placemarks, 'start');
            setTimeout(() => searchStartPoint.focus(), 100);
          }
        });
      }

      if (endPointBtn) {
        endPointBtn.addEventListener('click', () => {
          if (searchEndPoint) {
            searchEndPoint.value = '';
            populateDropdownList(endPointList, placemarks, 'end');
            setTimeout(() => searchEndPoint.focus(), 100);
          }
        });
      }

      if (cableRouteBtn) {
        cableRouteBtn.addEventListener('click', () => {
          if (searchCableRoute) {
            searchCableRoute.value = '';
            populateCableRoutes();
            setTimeout(() => searchCableRoute.focus(), 100);
          }
        });
      }

      // Populate cable routes dropdown (OPTIMIZED)
      function populateCableRoutes() {
        const cableTypesMap = extractCableTypeInfo(cableLines);
        const displayRoutes = formatCableTypesForDisplay(cableTypesMap);
        
        cableRoutes = displayRoutes.map(c => c.type);
        cableRouteList.innerHTML = '';
        
        if (displayRoutes.length === 0) {
          cableRouteList.innerHTML = '<li><span class="dropdown-item text-muted">Tidak ada jalur kabel ditemukan</span></li>';
          return;
        }
        
        displayRoutes.forEach(item => {
          cableRouteList.appendChild(createDropdownItem(item.display, function(e) {
            e.preventDefault();
            selectedCableRoute = item.type;
            cableRouteText.textContent = item.display;
            checkProcessButton();
          }));
        });
      }

      // Hitung jarak antara dua titik (Haversine formula)
      function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // Radius bumi dalam meter
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        return R * c; // Jarak dalam meter
      }

      // Helper function: Hitung jarak dalam meter menggunakan Leaflet (lebih akurat)
      // Menggunakan L.latLng().distanceTo() untuk perhitungan presisi meter
      function getDistanceInMeters(lat1, lng1, lat2, lng2) {
        const point1 = L.latLng(lat1, lng1);
        const point2 = L.latLng(lat2, lng2);
        return point1.distanceTo(point2); // Returns distance in meters
      }

      // Helper function: Offset koordinat berdasarkan meter (untuk insert row)
      function offsetCoordinates(lat, lng, metersNorth, metersEast) {
        // 1 derajat latitude ≈ 111,320 meter (konstan)
        const latOffset = metersNorth / 111320;
        // 1 derajat longitude tergantung latitude: 111,320 * cos(lat)
        const lngOffset = metersEast / (111320 * Math.cos(lat * Math.PI / 180));
        return {
          lat: lat + latOffset,
          lng: lng + lngOffset
        };
      }

      // DUAL STRATEGY ROUTING: Jarak dekat = direct, Jarak jauh = branch detection
      function findCableRoute(startCoord, endCoord) {
        // Hitung jarak langsung antara start dan end
        const directDistance = calculateDistance(startCoord.lat, startCoord.lng, endCoord.lat, endCoord.lng);
        
        // THRESHOLD DINAMIS: Untuk jalur sangat pendek (<5m), gunakan 1 meter. Default: 3 meter. Jalur panjang: 100 meter
        let threshold;
        if (directDistance < 5) {
          threshold = 1; // Jalur sangat pendek - presisi tinggi (1 meter)
          console.log('⚡ VERY SHORT ROUTE (<5m) - Using 1m precision threshold');
        } else if (directDistance < 50) {
          threshold = 3; // Jalur pendek - presisi sedang (3 meter default)
          console.log('✓ SHORT ROUTE (<50m) - Using 3m threshold');
        } else {
          threshold = 100; // Jalur panjang - tolerance lebih besar (100 meter)
          console.log('✓ LONG ROUTE - Using 100m threshold');
        }
        
        const distanceThreshold = 500; // 500 meter sebagai batas jarak dekat/jauh
        
        console.log('=== CABLE ROUTING START (DUAL STRATEGY) ===');
        console.log('Start:', startCoord);
        console.log('End:', endCoord);
        console.log('Direct distance:', directDistance.toFixed(2), 'm');
        console.log('Active threshold:', threshold, 'm');
        console.log('Selected cable route filter:', selectedCableRoute || 'NONE');
        
        // STRATEGI 1: JARAK DEKAT - Direct routing (optimal, abaikan jalur lain)
        if (directDistance <= distanceThreshold) {
          console.log('✓ SHORT DISTANCE - Using direct routing (optimal path)');
          return findDirectRoute(startCoord, endCoord, threshold);
        }
        
        // STRATEGI 2: JARAK JAUH - Branch detection routing
        console.log('✓ LONG DISTANCE - Using branch detection routing');
        return findBranchRoute(startCoord, endCoord, threshold, directDistance);
      }
      
      // Helper function to filter cables by selected route
      function getFilteredCables() {
        if (!selectedCableRoute) {
          console.log('No cable route filter - returning all cables');
          return cableLines;
        }
        
        const filtered = cableLines.filter(cable => {
          const description = cable.description || cable.name || '';
          const matches = description.toUpperCase().includes(selectedCableRoute.toUpperCase());
          if (!matches) {
            console.log(`❌ BLOCKED: ${cable.name} (doesn't match ${selectedCableRoute})`);
          } else {
            console.log(`✓ ALLOWED: ${cable.name}`);
          }
          return matches;
        });
        
        console.log(`Filtered cables: ${filtered.length}/${cableLines.length} (filter: ${selectedCableRoute})`);
        return filtered;
      }
      
      // STRATEGI 1: Direct routing untuk jarak dekat
      function findDirectRoute(startCoord, endCoord, threshold) {
        const filteredCables = getFilteredCables();
        let routeCables = [];
        
        // METODE 1: Cari kabel yang melewati kedua titik (direct cable)
        for (let cable of filteredCables) {
          
          let nearStart = false;
          let nearEnd = false;
          
          for (let point of cable.coordinates) {
            const distToStart = calculateDistance(startCoord.lat, startCoord.lng, point.lat, point.lng);
            const distToEnd = calculateDistance(endCoord.lat, endCoord.lng, point.lat, point.lng);
            
            if (distToStart < threshold) nearStart = true;
            if (distToEnd < threshold) nearEnd = true;
          }
          
          if (nearStart && nearEnd) {
            routeCables.push(cable);
          }
        }
        
        if (routeCables.length > 0) {
          console.log(`Found ${routeCables.length} direct cables (route: ${selectedCableRoute || 'any'})`);
          return routeCables;
        }
        
        // METODE 2: A* shortest path
        console.log('No direct cable, using A* algorithm...');
        
        let cablesNearStart = [];
        for (let cable of filteredCables) {
          
          for (let point of cable.coordinates) {
            if (calculateDistance(startCoord.lat, startCoord.lng, point.lat, point.lng) < threshold) {
              cablesNearStart.push(cable);
              break;
            }
          }
        }
        
        let cablesNearEnd = [];
        for (let cable of filteredCables) {
          
          for (let point of cable.coordinates) {
            if (calculateDistance(endCoord.lat, endCoord.lng, point.lat, point.lng) < threshold) {
              cablesNearEnd.push(cable);
              break;
            }
          }
        }
        
        console.log(`Found ${cablesNearStart.length} cables near start, ${cablesNearEnd.length} cables near end`);
        
        if (cablesNearStart.length > 0 && cablesNearEnd.length > 0) {
          const cableGraph = buildCableGraph();
          const shortestPath = findShortestCablePath(cablesNearStart, cablesNearEnd, cableGraph, startCoord, endCoord);
          
          if (shortestPath && shortestPath.length > 0) {
            console.log(`A* found path with ${shortestPath.length} cables`);
            return shortestPath;
          }
        }
        
        // METODE 3: Fallback corridor
        console.log('Using corridor fallback...');
        const directDist = calculateDistance(startCoord.lat, startCoord.lng, endCoord.lat, endCoord.lng);
        
        for (let cable of filteredCables) {
          let minDetour = Infinity;
          
          for (let point of cable.coordinates) {
            const distFromStart = calculateDistance(startCoord.lat, startCoord.lng, point.lat, point.lng);
            const distFromEnd = calculateDistance(point.lat, point.lng, endCoord.lat, endCoord.lng);
            const totalDist = distFromStart + distFromEnd;
            const detour = totalDist - directDist;
            
            if (detour < minDetour) minDetour = detour;
            
            if (totalDist < directDist * 1.15) {
              routeCables.push({ cable: cable, detour: minDetour });
              break;
            }
          }
        }
        
        routeCables.sort((a, b) => a.detour - b.detour);
        return routeCables.map(item => item.cable);
      }
      
      // STRATEGI 2: Branch detection routing untuk jarak jauh
      function findBranchRoute(startCoord, endCoord, threshold, directDistance) {
        console.log('Detecting intermediate branches (junction points)...');
        
        const filteredCables = getFilteredCables();
        
        // Cari intermediate placemarks yang bisa jadi cabang (junction points)
        let branchCandidates = [];
        
        for (let pm of allPlacemarksData) {
          // Hitung jarak dari start dan end
          const distFromStart = calculateDistance(startCoord.lat, startCoord.lng, pm.latitude, pm.longitude);
          const distFromEnd = calculateDistance(pm.latitude, pm.longitude, endCoord.lat, endCoord.lng);
          const totalDist = distFromStart + distFromEnd;
          
          // Kandidat cabang: berada di antara start dan end (dalam corridor)
          // Tidak terlalu dekat dengan start atau end
          if (distFromStart > 100 && distFromEnd > 100 && totalDist < directDistance * 1.3) {
            // Cek apakah placemark ini ada di dekat banyak kabel (junction point)
            let nearCableCount = 0;
            for (let cable of filteredCables) {
              
              for (let point of cable.coordinates) {
                if (calculateDistance(pm.latitude, pm.longitude, point.lat, point.lng) < threshold) {
                  nearCableCount++;
                  break;
                }
              }
            }
            
            // Junction point = ada banyak kabel di sekitarnya
            if (nearCableCount >= 2) {
              branchCandidates.push({
                placemark: pm,
                distFromStart: distFromStart,
                distFromEnd: distFromEnd,
                cableCount: nearCableCount,
                detour: totalDist - directDistance
              });
            }
          }
        }
        
        // Sort branches by distance from start (start → cabang1 → cabang2 → end)
        branchCandidates.sort((a, b) => a.distFromStart - b.distFromStart);
        
        // Filter: pilih maksimal 3 cabang terbaik (paling sedikit detour)
        branchCandidates.sort((a, b) => a.detour - b.detour);
        const selectedBranches = branchCandidates.slice(0, 3);
        selectedBranches.sort((a, b) => a.distFromStart - b.distFromStart);
        
        console.log(`Found ${selectedBranches.length} intermediate branches`);
        
        if (selectedBranches.length === 0) {
          // Tidak ada cabang, gunakan direct routing
          console.log('No branches found, falling back to direct routing');
          return findDirectRoute(startCoord, endCoord, threshold);
        }
        
        // Route melalui cabang: start → branch1 → branch2 → ... → end
        let allSegmentCables = [];
        let waypoints = [startCoord];
        
        for (let branch of selectedBranches) {
          waypoints.push({
            lat: branch.placemark.latitude,
            lng: branch.placemark.longitude,
            name: branch.placemark.name
          });
        }
        
        waypoints.push(endCoord);
        
        console.log(`Routing through ${waypoints.length} waypoints (including start/end)`);
        
        // Route setiap segment
        for (let i = 0; i < waypoints.length - 1; i++) {
          const segmentStart = waypoints[i];
          const segmentEnd = waypoints[i + 1];
          
          console.log(`Segment ${i + 1}: ${segmentStart.name || 'START'} → ${segmentEnd.name || 'END'}`);
          
          const segmentCables = findDirectRoute(segmentStart, segmentEnd, threshold);
          
          // Gabungkan cables (hindari duplikasi)
          for (let cable of segmentCables) {
            if (!allSegmentCables.find(c => c.name === cable.name)) {
              allSegmentCables.push(cable);
            }
          }
        }
        
        console.log(`Total cables found: ${allSegmentCables.length}`);
        return allSegmentCables;
      }
      
      // Build cable connectivity graph
      function buildCableGraph() {
        const cableGraph = new Map();
        
        // Filter cables by selected route
        const filteredCables = cableLines.filter(cable => {
          if (!selectedCableRoute) return true;
          const description = cable.description || cable.name || '';
          return description.toUpperCase().includes(selectedCableRoute.toUpperCase());
        });
        
        for (let cable of filteredCables) {
          cableGraph.set(cable.name, []);
        }
        
        for (let i = 0; i < filteredCables.length; i++) {
          for (let j = i + 1; j < filteredCables.length; j++) {
            let minDist = Infinity;
            
            for (let p1 of filteredCables[i].coordinates) {
              for (let p2 of filteredCables[j].coordinates) {
                const dist = calculateDistance(p1.lat, p1.lng, p2.lat, p2.lng);
                if (dist < minDist) minDist = dist;
              }
            }
            
            if (minDist < 50) {
              cableGraph.get(filteredCables[i].name).push({ cable: filteredCables[j], distance: minDist });
              cableGraph.get(filteredCables[j].name).push({ cable: filteredCables[i], distance: minDist });
            }
          }
        }
        
        return cableGraph;
      }
      
      // Calculate bearing between two points (for direction)
      function calculateBearing(lat1, lon1, lat2, lon2) {
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;
        
        const y = Math.sin(Δλ) * Math.cos(φ2);
        const x = Math.cos(φ1) * Math.sin(φ2) - Math.sin(φ1) * Math.cos(φ2) * Math.cos(Δλ);
        const θ = Math.atan2(y, x);
        
        return (θ * 180 / Math.PI + 360) % 360; // Bearing in degrees
      }
      
      // A* algorithm for finding shortest cable path (Dijkstra + heuristic)
      function findShortestCablePath(startCables, endCables, cableGraph, startCoord, endCoord) {
        const gScore = new Map(); // Actual distance from start
        const fScore = new Map(); // gScore + heuristic
        const previous = new Map();
        const openSet = new Set();
        const closedSet = new Set();
        
        // Initialize scores
        for (let cable of cableLines) {
          gScore.set(cable.name, Infinity);
          fScore.set(cable.name, Infinity);
        }
        
        // Set distance to start cables
        for (let cable of startCables) {
          // gScore = distance from start point to nearest point on cable
          let minDistStart = Infinity;
          let minDistEnd = Infinity;
          
          for (let point of cable.coordinates) {
            const distStart = calculateDistance(startCoord.lat, startCoord.lng, point.lat, point.lng);
            const distEnd = calculateDistance(point.lat, point.lng, endCoord.lat, endCoord.lng);
            if (distStart < minDistStart) minDistStart = distStart;
            if (distEnd < minDistEnd) minDistEnd = distEnd;
          }
          
          gScore.set(cable.name, minDistStart);
          // fScore = gScore + heuristic (estimated distance to end)
          fScore.set(cable.name, minDistStart + minDistEnd);
          openSet.add(cable.name);
        }
        
        // Create end cables set for quick lookup
        const endCableNames = new Set(endCables.map(c => c.name));
        
        while (openSet.size > 0) {
          // Find cable in openSet with lowest fScore
          let currentCableName = null;
          let minFScore = Infinity;
          
          for (let cableName of openSet) {
            const score = fScore.get(cableName);
            if (score < minFScore) {
              minFScore = score;
              currentCableName = cableName;
            }
          }
          
          if (currentCableName === null || minFScore === Infinity) {
            break; // No more reachable cables
          }
          
          // Check if we reached any end cable
          if (endCableNames.has(currentCableName)) {
            // Reconstruct path
            const path = [];
            let current = currentCableName;
            
            while (current) {
              const cable = cableLines.find(c => c.name === current);
              if (cable) path.unshift(cable);
              current = previous.get(current);
            }
            
            console.log('A* found path with total distance:', gScore.get(currentCableName).toFixed(2), 'meters');
            return path;
          }
          
          openSet.delete(currentCableName);
          closedSet.add(currentCableName);
          
          // Get current cable
          const currentCable = cableLines.find(c => c.name === currentCableName);
          if (!currentCable) continue;
          
          // Calculate nearest point to end on current cable (for heuristic)
          let currentToEndDist = Infinity;
          for (let point of currentCable.coordinates) {
            const dist = calculateDistance(point.lat, point.lng, endCoord.lat, endCoord.lng);
            if (dist < currentToEndDist) currentToEndDist = dist;
          }
          
          // Update scores for neighbors
          const neighbors = cableGraph.get(currentCableName) || [];
          for (let neighbor of neighbors) {
            if (closedSet.has(neighbor.cable.name)) continue;
            
            // Calculate tentative gScore (TIDAK gunakan cable length, hanya connection distance)
            const tentativeGScore = gScore.get(currentCableName) + neighbor.distance;
            
            // Calculate heuristic (minimum distance from neighbor cable to end point)
            let neighborToEndDist = Infinity;
            for (let point of neighbor.cable.coordinates) {
              const dist = calculateDistance(point.lat, point.lng, endCoord.lat, endCoord.lng);
              if (dist < neighborToEndDist) neighborToEndDist = dist;
            }
            
            // Calculate direct distance from start to end for reference
            const directDistance = calculateDistance(startCoord.lat, startCoord.lng, endCoord.lat, endCoord.lng);
            
            // Check if neighbor cable is in the corridor towards target
            let avgNeighborLat = 0;
            let avgNeighborLng = 0;
            for (let point of neighbor.cable.coordinates) {
              avgNeighborLat += point.lat;
              avgNeighborLng += point.lng;
            }
            avgNeighborLat /= neighbor.cable.coordinates.length;
            avgNeighborLng /= neighbor.cable.coordinates.length;
            
            const distFromStart = calculateDistance(startCoord.lat, startCoord.lng, avgNeighborLat, avgNeighborLng);
            const distFromEnd = calculateDistance(avgNeighborLat, avgNeighborLng, endCoord.lat, endCoord.lng);
            
            // Strong penalty if cable is outside direct corridor (tolerance 20%)
            let corridorPenalty = 0;
            if (distFromStart + distFromEnd > directDistance * 1.2) {
              corridorPenalty = (distFromStart + distFromEnd - directDistance) * 10; // 10x penalty for outside corridor
            }
            
            // Very strong penalty if neighbor moves away from target
            let directionPenalty = 0;
            if (neighborToEndDist > currentToEndDist) {
              // Neighbor is moving away from target - HEAVY penalty
              directionPenalty = (neighborToEndDist - currentToEndDist) * 5; // 5x penalty for moving away
            }
            
            const tentativeFScore = tentativeGScore + neighborToEndDist + directionPenalty + corridorPenalty;
            
            if (tentativeGScore < gScore.get(neighbor.cable.name)) {
              // This path to neighbor is better
              previous.set(neighbor.cable.name, currentCableName);
              gScore.set(neighbor.cable.name, tentativeGScore);
              fScore.set(neighbor.cable.name, tentativeFScore);
              
              if (!openSet.has(neighbor.cable.name)) {
                openSet.add(neighbor.cable.name);
              }
            }
          }
        }
        
        console.log('A* algorithm: No path found');
        return null; // No path found
      }
      
      // Calculate total length of a cable
      function calculateCableLength(cable) {
        let totalLength = 0;
        for (let i = 0; i < cable.coordinates.length - 1; i++) {
          const p1 = cable.coordinates[i];
          const p2 = cable.coordinates[i + 1];
          totalLength += calculateDistance(p1.lat, p1.lng, p2.lat, p2.lng);
        }
        return totalLength;
      }

      // Cari placemark di sepanjang jalur kabel
      function findPlacemarksAlongRoute(routeCables, startCoord, endCoord) {
        // THRESHOLD ADAPTIF: Sesuaikan dengan panjang jalur
        const routeDistance = getDistanceInMeters(startCoord.lat, startCoord.lng, endCoord.lat, endCoord.lng);
        
        let threshold;
        if (routeDistance < 100) {
          threshold = 20; // Jalur pendek (<100m): threshold ketat 20m (balance GPS drift + presisi)
        } else if (routeDistance < 500) {
          threshold = 40; // Jalur sedang (100-500m): threshold sedang 40m
        } else {
          threshold = 100; // Jalur panjang (>500m): threshold luas 100m
        }
        
        let routePlacemarks = [];
        let routePlacemarksNonDonut = [];
        
        console.log('=== FINDING PLACEMARKS ALONG ROUTE ===');
        console.log('Total placemarks to check:', allPlacemarksData.length);
        console.log('Route cables:', routeCables.length);
        console.log('Route distance:', routeDistance.toFixed(2), 'meters');
        console.log('Detection threshold (ADAPTIVE):', threshold, 'meters');
        
        let checkedCount = 0;
        let nearCableCount = 0;
        
        // Untuk setiap placemark, cek apakah dekat dengan jalur kabel
        for (let pm of allPlacemarksData) {
          checkedCount++;
          let nearCable = false;
          let minDistance = Infinity;
          
          // Cek jarak ke setiap titik di jalur kabel
          for (let cable of routeCables) {
            for (let point of cable.coordinates) {
              const dist = calculateDistance(pm.latitude, pm.longitude, point.lat, point.lng);
              if (dist < minDistance) minDistance = dist;
              if (dist < threshold) {
                nearCable = true;
                break;
              }
            }
            if (nearCable) break;
          }
          
          if (nearCable) {
            nearCableCount++;
            console.log(`✓ Placemark "${pm.name}" is near cable (${minDistance.toFixed(2)}m), iconType=${pm.iconType}`);
            console.log(`  → Description: ${pm.description?.substring(0, 100)}`);
            console.log(`  → StyleUrl: ${pm.styleUrl}`);
            
            // Skip placemark dengan styleUrl msn_homegardenbusiness
            if (pm.styleUrl.includes('msn_homegardenbusiness')) {
              console.log(`  ⚠️ SKIPPED (msn_homegardenbusiness) - This placemark will NOT appear in preview`);
              continue;
            }
            
            // Hitung jarak dari titik awal untuk sorting
            const distFromStart = calculateDistance(
              startCoord.lat, startCoord.lng,
              pm.latitude, pm.longitude
            );
            
            const placemarkWithDist = {
              ...pm,
              distanceFromStart: distFromStart
            };
            
            // LOGIKA BARU: Pisahkan berdasarkan iconType
            // DONUT = Tiang (icon donut.png)
            // NON-DONUT = Lainnya (square, circle, dollar, dll)
            if (pm.iconType === 'donut') {
              console.log(`  → Added to DONUT list (TIANG)`);
              routePlacemarks.push(placemarkWithDist);
            } else {
              console.log(`  → Added to NON-DONUT list (iconType: ${pm.iconType})`);
              routePlacemarksNonDonut.push(placemarkWithDist);
            }
          }
        }
        
        console.log(`Checked ${checkedCount} placemarks, found ${nearCableCount} near cables`);
        console.log(`Final: ${routePlacemarks.length} donut, ${routePlacemarksNonDonut.length} non-donut`);
        
        // Sort berdasarkan jarak dari titik awal
        routePlacemarks.sort((a, b) => a.distanceFromStart - b.distanceFromStart);
        routePlacemarksNonDonut.sort((a, b) => a.distanceFromStart - b.distanceFromStart);
        
        return {
          donut: routePlacemarks,
          nonDonut: routePlacemarksNonDonut
        };
      }

      // Resolve selected point to the correct placemark in allPlacemarksData.
      // Priority: exact selected name within threshold, then nearest candidate.
      function resolveSelectedPlacemark(selectedPoint, targetCoord, thresholdMeters = 3) {
        if (!selectedPoint || !targetCoord) return null;

        const selectedName = ((selectedPoint.originalName || selectedPoint.name) || '').trim().toLowerCase();
        const nearby = [];

        for (const pm of allPlacemarksData) {
          const distance = getDistanceInMeters(pm.latitude, pm.longitude, targetCoord.lat, targetCoord.lng);
          if (distance < thresholdMeters) {
            nearby.push({ pm, distance });
          }
        }

        if (nearby.length === 0) return null;

        const exactNameMatches = nearby.filter(x => (x.pm.name || '').trim().toLowerCase() === selectedName);
        const pool = exactNameMatches.length > 0 ? exactNameMatches : nearby;

        pool.sort((a, b) => a.distance - b.distance);

        if (pool.length > 1) {
          console.log(`🔎 resolveSelectedPlacemark: ${pool.length} candidate(s) for "${selectedPoint.name}"; picked nearest.`);
        }

        return pool[0].pm;
      }

      // Process button click
      processBtn.addEventListener('click', function() {
        if (selectedStartPoint && selectedEndPoint) {
          console.log('Processing from:', selectedStartPoint.name, 'to:', selectedEndPoint.name);
          
          // Ambil koordinat titik awal dan akhir
          const startCoords = selectedStartPoint.coordinates.split(/[\s,]+/);
          const endCoords = selectedEndPoint.coordinates.split(/[\s,]+/);
          
          const startCoord = {
            lng: parseFloat(startCoords[0]),
            lat: parseFloat(startCoords[1])
          };
          
          const endCoord = {
            lng: parseFloat(endCoords[0]),
            lat: parseFloat(endCoords[1])
          };
          
          // Cari jalur kabel yang menghubungkan titik awal dan akhir (jika mode jalur kabel aktif & ada kabel)
          let routeCables = [];
          let routePlacemarks = { donut: [], nonDonut: [] };

          if (useCableRoute && cableLines && cableLines.length > 0) {
            routeCables = findCableRoute(startCoord, endCoord);
            console.log('=== ROUTING RESULT ===');
            console.log('Cables in route:', routeCables.length);
            
            if (routeCables.length > 0) {
              routePlacemarks = findPlacemarksAlongRoute(routeCables, startCoord, endCoord);
            }
          }

          // Fallback jika tidak memakai jalur kabel atau tidak ditemukan kabel penghubung:
          // Gunakan urutan placemark langsung dari titik awal ke titik akhir
          if (!useCableRoute || !cableLines || cableLines.length === 0 || (routePlacemarks.donut.length === 0 && routePlacemarks.nonDonut.length === 0)) {
            console.log('Using direct placemark sequence routing (without cable constraint)...');
            const startName = selectedStartPoint.originalName || selectedStartPoint.name;
            const endName = selectedEndPoint.originalName || selectedEndPoint.name;
            
            const startIdx = allPlacemarksData.findIndex(p => (p.name === startName || p.name === selectedStartPoint.name));
            const endIdx = allPlacemarksData.findIndex(p => (p.name === endName || p.name === selectedEndPoint.name));
            
            let orderedPms = [];
            if (startIdx !== -1 && endIdx !== -1) {
              const minIdx = Math.min(startIdx, endIdx);
              const maxIdx = Math.max(startIdx, endIdx);
              orderedPms = allPlacemarksData.slice(minIdx, maxIdx + 1);
              if (startIdx > endIdx) orderedPms.reverse();
            } else {
              orderedPms = allPlacemarksData;
            }

            let cumulativeDist = 0;
            let prevCoord = startCoord;
            routePlacemarks = { donut: [], nonDonut: [] };
            
            orderedPms.forEach((pm, idx) => {
              if (idx > 0) {
                cumulativeDist += calculateDistance(prevCoord.lat, prevCoord.lng, pm.latitude, pm.longitude);
                prevCoord = { lat: pm.latitude, lng: pm.longitude };
              }
              const pmObj = {
                name: pm.name,
                longitude: typeof pm.longitude === 'number' ? pm.longitude.toFixed(6) : pm.longitude,
                latitude: typeof pm.latitude === 'number' ? pm.latitude.toFixed(6) : pm.latitude,
                description: pm.description,
                styleUrl: pm.styleUrl || '',
                distanceFromStart: cumulativeDist,
                type: pm.iconType === 'donut' ? 'donut' : 'nonDonut'
              };
              if (pmObj.type === 'donut') {
                routePlacemarks.donut.push(pmObj);
              } else {
                routePlacemarks.nonDonut.push(pmObj);
              }
            });
          }

          // Update kmlData dengan placemark msn_donut
          kmlData = routePlacemarks.donut.map(pm => ({
            name: pm.name,
            longitude: typeof pm.longitude === 'number' ? pm.longitude.toFixed(6) : pm.longitude,
            latitude: typeof pm.latitude === 'number' ? pm.latitude.toFixed(6) : pm.latitude,
            description: pm.description,
            styleUrl: pm.styleUrl || '',
            distanceFromStart: pm.distanceFromStart,
            type: 'donut'
          }));
          
          // Update kmlDataNonDonut dengan placemark NON msn_donut
          kmlDataNonDonut = routePlacemarks.nonDonut.map(pm => ({
            name: pm.name,
            longitude: typeof pm.longitude === 'number' ? pm.longitude.toFixed(6) : pm.longitude,
            latitude: typeof pm.latitude === 'number' ? pm.latitude.toFixed(6) : pm.latitude,
            description: pm.description,
            styleUrl: pm.styleUrl || '',
            distanceFromStart: pm.distanceFromStart,
            type: 'nonDonut'
          }));
          
          // ===== WAJIB: PASTIKAN START & END POINT SELALU ADA =====
          
          // Cari data placemark untuk start point (threshold: 3 meter)
          const POINT_MATCH_THRESHOLD = 3; // 3 meter threshold untuk matching placemark
          const startPlacemark = resolveSelectedPlacemark(selectedStartPoint, startCoord, POINT_MATCH_THRESHOLD);
          
          // Cari data placemark untuk end point (threshold: 3 meter)
          const endPlacemark = resolveSelectedPlacemark(selectedEndPoint, endCoord, POINT_MATCH_THRESHOLD);

          const selectedStartName = selectedStartPoint.originalName || selectedStartPoint.name;
          const selectedEndName = selectedEndPoint.originalName || selectedEndPoint.name;
          
          // Hapus start/end dari list jika sudah ada (berdasarkan nama)
          if (startPlacemark) {
            kmlData = kmlData.filter(pm => pm.name !== selectedStartName);
            kmlDataNonDonut = kmlDataNonDonut.filter(pm => pm.name !== selectedStartName);
          }
          
          if (endPlacemark) {
            kmlData = kmlData.filter(pm => pm.name !== selectedEndName);
            kmlDataNonDonut = kmlDataNonDonut.filter(pm => pm.name !== selectedEndName);
          }
          
          // Tambahkan start point di AWAL (distance = 0)
          if (startPlacemark) {
            const startEntry = {
              name: selectedStartName,
              longitude: startCoord.lng.toFixed(6),
              latitude: startCoord.lat.toFixed(6),
              description: startPlacemark.description || '-',
              styleUrl: startPlacemark.styleUrl || '',
              distanceFromStart: 0,
              type: startPlacemark.iconType === 'donut' ? 'donut' : 'nonDonut'
            };
            
            if (startEntry.type === 'donut') {
              kmlData.unshift(startEntry);
            } else {
              kmlDataNonDonut.unshift(startEntry);
            }
          }
          
          // Hitung jarak langsung start ke end (untuk info saja)
          const directDist = calculateDistance(startCoord.lat, startCoord.lng, endCoord.lat, endCoord.lng);
          
          // Tambahkan end point di AKHIR
          // PENTING: Gunakan jarak maksimum + 1 agar end point SELALU di akhir saat sorting
          if (endPlacemark) {
            // Endpoint-only fallback: gunakan BalloonStyle jika deskripsi endpoint kosong
            let endDescription = endPlacemark.description || '-';
            if ((!endDescription || endDescription === '-') && endPlacemark.styleUrl) {
              let resolvedStyleId = endPlacemark.styleUrl;
              if (styleMapMap.has(endPlacemark.styleUrl)) {
                resolvedStyleId = styleMapMap.get(endPlacemark.styleUrl);
              }

              const fallbackBalloon =
                balloonStyleMapping.get(endPlacemark.styleUrl) ||
                balloonStyleMapping.get(resolvedStyleId) ||
                '';

              if (fallbackBalloon && !fallbackBalloon.includes('$[')) {
                const cleanBalloon = stripHtmlTags(fallbackBalloon).trim();
                if (cleanBalloon) {
                  endDescription = cleanBalloon;
                  console.log(`🔄 Endpoint balloon fallback applied for "${selectedEndPoint.name}":`, cleanBalloon);
                }
              }
            }

            // Cari jarak maksimum dari semua placemark yang sudah ada
            let maxDistance = 0;
            for (let pm of [...kmlDataNonDonut, ...kmlData]) {
              if (pm.distanceFromStart > maxDistance) {
                maxDistance = pm.distanceFromStart;
              }
            }
            
            const endEntry = {
              name: selectedEndName,
              longitude: endCoord.lng.toFixed(6),
              latitude: endCoord.lat.toFixed(6),
              description: endDescription,
              styleUrl: endPlacemark.styleUrl || '',
              distanceFromStart: maxDistance + 1, // Maksimum + 1 agar selalu di akhir
              type: endPlacemark.iconType === 'donut' ? 'donut' : 'nonDonut'
            };
            
            if (endEntry.type === 'donut') {
              kmlData.push(endEntry);
            } else {
              kmlDataNonDonut.push(endEntry);
            }
          }
          
          // Gabungkan semua placemark dan urutkan berdasarkan jarak dari titik awal
          allRoutePlacemarks = [...kmlDataNonDonut, ...kmlData].sort((a, b) => a.distanceFromStart - b.distanceFromStart);
          
          console.log('✓ Start point:', startPlacemark ? selectedStartPoint.name : 'NOT FOUND');
          console.log('✓ End point:', endPlacemark ? selectedEndPoint.name : 'NOT FOUND');
          
          // Tampilkan preview
          displayPreview();
          
          showToast('success', 'Routing Berhasil', `Data rute (${allRoutePlacemarks.length} titik) berhasil diproses ke preview tabel.`);

          // Update notification info (jika container ada)
          if (notificationContent) {
            notificationContent.innerHTML = `
              <div class="alert alert-info mb-0" role="alert">
                <h6 class="alert-heading mb-2"><i class="bi bi-check-circle me-2"></i>Routing Berhasil</h6>
                <p class="mb-1"><strong>Titik Awal:</strong> ${selectedStartPoint.name}</p>
                <p class="mb-1"><strong>Titik Akhir:</strong> ${selectedEndPoint.name}</p>
                <p class="mb-1"><strong>Jalur Kabel Ditemukan:</strong> ${routeCables.length} jalur</p>
                <p class="mb-1"><strong>Total Placemark di Jalur:</strong> ${allRoutePlacemarks.length} titik</p>
                <p class="mb-1"><strong>- Non-Donut (Kolom Kiri):</strong> ${kmlDataNonDonut.length} titik</p>
                <p class="mb-0"><strong>- Donut (DESIGNATOR):</strong> ${kmlData.length} titik</p>
              </div>
            `;
          }
        }
      });

      // ========== MODERN UI EVENT LISTENERS & OBSERVERS ==========
      document.addEventListener('DOMContentLoaded', function() {
        // Dropzone click & drag-drop handling
        const kmlDropzoneArea = document.getElementById('kmlDropzoneArea');
        if (kmlDropzoneArea) {
          kmlDropzoneArea.addEventListener('click', function(e) {
            if (e.target.closest('#clearFileBtn')) return;
            if (fileInput) fileInput.click();
          });
          kmlDropzoneArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            kmlDropzoneArea.style.borderColor = '#DC2626';
            kmlDropzoneArea.style.backgroundColor = '#353745';
          });
          kmlDropzoneArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            kmlDropzoneArea.style.borderColor = '#4B4E5F';
            kmlDropzoneArea.style.backgroundColor = '#2F313D';
          });
          kmlDropzoneArea.addEventListener('drop', function(e) {
            e.preventDefault();
            kmlDropzoneArea.style.borderColor = '#4B4E5F';
            kmlDropzoneArea.style.backgroundColor = '#2F313D';
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
              if (fileInput) fileInput.files = e.dataTransfer.files;
              displayFileInfo(e.dataTransfer.files[0]);
            }
          });
        }

        // Auto-sync row count badge
        function syncRowCountBadge() {
          const rowCountBadge = document.getElementById('rowCountBadge');
          const tbody = document.getElementById('previewTableBody');
          if (rowCountBadge && tbody) {
            const rows = tbody.querySelectorAll('tr[data-index]');
            rowCountBadge.textContent = 'Rows: ' + (rows ? rows.length : 0);
          }
        }
        const tbodyEl = document.getElementById('previewTableBody');
        if (tbodyEl) {
          const tableObserver = new MutationObserver(syncRowCountBadge);
          tableObserver.observe(tbodyEl, { childList: true, subtree: true });
        }

        // Auto-sync Download buttons state with previewTableBody
        function syncDownloadButtonsState() {
          if (typeof checkExportButton === 'function') {
            checkExportButton();
          }
        }
        if (tbodyEl) {
          const downloadSyncObserver = new MutationObserver(syncDownloadButtonsState);
          downloadSyncObserver.observe(tbodyEl, { childList: true, subtree: true });

          // Click on previewTable row to toggle checkbox in Edit Mode
          tbodyEl.addEventListener('click', function(e) {
            if (typeof isEditMode === 'undefined' || !isEditMode) return;
            // Jika klik langsung pada checkbox, sel yang diedit, atau indikator insert baris, lewati
            if (e.target.matches('.row-checkbox') || e.target.isContentEditable || e.target.closest('#rowInsertIndicator')) return;
            const tr = e.target.closest('tr');
            if (!tr) return;
            const cb = tr.querySelector('.row-checkbox');
            if (cb) {
              cb.checked = !cb.checked;
              toggleRowCheckbox(cb);
            }
          });
        }

        // Inisialisasi fitur hover & tambah baris dinamis
        if (typeof setupRowInsertHover === 'function') {
          setupRowInsertHover();
        }
      });
    
      // ===== WORKSPACE VIEW SWITCHER =====
      window.currentWorkspaceView = 'landing';

      window.switchWorkspaceView = function(viewName) {
        window.currentWorkspaceView = viewName;
        const landingView  = document.getElementById('viewLandingCards');
        const matrixView   = document.getElementById('viewMatrixWorkspace');
        const pemetaanView = document.getElementById('mapPemetaanOverlay');

        if (viewName === 'landing') {
          if (landingView)  landingView.style.display  = 'flex';
          if (matrixView)   matrixView.style.display   = 'none';
          if (pemetaanView) pemetaanView.style.display = 'none';
          if (typeof pemetaanMap !== 'undefined' && pemetaanMap) {
            try { pemetaanMap.remove(); } catch(e) {}
            pemetaanMap = null;
          }
        } else if (viewName === 'matrix') {
          if (landingView)  landingView.style.display  = 'none';
          if (matrixView)   matrixView.style.display   = 'flex';
          if (pemetaanView) pemetaanView.style.display = 'none';
        } else if (viewName === 'pemetaan') {
          if (landingView)  landingView.style.display  = 'none';
          if (matrixView)   matrixView.style.display   = 'none';
          if (pemetaanView) {
            pemetaanView.style.display = 'flex';
            [100, 300, 600].forEach(d => {
              setTimeout(() => {
                if (typeof pemetaanMap !== 'undefined' && pemetaanMap) {
                  pemetaanMap.invalidateSize(true);
                }
              }, d);
            });
          }
        }
      };
      var switchWorkspaceView = window.switchWorkspaceView;

      // Landing action buttons
      document.addEventListener('DOMContentLoaded', function() {
        const btnLandingUpload = document.getElementById('btnLandingUpload');
        if (btnLandingUpload) {
          btnLandingUpload.addEventListener('click', function(e) {
            e.preventDefault();
            const modalEl = document.getElementById('kmlSourceModal');
            if (modalEl) {
              const kmlModal = new bootstrap.Modal(modalEl);
              kmlModal.show();
            }
          });
        }

        const btnLandingPemetaan = document.getElementById('btnLandingPemetaan');
        if (btnLandingPemetaan) {
          btnLandingPemetaan.addEventListener('click', function(e) {
            e.preventDefault();
            const projInput = document.getElementById('planNamaProyek');
            const dateInput = document.getElementById('planTanggal');
            if (projInput) projInput.value = '';
            if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];
            const planModalEl = document.getElementById('planNewModal');
            if (planModalEl) {
              const planModal = new bootstrap.Modal(planModalEl);
              planModal.show();
            }
          });
        }


        // Drag and drop on Landing KML card
        const cardUploadKml = document.getElementById('cardUploadKml');
        if (cardUploadKml) {
          ['dragenter', 'dragover'].forEach(eventName => {
            cardUploadKml.addEventListener(eventName, (e) => {
              e.preventDefault();
              e.stopPropagation();
              cardUploadKml.style.borderColor = '#DC2626';
              cardUploadKml.style.backgroundColor = '#323240';
            }, false);
          });

          ['dragleave', 'drop'].forEach(eventName => {
            cardUploadKml.addEventListener(eventName, (e) => {
              e.preventDefault();
              e.stopPropagation();
              cardUploadKml.style.borderColor = 'rgba(220, 38, 38, 0.25)';
              cardUploadKml.style.backgroundColor = '#2B2B36';
            }, false);
          });

          cardUploadKml.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0 && files[0].name.endsWith('.kml')) {
              window.switchWorkspaceView('matrix');
              const fi = document.getElementById('fileInput');
              if (fi) {
                fi.files = files;
                displayFileInfo(files[0]);
              }
            } else {
              showToast('error', 'Format File Tidak Valid', 'Silakan drop file berformat .kml!');
            }
          }, false);
        }
      });

      // ========== DASHBOARD STATS & CHART.JS LOGIC ==========
      let monthlyTrendChartInstance = null;

      async function fetchDashboardStats(year, month) {
        try {
          const url = new URL('/api/dashboard/stats', window.location.origin);
          if (year && year !== 'all') url.searchParams.append('year', year);
          if (month && month !== 'all') url.searchParams.append('month', month);

          const response = await fetch(url.toString(), {
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          if (!response.ok) throw new Error('Gagal mengambil data statistik');
          const data = await response.json();
          if (data.success) {
            updateDashboardUI(data);
          }
        } catch (error) {
          console.error('Error fetching dashboard stats:', error);
        }
      }

      function updateDashboardUI(data) {
        // 1. Update KPI numbers
        const elProj = document.getElementById('kpiTotalProjects');
        const elPoints = document.getElementById('kpiTotalPoints');
        const elAreas = document.getElementById('kpiTotalAreas');

        if (elProj) elProj.textContent = data.kpis.total_projects || 0;
        if (elPoints) elPoints.textContent = data.kpis.total_points || 0;
        if (elAreas) elAreas.textContent = data.kpis.total_areas || 0;

        // 2. Update Year Select Options if needed
        const yearSelect = document.getElementById('filterYear');
        if (yearSelect && data.available_years && data.available_years.length > 0) {
          const currentVal = yearSelect.value;
          yearSelect.innerHTML = '';
          data.available_years.forEach(yr => {
            const opt = document.createElement('option');
            opt.value = yr;
            opt.textContent = yr;
            if (parseInt(yr) === parseInt(data.selected_year)) {
              opt.selected = true;
            }
            yearSelect.appendChild(opt);
          });
          if (currentVal && data.available_years.includes(parseInt(currentVal))) {
            yearSelect.value = currentVal;
          }
        }

        // 3. Update Chart Badges
        const yearBadge = document.getElementById('chartYearBadge');
        if (yearBadge) {
          yearBadge.textContent = 'Tahun ' + data.selected_year;
        }

        const monthBadge = document.getElementById('chartMonthBadge');
        if (monthBadge) {
          const monthText = document.getElementById('filterMonth');
          const selectedMonthName = monthText ? monthText.options[monthText.selectedIndex].text : '';
          monthBadge.textContent = data.selected_month !== 'all' ? selectedMonthName : 'Semua Bulan';
        }

        // 4. Render or Update Monthly Trend Bar Chart
        renderMonthlyTrendChart(data.monthly_trend, data.selected_month);
      }

      function renderMonthlyTrendChart(monthlyData, selectedMonth) {
        const ctx = document.getElementById('monthlyTrendChart');
        if (!ctx) return;

        const monthLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const chartCtx = ctx.getContext('2d');
        const gradient = chartCtx.createLinearGradient(0, 0, 0, 220);
        gradient.addColorStop(0, 'rgba(220, 38, 38, 0.9)');
        gradient.addColorStop(1, 'rgba(220, 38, 38, 0.15)');

        // Background color array: highlight selected month if specific month selected
        let bgColors = [];
        let borderColors = [];
        const selMonthIdx = (selectedMonth !== 'all' && isFinite(selectedMonth)) ? (parseInt(selectedMonth) - 1) : -1;

        for (let i = 0; i < 12; i++) {
          if (selMonthIdx >= 0) {
            if (i === selMonthIdx) {
              bgColors.push('#EF4444');
              borderColors.push('#FFFFFF');
            } else {
              bgColors.push('rgba(255, 255, 255, 0.08)');
              borderColors.push('rgba(255, 255, 255, 0.15)');
            }
          } else {
            bgColors.push(gradient);
            borderColors.push('#DC2626');
          }
        }

        if (monthlyTrendChartInstance) {
          monthlyTrendChartInstance.data.datasets[0].data = monthlyData;
          monthlyTrendChartInstance.data.datasets[0].backgroundColor = bgColors;
          monthlyTrendChartInstance.data.datasets[0].borderColor = borderColors;
          monthlyTrendChartInstance.update();
          return;
        }

        monthlyTrendChartInstance = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: monthLabels,
            datasets: [{
              label: 'Jumlah Proyek',
              data: monthlyData,
              backgroundColor: bgColors,
              borderColor: borderColors,
              borderWidth: 1.5,
              borderRadius: 8,
              borderSkipped: false,
              hoverBackgroundColor: '#EF4444'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            resizeDelay: 50,
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: '#1E1E24',
                borderColor: 'rgba(220, 38, 38, 0.6)',
                borderWidth: 1,
                titleColor: '#FFFFFF',
                bodyColor: '#F3F4F6',
                padding: 12,
                displayColors: false,
                callbacks: {
                  label: function(context) {
                    return context.parsed.y + ' Proyek Survei KML';
                  }
                }
              }
            },
            scales: {
              x: {
                grid: { display: false, drawBorder: false },
                ticks: { color: '#9CA3AF', font: { size: 11, weight: '500' } }
              },
              y: {
                beginAtZero: true,
                grid: { color: 'rgba(255, 255, 255, 0.06)', drawBorder: false },
                ticks: {
                  color: '#9CA3AF',
                  font: { size: 11 },
                  stepSize: 1,
                  precision: 0
                }
              }
            }
          }
        });
      }

      // Event Listeners for Filters
      document.addEventListener('DOMContentLoaded', function() {
        const filterYear = document.getElementById('filterYear');
        const filterMonth = document.getElementById('filterMonth');
        const btnResetFilter = document.getElementById('btnResetFilter');

        if (filterYear) {
          filterYear.addEventListener('change', function() {
            fetchDashboardStats(this.value, filterMonth ? filterMonth.value : 'all');
          });
        }

        if (filterMonth) {
          filterMonth.addEventListener('change', function() {
            fetchDashboardStats(filterYear ? filterYear.value : '', this.value);
          });
        }

        if (btnResetFilter) {
          btnResetFilter.addEventListener('click', function() {
            if (filterMonth) filterMonth.value = 'all';
            if (filterYear && filterYear.options.length > 0) {
              filterYear.selectedIndex = 0;
            }
            fetchDashboardStats(filterYear ? filterYear.value : '', 'all');
          });
        }

        // Initial Load of Dashboard Stats
        fetchDashboardStats('', 'all');

        // Auto-adapt chart and map on window resize / browser zoom in-out
        window.addEventListener('resize', function() {
          if (typeof monthlyTrendChartInstance !== 'undefined' && monthlyTrendChartInstance) {
            monthlyTrendChartInstance.resize();
          }
          if (typeof pemetaanMap !== 'undefined' && pemetaanMap) {
            pemetaanMap.invalidateSize(true);
          }
        });
      });

    </script>

    <!-- ===== Unified Toast Container ===== -->
    <div class="toast-container-custom" id="toastContainer"></div>

    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
