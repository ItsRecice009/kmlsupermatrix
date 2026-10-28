      // ===== PETA INTERAKTIF: PLAN NEW =====
      let pemetaanMap = null; // instance Leaflet — disimpan agar bisa di-destroy

      // ===== NOTIFIKASI TOAST (pengganti alert() bawaan browser) =====
      // Muncul sekali, tidak memblokir UI, auto-dismiss dalam 4 detik
      let _pmNotifTimer = null;
      function pmNotif(message, type) {
        // type: 'info' | 'warning' | 'error' | 'success'
        const colors = {
          info:    { bg: '#1E293B', border: '#3B82F6', icon: 'bi-info-circle-fill', iconColor: '#60A5FA' },
          warning: { bg: '#1E1A0E', border: '#F59E0B', icon: 'bi-exclamation-triangle-fill', iconColor: '#FBBF24' },
          error:   { bg: '#1E0E0E', border: '#EF4444', icon: 'bi-x-circle-fill', iconColor: '#F87171' },
          success: { bg: '#0E1E12', border: '#10B981', icon: 'bi-check-circle-fill', iconColor: '#34D399' },
        };
        const c = colors[type] || colors['info'];
        const id = '__pmNotifToast';
        let el = document.getElementById(id);
        if (!el) {
          el = document.createElement('div');
          el.id = id;
          el.style.cssText = `
            position: fixed; bottom: 24px; right: 24px; z-index: 99999;
            max-width: 360px; padding: 14px 18px;
            border-radius: 12px; border-left: 4px solid;
            display: flex; align-items: flex-start; gap: 12px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.5);
            transition: opacity 0.3s ease, transform 0.3s ease;
            font-family: inherit; font-size: 0.85rem; color: #F1F5F9;
            pointer-events: auto; cursor: pointer;
          `;
          el.onclick = () => { el.style.opacity = '0'; el.style.transform = 'translateY(10px)'; };
          document.body.appendChild(el);
        }
        // Reset animasi
        el.style.opacity = '0';
        el.style.transform = 'translateY(10px)';
        el.style.background = c.bg;
        el.style.borderColor = c.border;
        el.innerHTML = `
          <i class="bi ${c.icon}" style="font-size:1.1rem;color:${c.iconColor};margin-top:1px;flex-shrink:0;"></i>
          <span style="line-height:1.5;">${message.replace(/\n/g, '<br>')}</span>
        `;
        // Trigger animasi masuk
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
          });
        });
        // Auto-dismiss
        if (_pmNotifTimer) clearTimeout(_pmNotifTimer);
        _pmNotifTimer = setTimeout(() => {
          el.style.opacity = '0';
          el.style.transform = 'translateY(10px)';
        }, 4000);
      }
      // ===== END NOTIFIKASI TOAST =====

      // Helper hitung jarak dalam meter menggunakan Leaflet
      function getDistanceInMeters(lat1, lng1, lat2, lng2) {
        return L.latLng(lat1, lng1).distanceTo(L.latLng(lat2, lng2));
      }

      // ===== GLOBAL HANDLERS UNTUK DAFTAR TITIK & KABEL (pmListPanel) =====
      window.openPmListPanel = function() {
        const panel = document.getElementById('pmListPanel');
        if (!panel) return;
        panel.classList.add('open');
        panel.style.display = 'flex';
        if (typeof window.renderPmList === 'function') {
          window.renderPmList();
        }
      };

      window.closePmListPanel = function() {
        const panel = document.getElementById('pmListPanel');
        if (!panel) return;
        panel.classList.remove('open');
        panel.style.display = 'none';
      };

      window.togglePmListPanel = function(e) {
        if (e) {
          if (typeof e.preventDefault === 'function') e.preventDefault();
          if (typeof e.stopPropagation === 'function') e.stopPropagation();
        }
        const panel = document.getElementById('pmListPanel');
        if (!panel) return;
        const isOpen = panel.classList.contains('open') && panel.style.display === 'flex';
        if (isOpen) {
          window.closePmListPanel();
        } else {
          window.openPmListPanel();
        }
      };

      // Tombol Mulai Pemetaan — tutup modal plan, buka overlay peta
      function startPemetaanProcess() {
        // Ambil judul proyek & meta untuk topbar SEBELUM modal ditutup
        const projEl = document.getElementById('planNamaProyek');
        const areaEl = document.getElementById('planArea');
        const dateEl = document.getElementById('planTanggal');

        const namaProyek = (projEl ? projEl.value.trim() : '') || 'Pemetaan Baru';
        const area       = areaEl ? areaEl.value.trim() : '';
        const tanggal    = dateEl ? dateEl.value : '';

        const titleEl = document.getElementById('mapPlanTitle');
        if (titleEl) titleEl.textContent = namaProyek;
        const sumProj = document.getElementById('pemetaanSummaryProject');
        if (sumProj) sumProj.textContent = namaProyek;
        const metaEl = document.getElementById('mapPlanMeta');
        if (metaEl) {
          metaEl.textContent = (area ? area + (tanggal ? '  •  ' + tanggal : '') : (tanggal || 'Mode: Lihat Peta'));
        }

        // Tutup modal form plan secara paksa dan bersih
        const planModalEl = document.getElementById('planNewModal');
        if (planModalEl) {
          try {
            const planModalInstance = bootstrap.Modal.getInstance(planModalEl);
            if (planModalInstance) planModalInstance.hide();
          } catch(e) {}
          planModalEl.classList.remove('show');
          planModalEl.style.display = 'none';
          planModalEl.setAttribute('aria-hidden', 'true');
          planModalEl.removeAttribute('aria-modal');
        }
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        if (typeof window.switchWorkspaceView === 'function') {
          window.switchWorkspaceView('pemetaan');
        } else {
          const lView = document.getElementById('viewLandingCards');
          const mView = document.getElementById('viewMatrixWorkspace');
          const pView = document.getElementById('mapPemetaanOverlay');
          if (lView) lView.style.display = 'none';
          if (mView) mView.style.display = 'none';
          if (pView) pView.style.display = 'flex';
        }

        const overlay = document.getElementById('mapPemetaanOverlay');
        if (overlay) overlay.style.display = 'flex';

        // Inisialisasi peta setelah overlay visible (agar ukuran container terdeteksi)
        setTimeout(function () {
          if (pemetaanMap) {
            pemetaanMap.remove(); // destroy dulu jika sudah ada
            pemetaanMap = null;
          }

          const mapContainerEl = document.getElementById('mapPemetaanContainer');
          if (mapContainerEl) {
            mapContainerEl._leaflet_id = null; // Clear existing Leaflet ID if any
          }

          pemetaanMap = L.map('mapPemetaanContainer', {
            center: [0.5435, 123.0595], // Gorontalo
            zoom: 15,
            minZoom: 3,
            maxZoom: 20,
            zoomControl: true,
            attributionControl: true,
            dragging: true,
            scrollWheelZoom: true,
            doubleClickZoom: false,
            easeLinearity: 0.25,
          });

          // Pastikan dragging & scroll wheel aktif secara eksplisit
          pemetaanMap.dragging.enable();
          pemetaanMap.scrollWheelZoom.enable();

          [100, 300, 600, 1000].forEach(function(delay) {
            setTimeout(function() {
              if (pemetaanMap) {
                pemetaanMap.invalidateSize(true);
              }
            }, delay);
          });

          // === LAYER 1: Esri World Imagery (Satelit) ===
          // className dipakai untuk menerapkan CSS filter ala Google Earth
          L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            {
              attribution: 'Imagery &copy; <a href="https://www.esri.com/">Esri</a>',
              maxNativeZoom: 19,
              maxZoom: 20,
              className: 'esri-satellite-layer',
            }
          ).addTo(pemetaanMap);

          // Injeksi CSS filter satelit (sekali saja)
          if (!document.getElementById('esriSatelliteStyle')) {
            const satStyle = document.createElement('style');
            satStyle.id = 'esriSatelliteStyle';
            satStyle.textContent = `
              /* Subtle natural tone — mendekati Google Earth tanpa efek artifisial */
              .esri-satellite-layer {
                filter:
                  brightness(1.04)   /* sangat tipis, tidak washing out detail */
                  saturate(1.08)     /* sedikit lebih kaya warna, tetap natural */
                  sepia(0.06);       /* sedikit warm tone ala Google Earth */
              }
            `;
            document.head.appendChild(satStyle);
          }

          // === LAYER 2: Esri World Boundaries and Places (Label resmi Esri, bersih tanpa watermark & tanpa garis aneh jalan) ===
          L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}',
            {
              attribution: '&copy; <a href="https://www.esri.com/">Esri</a>',
              maxZoom: 20,
              maxNativeZoom: 19,
              opacity: 0.95,
            }
          ).addTo(pemetaanMap);

          // CSS untuk label layer + tooltip POI + divIcon POI (injeksi sekali)
          if (!document.getElementById('mapLabelStyle')) {
            const lblStyle = document.createElement('style');
            lblStyle.id = 'mapLabelStyle';
            lblStyle.textContent = `
              /* Paksa teks label CartoDB menjadi putih murni dengan outline hitam tegas */
              .carto-dark-labels {
                opacity: 1;
                filter: brightness(2.2) contrast(1.6);
              }

              /* Tooltip POI: transparan, hanya teks dengan outline hitam */
              .poi-label-tooltip {
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                padding: 2px 0 0 6px !important;
              }
              .poi-label-tooltip::before {
                display: none !important;
              }

              /* [OPTIMIZED] divIcon POI — pakai CSS class + custom property, bukan inline style per marker */
              .poi-icon-wrap {
                width: 30px; height: 30px;
                background: var(--poi-bg, #fff);
                border: 2px solid var(--poi-color, #333);
                border-radius: 50% 50% 50% 0;
                transform: rotate(-45deg);
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 2px 6px rgba(0,0,0,0.35);
                cursor: pointer;
              }
              .poi-icon-wrap i {
                transform: rotate(45deg);
                color: var(--poi-color, #333);
                font-size: 13px;
              }

              /* [OPTIMIZED] Teks tooltip — pakai -webkit-text-stroke, lebih ringan dari 8× text-shadow */
              .poi-tooltip-text {
                font-family: 'Inter', Arial, sans-serif;
                font-size: 20.5px;
                font-weight: 700;
                color: #ffffff;
                -webkit-text-stroke: 0.8px #000;
                letter-spacing: 0.3px;
                white-space: nowrap;
              }
            `;
            document.head.appendChild(lblStyle);
          }

          // Paksa ukuran ulang agar tile terrender sempurna
          pemetaanMap.invalidateSize();

          // ===== LAYER 3: POI dari Overpass API (OpenStreetMap) =====
          let poiLayerGroup = L.layerGroup().addTo(pemetaanMap);
          let poiFetchTimeout = null;
          let poiLoadingDiv  = null;


          // Definisi kategori POI: query tag, warna, ikon Bootstrap Icons
          const POI_CATEGORIES = [
            { tag: 'amenity', val: 'hospital',        color: '#E53E3E', bg: '#FFF5F5', icon: 'bi-hospital-fill',         label: 'Rumah Sakit'     },
            { tag: 'amenity', val: 'clinic',          color: '#E53E3E', bg: '#FFF5F5', icon: 'bi-hospital',               label: 'Klinik'          },
            { tag: 'amenity', val: 'pharmacy',        color: '#38A169', bg: '#F0FFF4', icon: 'bi-capsule-pill',           label: 'Apotek'          },
            { tag: 'amenity', val: 'school',          color: '#3182CE', bg: '#EBF8FF', icon: 'bi-mortarboard-fill',       label: 'Sekolah'         },
            { tag: 'amenity', val: 'university',      color: '#2B6CB0', bg: '#EBF8FF', icon: 'bi-building-fill',          label: 'Universitas'     },
            { tag: 'amenity', val: 'place_of_worship',color: '#805AD5', bg: '#FAF5FF', icon: 'bi-geo-alt-fill',           label: 'Tempat Ibadah'  },
            { tag: 'amenity', val: 'bank',            color: '#D69E2E', bg: '#FFFFF0', icon: 'bi-bank2',                  label: 'Bank'            },
            { tag: 'amenity', val: 'atm',             color: '#D69E2E', bg: '#FFFFF0', icon: 'bi-cash-coin',              label: 'ATM'             },
            { tag: 'amenity', val: 'fuel',            color: '#DD6B20', bg: '#FFFAF0', icon: 'bi-fuel-pump-fill',         label: 'SPBU'            },
            { tag: 'amenity', val: 'police',          color: '#2C5282', bg: '#EBF8FF', icon: 'bi-shield-fill',            label: 'Kantor Polisi'  },
            { tag: 'office',  val: 'government',      color: '#2D3748', bg: '#F7FAFC', icon: 'bi-buildings-fill',         label: 'Pemerintahan'   },
            { tag: 'amenity', val: 'marketplace',     color: '#744210', bg: '#FFFFF0', icon: 'bi-bag-fill',               label: 'Pasar'           },
            { tag: 'amenity', val: 'restaurant',      color: '#C05621', bg: '#FFFAF0', icon: 'bi-cup-hot-fill',           label: 'Restoran'        },
          ];

          // Buat peta lookup: "amenity=hospital" → kategori
          const tagMap = {};
          POI_CATEGORIES.forEach(cat => { tagMap[`${cat.tag}=${cat.val}`] = cat; });

          // [OPTIMIZED] divIcon menggunakan CSS class + CSS custom properties
          // Tidak membuat style inline baru per marker — shared class, hanya custom property yang unik
          function makePOIIcon(cat) {
            return L.divIcon({
              className: '',
              html: `<div class="poi-icon-wrap" style="--poi-bg:${cat.bg};--poi-color:${cat.color};">
                       <i class="${cat.icon}"></i>
                     </div>`,
              iconSize: [30, 30],
              iconAnchor: [15, 30],
              popupAnchor: [0, -32],
            });
          }

          // Tampilkan / sembunyikan loading indicator
          function showPOILoading(show) {
            if (!poiLoadingDiv) {
              poiLoadingDiv = document.createElement('div');
              poiLoadingDiv.style.cssText =
                'position:absolute;bottom:28px;right:10px;z-index:1000;' +
                'background:rgba(0,0,0,0.65);color:white;' +
                'padding:5px 10px;border-radius:20px;font-size:0.75rem;' +
                'display:flex;align-items:center;gap:6px;backdrop-filter:blur(4px);';
              poiLoadingDiv.innerHTML =
                '<span style="width:8px;height:8px;border-radius:50%;background:#38A169;' +
                'animation:poiPulse 1s infinite;display:inline-block;"></span>Memuat POI...';
              document.getElementById('mapPemetaanContainer').appendChild(poiLoadingDiv);
              // keyframe animasi
              if (!document.getElementById('poiPulseStyle')) {
                const s = document.createElement('style');
                s.id = 'poiPulseStyle';
                s.textContent = '@keyframes poiPulse{0%,100%{opacity:1}50%{opacity:.3}}';
                document.head.appendChild(s);
              }
            }
            poiLoadingDiv.style.display = show ? 'flex' : 'none';
          }

          // [OPTIMIZED] AbortController — cancel request lama jika ada fetch baru dimulai
          let poiAbortController = null;

          // Fetch + render POI dari Overpass
          async function fetchAndRenderPOI() {
            const zoom = pemetaanMap.getZoom();

            // [OPTIMIZED] Zoom guard dinaikkan 13 → 14 — area query lebih kecil, response lebih cepat
            if (zoom < 14) {
              poiLayerGroup.clearLayers();
              // Tampilkan petunjuk zoom-in jika user berada di zoom 13
              if (zoom === 13) {
                if (!document.getElementById('poiZoomHint')) {
                  const hint = document.createElement('div');
                  hint.id = 'poiZoomHint';
                  hint.style.cssText =
                    'position:absolute;bottom:28px;left:50%;transform:translateX(-50%);z-index:1000;' +
                    'background:rgba(0,0,0,0.6);color:rgba(255,255,255,0.9);' +
                    'padding:5px 14px;border-radius:20px;font-size:0.72rem;' +
                    'backdrop-filter:blur(4px);white-space:nowrap;pointer-events:none;';
                  hint.textContent = '🔍 Zoom in lebih dekat untuk melihat lokasi sekitar';
                  document.getElementById('mapPemetaanContainer').appendChild(hint);
                  setTimeout(() => hint.remove(), 3000);
                }
              }
              return;
            }

            // [OPTIMIZED] Cancel request sebelumnya jika masih berjalan
            if (poiAbortController) {
              poiAbortController.abort();
            }
            poiAbortController = new AbortController();
            const signal = poiAbortController.signal;

            const b = pemetaanMap.getBounds();
            const bbox = `${b.getSouth().toFixed(5)},${b.getWest().toFixed(5)},${b.getNorth().toFixed(5)},${b.getEast().toFixed(5)}`;

            // Bangun query Overpass
            const tagConditions = POI_CATEGORIES.map(cat =>
              `node["${cat.tag}"="${cat.val}"](${bbox});`
            ).join('\n              ');

            const query = `[out:json][timeout:25];
              (
              ${tagConditions}
              );
              out body;`;

            // Daftar server Overpass sebagai fallback
            const OVERPASS_SERVERS = [
              'https://overpass.kumi.systems/api/interpreter',
              'https://overpass-api.de/api/interpreter',
              'https://maps.mail.ru/osm/tools/overpass/api/interpreter',
            ];

            // Fungsi fetch ke satu server dengan POST (lebih andal dari GET)
            async function fetchOverpass(url) {
              const r = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'data=' + encodeURIComponent(query),
                signal,
              });
              if (!r.ok) throw new Error('HTTP ' + r.status);
              return r.json();
            }

            showPOILoading(true);
            try {
              // Coba server satu per satu sampai berhasil
              let data = null;
              let lastErr = null;
              for (const serverUrl of OVERPASS_SERVERS) {
                try {
                  data = await fetchOverpass(serverUrl);
                  break; // berhasil, hentikan loop
                } catch (e) {
                  if (e.name === 'AbortError') throw e; // propagate abort
                  lastErr = e;
                  console.warn('Overpass server gagal, coba berikutnya:', serverUrl, e.message);
                }
              }
              if (!data) throw lastErr;
              poiLayerGroup.clearLayers();

              // [OPTIMIZED] Batasi maksimum 100 marker agar DOM tidak berat di area padat
              const MAX_MARKERS = 100;
              let markerCount = 0;
              let totalFiltered = 0;

              for (const el of data.elements) {
                // Guard: hanya proses node yang punya koordinat valid
                if (el.type !== 'node' || !el.lat || !el.lon) continue;
                const tags = el.tags || {};

                // Tentukan kategori
                let cat = null;
                for (const key of Object.keys(tagMap)) {
                  const [k, v] = key.split('=');
                  if (tags[k] === v) { cat = tagMap[key]; break; }
                }
                if (!cat) continue;

                totalFiltered++;

                // Stop setelah MAX_MARKERS
                if (markerCount >= MAX_MARKERS) continue;
                markerCount++;

                const name = tags.name || tags['name:id'] || tags['name:en'] || cat.label;
                const marker = L.marker([el.lat, el.lon], { icon: makePOIIcon(cat) });

                // [OPTIMIZED] Tooltip menggunakan class .poi-tooltip-text (bukan 8× text-shadow inline)
                marker.bindTooltip(
                  `<span class="poi-tooltip-text">${name}</span>`,
                  {
                    permanent: false,
                    direction: 'right',
                    offset: [8, -14],
                    className: 'poi-label-tooltip',
                  }
                );

                marker.bindPopup(`
                  <div style="font-family:'Inter',sans-serif;min-width:170px;padding:4px 0;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                      <span style="width:28px;height:28px;background:${cat.bg};border:2px solid ${cat.color};
                        border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="${cat.icon}" style="color:${cat.color};font-size:14px;"></i>
                      </span>
                      <span style="font-weight:700;font-size:0.88rem;color:#1A202C;">${name}</span>
                    </div>
                    <div style="font-size:0.75rem;color:#718096;">
                      <span style="background:${cat.bg};color:${cat.color};border-radius:12px;
                        padding:2px 8px;font-weight:600;font-size:0.7rem;">${cat.label}</span>
                    </div>
                    ${tags['addr:street'] ? `<div style="font-size:0.75rem;color:#4A5568;margin-top:5px;">📍 ${tags['addr:street']}</div>` : ''}
                    ${tags.phone ? `<div style="font-size:0.75rem;color:#4A5568;">📞 ${tags.phone}</div>` : ''}
                  </div>
                `, { maxWidth: 240 });

                poiLayerGroup.addLayer(marker);
              }

              // [OPTIMIZED] Tampilkan notif jika ada POI yang dipotong karena limit
              const existingNotice = document.getElementById('poiLimitNotice');
              if (existingNotice) existingNotice.remove();
              if (totalFiltered > MAX_MARKERS) {
                const notice = document.createElement('div');
                notice.id = 'poiLimitNotice';
                notice.style.cssText =
                  'position:absolute;bottom:28px;left:50%;transform:translateX(-50%);z-index:1000;' +
                  'background:rgba(0,0,0,0.6);color:rgba(255,255,255,0.85);' +
                  'padding:4px 12px;border-radius:20px;font-size:0.70rem;' +
                  'backdrop-filter:blur(4px);white-space:nowrap;pointer-events:none;';
                notice.textContent = `⚠️ Menampilkan ${MAX_MARKERS} dari ${totalFiltered} lokasi — zoom in untuk melihat area lebih spesifik`;
                document.getElementById('mapPemetaanContainer').appendChild(notice);
                setTimeout(() => { if (notice.parentNode) notice.remove(); }, 5000);
              }

            } catch (err) {
              // Abaikan error jika memang sengaja di-abort
              if (err.name !== 'AbortError') {
                console.warn('Overpass POI fetch error:', err);
              }
            } finally {
              showPOILoading(false);
            }
          }

          // Trigger fetch dengan debounce 800ms setelah peta berhenti bergerak
          function schedulePOIFetch() {
            clearTimeout(poiFetchTimeout);
            poiFetchTimeout = setTimeout(fetchAndRenderPOI, 800);
          }

          pemetaanMap.on('moveend', schedulePOIFetch);
          pemetaanMap.on('zoomend', schedulePOIFetch);

          // Fetch pertama kali saat peta dibuka
          schedulePOIFetch();
          // ===== END POI =====

          // ===== ADD PLACEMARK & TARIK KABEL FEATURE =====
          let isAddingPlacemark = false;       // Mode tambah placemark aktif/tidak
          let isDrawingCable    = false;       // Mode tarik kabel aktif/tidak
          let pendingMarker     = null;        // Marker sementara sebelum disimpan
          let pendingLatLng     = null;        // Koordinat yang diklik untuk placemark
          let lastPlacemarkConfig = null;      // Memori 1 sesi pengisian placemark sebelumnya

          // Deklarasikan sebagai window property agar bisa diakses global
          window.addedPlacemarks   = [];       // Array placemark titik: [{name, category, notes, lat, lng}]
          const addedPlacemarks    = window.addedPlacemarks; // alias lokal untuk backward compat
          const addedMarkerLayers  = [];       // Leaflet marker layers

          let currentCablePoints   = [];       // Koordinat titik kabel yang sedang ditarik: [{lat, lng}]
          let currentCablePolyline = null;     // Leaflet polyline layer saat ditarik
          let currentCableMarkers  = [];       // Leaflet dot markers pada vertex kabel
          window.addedCables       = [];       // Array kabel: [{name, type, length, coordinates: [{lat, lng}]}]
          const addedCables        = window.addedCables;     // alias lokal untuk backward compat
          const addedCableLayers   = [];       // Leaflet polyline layers untuk kabel tersimpan

          // Tipe Titik SOP Telkom (sesuai shape Google Earth)
          const PM_SHAPES = {
            triangle: {
              label: 'Triangle',
              kmlIconHref: 'http://maps.google.com/mapfiles/kml/shapes/triangle.png',
              defaultFill: '#EE3124',
              defaultOutline: '#ffffff',
            },
            donut: {
              label: 'Donut',
              kmlIconHref: 'http://maps.google.com/mapfiles/kml/shapes/donut.png',
              defaultFill: '#000000',
              defaultOutline: '#ffffff',
            },
            square: {
              label: 'Square',
              kmlIconHref: 'http://maps.google.com/mapfiles/kml/shapes/square.png',
              defaultFill: '#0000ff',
              defaultOutline: '#ffffff',
            },
          };

          // Buat SVG string untuk shape hollow (mirip Google Earth icon)
          // fill  = warna garis/stroke (badan)
          // outline = tidak dipakai sebagai stroke lagi, hanya stroke-warna = fill
          function makePmSvgHtml(shape, fill, outline, size) {
            const s        = size || 28;
            const sw       = Math.max(3,   s * 0.22); // ketebalan donut (ring)
            const swShape  = Math.max(1.8, s * 0.13); // ketebalan segitiga & kotak
            const outlineW = 1.5; // ketebalan outline yang tampak (1.5px)
            const ol       = outlineW * 2; // total stroke tambahan (3.0px) agar outline tampak persis 1.5px di tiap sisi
            if (shape === 'donut') {
              // Ring/Donut — dua lapis: outline di bawah, ring utama di atas (tebal outline seragam 0.5px)
              const ringW = sw;
              const r     = (s / 2) - ringW / 2 - 0.5;
              return `<svg width="${s}" height="${s}" viewBox="0 0 ${s} ${s}" style="overflow:visible;" xmlns="http://www.w3.org/2000/svg">
                <circle cx="${s/2}" cy="${s/2}" r="${r}" fill="none" stroke="${outline}" stroke-width="${ringW + ol}"/>
                <circle cx="${s/2}" cy="${s/2}" r="${r}" fill="none" stroke="${fill}"   stroke-width="${ringW}"/>
              </svg>`;
            } else if (shape === 'square') {
              // Square — dua lapis: outline di bawah, kotak utama di atas (tebal outline seragam 0.5px)
              const pad = swShape / 2 + 1.5;
              return `<svg width="${s}" height="${s}" viewBox="0 0 ${s} ${s}" style="overflow:visible;" xmlns="http://www.w3.org/2000/svg">
                <rect x="${pad}" y="${pad}" width="${s-pad*2}" height="${s-pad*2}" rx="1" fill="none" stroke="${outline}" stroke-width="${swShape + ol}" stroke-linejoin="round"/>
                <rect x="${pad}" y="${pad}" width="${s-pad*2}" height="${s-pad*2}" rx="1" fill="none" stroke="${fill}"   stroke-width="${swShape}"      stroke-linejoin="round"/>
              </svg>`;
            } else {
              // Triangle — dua lapis: outline di bawah, segitiga utama di atas (tebal outline seragam 0.5px)
              const pad = swShape / 2 + 1.5;
              const x1 = s/2,   y1 = pad;
              const x2 = s-pad, y2 = s-pad;
              const x3 = pad,   y3 = s-pad;
              const pts = `${x1},${y1} ${x2},${y2} ${x3},${y3}`;
              return `<svg width="${s}" height="${s}" viewBox="0 0 ${s} ${s}" style="overflow:visible;" xmlns="http://www.w3.org/2000/svg">
                <polygon points="${pts}" fill="none" stroke="${outline}" stroke-width="${swShape + ol}" stroke-linejoin="round"/>
                <polygon points="${pts}" fill="none" stroke="${fill}"   stroke-width="${swShape}"      stroke-linejoin="round"/>
              </svg>`;
            }
          }

          function makePmIcon(shape, fillColor, outlineColor) {
            const shapeKey = (shape in PM_SHAPES) ? shape : 'triangle';
            const fill    = fillColor    || PM_SHAPES[shapeKey].defaultFill;
            const outline = outlineColor || PM_SHAPES[shapeKey].defaultOutline;
            const s = 24;
            const svgHtml = makePmSvgHtml(shapeKey, fill, outline, s);
            // anchor: triangle → base center, donut/square → center
            const anchorY = (shapeKey === 'triangle') ? s : s / 2;
            return L.divIcon({
              className: '',
              html: `<div style="filter:drop-shadow(0 2px 6px rgba(0,0,0,0.55));width:${s}px;height:${s}px;">${svgHtml}</div>`,
              iconSize:    [s, s],
              iconAnchor:  [s / 2, anchorY],
              popupAnchor: [0, -anchorY - 4],
            });
          }

          // Update preview ikon di menu pemilihan shape (ukuran 24px persis sesuai ukuran marker asli di peta)
          function updateShapeButtonPreviews() {
            const currentShape = (document.getElementById('pmInputShape') && document.getElementById('pmInputShape').value) || 'triangle';
            const fillColor    = document.getElementById('pmColorFill') ? document.getElementById('pmColorFill').value : null;
            const outlineColor = document.getElementById('pmColorOutline') ? document.getElementById('pmColorOutline').value : null;

            document.querySelectorAll('.pm-shape-btn').forEach(function(btn) {
              const shape = btn.getAttribute('data-shape');
              const shapeInfo = PM_SHAPES[shape] || PM_SHAPES.triangle;
              const fill    = (shape === currentShape) ? (fillColor || shapeInfo.defaultFill) : shapeInfo.defaultFill;
              const outline = (shape === currentShape) ? (outlineColor || shapeInfo.defaultOutline) : shapeInfo.defaultOutline;
              
              const iconWrap = btn.querySelector('.pm-shape-icon-wrap');
              if (iconWrap) {
                iconWrap.innerHTML = makePmSvgHtml(shape, fill, outline, 24);
              }
            });
          }
          updateShapeButtonPreviews();

          function updatePmBadge() {
            const totalItems = addedPlacemarks.length + addedCables.length;
            document.getElementById('pmCountBadge').textContent = totalItems;
            document.getElementById('pmListCount').textContent = totalItems;
            const exportBtn = document.getElementById('btnExportPmKml');
            if (exportBtn) {
              exportBtn.style.display = 'flex';
              exportBtn.disabled = (totalItems === 0);
              exportBtn.style.opacity = totalItems > 0 ? '1' : '0.45';
              exportBtn.style.cursor = totalItems > 0 ? 'pointer' : 'not-allowed';
            }
            const saveBtn = document.getElementById('btnSaveToDatabase');
            if (saveBtn) {
              saveBtn.style.display = 'flex';
              saveBtn.disabled = (totalItems === 0);
              saveBtn.style.opacity = totalItems > 0 ? '1' : '0.45';
              saveBtn.style.cursor = totalItems > 0 ? 'pointer' : 'not-allowed';
            }
            const pSummary = document.getElementById('pemetaanSummaryPoints');
            if (pSummary) pSummary.textContent = addedPlacemarks.length + ' titik';
            const cSummary = document.getElementById('pemetaanSummaryCables');
            if (cSummary) {
              const totalMeters = addedCables.reduce((acc, c) => acc + (c.lengthMeters || 0), 0);
              cSummary.textContent = totalMeters >= 1000 ? (totalMeters/1000).toFixed(2) + ' km' : Math.round(totalMeters) + ' m';
            }
          }

          function renderPmList() {
            const scroll = document.getElementById('pmListScroll');
            const empty  = document.getElementById('pmEmptyState');
            const totalItems = addedPlacemarks.length + addedCables.length;

            if (totalItems === 0) {
              empty.style.display = 'block';
              Array.from(scroll.children).forEach(c => { if (c !== empty) c.remove(); });
              return;
            }
            empty.style.display = 'none';
            Array.from(scroll.children).forEach(c => { if (c !== empty) c.remove(); });

            // 1. Render Jalur Kabel jika ada
            if (addedCables.length > 0) {
              const cableHeader = document.createElement('div');
              cableHeader.style.cssText = 'font-size:0.7rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin:6px 4px 4px; letter-spacing:0.5px;';
              cableHeader.textContent = `🔌 Jalur Kabel (${addedCables.length})`;
              scroll.appendChild(cableHeader);

              addedCables.forEach((cable, idx) => {
                const item = document.createElement('div');
                item.className = 'pm-list-item';
                item.innerHTML = `
                  <div class="pm-list-icon" style="background:#805AD5;">
                    <i class="bi bi-bezier2"></i>
                  </div>
                  <div class="pm-list-info" style="cursor:pointer;">
                    <div class="pm-list-name" title="${escapeXml(cable.name)}">${escapeXml(cable.name)}</div>
                    <div class="pm-list-cat">${escapeXml(cable.type)}  •  ${cable.length.toFixed(1)}m</div>
                    <div class="pm-list-coords">${cable.coordinates.length} titik koordinat</div>
                  </div>
                  <button class="pm-list-delete" title="Hapus kabel ini" onclick="deleteCable(${idx})">
                    <i class="bi bi-trash"></i>
                  </button>
                `;
                item.querySelector('.pm-list-info').addEventListener('click', () => {
                  if (cable.coordinates.length > 0) {
                    const bounds = L.latLngBounds(cable.coordinates.map(c => [c.lat, c.lng]));
                    pemetaanMap.fitBounds(bounds, { padding: [40, 40] });
                    const layer = addedCableLayers[idx];
                    if (layer) layer.openPopup();
                  }
                });
                scroll.appendChild(item);

                // Update popup kabel di peta dengan tombol hapus
                if (addedCableLayers[idx]) {
                  addedCableLayers[idx].bindPopup(`
                    <div style="font-family:'Inter',sans-serif;min-width:180px;padding:4px 0;">
                      <div style="font-weight:700;font-size:0.88rem;color:#1A202C;margin-bottom:4px;">🔌 ${escapeXml(cable.name)}</div>
                      <div style="font-size:0.75rem;color:#805AD5;font-weight:600;margin-bottom:4px;">${escapeXml(cable.type)}</div>
                      <div style="font-size:0.72rem;color:#718096;">📏 Panjang: <strong>${cable.length.toFixed(1)} m</strong> (${cable.coordinates.length} titik)</div>
                      <button type="button" onclick="deleteCable(${idx})" class="btn btn-sm btn-outline-danger w-100 mt-2 py-1" style="font-size:0.75rem; border-radius:6px; font-weight:600;">
                        <i class="bi bi-trash me-1"></i>Hapus Jalur Kabel
                      </button>
                    </div>
                  `);
                }
              });
            }

            // 2. Render Placemark Titik jika ada
            if (addedPlacemarks.length > 0) {
              const pmHeader = document.createElement('div');
              pmHeader.style.cssText = 'font-size:0.7rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin:10px 4px 4px; letter-spacing:0.5px;';
              pmHeader.textContent = `📍 Titik Placemark (${addedPlacemarks.length})`;
              scroll.appendChild(pmHeader);

              addedPlacemarks.forEach((pm, idx) => {
                const shapeInfo = PM_SHAPES[pm.shape] || PM_SHAPES.triangle;
                const fill    = pm.fillColor    || shapeInfo.defaultFill;
                const outline = pm.outlineColor || shapeInfo.defaultOutline;
                const svgThumb = makePmSvgHtml(pm.shape || 'triangle', fill, outline, 22);
                const item = document.createElement('div');
                item.className = 'pm-list-item';
                item.innerHTML = `
                  <div class="pm-list-icon" style="background:transparent;overflow:visible;">${svgThumb}</div>
                  <div class="pm-list-info" style="cursor:pointer;">
                    <div class="pm-list-name" title="${escapeXml(pm.name)}">${escapeXml(pm.name)}</div>
                    <div class="pm-list-cat">${shapeInfo.label}${pm.notes ? '  •  ' + escapeXml(pm.notes.substring(0, 30)) + (pm.notes.length > 30 ? '…' : '') : ''}</div>
                    <div class="pm-list-coords">${pm.lat.toFixed(6)}, ${pm.lng.toFixed(6)}</div>
                  </div>
                  <button class="pm-list-delete" title="Hapus placemark ini" onclick="deletePlacemark(${idx})">
                    <i class="bi bi-trash"></i>
                  </button>
                `;
                item.querySelector('.pm-list-info').addEventListener('click', () => {
                  pemetaanMap.flyTo([pm.lat, pm.lng], 18, { animate: true, duration: 0.8 });
                  const layer = addedMarkerLayers[idx];
                  if (layer) layer.openPopup();
                });
                scroll.appendChild(item);

                // Update popup placemark di peta dengan tombol hapus
                if (addedMarkerLayers[idx]) {
                  const svgPopup = makePmSvgHtml(pm.shape || 'triangle', fill, outline, 28);
                  addedMarkerLayers[idx].bindPopup(`
                    <div style="font-family:'Inter',sans-serif;min-width:180px;padding:4px 0;">
                      <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                        <span style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">${svgPopup}</span>
                        <span style="font-weight:700;font-size:0.88rem;color:#1A202C;">${escapeXml(pm.name)}</span>
                      </div>
                      <div style="margin-bottom:4px;">
                        <span style="background:${fill}22;color:${fill};border-radius:10px;
                          padding:2px 8px;font-size:0.7rem;font-weight:600;border:1px solid ${fill}44;">${shapeInfo.label}</span>
                      </div>
                      ${pm.notes ? `<div style="font-size:0.75rem;color:#4A5568;margin-top:5px;">${escapeXml(pm.notes)}</div>` : ''}
                      <div style="font-size:0.68rem;color:#A0AEC0;margin-top:5px;font-family:monospace;">
                        ${pm.lat.toFixed(6)}, ${pm.lng.toFixed(6)}
                      </div>
                      <button type="button" onclick="deletePlacemark(${idx})" class="btn btn-sm btn-outline-danger w-100 mt-2 py-1" style="font-size:0.75rem; border-radius:6px; font-weight:600;">
                        <i class="bi bi-trash me-1"></i>Hapus Titik Ini
                      </button>
                    </div>
                  `, { maxWidth: 240 });
                }
              });
            }

            updatePmBadge();
          }
          window.renderPmList = renderPmList;

          // Hapus satu placemark
          window.deletePlacemark = function(idx) {
            if (idx < 0 || idx >= addedPlacemarks.length) return;
            const pmName = addedPlacemarks[idx].name;
            const doDelete = function() {
              const layer = addedMarkerLayers[idx];
              if (layer) pemetaanMap.removeLayer(layer);
              addedPlacemarks.splice(idx, 1);
              addedMarkerLayers.splice(idx, 1);
              renderPmList();
              updatePmBadge();
              pmNotif(`Placemark "${pmName}" telah dihapus.`, 'info');
            };
            if (typeof window.showDarkConfirm === 'function') {
              window.showDarkConfirm({
                title: 'Hapus Placemark?',
                message: `Hapus placemark <strong>"${pmName}"</strong>?`,
                confirmText: 'Ya, Hapus',
                onConfirm: doDelete
              });
            } else if (confirm(`Hapus placemark "${pmName}"?`)) {
              doDelete();
            }
          };

          // Hapus satu kabel
          window.deleteCable = function(idx) {
            if (idx < 0 || idx >= addedCables.length) return;
            const cableName = addedCables[idx].name;
            const doDelete = function() {
              const layer = addedCableLayers[idx];
              if (layer) pemetaanMap.removeLayer(layer);
              addedCables.splice(idx, 1);
              addedCableLayers.splice(idx, 1);
              renderPmList();
              updatePmBadge();
              pmNotif(`Jalur kabel "${cableName}" telah dihapus.`, 'info');
            };
            if (typeof window.showDarkConfirm === 'function') {
              window.showDarkConfirm({
                title: 'Hapus Kabel?',
                message: `Hapus jalur kabel <strong>"${cableName}"</strong>?`,
                confirmText: 'Ya, Hapus',
                onConfirm: doDelete
              });
            } else if (confirm(`Hapus jalur kabel "${cableName}"?`)) {
              doDelete();
            }
          };

          // Hapus hanya semua titik placemark
          window.clearAllPlacemarksOnly = function() {
            if (addedPlacemarks.length === 0) {
              pmNotif('Tidak ada titik placemark untuk dihapus.', 'warning');
              return;
            }
            const count = addedPlacemarks.length;
            const doClear = function() {
              addedMarkerLayers.forEach(l => pemetaanMap.removeLayer(l));
              addedPlacemarks.length = 0;
              addedMarkerLayers.length = 0;
              lastPlacemarkConfig = null;
              renderPmList();
              updatePmBadge();
              pmNotif(`Seluruh ${count} titik placemark telah dihapus.`, 'warning');
            };
            if (typeof window.showDarkConfirm === 'function') {
              window.showDarkConfirm({
                title: 'Hapus Semua Placemark?',
                message: `Apakah Anda yakin ingin menghapus seluruh <strong>${count} titik placemark</strong>?`,
                confirmText: 'Ya, Hapus Semua',
                onConfirm: doClear
              });
            } else if (confirm(`Hapus SEMUA ${count} titik placemark?`)) {
              doClear();
            }
          };

          // Hapus hanya semua jalur kabel
          window.clearAllCablesOnly = function() {
            if (addedCables.length === 0) {
              pmNotif('Tidak ada jalur kabel untuk dihapus.', 'warning');
              return;
            }
            const count = addedCables.length;
            const doClear = function() {
              addedCableLayers.forEach(l => pemetaanMap.removeLayer(l));
              addedCables.length = 0;
              addedCableLayers.length = 0;
              renderPmList();
              updatePmBadge();
              pmNotif(`Seluruh ${count} jalur kabel telah dihapus.`, 'warning');
            };
            if (typeof window.showDarkConfirm === 'function') {
              window.showDarkConfirm({
                title: 'Hapus Semua Kabel?',
                message: `Apakah Anda yakin ingin menghapus seluruh <strong>${count} jalur kabel</strong>?`,
                confirmText: 'Ya, Hapus Semua',
                onConfirm: doClear
              });
            } else if (confirm(`Hapus SEMUA ${count} jalur kabel?`)) {
              doClear();
            }
          };

          // Hapus semua placemark & kabel sekaligus
          window.clearAllPlacemarks = function() {
            const total = addedPlacemarks.length + addedCables.length;
            if (total === 0) {
              pmNotif('Tidak ada data placemark atau kabel untuk dihapus.', 'warning');
              return;
            }
            const pmCount = addedPlacemarks.length;
            const cbCount = addedCables.length;
            const doClear = function() {
              addedMarkerLayers.forEach(l => pemetaanMap.removeLayer(l));
              addedCableLayers.forEach(l => pemetaanMap.removeLayer(l));
              addedPlacemarks.length = 0;
              addedMarkerLayers.length = 0;
              addedCables.length = 0;
              addedCableLayers.length = 0;
              renderPmList();
              updatePmBadge();
              pmNotif('Seluruh data placemark dan kabel telah dihapus.', 'warning');
            };
            if (typeof window.showDarkConfirm === 'function') {
              window.showDarkConfirm({
                title: 'Hapus Semua Data?',
                message: `Apakah Anda yakin ingin menghapus seluruh <strong>${pmCount} placemark</strong> dan <strong>${cbCount} jalur kabel</strong>?`,
                confirmText: 'Ya, Hapus Semua',
                onConfirm: doClear
              });
            } else if (confirm(`Hapus SEMUA ${pmCount} titik placemark dan ${cbCount} kabel?`)) {
              doClear();
            }
          };

          // Hitung jarak total polyline dalam meter
          function calculatePolylineLength(points) {
            let total = 0;
            for (let i = 0; i < points.length - 1; i++) {
              total += getDistanceInMeters(points[i].lat, points[i].lng, points[i+1].lat, points[i+1].lng);
            }
            return total;
          }

          // ============================================================
          // EXPORT KML: Standar Google Earth Pro & Proyek Telkom (1:1 doc.kml)
          // ============================================================
          let _isExportingPmKml = false;
          window.exportPlacemarksKml = function() {
            if (_isExportingPmKml) {
              console.warn('⚠️ Export KML sedang diproses, mengabaikan klik duplikat.');
              return;
            }
            _isExportingPmKml = true;

            const total = addedPlacemarks.length + addedCables.length;
            if (total === 0) {
              _isExportingPmKml = false;
              pmNotif('Tidak ada placemark atau kabel untuk di-export!', 'warning');
              return;
            }

            const projectTitle = document.getElementById('mapPlanTitle')
              ? document.getElementById('mapPlanTitle').textContent.trim() || 'Plan New KML'
              : 'Plan New KML';

            // 1. Kelompokkan placemark berdasarkan shape SOP Telkom
            const groups = {
              triangle: [],   // → NEW / Site TOP & Triangle shapes
              donut:    [],   // → EKSISTING / TIANG & Donut shapes
              square:   [],   // → NEW / ODP-OTB & Square shapes
            };
            addedPlacemarks.forEach(pm => {
              const key = (pm.shape in groups) ? pm.shape : 'triangle';
              groups[key].push(pm);
            });

            // Helper: konversi hex warna (#rrggbb) ke format KML aabbggrr (alpha=ff)
            function hexToKmlColor(hex, alpha) {
              const a = alpha !== undefined ? alpha : 'ff';
              const c = (hex || '#ffffff').replace('#', '');
              const r = c.substring(0, 2), g = c.substring(2, 4), b = c.substring(4, 6);
              return `${a}${b}${g}${r}`.toLowerCase();
            }

            function makePointPlacemark(pm) {
              const notesXml  = escapeXml(pm.notes || '');
              const shapeInfo = PM_SHAPES[pm.shape || 'triangle'] || PM_SHAPES.triangle;
              const fill      = pm.fillColor    || shapeInfo.defaultFill;
              const outline   = pm.outlineColor || shapeInfo.defaultOutline;
              const kmlFill   = hexToKmlColor(fill);
              const kmlOutline= hexToKmlColor(outline);
              const iconHref  = shapeInfo.kmlIconHref;
              // Inline style per-placemark agar warna ikut yang dipilih user
              const inlineStyle = `<Style>
\t\t\t\t\t\t<IconStyle>
\t\t\t\t\t\t\t<color>${kmlFill}</color>
\t\t\t\t\t\t\t<scale>1.1</scale>
\t\t\t\t\t\t\t<Icon><href>${iconHref}</href></Icon>
\t\t\t\t\t\t</IconStyle>
\t\t\t\t\t\t<LabelStyle><color>${kmlFill}</color></LabelStyle>
\t\t\t\t\t</Style>`;
              return `\t\t\t\t<Placemark>
\t\t\t\t\t<name>${escapeXml(pm.name)}</name>
\t\t\t\t\t<open>1</open>
${inlineStyle}
\t\t\t\t\t<ExtendedData>
\t\t\t\t\t\t<SchemaData schemaUrl="#S_Site_ID_KSM">
\t\t\t\t\t\t\t<SimpleData name="Site_ID">${escapeXml(pm.name)}</SimpleData>
\t\t\t\t\t\t\t<SimpleData name="Lat">${pm.lat.toFixed(7)}</SimpleData>
\t\t\t\t\t\t\t<SimpleData name="Long">${pm.lng.toFixed(7)}</SimpleData>
\t\t\t\t\t\t\t${pm.notes ? `<SimpleData name="Keterangan">${notesXml}</SimpleData>` : ''}
\t\t\t\t\t\t</SchemaData>
\t\t\t\t\t</ExtendedData>
\t\t\t\t\t<Point>
\t\t\t\t\t\t<gx:drawOrder>1</gx:drawOrder>
\t\t\t\t\t\t<coordinates>${pm.lng.toFixed(13)},${pm.lat.toFixed(13)},0</coordinates>
\t\t\t\t\t</Point>
\t\t\t\t</Placemark>`;
            }

            function makeFolder(name, items) {
              if (items.length === 0) return '';
              const pms = items.map(pm => makePointPlacemark(pm)).join('\n');
              return `\t\t\t<Folder>
\t\t\t\t<name>${escapeXml(name)}</name>
\t\t\t\t<open>1</open>
${pms}
\t\t\t</Folder>`;
            }

            // 2. Susun Folder NEW (Triangle → Site TOP, Square → ODP/OTB, Route)
            const folderTriangle = makeFolder('Site TOP', groups.triangle);
            const folderSquare   = makeFolder('ODP',      groups.square);

            // Susun LineString kabel di Folder Route
            let folderRoute = '';
            if (addedCables.length > 0) {
              const cablePlacemarks = addedCables.map((c, cIdx) => {
                const coordsString = c.coordinates.map(pt => `${pt.lng.toFixed(13)},${pt.lat.toFixed(13)},0`).join(' ');
                // Format deskripsi kabel standar Telkom yang dikenali parser: Tipe kabel + panjang
                const descString = `${escapeXml(c.type)}\n${Math.round(c.length)}M\n`;
                return `\t\t\t\t<Placemark id="Route.${cIdx+1}">
\t\t\t\t\t<name>${escapeXml(c.name)}</name>
\t\t\t\t\t<description>${descString}</description>
\t\t\t\t\t<styleUrl>#dir_route_ksm</styleUrl>
\t\t\t\t\t<LineString>
\t\t\t\t\t\t<coordinates>
\t\t\t\t\t\t\t${coordsString}
\t\t\t\t\t\t</coordinates>
\t\t\t\t\t</LineString>
\t\t\t\t</Placemark>`;
              }).join('\n');

              folderRoute = `\t\t\t<Folder>
\t\t\t\t<name>Route</name>
\t\t\t\t<open>1</open>
${cablePlacemarks}
\t\t\t</Folder>`;
            }

            const folderNewParts = [folderTriangle, folderRoute, folderSquare].filter(f => f).join('\n');

            // 3. Susun Folder EKSISTING (Donut → TIANG / TE)
            const folderDonut   = makeFolder('TIANG',  groups.donut);
            const folderEksParts = [folderDonut].filter(f => f).join('\n');

            let rootFolderContent = '';
            if (folderNewParts.trim()) {
              rootFolderContent += `\t\t<Folder>
\t\t\t<name>NEW</name>
\t\t\t<open>1</open>
${folderNewParts}
\t\t</Folder>
`;
            }
            if (folderEksParts.trim()) {
              rootFolderContent += `\t\t<Folder>
\t\t\t<name>EKSISTING</name>
\t\t\t<open>1</open>
${folderEksParts}
\t\t</Folder>
`;
            }

            // Bangun KML lengkap
            const xmlDeclaration = '<' + '?xml version="1.0" encoding="UTF-8"?' + '>';
            const kmlContent = xmlDeclaration + '\n' +
`<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
\t<name>${escapeXml(projectTitle)}.kml</name>
\t<open>1</open>
\t<atom:link rel="app" href="https://www.google.com/earth/about/versions/#earth-pro" title="Google Earth Pro"></atom:link>

\t<!-- ===== SCHEMA ===== -->
\t<Schema name="Site ID" id="S_Site_ID_KSM">
\t\t<SimpleField type="string" name="Site_ID"><displayName><![CDATA[<b>Site ID</b>]]></displayName></SimpleField>
\t\t<SimpleField type="double" name="Lat"><displayName><![CDATA[<b>Lat</b>]]></displayName></SimpleField>
\t\t<SimpleField type="double" name="Long"><displayName><![CDATA[<b>Long</b>]]></displayName></SimpleField>
\t\t<SimpleField type="string" name="Keterangan"><displayName><![CDATA[<b>Keterangan</b>]]></displayName></SimpleField>
\t</Schema>

\t<!-- ===== STYLE: Jalur Kabel (LineString) ===== -->
\t<StyleMap id="dir_route_ksm">
\t\t<Pair><key>normal</key><styleUrl>#dir_route_ksm_norm</styleUrl></Pair>
\t\t<Pair><key>highlight</key><styleUrl>#dir_route_ksm_hlight</styleUrl></Pair>
\t</StyleMap>
\t<Style id="dir_route_ksm_norm">
\t\t<LineStyle><width>3</width></LineStyle>
\t</Style>
\t<Style id="dir_route_ksm_hlight">
\t\t<LineStyle><width>3</width></LineStyle>
\t</Style>

\t<!-- ===== STYLE: Tiang / TE (icon donut.png hitam - dibaca oleh parser) ===== -->
\t<StyleMap id="msn_placemark_circle_ksm">
\t\t<Pair><key>normal</key><styleUrl>#sn_placemark_circle_ksm</styleUrl></Pair>
\t\t<Pair><key>highlight</key><styleUrl>#sh_placemark_circle_ksm</styleUrl></Pair>
\t</StyleMap>
\t<Style id="sn_placemark_circle_ksm">
\t\t<IconStyle>
\t\t\t<color>ff000000</color>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href></Icon>
\t\t</IconStyle>
\t\t<BalloonStyle>
\t\t\t<text><![CDATA[<table border="0">
  <tr><td><b>Site ID</b></td><td>$[Site ID/Site_ID]</td></tr>
  <tr><td><b>Lat</b></td><td>$[Site ID/Lat]</td></tr>
  <tr><td><b>Long</b></td><td>$[Site ID/Long]</td></tr>
  <tr><td><b>Keterangan</b></td><td>$[Site ID/Keterangan]</td></tr>
</table>]]></text>
\t\t</BalloonStyle>
\t</Style>
\t<Style id="sh_placemark_circle_ksm">
\t\t<IconStyle>
\t\t\t<color>ff000000</color>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href></Icon>
\t\t</IconStyle>
\t</Style>

\t<!-- ===== STYLE: ODP (icon paddle/ltblu-circle.png) ===== -->
\t<StyleMap id="pointStyleMap_ksm_odp">
\t\t<Pair><key>normal</key><styleUrl>#normPointStyle_ksm_odp</styleUrl></Pair>
\t\t<Pair><key>highlight</key><styleUrl>#hlightPointStyle_ksm_odp</styleUrl></Pair>
\t</StyleMap>
\t<Style id="normPointStyle_ksm_odp">
\t\t<IconStyle>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/paddle/ltblu-circle.png</href></Icon>
\t\t\t<hotSpot x="32" y="1" xunits="pixels" yunits="pixels"/>
\t\t</IconStyle>
\t\t<BalloonStyle>
\t\t\t<text><![CDATA[<table border="0">
  <tr><td><b>Site ID</b></td><td>$[Site ID/Site_ID]</td></tr>
  <tr><td><b>Lat</b></td><td>$[Site ID/Lat]</td></tr>
  <tr><td><b>Long</b></td><td>$[Site ID/Long]</td></tr>
  <tr><td><b>Keterangan</b></td><td>$[Site ID/Keterangan]</td></tr>
</table>]]></text>
\t\t</BalloonStyle>
\t\t<ListStyle>
\t\t\t<ItemIcon><href>http://maps.google.com/mapfiles/kml/paddle/ltblu-circle-lv.png</href></ItemIcon>
\t\t</ListStyle>
\t</Style>
\t<Style id="hlightPointStyle_ksm_odp">
\t\t<IconStyle>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/paddle/ltblu-circle.png</href></Icon>
\t\t\t<hotSpot x="32" y="1" xunits="pixels" yunits="pixels"/>
\t\t</IconStyle>
\t\t<BalloonStyle>
\t\t\t<text><![CDATA[<table border="0">
  <tr><td><b>Site ID</b></td><td>$[Site ID/Site_ID]</td></tr>
  <tr><td><b>Lat</b></td><td>$[Site ID/Lat]</td></tr>
  <tr><td><b>Long</b></td><td>$[Site ID/Long]</td></tr>
</table>]]></text>
\t\t</BalloonStyle>
\t\t<ListStyle>
\t\t\t<ItemIcon><href>http://maps.google.com/mapfiles/kml/paddle/ltblu-circle-lv.png</href></ItemIcon>
\t\t</ListStyle>
\t</Style>

\t<!-- ===== STYLE: ODC / OTB (icon square.png biru) ===== -->
\t<StyleMap id="pointStyleMap_ksm_odc">
\t\t<Pair><key>normal</key><styleUrl>#normPointStyle_ksm_odc</styleUrl></Pair>
\t\t<Pair><key>highlight</key><styleUrl>#hlightPointStyle_ksm_odc</styleUrl></Pair>
\t</StyleMap>
\t<Style id="normPointStyle_ksm_odc">
\t\t<IconStyle>
\t\t\t<color>ff0000ff</color>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/shapes/square.png</href></Icon>
\t\t</IconStyle>
\t\t<LabelStyle><scale>0.7</scale></LabelStyle>
\t\t<BalloonStyle>
\t\t\t<text><![CDATA[<table border="0">
  <tr><td><b>Site ID</b></td><td>$[Site ID/Site_ID]</td></tr>
  <tr><td><b>Lat</b></td><td>$[Site ID/Lat]</td></tr>
  <tr><td><b>Long</b></td><td>$[Site ID/Long]</td></tr>
  <tr><td><b>Keterangan</b></td><td>$[Site ID/Keterangan]</td></tr>
</table>]]></text>
\t\t</BalloonStyle>
\t</Style>
\t<Style id="hlightPointStyle_ksm_odc">
\t\t<IconStyle>
\t\t\t<color>ff0000ff</color>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/shapes/square.png</href></Icon>
\t\t</IconStyle>
\t\t<LabelStyle><scale>0.7</scale></LabelStyle>
\t</Style>

\t<!-- ===== STYLE: Site TOP / Lokasi (icon dollar.png) ===== -->
\t<StyleMap id="pointStyleMap_ksm_dollar">
\t\t<Pair><key>normal</key><styleUrl>#normPointStyle_ksm_dollar</styleUrl></Pair>
\t\t<Pair><key>highlight</key><styleUrl>#hlightPointStyle_ksm_dollar</styleUrl></Pair>
\t</StyleMap>
\t<Style id="normPointStyle_ksm_dollar">
\t\t<IconStyle>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/shapes/dollar.png</href></Icon>
\t\t\t<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>
\t\t</IconStyle>
\t\t<BalloonStyle>
\t\t\t<text><![CDATA[<table border="0">
  <tr><td><b>Site ID</b></td><td>$[Site ID/Site_ID]</td></tr>
  <tr><td><b>Lat</b></td><td>$[Site ID/Lat]</td></tr>
  <tr><td><b>Long</b></td><td>$[Site ID/Long]</td></tr>
  <tr><td><b>Keterangan</b></td><td>$[Site ID/Keterangan]</td></tr>
</table>]]></text>
\t\t</BalloonStyle>
\t</Style>
\t<Style id="hlightPointStyle_ksm_dollar">
\t\t<IconStyle>
\t\t\t<color>ff000000</color>
\t\t\t<Icon><href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href></Icon>
\t\t</IconStyle>
\t\t<BalloonStyle>
\t\t\t<text><![CDATA[<table border="0">
  <tr><td><b>Site ID</b></td><td>$[Site ID/Site_ID]</td></tr>
  <tr><td><b>Lat</b></td><td>$[Site ID/Lat]</td></tr>
  <tr><td><b>Long</b></td><td>$[Site ID/Long]</td></tr>
</table>]]></text>
\t\t</BalloonStyle>
\t</Style>

\t<!-- ===== FOLDERS ===== -->
\t<Folder>
\t\t<name>${escapeXml(projectTitle)}</name>
\t\t<open>1</open>
${rootFolderContent}\t</Folder>
</Document>
</kml>`;

            const blob = new Blob([kmlContent], { type: 'application/vnd.google-earth.kml+xml' });
            const url  = URL.createObjectURL(blob);
            const a    = document.createElement('a');
            const ts   = new Date().toISOString().replace(/[:.]/g, '-').substring(0, 16);
            a.href     = url;
            a.download = `${projectTitle.replace(/[^a-zA-Z0-9\-_. ]/g, '_')}_${ts}.kml`;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
              if (a.parentNode) a.parentNode.removeChild(a);
              URL.revokeObjectURL(url);
              _isExportingPmKml = false;
            }, 1000);

            const meta = document.getElementById('mapPlanMeta');
            if (meta) {
              const origText = meta.textContent;
              meta.textContent = `✅ File KML berhasil di-export (${addedPlacemarks.length} titik, ${addedCables.length} kabel)`;
              setTimeout(() => { meta.textContent = origText; }, 3000);
            }
          };

          // ============================================================
          // SIMPAN KE DATABASE (Tabel kml_projects, kml_placemarks, kml_cables)
          // ============================================================
          window.savePemetaanToDatabase = function() {
            const total = addedPlacemarks.length + addedCables.length;
            if (total === 0) {
              pmNotif('Belum ada titik placemark atau kabel yang dibuat pada peta!', 'warning');
              return;
            }

            const projectTitle = (document.getElementById('mapPlanTitle')
              ? document.getElementById('mapPlanTitle').textContent.trim()
              : '') || (document.getElementById('planNamaProyek') ? document.getElementById('planNamaProyek').value.trim() : '') || 'Proyek Pemetaan Baru';

            const areaMeta = document.getElementById('mapPlanMeta') 
              ? document.getElementById('mapPlanMeta').textContent.trim() 
              : '';

            const btnSave = document.getElementById('btnSaveToDatabase');
            let originalBtnHtml = '';
            if (btnSave) {
              originalBtnHtml = btnSave.innerHTML;
              btnSave.disabled = true;
              btnSave.innerHTML = `
                <div class="tool-icon-wrap icon-save" style="background: rgba(220, 38, 38, 0.2); color: #EF4444;">
                  <span class="spinner-border spinner-border-sm" role="status"></span>
                </div>
                <div class="tool-info-wrap">
                  <span class="tool-main-name">Menyimpan...</span>
                  <span class="tool-sub-desc">Sinkron ke Database</span>
                </div>
              `;
            }

            // Siapkan data placemarks
            const placemarksPayload = addedPlacemarks.map((pm, idx) => ({
              name: pm.name || ('Titik-' + (idx + 1)),
              shape: pm.shape || 'triangle',
              category: pm.category || 'Titik FO',
              lat: pm.lat,
              lng: pm.lng,
              fill_color: pm.fillColor || '#EE3124',
              outline_color: pm.outlineColor || '#FFFFFF',
              notes: pm.notes || ''
            }));

            // Siapkan data cables
            const cablesPayload = addedCables.map((cb, idx) => ({
              name: cb.name || ('Kabel-' + (idx + 1)),
              cable_type: cb.type || 'Kabel Distribusi',
              length_meters: cb.length || 0,
              color: cb.color || '#EE3124',
              coordinates_json: cb.coordinates || []
            }));

            const payload = {
              nama_project: projectTitle,
              area: areaMeta || 'Witel Regional',
              file_name: projectTitle.toLowerCase().replace(/[^a-z0-9]/g, '_') + '.kml',
              total_titik: addedPlacemarks.length,
              total_jarak: addedCables.reduce((acc, c) => acc + (c.length || 0), 0),
              placemarks: placemarksPayload,
              cables: cablesPayload,
              status: 'validated'
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch('/api/kml-projects', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
              },
              body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(res => {
              if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = originalBtnHtml;
              }
              if (res.success) {
                const meta = document.getElementById('mapPlanMeta');
                if (meta) {
                  meta.textContent = `✅ Tersimpan ke Database (${addedPlacemarks.length} titik, ${addedCables.length} kabel)`;
                }
                pmNotif(`✅ Berhasil! Proyek "${projectTitle}" telah tersimpan ke basis data Data Manager dengan ${addedPlacemarks.length} titik placemark dan ${addedCables.length} jalur kabel.`, 'success');
              } else {
                pmNotif('Gagal menyimpan ke database: ' + (res.message || 'Terjadi kesalahan sistem'), 'error');
              }
            })
            .catch(err => {
              if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = originalBtnHtml;
              }
              console.error('Save to DB error:', err);
              pmNotif('Gagal menyimpan ke database: ' + err.message, 'error');
            });
          };

          // ============================================================
          // HELPER RENDER PLACEMARK & KABEL DARI DATABASE KE PETA
          // ============================================================
          window.addPlacemarkToMap = function(pm) {
            if (!pemetaanMap) return;
            const name = pm.name || 'Titik';
            const shape = pm.shape || 'triangle';
            const category = pm.category || 'Titik FO';
            const fill = pm.fill_color || pm.fillColor || '#EE3124';
            const outline = pm.outline_color || pm.outlineColor || '#FFFFFF';
            const notes = pm.notes || '';
            const lat = parseFloat(pm.lat);
            const lng = parseFloat(pm.lng);

            const icon = makePmIcon(shape, fill, outline);
            const marker = L.marker([lat, lng], {
              icon: icon,
              draggable: true
            });

            const notesHtml = notes ? `<div style="font-size:0.75rem;color:#718096;margin-top:4px;border-top:1px solid #E2E8F0;padding-top:4px;">${escapeXml(notes)}</div>` : '';
            const shapeInfo = PM_SHAPES[shape] || PM_SHAPES.triangle;

            marker.bindPopup(`
              <div style="font-family:'Inter',sans-serif;min-width:160px;padding:4px 0;">
                <div style="font-weight:700;font-size:0.9rem;color:#1A202C;margin-bottom:2px;">📍 ${escapeXml(name)}</div>
                <div style="font-size:0.75rem;color:${fill};font-weight:600;margin-bottom:4px;">${escapeXml(category)} (${shapeInfo.label})</div>
                <div style="font-size:0.72rem;color:#A0AEC0;">🌐 ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                ${notesHtml}
              </div>
            `);

            marker.on('click', function(e) {
              if (isDrawingCable) {
                if (e.originalEvent) {
                  e.originalEvent.stopPropagation();
                  e.originalEvent.preventDefault();
                }
                setTimeout(() => marker.closePopup(), 10);
                addCableVertex(lat, lng, name);
                return;
              }
            });

            marker.addTo(pemetaanMap);
            addedPlacemarks.push({
              name: name,
              shape: shape,
              category: category,
              fillColor: fill,
              outlineColor: outline,
              notes: notes,
              lat: lat,
              lng: lng
            });
            addedMarkerLayers.push(marker);
          };

          window.addCableToMap = function(cb) {
            if (!pemetaanMap) return;
            const name = cb.name || 'Kabel';
            const type = cb.cable_type || cb.type || 'Kabel Distribusi';
            const color = cb.color || '#805AD5';
            const coords = cb.coordinates_json || cb.coordinates || [];
            const lengthMeters = parseFloat(cb.length_meters || cb.length || 0);

            if (!coords || coords.length < 2) return;

            const latlngs = coords.map(p => [parseFloat(p.lat), parseFloat(p.lng)]);
            const polyline = L.polyline(latlngs, {
              color: color,
              weight: 4,
              opacity: 0.85,
              dashArray: '6, 6'
            }).addTo(pemetaanMap);

            polyline.bindPopup(`
              <div style="font-family:'Inter',sans-serif;min-width:180px;padding:4px 0;">
                <div style="font-weight:700;font-size:0.88rem;color:#1A202C;margin-bottom:4px;">🔌 ${escapeXml(name)}</div>
                <div style="font-size:0.75rem;color:${color};font-weight:600;margin-bottom:4px;">${escapeXml(type)}</div>
                <div style="font-size:0.72rem;color:#718096;">📏 Panjang: <strong>${lengthMeters.toFixed(1)} m</strong> (${coords.length} titik)</div>
              </div>
            `);

            addedCables.push({
              name: name,
              type: type,
              color: color,
              length: lengthMeters,
              coordinates: coords
            });
            addedCableLayers.push(polyline);
          };

          // ============================================================
          // LOAD KML DARI DATABASE KE WORKSPACE PETA
          // ============================================================
          window.loadKmlProjectToMap = function(projectId) {
            fetch(`/api/kml-projects/${projectId}`)
              .then(res => res.json())
              .then(res => {
                if (!res.success || !res.data) {
                  pmNotif('Gagal mengambil data proyek KML dari database.', 'error');
                  return;
                }
                const project = res.data;

                // Tutup modal jika ada
                const modalEl = document.getElementById('modalSelectKmlFromDb');
                if (modalEl) {
                  const modalInst = bootstrap.Modal.getInstance(modalEl);
                  if (modalInst) modalInst.hide();
                }
                const srcModal = document.getElementById('kmlSourceModal');
                if (srcModal) {
                  const srcInst = bootstrap.Modal.getInstance(srcModal);
                  if (srcInst) srcInst.hide();
                }

                // Buka overlay peta jika belum terbuka
                if (typeof window.startPemetaanProcess === 'function') {
                  window.startPemetaanProcess();
                }

                setTimeout(() => {
                  const titleEl = document.getElementById('mapPlanTitle');
                  if (titleEl) titleEl.textContent = project.nama_project;
                  const sumProj = document.getElementById('pemetaanSummaryProject');
                  if (sumProj) sumProj.textContent = project.nama_project;
                  const metaEl = document.getElementById('mapPlanMeta');
                  if (metaEl) metaEl.textContent = `${project.area || 'Witel Regional'} • Database Cloud`;

                  // Bersihkan elemen sebelumnya di peta
                  addedMarkerLayers.forEach(m => { try { pemetaanMap.removeLayer(m); } catch(e){} });
                  addedMarkerLayers.length = 0;
                  addedPlacemarks.length = 0;

                  addedCableLayers.forEach(c => { try { pemetaanMap.removeLayer(c); } catch(e){} });
                  addedCableLayers.length = 0;
                  addedCables.length = 0;

                  const allLatLngs = [];

                  // Muat Placemarks dari tabel kml_placemarks (atau fallback data_json)
                  const placemarks = (project.placemarks && project.placemarks.length > 0)
                    ? project.placemarks 
                    : (typeof project.data_json === 'string' ? JSON.parse(project.data_json || '[]') : (project.data_json || []));

                  placemarks.forEach(pm => {
                    window.addPlacemarkToMap(pm);
                    if (pm.lat && pm.lng) allLatLngs.push([parseFloat(pm.lat), parseFloat(pm.lng)]);
                  });

                  // Muat Cables dari tabel kml_cables
                  const cables = project.cables || [];
                  cables.forEach(cb => {
                    window.addCableToMap(cb);
                    const coords = cb.coordinates_json || cb.coordinates || [];
                    coords.forEach(pt => {
                      if (pt.lat && pt.lng) allLatLngs.push([parseFloat(pt.lat), parseFloat(pt.lng)]);
                    });
                  });

                  renderPmList();
                  updatePmBadge();

                  // Autofit zoom map
                  if (allLatLngs.length > 0 && pemetaanMap) {
                    const bounds = L.latLngBounds(allLatLngs);
                    pemetaanMap.fitBounds(bounds, { padding: [50, 50], maxZoom: 17 });
                  }

                  window.openPmListPanel();
                }, 400);
              })
              .catch(err => {
                console.error('Error loadKmlProjectToMap:', err);
                pmNotif('Gagal memuat proyek dari database: ' + err.message, 'error');
              });
          };

          function escapeXml(str) {
            return String(str || '')
              .replace(/&/g, '&amp;')
              .replace(/</g, '&lt;')
              .replace(/>/g, '&gt;')
              .replace(/"/g, '&quot;');
          }

          // Tutup form popup placemark
          function closePmForm() {
            document.getElementById('pmFormPopup').style.display = 'none';
            if (typeof hidePmNameAutocomplete === 'function') hidePmNameAutocomplete();
            if (pendingMarker) {
              pemetaanMap.removeLayer(pendingMarker);
              pendingMarker = null;
            }
            pendingLatLng = null;
          }

          // Tutup form popup kabel
          function closeCableForm() {
            document.getElementById('cableFormPopup').style.display = 'none';
          }

          // Simpan placemark dari form
          document.getElementById('btnPmSave').addEventListener('click', function() {
            const name       = document.getElementById('pmInputName').value.trim();
            const shape      = document.getElementById('pmInputShape').value || 'triangle';
            const fillColor  = document.getElementById('pmColorFill').value;
            const outlineColor = document.getElementById('pmColorOutline').value;
            const notes      = document.getElementById('pmInputNotes').value.trim();

            if (!name) {
              document.getElementById('pmInputName').focus();
              document.getElementById('pmInputName').style.borderColor = '#E53E3E';
              setTimeout(() => document.getElementById('pmInputName').style.borderColor = '', 1500);
              return;
            }
            if (!pendingLatLng) { closePmForm(); return; }

            const shapeInfo  = PM_SHAPES[shape] || PM_SHAPES.triangle;
            const fill       = fillColor    || shapeInfo.defaultFill;
            const outline    = outlineColor || shapeInfo.defaultOutline;
            const pmData     = { name, shape, fillColor: fill, outlineColor: outline, notes, lat: pendingLatLng.lat, lng: pendingLatLng.lng };

            const marker = L.marker([pmData.lat, pmData.lng], {
              icon: makePmIcon(shape, fill, outline),
              draggable: !isDrawingCable,
              title: name,
            });

            const svgPopup = makePmSvgHtml(shape, fill, outline, 28);
            marker.bindPopup(`
              <div style="font-family:'Inter',sans-serif;min-width:180px;padding:4px 0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                  <span style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">${svgPopup}</span>
                  <span style="font-weight:700;font-size:0.88rem;color:#1A202C;">${escapeXml(name)}</span>
                </div>
                <div style="margin-bottom:4px;">
                  <span style="background:${fill}22;color:${fill};border-radius:10px;
                    padding:2px 8px;font-size:0.7rem;font-weight:600;border:1px solid ${fill}44;">${shapeInfo.label}</span>
                </div>
                ${notes ? `<div style="font-size:0.75rem;color:#4A5568;margin-top:5px;">${escapeXml(notes)}</div>` : ''}
                <div style="font-size:0.68rem;color:#A0AEC0;margin-top:5px;font-family:monospace;">
                  ${pmData.lat.toFixed(6)}, ${pmData.lng.toFixed(6)}
                </div>
                <div style="margin-top:8px;font-size:0.72rem;color:#718096;">✋ Geser marker untuk pindah lokasi</div>
              </div>
            `, { maxWidth: 240 });

            const pmIdx = addedPlacemarks.length;
            marker.on('dragend', function(e) {
              const pos = e.target.getLatLng();
              addedPlacemarks[pmIdx].lat = pos.lat;
              addedPlacemarks[pmIdx].lng = pos.lng;
              renderPmList();
            });

            // Klik langsung pada marker saat mode tarik kabel: otomatis snap ke titik tengah placemark!
            marker.on('click', function(e) {
              if (isDrawingCable) {
                if (e.originalEvent) {
                  e.originalEvent.stopPropagation();
                  e.originalEvent.preventDefault();
                }
                setTimeout(() => marker.closePopup(), 10);
                addCableVertex(pmData.lat, pmData.lng, pmData.name);
                return;
              }
            });

            marker.addTo(pemetaanMap);
            addedPlacemarks.push(pmData);
            addedMarkerLayers.push(marker);

            // Simpan informasi dari placemark ini ke memori 1 sesi (untuk pre-fill placemark berikutnya)
            lastPlacemarkConfig = {
              name: name,
              shape: shape,
              fillColor: fill,
              outlineColor: outline,
              notes: notes
            };

            closePmForm();
            renderPmList();
            updatePmBadge();

            const meta = document.getElementById('mapPlanMeta');
            const origMeta = meta.textContent;
            meta.textContent = `✅ Placemark "${name}" berhasil ditambahkan!`;
            setTimeout(() => { meta.textContent = origMeta; }, 2000);
          });

          // ============================================================
          // LOGIKA TARIK KABEL (LineString) & AUTO-SNAP KE PLACEMARK
          // ============================================================
          let snapIndicator = null; // Lingkaran highlight saat kursor mendekati placemark

          // Cari placemark terdekat dari koordinat klik/kursor (dalam radius pixel di layar)
          function findSnapPlacemark(latlng, maxPixelDist = 24) {
            if (!pemetaanMap || addedPlacemarks.length === 0) return null;
            const clickPoint = pemetaanMap.latLngToContainerPoint(latlng);
            let closestPm = null;
            let minDist = maxPixelDist;

            for (let i = 0; i < addedPlacemarks.length; i++) {
              const pm = addedPlacemarks[i];
              const pmPoint = pemetaanMap.latLngToContainerPoint([pm.lat, pm.lng]);
              const dist = clickPoint.distanceTo(pmPoint);
              if (dist <= minDist) {
                minDist = dist;
                closestPm = pm;
              }
            }
            return closestPm;
          }

          // Tambahkan titik simpul kabel (vertex) dengan dukungan auto-snap
          function addCableVertex(lat, lng, snapName) {
            // Cegah duplikasi titik berturut-turut pada koordinat yang sama
            if (currentCablePoints.length > 0) {
              const lastPt = currentCablePoints[currentCablePoints.length - 1];
              if (Math.abs(lastPt.lat - lat) < 0.000001 && Math.abs(lastPt.lng - lng) < 0.000001) {
                return;
              }
            }

            currentCablePoints.push({ lat, lng });

            // Marker titik vertex sementara (di overlayPane agar di bawah placemark)
            const dotMarker = L.circleMarker([lat, lng], {
              radius: snapName ? 6 : 4.5,
              fillColor: snapName ? '#38A169' : '#805AD5',
              color: '#fff',
              weight: 2,
              opacity: 1,
              fillOpacity: 0.95,
              pane: 'overlayPane'
            }).addTo(pemetaanMap);
            currentCableMarkers.push(dotMarker);

            // Update polyline real-time (di overlayPane agar selalu di bawah ikon placemark)
            if (currentCablePolyline) {
              currentCablePolyline.setLatLngs(currentCablePoints.map(p => [p.lat, p.lng]));
            } else {
              currentCablePolyline = L.polyline(currentCablePoints.map(p => [p.lat, p.lng]), {
                color: '#805AD5',
                weight: 3.5,
                opacity: 0.9,
                pane: 'overlayPane'
              }).addTo(pemetaanMap);
            }

            const len = calculatePolylineLength(currentCablePoints);
            const snapMsg = snapName
              ? ` <span style="background:rgba(56,161,105,0.3);padding:2px 7px;border-radius:10px;font-size:0.75rem;">🧲 Snap: ${escapeXml(snapName)}</span>`
              : '';
            document.getElementById('cableBannerText').innerHTML =
              `<i class="bi bi-bezier2 me-1"></i> ${currentCablePoints.length} titik (${len.toFixed(1)}m)${snapMsg} — Klik titik berikutnya atau Selesai`;
          }

          function startDrawingCable() {
            isDrawingCable = true;
            isAddingPlacemark = false;
            const btnAdd = document.getElementById('btnAddPlacemark');
            const label  = document.getElementById('btnAddPlacemarkLabel');
            if (btnAdd) btnAdd.classList.remove('active');
            if (label) label.textContent = 'Tambah Placemark';
            closePmForm();
            closeCableForm();

            // NONAKTIFKAN drag pada semua marker placemark saat mode tarik kabel!
            // Ini kunci agar klik tepat di tengah placemark tidak terintersepsi oleh drag handler
            addedMarkerLayers.forEach(m => {
              if (m && m.dragging) m.dragging.disable();
            });

            const btnAddCable   = document.getElementById('btnAddCable');
            const btnCableLabel = document.getElementById('btnAddCableLabel');
            if (btnAddCable) btnAddCable.classList.add('active');
            if (btnCableLabel) btnCableLabel.textContent = 'Menarik Kabel…';

            const mapContainer = document.getElementById('mapPemetaanContainer');
            if (mapContainer) {
              mapContainer.classList.add('drawing-cable');
              mapContainer.classList.remove('adding-placemark');
            }

            // Reset temp drawing points
            currentCablePoints = [];
            currentCableMarkers.forEach(m => pemetaanMap.removeLayer(m));
            currentCableMarkers = [];
            if (currentCablePolyline) {
              pemetaanMap.removeLayer(currentCablePolyline);
              currentCablePolyline = null;
            }

            const banner = document.getElementById('cableDrawingBanner');
            if (banner) {
              banner.style.display = 'flex';
              document.getElementById('cableBannerText').innerHTML =
                '<i class="bi bi-bezier2 me-1"></i> Klik di peta / klik placemark untuk snap kabel';
            }
          }

          function stopDrawingCable() {
            isDrawingCable = false;
            const btnAddCable   = document.getElementById('btnAddCable');
            const btnCableLabel = document.getElementById('btnAddCableLabel');
            if (btnAddCable) btnAddCable.classList.remove('active');
            if (btnCableLabel) btnCableLabel.textContent = 'Tarik Kabel';

            const mapContainer = document.getElementById('mapPemetaanContainer');
            if (mapContainer) mapContainer.classList.remove('drawing-cable');

            const banner = document.getElementById('cableDrawingBanner');
            if (banner) banner.style.display = 'none';

            // Tutup form popup kabel jika terbuka
            closeCableForm();

            // Aktifkan kembali drag pada placemark setelah selesai / batal
            addedMarkerLayers.forEach(m => {
              if (m && m.dragging) m.dragging.enable();
            });

            // Bersihkan snap indicator
            if (snapIndicator) {
              pemetaanMap.removeLayer(snapIndicator);
              snapIndicator = null;
            }

            // Bersihkan temp drawing
            currentCableMarkers.forEach(m => pemetaanMap.removeLayer(m));
            currentCableMarkers = [];
            if (currentCablePolyline) {
              pemetaanMap.removeLayer(currentCablePolyline);
              currentCablePolyline = null;
            }
            currentCablePoints = [];
          }

          function finishDrawingCable() {
            if (currentCablePoints.length < 2) {
              pmNotif('Minimal buat 2 titik untuk membentuk jalur kabel!', 'warning');
              return;
            }

            // Segera sembunyikan banner panduan tarik kabel saat Selesai diklik
            const banner = document.getElementById('cableDrawingBanner');
            if (banner) banner.style.display = 'none';

            // Nonaktifkan mode klik gambar kabel pada peta
            isDrawingCable = false;
            const btnAddCable   = document.getElementById('btnAddCable');
            const btnCableLabel = document.getElementById('btnAddCableLabel');
            if (btnAddCable) btnAddCable.classList.remove('active');
            if (btnCableLabel) btnCableLabel.textContent = 'Tarik Kabel';

            const mapContainer = document.getElementById('mapPemetaanContainer');
            if (mapContainer) mapContainer.classList.remove('drawing-cable');

            // Aktifkan kembali drag pada placemark
            addedMarkerLayers.forEach(m => {
              if (m && m.dragging) m.dragging.enable();
            });
            if (snapIndicator) {
              pemetaanMap.removeLayer(snapIndicator);
              snapIndicator = null;
            }

            // Tutup form placemark jika sedang terbuka
            closePmForm();

            const lengthMeters = calculatePolylineLength(currentCablePoints);
            const form = document.getElementById('cableFormPopup');
            document.getElementById('cableLengthDisplay').innerHTML =
              `<i class="bi bi-rulers me-1"></i> Panjang: <strong>${lengthMeters.toFixed(1)} meter</strong> (${currentCablePoints.length} titik)`;
            document.getElementById('cableInputName').value = `DS-KABEL-${addedCables.length + 1}`;
            document.getElementById('cableInputType').value = 'AC-OF-SM-24FO';
            document.getElementById('cableCustomTypeWrapper').style.display = 'none';
            document.getElementById('cableCustomTypeInput').value = '';

            form.style.display = 'block';
            form.style.top   = '10px';
            form.style.right = '10px';
            form.style.left  = 'auto';

            setTimeout(() => document.getElementById('cableInputName').focus(), 80);
          }

          // Toggle custom cable type input
          document.getElementById('cableInputType').addEventListener('change', function() {
            const wrap = document.getElementById('cableCustomTypeWrapper');
            if (this.value === 'CUSTOM') {
              wrap.style.display = 'block';
              document.getElementById('cableCustomTypeInput').focus();
            } else {
              wrap.style.display = 'none';
            }
          });

          // Simpan kabel dari popup form
          document.getElementById('btnCableSave').addEventListener('click', function() {
            const name = document.getElementById('cableInputName').value.trim();
            let type   = document.getElementById('cableInputType').value;
            if (type === 'CUSTOM') {
              type = document.getElementById('cableCustomTypeInput').value.trim() || 'AC-OF-SM-24FO';
            }

            if (!name) {
              document.getElementById('cableInputName').focus();
              document.getElementById('cableInputName').style.borderColor = '#E53E3E';
              setTimeout(() => document.getElementById('cableInputName').style.borderColor = '', 1500);
              return;
            }

            const lengthMeters = calculatePolylineLength(currentCablePoints);
            const cableData = {
              name: name,
              type: type,
              length: lengthMeters,
              coordinates: [...currentCablePoints]
            };

            // Buat polyline permanen di peta (garis ungu-biru dengan popup)
            const polyline = L.polyline(cableData.coordinates.map(p => [p.lat, p.lng]), {
              color: '#805AD5',
              weight: 4,
              opacity: 0.85,
              dashArray: '6, 6'
            }).addTo(pemetaanMap);

            polyline.bindPopup(`
              <div style="font-family:'Inter',sans-serif;min-width:180px;padding:4px 0;">
                <div style="font-weight:700;font-size:0.88rem;color:#1A202C;margin-bottom:4px;">🔌 ${escapeXml(name)}</div>
                <div style="font-size:0.75rem;color:#805AD5;font-weight:600;margin-bottom:4px;">${escapeXml(type)}</div>
                <div style="font-size:0.72rem;color:#718096;">📏 Panjang: <strong>${lengthMeters.toFixed(1)} m</strong> (${cableData.coordinates.length} titik)</div>
              </div>
            `);

            addedCables.push(cableData);
            addedCableLayers.push(polyline);

            closeCableForm();
            stopDrawingCable();
            renderPmList();
            updatePmBadge();

            const meta = document.getElementById('mapPlanMeta');
            const origMeta = meta.textContent;
            meta.textContent = `✅ Jalur Kabel "${name}" (${lengthMeters.toFixed(1)}m) berhasil disimpan!`;
            setTimeout(() => { meta.textContent = origMeta; }, 2500);
          });

          document.getElementById('btnCableCancel').addEventListener('click', function(e) {
            e.stopPropagation();
            closeCableForm();
            stopDrawingCable();
          });
          document.getElementById('btnFinishCable').addEventListener('click', function(e) {
            e.stopPropagation();
            finishDrawingCable();
          });
          document.getElementById('btnCancelCableDraw').addEventListener('click', function(e) {
            e.stopPropagation();
            stopDrawingCable();
          });

          // Cegah event click & scroll pada UI controls tembus ke Leaflet map
          const pmToolbarEl      = document.getElementById('pmToolbar');
          const pmFormPopupEl    = document.getElementById('pmFormPopup');
          const cableFormPopupEl = document.getElementById('cableFormPopup');
          const pmListPanelEl    = document.getElementById('pmListPanel');
          const cableBannerEl    = document.getElementById('cableDrawingBanner');
          const pmAcDropdownEl   = document.getElementById('pmNameAutocomplete');

          [pmToolbarEl, pmFormPopupEl, cableFormPopupEl, pmListPanelEl, cableBannerEl, pmAcDropdownEl].forEach(el => {
            if (el) {
              L.DomEvent.disableClickPropagation(el);
              L.DomEvent.disableScrollPropagation(el);
            }
          });

          // ===== AUTOCOMPLETE NAMA PLACEMARK DARI DATABASE DESIGNATORS =====
          const pmInputNameEl    = document.getElementById('pmInputName');
          let currentAcHighlight = -1;

          function getDesignatorCategoryInfo(name) {
            const n = (name || '').toUpperCase().trim();
            if (n.startsWith('ODP') || n.includes('ODP')) return { cat: 'odp', label: 'ODP', badgeClass: 'bg-success' };
            if (n.startsWith('ODC') || n.startsWith('OTB') || n.includes('ODC') || n.includes('CATUAN')) return { cat: 'odc', label: 'ODC', badgeClass: 'bg-info' };
            if (n.startsWith('TE') || n.startsWith('TIANG') || n.includes('POLE') || n.includes('TIANG')) return { cat: 'tiang', label: 'Tiang / TE', badgeClass: 'bg-warning text-dark' };
            if (n.startsWith('SITE') || n.startsWith('TOP') || n.includes('LOKASI')) return { cat: 'lokasi', label: 'Site TOP', badgeClass: 'bg-danger' };
            return { cat: 'catatan', label: 'Designator', badgeClass: 'bg-secondary' };
          }

          function getMatchingDesignators(query) {
            const q = (query || '').trim().toLowerCase();
            const pool = [];
            const seen = new Set();

            // 1. Ambil dari databaseDesignators yang dimuat dari database
            if (Array.isArray(databaseDesignators)) {
              databaseDesignators.forEach(d => {
                const clean = (d || '').trim();
                if (clean && !seen.has(clean.toLowerCase())) {
                  seen.add(clean.toLowerCase());
                  pool.push(clean);
                }
              });
            }

            // 2. Default designators jika database masih kosong
            const defaults = ['ODP-GTL-FCB/001', 'ODC-GTL-01', 'TE-01', 'TIANG-01', 'OTB-01', 'SITE-TOP-01'];
            defaults.forEach(d => {
              if (!seen.has(d.toLowerCase())) {
                seen.add(d.toLowerCase());
                pool.push(d);
              }
            });

            if (!q) {
              return pool.slice(0, 15);
            }

            // Prioritaskan yang berawalan huruf/kata yang diketik, lalu yang mengandung
            const startsWithMatches = [];
            const containsMatches   = [];

            pool.forEach(item => {
              const itemLower = item.toLowerCase();
              if (itemLower.startsWith(q)) {
                startsWithMatches.push(item);
              } else if (itemLower.includes(q)) {
                containsMatches.push(item);
              }
            });

            return [...startsWithMatches, ...containsMatches].slice(0, 20);
          }

          function renderPmNameAutocomplete() {
            if (!pmInputNameEl || !pmAcDropdownEl) return;
            const query = pmInputNameEl.value;
            const matches = getMatchingDesignators(query);

            pmAcDropdownEl.innerHTML = '';
            currentAcHighlight = -1;

            if (matches.length === 0) {
              pmAcDropdownEl.style.display = 'none';
              return;
            }

            matches.forEach((item, idx) => {
              const info = getDesignatorCategoryInfo(item);
              const div = document.createElement('div');
              div.className = 'pm-ac-item';
              div.dataset.index = idx;
              div.dataset.value = item.toUpperCase();
              div.dataset.category = info.cat;

              // Highlight substring yang cocok jika ada query
              const itemUpper = item.toUpperCase();
              let formattedLabel = escapeXml(itemUpper);
              const q = query.trim().toUpperCase();
              if (q && itemUpper.includes(q)) {
                const pos = itemUpper.indexOf(q);
                formattedLabel = `${escapeXml(itemUpper.substring(0, pos))}<strong style="color:#2F855A;text-decoration:underline;">${escapeXml(itemUpper.substring(pos, pos + q.length))}</strong>${escapeXml(itemUpper.substring(pos + q.length))}`;
              }

              div.innerHTML = `
                <div style="display:flex;align-items:center;gap:6px;min-width:0;overflow:hidden;text-overflow:ellipsis;">
                  <i class="bi bi-geo-alt" style="color:#718096;font-size:0.75rem;flex-shrink:0;"></i>
                  <span style="font-size:0.82rem;font-weight:600;">${formattedLabel}</span>
                </div>
                <span class="badge ${info.badgeClass}" style="font-size:0.65rem;border-radius:4px;flex-shrink:0;margin-left:8px;">${info.label}</span>
              `;

              div.addEventListener('mousedown', function(e) {
                e.preventDefault();
                e.stopPropagation();
                selectPmAutocompleteItem(item.toUpperCase(), info.cat);
              });

              pmAcDropdownEl.appendChild(div);
            });

            pmAcDropdownEl.style.display = 'block';
          }

          function selectPmAutocompleteItem(val) {
            if (!pmInputNameEl) return;
            pmInputNameEl.value = val;
            hidePmNameAutocomplete();
            pmInputNameEl.focus();
          }

          function hidePmNameAutocomplete() {
            if (pmAcDropdownEl) {
              pmAcDropdownEl.style.display = 'none';
              pmAcDropdownEl.innerHTML = '';
              currentAcHighlight = -1;
            }
          }

          if (pmInputNameEl && pmAcDropdownEl) {
            pmInputNameEl.addEventListener('input', function() {
              renderPmNameAutocomplete();
            });

            pmInputNameEl.addEventListener('focus', function() {
              renderPmNameAutocomplete();
            });

            // Hilangkan dropdown saat cursor/fokus tidak lagi berada di kolom input
            pmInputNameEl.addEventListener('blur', function() {
              setTimeout(() => {
                hidePmNameAutocomplete();
              }, 150);
            });

            pmInputNameEl.addEventListener('keydown', function(e) {
              if (pmAcDropdownEl.style.display === 'none') {
                if (e.key === 'ArrowDown') {
                  renderPmNameAutocomplete();
                }
                return;
              }

              const items = pmAcDropdownEl.querySelectorAll('.pm-ac-item');
              if (items.length === 0) return;

              if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentAcHighlight = (currentAcHighlight + 1) % items.length;
                updateAcHighlightItem(items);
              } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentAcHighlight = (currentAcHighlight - 1 + items.length) % items.length;
                updateAcHighlightItem(items);
              } else if (e.key === 'Enter') {
                if (currentAcHighlight >= 0 && items[currentAcHighlight]) {
                  e.preventDefault();
                  const selected = items[currentAcHighlight];
                  selectPmAutocompleteItem(selected.dataset.value, selected.dataset.category);
                }
              } else if (e.key === 'Escape') {
                hidePmNameAutocomplete();
              }
            });

            function updateAcHighlightItem(items) {
              items.forEach((it, i) => {
                if (i === currentAcHighlight) {
                  it.classList.add('active');
                  it.scrollIntoView({ block: 'nearest' });
                } else {
                  it.classList.remove('active');
                }
              });
            }

            document.addEventListener('click', function(e) {
              if (pmFormPopupEl && !pmFormPopupEl.contains(e.target)) {
                hidePmNameAutocomplete();
              }
            });
          }

          // Shape button selector
          document.querySelectorAll('.pm-shape-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
              document.querySelectorAll('.pm-shape-btn').forEach(b => b.classList.remove('active'));
              this.classList.add('active');
              const selectedShape = this.getAttribute('data-shape');
              document.getElementById('pmInputShape').value = selectedShape;
              // Update warna default sesuai shape yang dipilih
              const shapeInfo = PM_SHAPES[selectedShape] || PM_SHAPES.triangle;
              document.getElementById('pmColorFill').value    = shapeInfo.defaultFill;
              document.getElementById('pmColorOutline').value = shapeInfo.defaultOutline;
              document.getElementById('pmColorFillLabel').textContent    = shapeInfo.defaultFill;
              document.getElementById('pmColorOutlineLabel').textContent = shapeInfo.defaultOutline;
              updateShapeButtonPreviews();
            });
          });

          // Sync hex label saat color picker berubah
          document.getElementById('pmColorFill').addEventListener('input', function() {
            document.getElementById('pmColorFillLabel').textContent = this.value;
            updateShapeButtonPreviews();
          });
          document.getElementById('pmColorOutline').addEventListener('input', function() {
            document.getElementById('pmColorOutlineLabel').textContent = this.value;
            updateShapeButtonPreviews();
          });

          document.getElementById('btnPmCancel').addEventListener('click', function(e) {
            e.stopPropagation();
            closePmForm();
          });

          // Tombol Reset ke Default pada form popup placemark
          const btnResetDefaults = document.getElementById('btnResetPmFormDefaults');
          if (btnResetDefaults) {
            btnResetDefaults.addEventListener('click', function(e) {
              if (e) e.stopPropagation();
              lastPlacemarkConfig = null;
              document.getElementById('pmInputName').value = '';
              document.getElementById('pmInputNotes').value = '';
              document.getElementById('pmInputShape').value = 'triangle';
              document.querySelectorAll('.pm-shape-btn').forEach(b => b.classList.remove('active'));
              const defBtn = document.querySelector('.pm-shape-btn[data-shape="triangle"]');
              if (defBtn) defBtn.classList.add('active');

              document.getElementById('pmColorFill').value = PM_SHAPES.triangle.defaultFill;
              document.getElementById('pmColorOutline').value = PM_SHAPES.triangle.defaultOutline;
              document.getElementById('pmColorFillLabel').textContent = PM_SHAPES.triangle.defaultFill;
              document.getElementById('pmColorOutlineLabel').textContent = PM_SHAPES.triangle.defaultOutline;
              updateShapeButtonPreviews();
              btnResetDefaults.style.display = 'none';
            });
          }

          // Toggle mode tambah placemark
          const btnAdd = document.getElementById('btnAddPlacemark');
          const label  = document.getElementById('btnAddPlacemarkLabel');
          btnAdd.addEventListener('click', function(e) {
            if (e) { e.stopPropagation(); e.preventDefault(); }
            
            // Hentikan mode tarik kabel dan tutup popup form kabel jika ada
            stopDrawingCable();
            closeCableForm();

            isAddingPlacemark = !isAddingPlacemark;
            const container = document.getElementById('mapPemetaanContainer');
            if (isAddingPlacemark) {
              this.classList.add('active');
              label.textContent = 'Klik di Peta…';
              if (container) {
                container.classList.add('adding-placemark');
                container.classList.remove('drawing-cable');
              }
              closePmForm();
            } else {
              this.classList.remove('active');
              label.textContent = 'Tambah Placemark';
              if (container) container.classList.remove('adding-placemark');
              closePmForm();
            }
          });

          // Toggle mode tarik kabel
          const btnAddCable   = document.getElementById('btnAddCable');
          const btnCableLabel = document.getElementById('btnAddCableLabel');
          btnAddCable.addEventListener('click', function(e) {
            if (e) { e.stopPropagation(); e.preventDefault(); }
            
            // Hentikan mode tambah placemark jika aktif
            if (isAddingPlacemark) {
              isAddingPlacemark = false;
              btnAdd.classList.remove('active');
              label.textContent = 'Tambah Placemark';
              const container = document.getElementById('mapPemetaanContainer');
              if (container) container.classList.remove('adding-placemark');
              closePmForm();
            }
            closeCableForm();

            if (!isDrawingCable) {
              startDrawingCable();
            } else {
              stopDrawingCable();
            }
          });

          // Klik peta saat mode add placemark / tarik kabel aktif
          pemetaanMap.on('click', function(e) {
            // Mode Tarik Kabel (otomatis snap jika klik dekat atau di atas placemark)
            if (isDrawingCable) {
              const snapped = findSnapPlacemark(e.latlng, 24);
              if (snapped) {
                addCableVertex(snapped.lat, snapped.lng, snapped.name);
              } else {
                addCableVertex(e.latlng.lat, e.latlng.lng, null);
              }
              return;
            }

            // Mode Tambah Placemark
            if (!isAddingPlacemark) return;

            if (pendingMarker) pemetaanMap.removeLayer(pendingMarker);
            pendingLatLng = e.latlng;

            pendingMarker = L.marker([e.latlng.lat, e.latlng.lng], {
              icon: L.divIcon({
                className: '',
                html: `<div style="
                  width:28px;height:28px;
                  background:rgba(56,161,105,0.25);
                  border:2.5px dashed #38A169;
                  border-radius:50%;
                  animation: pmPendingPulse 1s infinite;
                  display:flex;align-items:center;justify-content:center;
                "><i class="bi bi-geo-alt-fill" style="color:#38A169;font-size:14px;"></i></div>`,
                iconSize: [28, 28],
                iconAnchor: [14, 28],
              }),
            }).addTo(pemetaanMap);

            if (!document.getElementById('pmPendingStyle')) {
              const s = document.createElement('style');
              s.id = 'pmPendingStyle';
              s.textContent = `@keyframes pmPendingPulse{0%,100%{transform:scale(1);}50%{transform:scale(1.15);}}`;
              document.head.appendChild(s);
            }

            const form = document.getElementById('pmFormPopup');
            const btnResetDefaults = document.getElementById('btnResetPmFormDefaults');

            // Cek apakah ada memori konfigurasi dari 1 sesi pengisian placemark tepat sebelumnya
            if (lastPlacemarkConfig) {
              // Pulihkan tipe titik (icon shape)
              const shapeKey = lastPlacemarkConfig.shape || 'triangle';
              document.getElementById('pmInputShape').value = shapeKey;
              document.querySelectorAll('.pm-shape-btn').forEach(b => b.classList.remove('active'));
              const activeBtn = document.querySelector(`.pm-shape-btn[data-shape="${shapeKey}"]`);
              if (activeBtn) activeBtn.classList.add('active');

              // Pulihkan warna badan (fill) dan warna outline
              document.getElementById('pmColorFill').value    = lastPlacemarkConfig.fillColor;
              document.getElementById('pmColorOutline').value = lastPlacemarkConfig.outlineColor;
              document.getElementById('pmColorFillLabel').textContent    = lastPlacemarkConfig.fillColor;
              document.getElementById('pmColorOutlineLabel').textContent = lastPlacemarkConfig.outlineColor;

              // Pulihkan catatan/keterangan
              document.getElementById('pmInputNotes').value  = lastPlacemarkConfig.notes || '';

              // Auto-increment nama jika nama sebelumnya berakhiran angka (contoh: "odp 1" -> "odp 2")
              const nameInput = document.getElementById('pmInputName');
              if (lastPlacemarkConfig.name) {
                const match = lastPlacemarkConfig.name.match(/^(.*?)(\d+)$/);
                if (match) {
                  const prefix = match[1];
                  const numStr = match[2];
                  const nextNum = String(parseInt(numStr, 10) + 1).padStart(numStr.length, '0');
                  nameInput.value = prefix + nextNum;
                } else {
                  nameInput.value = '';
                }
              } else {
                nameInput.value = '';
              }

              if (btnResetDefaults) btnResetDefaults.style.display = 'inline-flex';
            } else {
              // Jika belum ada memori pengisian sebelumnya, gunakan default sistem
              document.getElementById('pmInputName').value   = '';
              document.getElementById('pmInputNotes').value  = '';
              document.getElementById('pmInputShape').value = 'triangle';
              document.querySelectorAll('.pm-shape-btn').forEach(b => b.classList.remove('active'));
              const defBtn = document.querySelector('.pm-shape-btn[data-shape="triangle"]');
              if (defBtn) defBtn.classList.add('active');

              document.getElementById('pmColorFill').value    = PM_SHAPES.triangle.defaultFill;
              document.getElementById('pmColorOutline').value = PM_SHAPES.triangle.defaultOutline;
              document.getElementById('pmColorFillLabel').textContent    = PM_SHAPES.triangle.defaultFill;
              document.getElementById('pmColorOutlineLabel').textContent = PM_SHAPES.triangle.defaultOutline;

              if (btnResetDefaults) btnResetDefaults.style.display = 'none';
            }

            updateShapeButtonPreviews();
            hidePmNameAutocomplete();

            if (window.closePmListPanel) window.closePmListPanel();
            form.style.display = 'block';
            form.style.top   = '10px';
            form.style.right = '10px';
            form.style.left  = 'auto';

            isAddingPlacemark = false;
            btnAdd.classList.remove('active');
            label.textContent = 'Tambah Placemark';
            document.getElementById('mapPemetaanContainer').classList.remove('adding-placemark');
          });

          // Highlight visual auto-snap saat kursor mendekati placemark di mode tarik kabel
          pemetaanMap.on('mousemove', function(e) {
            if (!isDrawingCable) return;
            const snapped = findSnapPlacemark(e.latlng, 24);
            if (snapped) {
              if (!snapIndicator) {
                snapIndicator = L.circleMarker([snapped.lat, snapped.lng], {
                  radius: 16,
                  fillColor: '#38A169',
                  fillOpacity: 0.25,
                  color: '#38A169',
                  weight: 2,
                  dashArray: '4, 4',
                  interactive: false,
                  pane: 'overlayPane'
                }).addTo(pemetaanMap);
              } else {
                snapIndicator.setLatLng([snapped.lat, snapped.lng]);
                snapIndicator.setStyle({ opacity: 1, fillOpacity: 0.25 });
              }
            } else if (snapIndicator) {
              pemetaanMap.removeLayer(snapIndicator);
              snapIndicator = null;
            }
          });

          // Dobel klik peta saat tarik kabel → langsung selesai
          pemetaanMap.on('dblclick', function(e) {
            if (isDrawingCable && currentCablePoints.length >= 2) {
              finishDrawingCable();
            }
          });

          // Toggle & Tutup panel list
          const btnTogglePmListEl = document.getElementById('btnTogglePmList');
          if (btnTogglePmListEl) {
            btnTogglePmListEl.onclick = function(e) {
              window.togglePmListPanel(e);
            };
          }
          const btnClosePmListEl = document.getElementById('btnClosePmList');
          if (btnClosePmListEl) {
            btnClosePmListEl.onclick = function(e) {
              window.closePmListPanel(e);
            };
          }

          // Export KML dari toolbar (gunakan onclick tunggal agar tidak menumpuk listener duplikat)
          const btnExportPmKmlEl = document.getElementById('btnExportPmKml');
          if (btnExportPmKmlEl) {
            btnExportPmKmlEl.onclick = function(e) {
              if (e) {
                e.preventDefault();
                e.stopPropagation();
              }
              exportPlacemarksKml();
            };
          }

          // Simpan KML ke Database dari toolbar
          const btnSaveDb = document.getElementById('btnSaveToDatabase');
          if (btnSaveDb) {
            btnSaveDb.onclick = function(e) {
              if (e) {
                e.preventDefault();
                e.stopPropagation();
              }
              window.savePemetaanToDatabase();
            };
          }

          // ===== END ADD PLACEMARK & TARIK KABEL FEATURE =====

        }, 150);
      }

      window.startPemetaanProcess = startPemetaanProcess;

      const btnMulaiPemetaanEl = document.getElementById('btnMulaiPemetaan');
      if (btnMulaiPemetaanEl) {
        btnMulaiPemetaanEl.onclick = startPemetaanProcess;
      }

      // Tombol X — tutup overlay peta, kembali ke beranda landing
      const btnTutupMapEl = document.getElementById('btnTutupMap');
      if (btnTutupMapEl) {
        btnTutupMapEl.addEventListener('click', function () {
          const overlay = document.getElementById('mapPemetaanOverlay');
          if (overlay) overlay.style.display = 'none';
          window.closePmListPanel();
          lastPlacemarkConfig = null;
          if (pemetaanMap) {
            try { pemetaanMap.remove(); } catch(e) {}
            pemetaanMap = null;
          }
          if (typeof window.switchWorkspaceView === 'function') {
            window.switchWorkspaceView('landing');
          }
        });
      }
      // ===== END PETA INTERAKTIF =====

      // ============================================================
      // HANDLER MODAL DATABASE CLOUD KML (PILIH DARI DATABASE)
      // ============================================================
      window.openSelectKmlFromDbModal = function() {
        const srcModal = document.getElementById('kmlSourceModal');
        if (srcModal) {
          try {
            const srcInst = bootstrap.Modal.getInstance(srcModal);
            if (srcInst) srcInst.hide();
          } catch(e) {}
        }

        const modalEl = document.getElementById('modalSelectKmlFromDb');
        if (!modalEl) return;
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        const container = document.getElementById('kmlDbListContainer');
        container.innerHTML = `
          <div class="text-center py-4 text-muted">
            <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
            <div>Mengambil daftar proyek dari database...</div>
          </div>
        `;

        fetch('/api/kml-projects')
          .then(res => res.json())
          .then(res => {
            if (!res.success || !res.data || res.data.length === 0) {
              container.innerHTML = `
                <div class="text-center py-4 text-muted">
                  <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                  <p class="mb-0 fw-bold">Belum ada proyek KML di database.</p>
                  <small>Buat pemetaan baru di peta atau upload file KML di Data Manager.</small>
                </div>
              `;
              return;
            }
            window.cachedKmlDbProjects = res.data;
            renderKmlDbCards(res.data);
          })
          .catch(err => {
            container.innerHTML = `<div class="alert alert-danger py-2">Gagal memuat dari database: ${err.message}</div>`;
          });
      };

      function formatKmlDbDate(dateStr) {
        if (!dateStr) return '-';
        try {
          const d = new Date(dateStr);
          if (isNaN(d.getTime())) return dateStr;
          const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
          return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        } catch(e) {
          return dateStr;
        }
      }

      function renderKmlDbCards(projects) {
        const container = document.getElementById('kmlDbListContainer');
        if (!projects || projects.length === 0) {
          container.innerHTML = `<div class="text-center py-4 text-muted">Tidak ada proyek yang sesuai pencarian.</div>`;
          return;
        }
        let html = '<div class="d-flex flex-column gap-2">';
        projects.forEach(p => {
          const tglCreated = formatKmlDbDate(p.tanggal_survei || p.created_at);

          html += `
            <div class="p-3 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background:#1E1E24; border:1px solid rgba(255,255,255,0.08); transition:all 0.2s ease;">
              <div>
                <div class="fw-bold text-white mb-1" style="font-size:0.92rem;">
                  <i class="bi bi-file-earmark-code me-2 text-danger"></i>${p.nama_project}
                </div>
                <div class="text-muted d-flex gap-3 align-items-center flex-wrap" style="font-size:0.8rem; color:#9CA3AF !important;">
                  <span><i class="bi bi-geo-alt me-1 text-danger"></i>${p.area || 'Witel Regional'}</span>
                  <span><i class="bi bi-calendar3 me-1 text-secondary"></i>${tglCreated}</span>
                </div>
              </div>
              <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1" style="border-radius:8px; padding:6px 14px; font-weight:600; font-size:0.8rem; background-color:#DC2626; border-color:#DC2626;" onclick="loadKmlProjectToMatrix(${p.id})">
                  <i class="bi bi-table"></i> Muat ke Tabel
                </button>
              </div>
            </div>
          `;
        });
        html += '</div>';
        container.innerHTML = html;
      }

      window.loadKmlProjectToMatrix = async function(projectId) {
        try {
          // Tutup modal database dan modal sumber KML
          const modalEl = document.getElementById('modalSelectKmlFromDb');
          if (modalEl) {
            const modalInst = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
            if (modalInst) modalInst.hide();
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
          }
          const srcModal = document.getElementById('kmlSourceModal');
          if (srcModal) {
            const srcInst = bootstrap.Modal.getInstance(srcModal) || bootstrap.Modal.getOrCreateInstance(srcModal);
            if (srcInst) srcInst.hide();
            srcModal.classList.remove('show');
            srcModal.style.display = 'none';
          }
          document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
          document.body.classList.remove('modal-open');
          document.body.style.overflow = '';

          // Fetch file KML dari endpoint download
          const res = await fetch(`/api/kml-projects/${projectId}/download`);
          if (!res.ok) {
            throw new Error('Gagal mengunduh berkas KML dari database.');
          }
          const kmlContent = await res.text();

          // Dapatkan nama berkas KML
          let fileName = 'proyek_database.kml';
          if (window.cachedKmlDbProjects) {
            const found = window.cachedKmlDbProjects.find(item => item.id == projectId);
            if (found) {
              fileName = found.file_name || (found.nama_project + '.kml');
            }
          }
          if (!fileName.toLowerCase().endsWith('.kml')) {
            fileName += '.kml';
          }

          // Buat File object virtual
          const file = new File([kmlContent], fileName, { type: 'application/vnd.google-earth.kml+xml' });

          // Pindah ke mode tampilan matrix workspace
          if (typeof window.switchWorkspaceView === 'function') {
            window.switchWorkspaceView('matrix');
          }

          // Tandai agar parseKMLFile tidak auto-fill dropdown
          window._kmlFromDbNoAutoSelect = true;

          // Reset pilihan dropdown sebelum memuat KML dari database
          // agar Titik Awal, Titik Akhir, dan Jalur Kabel tidak terisi otomatis
          if (typeof window.clearFile === 'function') {
            window.clearFile();
          } else {
            // Reset manual jika clearFile tidak tersedia
            const startPointText = document.getElementById('startPointText');
            const endPointText   = document.getElementById('endPointText');
            const cableRouteText = document.getElementById('cableRouteText');
            if (startPointText) startPointText.textContent = 'Pilih Titik Awal';
            if (endPointText)   endPointText.textContent   = 'Pilih Titik Akhir';
            if (cableRouteText) cableRouteText.textContent = 'Pilih Jalur Kabel';
          }

          // Set ulang flag (clearFile mungkin mereset window state)
          window._kmlFromDbNoAutoSelect = true;

          // Panggil displayFileInfo
          if (typeof window.displayFileInfo === 'function') {
            window.displayFileInfo(file);
          } else if (typeof displayFileInfo === 'function') {
            displayFileInfo(file);
          }
        } catch (err) {
          console.error('Error loadKmlProjectToMatrix:', err);
          pmNotif('Gagal memuat proyek KML ke tabel: ' + err.message, 'error');
        }
      };

      window.filterKmlDbList = function(query) {
        if (!window.cachedKmlDbProjects) return;
        const q = (query || '').toLowerCase().trim();
        const filtered = window.cachedKmlDbProjects.filter(p => 
          (p.nama_project || '').toLowerCase().includes(q) || 
          (p.area || '').toLowerCase().includes(q)
        );
        renderKmlDbCards(filtered);
      };

      // Periksa query parameter URL saat halaman dibuka (misal dari Data Manager ?load_kml=ID)
      document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const loadKmlId = urlParams.get('load_kml');
        if (loadKmlId && typeof window.loadKmlProjectToMap === 'function') {
          setTimeout(() => {
            window.loadKmlProjectToMap(loadKmlId);
          }, 600);
        }
      });



