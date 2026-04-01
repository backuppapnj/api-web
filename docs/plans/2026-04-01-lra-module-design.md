# Desain Modul LRA (Laporan Realisasi Anggaran)

**Tanggal:** 2026-04-01
**Status:** Disetujui

## Ringkasan

Modul LRA mengelola dokumen Laporan Realisasi Anggaran per triwulan per jenis DIPA. Menggantikan halaman statis `LRA.html` yang sebelumnya hardcoded dengan link Google Drive.

## Keputusan Desain

- **Hosting file:** Upload ke Google Drive via `GoogleDriveService` (pola Itsbat), fallback ke local storage.
- **Cover image:** Upload juga ke Google Drive, terpisah dari file PDF.
- **Arsitektur:** Flat table (satu tabel `lra_reports`), bukan normalized. DIPA hanya 2 nilai statis.
- **Pola modul:** Mengikuti pola 1:1:1 existing (Controller, Model, Halaman frontend).

## Database — Tabel `lra_reports`

| Field | Tipe | Validasi | Keterangan |
|---|---|---|---|
| `id` | bigint (PK) | auto | |
| `tahun` | integer | 2000-2100 | Tahun laporan |
| `jenis_dipa` | string(10) | `DIPA 01` / `DIPA 04` | Jenis DIPA |
| `triwulan` | integer | 1-4 | Triwulan ke- |
| `judul` | string(255) | required | Judul laporan |
| `file_url` | string(500) | required | Link Google Drive PDF |
| `cover_url` | string(500) | nullable | Link Google Drive cover image |
| `created_at` | timestamp | | |
| `updated_at` | timestamp | | |

**Constraint:** Unique composite `(tahun, jenis_dipa, triwulan)`.

## API Endpoints — Route `/api/lra`

| Method | Endpoint | Middleware | Fungsi |
|---|---|---|---|
| GET | `/api/lra` | public (throttle:100,1) | List semua, filter `?tahun=` |
| GET | `/api/lra/{id}` | public (throttle:100,1) | Detail satu laporan |
| POST | `/api/lra` | api.key + throttle | Tambah (upload file + cover ke GDrive) |
| PUT | `/api/lra/{id}` | api.key + throttle | Edit (opsional ganti file/cover) |
| DELETE | `/api/lra/{id}` | api.key + throttle | Hapus |

### Upload Flow

1. Frontend mengirim FormData dengan `file_upload` (PDF) dan `cover_upload` (image).
2. Controller memanggil `GoogleDriveService::upload()` untuk masing-masing file.
3. URL hasil upload disimpan di `file_url` dan `cover_url`.
4. Jika Google Drive gagal, fallback ke `public/uploads/lra/`.

### Format Respons

```json
{
  "success": true,
  "data": [...],
  "total": 14,
  "current_page": 1,
  "last_page": 1,
  "per_page": 10
}
```

## Admin Panel — `app/lra/`

| Halaman | Path | Fungsi |
|---|---|---|
| List | `app/lra/page.tsx` | Tabel dengan filter tahun, kolom: Tahun, DIPA, Triwulan, Judul, Cover, Aksi |
| Tambah | `app/lra/tambah/page.tsx` | Form: tahun, jenis_dipa (select), triwulan (select 1-4), judul, upload file PDF, upload cover image |
| Edit | `app/lra/[id]/edit/page.tsx` | Form edit, tampilkan file/cover existing |

### Form Fields

- **Tahun**: Input number (default tahun sekarang)
- **Jenis DIPA**: Select dropdown (`DIPA 01`, `DIPA 04`)
- **Triwulan**: Select dropdown (1, 2, 3, 4)
- **Judul**: Input text
- **File Laporan**: Input file (accept: .pdf)
- **Cover Image**: Input file (accept: .jpg,.jpeg,.png,.webp)

## Halaman Publik — `api-web/docs/joomla-integration-lra.html`

- Pola `joomla-integration-*` untuk embed di Joomla
- Tab per tahun
- Grid card per triwulan dengan cover image
- Klik card → buka link Google Drive PDF
- Sub-section per jenis DIPA
- Fetch data dari API `/api/lra?tahun=...`

## Data Seed (dari LRA.html existing)

### 2025 — DIPA 01 (3 entri)
| Triwulan | File URL | Cover |
|---|---|---|
| 1 | `https://drive.google.com/file/d/1FkkI_zMHbCi5rngDwduX27dNGTk8dIzS/view?usp=sharing` | `images/COVER_LAP_TR1_O1.png` |
| 2 | `https://drive.google.com/file/d/1uEqnubSl8sXcfcN7eKSlfqtoO5OWy_a8/view?usp=sharing` | `images/COVER_LAP_TR2_O1.png` |
| 3 | `https://drive.google.com/file/d/1gnZe_J-raFpDMpgvWAZqulZUiddZArN-/view?usp=sharing` | `images/COVER_LAP_TR3_O1.png` |

### 2025 — DIPA 04 (3 entri)
| Triwulan | File URL | Cover |
|---|---|---|
| 1 | `https://drive.google.com/file/d/1AWGs9LtbJC6a6gXOvHMBpWuHadQqYSTf/view?usp=sharing` | `images/COVER_LAP_TR1_O1.png` |
| 2 | `https://drive.google.com/file/d/1jAL7DD85GxaplGyeGInbVC5PkRUBmr-C/view?usp=sharing` | `images/COVER_LAP_TR2_O1.png` |
| 3 | `https://drive.google.com/file/d/16naY0gdPtkado5Y3r2cEZ-puBsVxwX8z/view?usp=sharing` | `images/COVER_LAP_TR3_O1.png` |

### 2024 — DIPA 01 (4 entri)
| Triwulan | File URL | Cover |
|---|---|---|
| 1 | `https://drive.google.com/file/d/19vGd1E-XM2EEMETG1gdTy9LtrFO9hJBD/view` | `/images/keuangan/LRA_2024_S1.webp` |
| 2 | `https://drive.google.com/file/d/1tbVCIGzY1BZ8J97Zdv51imw4T76q3eEF/view` | `/images/keuangan/LRA_2024_S2.webp` |
| 3 | `https://drive.google.com/file/d/17tAXMpGoTILVflWmzFRpuuybx_ld6uRm/view` | `/images/keuangan/LRA_2024_S3.webp` |
| 4 | `https://drive.google.com/file/d/1JxETbqUVeUB6315klzvLwCzZCt_WoQw5/view` | `/images/keuangan/LRA_2024_S4.webp` |

### 2024 — DIPA 04 (4 entri)
| Triwulan | File URL | Cover |
|---|---|---|
| 1 | `https://drive.google.com/file/d/1rS3n-nWdWnKEhX-tFvVGpfBUUqPfe4yN/view` | `/images/keuangan/LRA_2024_S1.webp` |
| 2 | `https://drive.google.com/file/d/1AKhhzSENWL2wat0ROIX7JITpQ4yHCAeK/view` | `/images/keuangan/LRA_2024_S2.webp` |
| 3 | `https://drive.google.com/file/d/1KwvJJ9TpWPbDT-zAqFCofrvTXDybeP-U/view` | `/images/keuangan/LRA_2024_S3.webp` |
| 4 | `https://drive.google.com/file/d/1s2swxIrbWYxKnwJn4exJtKgd3RjHjITt/view` | `/images/keuangan/LRA_2024_S4.webp` |

Total: 14 entri seed data.
