# Sistem Validasi Designator

## Deskripsi
Sistem ini memastikan bahwa semua designator yang ada di file KML sesuai dengan data yang terdaftar di database `designators`.

## Fitur Utama

### 1. Validasi Otomatis
- Memeriksa setiap designator dari placemark KML terhadap database
- Menampilkan status validasi dengan warna:
  - **Hijau** (✓): Designator valid dan ditemukan di database
  - **Merah** (✗): Designator tidak valid/tidak ditemukan
  - **Kuning** (⚠): Designator memiliki saran yang mirip

### 2. Fuzzy Matching
- Mencari designator yang mirip jika tidak ditemukan exact match
- Menggunakan algoritma Levenshtein Distance
- Memberikan saran hingga 3 designator yang paling mirip

### 3. Visual Feedback
- Highlight baris dengan warna sesuai status validasi
- Ikon indikator (✓, ✗) di sebelah designator
- Pesan saran di bawah designator yang tidak valid

## Cara Penggunaan

### 1. Upload dan Proses File KML
```
1. Klik "Pilih File KML"
2. Pilih Titik Awal dan Titik Akhir
3. Klik tombol "Proses"
4. Preview data akan muncul di tabel
```

### 2. Validasi Designator
```
1. Setelah preview muncul, klik tombol "Validasi Designator"
2. Sistem akan memeriksa semua designator dengan database
3. Hasil validasi ditampilkan dengan warna dan ikon
4. Lihat notifikasi untuk ringkasan validasi
```

### 3. Interpretasi Hasil
- **Valid**: Designator sesuai dengan database, tidak perlu tindakan
- **Tidak Valid dengan Saran**: Periksa saran yang diberikan, mungkin ada typo
- **Tidak Valid tanpa Saran**: Designator tidak ada di database, perlu ditambahkan

## API Endpoint

### POST `/api/designators/validate`
Memvalidasi array designator terhadap database.

**Request Body:**
```json
{
  "designators": ["ODC-GTL-FBD", "ODP-ISM-FAV", "Tiang 123"]
}
```

**Response:**
```json
{
  "success": true,
  "results": [
    {
      "input": "ODC-GTL-FBD",
      "valid": true,
      "matched": "ODC-GTL-FBD",
      "message": "Valid"
    },
    {
      "input": "ODP-ISM-FAV",
      "valid": false,
      "matched": null,
      "suggestions": ["ODC-ISM-FAV", "ODP-ISM-FAB"],
      "message": "Mungkin maksud Anda: ODC-ISM-FAV, ODP-ISM-FAB"
    }
  ],
  "total": 2,
  "valid_count": 1,
  "invalid_count": 1
}
```

## Database Schema

### Table: designators
```sql
- id (bigint, primary key)
- nama_designator (varchar 255, unique)
- created_at (timestamp)
- updated_at (timestamp)
```

## Controller Methods

### `validateDesignators(Request $request)`
Method utama untuk validasi designator.
- Input: Array designator
- Output: Status validasi untuk setiap designator
- Feature: Case-insensitive comparison, fuzzy matching

### `findSimilar($input, $validDesignators, $threshold = 3)`
Helper method untuk mencari designator yang mirip.
- Menggunakan Levenshtein Distance
- Threshold default: 3 (maks 3 karakter berbeda)

## Penggunaan Praktis

### Skenario 1: Semua Valid
```
File KML berisi: ODC-GTL-FBD, ODP-ISM-FAV, Tiang-001
Database berisi: ODC-GTL-FBD, ODP-ISM-FAV, Tiang-001
Hasil: ✓ Semua baris hijau, 100% valid
```

### Skenario 2: Ada Typo
```
File KML berisi: ODC-GTL-FBD, ODP-ISM-FAV, Tiang-OO1 (typo, seharusnya 001)
Database berisi: ODC-GTL-FBD, ODP-ISM-FAV, Tiang-001
Hasil: 
- ODC-GTL-FBD: ✓ Hijau
- ODP-ISM-FAV: ✓ Hijau  
- Tiang-OO1: ✗ Merah dengan saran "Tiang-001"
```

### Skenario 3: Designator Baru
```
File KML berisi: ODC-NEW-001
Database: Tidak ada ODC-NEW-001
Hasil: ✗ Merah, "Tidak ditemukan di database"
Aksi: Tambahkan ODC-NEW-001 ke database melalui dashboard Designator
```

## Tips

1. **Sebelum Upload KML**: Pastikan data designator di database sudah lengkap
2. **Setelah Validasi**: Periksa semua baris merah dan kuning
3. **Update Database**: Jika menemukan designator baru yang valid, tambahkan ke database
4. **Case Sensitivity**: Sistem mengabaikan besar/kecil huruf (case-insensitive)
5. **Re-validasi**: Setelah update database atau file KML, validasi ulang

## Troubleshooting

### Tombol Validasi Disabled
- Pastikan sudah klik tombol "Proses" terlebih dahulu
- Pastikan ada data di preview table

### Semua Designator Invalid
- Cek koneksi database
- Pastikan tabel `designators` memiliki data
- Periksa nama kolom sesuai: `nama_designator`

### Saran Tidak Muncul
- Normal jika designator sangat berbeda (> 3 karakter)
- Fuzzy matching hanya mencari yang mirip (threshold 3)

## Maintenance

### Menambah Designator Baru
```
1. Buka Dashboard -> Designator
2. Tambah designator baru
3. Validasi ulang file KML
```

### Update Threshold Fuzzy Matching
Edit `DesignatorController.php`:
```php
private function findSimilar($input, $validDesignators, $threshold = 5) // ubah dari 3 ke 5
```

## Keamanan
- CSRF Token required untuk API call
- Authentication required (middleware: auth)
- Input validation untuk prevent SQL injection

---

**Version**: 1.0  
**Last Updated**: 2025-01-16
