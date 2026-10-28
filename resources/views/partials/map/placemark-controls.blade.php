<!-- Banner Panduan Mode Tarik Kabel -->
<div id="cableDrawingBanner" style="display:none; position:absolute; top:10px; left:50%; transform:translateX(-50%); z-index:1150; background:rgba(107,70,193,0.95); color:#fff; padding:7px 18px; border-radius:24px; font-size:0.79rem; font-weight:600; box-shadow:0 6px 20px rgba(0,0,0,0.28); backdrop-filter:blur(8px); align-items:center; gap:10px; border:1px solid rgba(255,255,255,0.22); max-width:calc(100% - 32px); white-space:nowrap;">
  <span id="cableBannerText"><i class="bi bi-bezier2 me-1"></i> Klik di peta / klik placemark untuk snap</span>
  <button type="button" id="btnFinishCable" class="btn btn-sm btn-light py-1 px-3 fw-bold" style="font-size:0.75rem; border-radius:14px; color:#6B46C1; box-shadow:0 2px 6px rgba(0,0,0,0.15);">Selesai</button>
  <button type="button" id="btnCancelCableDraw" class="btn btn-sm btn-outline-light py-1 px-3" style="font-size:0.75rem; border-radius:14px;">Batal</button>
</div>

<!-- Form Popup Add Placemark (muncul saat klik di peta - DARK GLASSMORPHISM matching Informasi Pemetaan KML Baru) -->
<div id="pmFormPopup" style="display: none;">
  <!-- Header with Green Gradient -->
  <div class="pm-popup-header pm-header-green" style="align-items: flex-start;">
    <div style="flex: 1; padding-right: 10px;">
      <h6 class="pm-popup-title">
        <i class="bi bi-geo-alt-fill me-2 text-success"></i>Tambah Placemark Baru
      </h6>
      <p class="pm-popup-subtitle">Atur nama titik dan tampilan icon</p>
    </div>
    <div style="display:flex;align-items:center;gap:6px;">
      <button type="button" id="btnResetPmFormDefaults" title="Kembalikan ke pengaturan awal" style="display:none;" class="btn-reset-defaults">
        <i class="bi bi-arrow-counterclockwise"></i> Reset
      </button>
      <button type="button" class="btn-close btn-close-white" id="btnClosePmPopup" aria-label="Close" onclick="if(typeof closePmForm==='function') closePmForm();"></button>
    </div>
  </div>

  <div class="pm-popup-body">
    <label for="pmInputName" class="pm-label">Nama Placemark <span class="text-danger">*</span></label>
    <div class="pm-ac-wrapper">
      <input type="text" id="pmInputName" autocomplete="off" placeholder="Nama titik / placemark">
      <div id="pmNameAutocomplete"></div>
    </div>
    
    <label class="pm-label">Tipe Titik (Icon)</label>
    <div class="pm-shape-group" id="pmShapeGroup">
      <button type="button" class="pm-shape-btn active" data-shape="triangle" title="Triangle — Site TOP">
        <div class="pm-shape-icon-wrap">
          <svg width="24" height="24" viewBox="0 0 24 24" style="overflow:visible;" xmlns="http://www.w3.org/2000/svg">
            <polygon points="12,3.06 20.94,20.94 3.06,20.94" fill="none" stroke="#ffffff" stroke-width="6.12" stroke-linejoin="round"/>
            <polygon points="12,3.06 20.94,20.94 3.06,20.94" fill="none" stroke="#EE3124" stroke-width="3.12" stroke-linejoin="round"/>
          </svg>
        </div>
        Triangle
      </button>
      <button type="button" class="pm-shape-btn" data-shape="donut" title="Donut — Tiang / TE">
        <div class="pm-shape-icon-wrap">
          <svg width="24" height="24" viewBox="0 0 24 24" style="overflow:visible;" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="8.86" fill="none" stroke="#ffffff" stroke-width="8.28"/>
            <circle cx="12" cy="12" r="8.86" fill="none" stroke="#000000" stroke-width="5.28"/>
          </svg>
        </div>
        Donut
      </button>
      <button type="button" class="pm-shape-btn" data-shape="square" title="Square — ODC / OTB">
        <div class="pm-shape-icon-wrap">
          <svg width="24" height="24" viewBox="0 0 24 24" style="overflow:visible;" xmlns="http://www.w3.org/2000/svg">
            <rect x="3.06" y="3.06" width="17.88" height="17.88" rx="1" fill="none" stroke="#ffffff" stroke-width="6.12" stroke-linejoin="round"/>
            <rect x="3.06" y="3.06" width="17.88" height="17.88" rx="1" fill="none" stroke="#0000ff" stroke-width="3.12" stroke-linejoin="round"/>
          </svg>
        </div>
        Square
      </button>
    </div>
    <input type="hidden" id="pmInputShape" value="triangle">

    <label class="pm-label">Warna</label>
    <div class="pm-color-row">
      <div class="pm-color-cell">
        <label for="pmColorFill">Badan (Fill)</label>
        <div class="pm-color-input-wrap" onclick="document.getElementById('pmColorFill').click()">
          <input type="color" id="pmColorFill" value="#EE3124" title="Pilih warna badan">
          <span class="pm-color-hex-label" id="pmColorFillLabel">#EE3124</span>
        </div>
      </div>
      <div class="pm-color-cell">
        <label for="pmColorOutline">Outline</label>
        <div class="pm-color-input-wrap" onclick="document.getElementById('pmColorOutline').click()">
          <input type="color" id="pmColorOutline" value="#ffffff" title="Pilih warna outline">
          <span class="pm-color-hex-label" id="pmColorOutlineLabel">#ffffff</span>
        </div>
      </div>
    </div>

    <label for="pmInputNotes" class="pm-label">Keterangan</label>
    <textarea id="pmInputNotes" placeholder="Catatan (opsional)"></textarea>

    <div class="pm-form-actions">
      <button type="button" class="pm-cancel-btn" id="btnPmCancel"><i class="bi bi-x-circle me-1"></i>Batal</button>
      <button type="button" class="pm-save-btn" id="btnPmSave"><i class="bi bi-check-circle me-1"></i>Simpan</button>
    </div>
  </div>
</div>

<!-- Form Popup Add Cable (muncul saat selesai menarik kabel - DARK GLASSMORPHISM matching Informasi Pemetaan KML Baru dengan tema ungu) -->
<div id="cableFormPopup" style="display: none;">
  <!-- Header with Purple Gradient -->
  <div class="pm-popup-header pm-header-purple" style="align-items: flex-start;">
    <div style="flex: 1; padding-right: 10px;">
      <h6 class="pm-popup-title">
        <i class="bi bi-bezier2 me-2" style="color:#C4B5FD;"></i>Simpan Jalur Kabel
      </h6>
      <p class="pm-popup-subtitle" style="color: #DDD6FE;">Atur nama jalur dan tipe kabel</p>
    </div>
    <button type="button" class="btn-close btn-close-white" id="btnCloseCablePopup" aria-label="Close" onclick="if(typeof closeCableForm==='function'){closeCableForm();if(typeof stopDrawingCable==='function')stopDrawingCable();}"></button>
  </div>

  <div class="pm-popup-body">
    <div class="pm-coords-display" id="cableLengthDisplay">
      <i class="bi bi-rulers"></i> Panjang: — meter (— titik)
    </div>

    <label for="cableInputName" class="pm-label">Nama Jalur Kabel <span class="text-danger">*</span></label>
    <input type="text" id="cableInputName" autocomplete="off" placeholder="Nama jalur kabel">

    <label for="cableInputType" class="pm-label">Tipe Kabel Telkom <span class="text-danger">*</span></label>
    <select id="cableInputType">
      <option value="AC-OF-SM-24FO">AC-OF-SM-24FO (Kabel Udara 24 Core)</option>
      <option value="AC-OF-SM-48FO">AC-OF-SM-48FO (Kabel Udara 48 Core)</option>
      <option value="AC-OF-SM-96FO">AC-OF-SM-96FO (Kabel Udara 96 Core)</option>
      <option value="AC-OF-SM-ADSS-12D">AC-OF-SM-ADSS-12D (ADSS 12 Core)</option>
      <option value="AC-OF-SM-12D">AC-OF-SM-12D (Kabel Udara 12 Core)</option>
      <option value="CUSTOM">-- Tulis Tipe Kabel Lainnya --</option>
    </select>
    <div id="cableCustomTypeWrapper" style="display:none; margin-top:-4px; margin-bottom:10px;">
      <input type="text" id="cableCustomTypeInput" placeholder="Nama tipe kabel...">
    </div>

    <div class="pm-form-actions">
      <button type="button" class="pm-cancel-btn" id="btnCableCancel"><i class="bi bi-x-circle me-1"></i>Batal</button>
      <button type="button" class="pm-save-btn pm-save-purple" id="btnCableSave"><i class="bi bi-check-circle me-1"></i>Simpan</button>
    </div>
  </div>
</div>

<!-- Panel Daftar Placemark & Kabel -->
<div id="pmListPanel">
  <div class="pm-panel-header">
    <span><i class="bi bi-layers-fill" style="color:#38A169;margin-right:6px;"></i>Daftar Titik & Kabel (<span id="pmListCount">0</span>)</span>
    <button class="pm-panel-close" id="btnClosePmList" type="button" onclick="if(window.closePmListPanel){window.closePmListPanel(event);}" title="Tutup"><i class="bi bi-x"></i></button>
  </div>
  <div id="pmListScroll">
    <div class="pm-empty-state" id="pmEmptyState">
      <i class="bi bi-geo-alt"></i>
      Belum ada placemark atau kabel.<br>Klik "Tambah Placemark" atau "Tarik Kabel"<br>lalu buat di peta.
    </div>
  </div>
  <div class="pm-panel-footer">
    <div class="pm-clear-row">
      <button id="btnPmClearPoints" class="pm-btn-clear pm-btn-clear-points"
        type="button" onclick="clearAllPlacemarksOnly()" title="Hapus semua titik placemark">
        <i class="bi bi-geo-alt-fill"></i> Hapus Titik
      </button>
      <button id="btnPmClearCables" class="pm-btn-clear pm-btn-clear-cables"
        type="button" onclick="clearAllCablesOnly()" title="Hapus semua jalur kabel">
        <i class="bi bi-bezier2"></i> Hapus Kabel
      </button>
    </div>
    <button id="btnPmClearAll" class="pm-btn-clear pm-btn-clear-all"
      type="button" onclick="clearAllPlacemarks()" title="Hapus semua titik dan kabel">
      <i class="bi bi-trash3-fill"></i> Hapus Semua
    </button>
  </div>
</div>
