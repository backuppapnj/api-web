# Uraian Tugas Module — Design Document

**Date:** 2026-04-23  
**Status:** Approved

## Latar Belakang

Halaman `uraian-tugas.html` pada Joomla saat ini adalah tabel statis 3 kolom (Nama | Jabatan | Download) yang sudah tidak diperbarui sejak 1 September 2021. Banyak data tidak konsisten: nama kosong, link download tidak aktif, tidak ada pengelompokan jabatan, tidak ada foto pegawai.

## Tujuan

Membangun modul Uraian Tugas yang:
1. Dikelola penuh dari admin panel (CRUD).
2. Menampilkan pegawai dalam **card grid** dengan foto/avatar inisial.
3. Diorganisir dalam **tab per kelompok jabatan** yang dinamis (tidak hardcoded).
4. Terintegrasi ke Joomla via satu file HTML seperti modul-modul sebelumnya.

---

## Arsitektur Database

### Tabel `kelompok_jabatan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint UNSIGNED AI PK | |
| `nama_kelompok` | varchar(100) | Contoh: "Pimpinan", "Kepaniteraan" |
| `urutan` | int DEFAULT 0 | Urutan tampil di tab |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Tabel `uraian_tugas`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint UNSIGNED AI PK | |
| `nama` | varchar(255) NULLABLE | Nama pegawai, opsional |
| `jabatan` | varchar(255) | Required |
| `kelompok_jabatan_id` | bigint UNSIGNED FK | → kelompok_jabatan.id |
| `nip` | varchar(30) NULLABLE | |
| `status_kepegawaian` | enum('PNS','PPNPN','CASN') NULLABLE | |
| `foto_url` | varchar(500) NULLABLE | URL foto eksternal |
| `link_dokumen` | varchar(500) NULLABLE | Google Drive URL uraian tugas |
| `urutan` | int DEFAULT 0 | Urutan dalam kelompok |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

## Backend (Lumen API)

**2 Controller baru:**
- `KelompokJabatanController` — CRUD kelompok jabatan
- `UraianTugasController` — CRUD pegawai dengan filter `kelompok_jabatan_id`

**Routes PUBLIC:**
```
GET /api/kelompok-jabatan
GET /api/kelompok-jabatan/{id}
GET /api/uraian-tugas
GET /api/uraian-tugas/{id}
```

**Routes PROTECTED (API Key):**
```
POST   /api/kelompok-jabatan
PUT    /api/kelompok-jabatan/{id}
DELETE /api/kelompok-jabatan/{id}
POST   /api/uraian-tugas
PUT    /api/uraian-tugas/{id}
DELETE /api/uraian-tugas/{id}
```

---

## Frontend (Next.js Admin Panel)

**Halaman baru:**
- `/uraian-tugas` — list pegawai + filter kelompok + tombol "Kelola Kelompok" (Sheet dialog inline)
- `/uraian-tugas/tambah` — form tambah pegawai
- `/uraian-tugas/[id]/edit` — form edit pegawai

**Sidebar:** tambah 1 menu "Uraian Tugas" dengan icon `Users`.

---

## Joomla Integration

File: `docs/joomla-integration-uraian-tugas.html`

- Tab navigasi horizontal per kelompok (dari API `/kelompok-jabatan`)
- Card grid per pegawai: foto / avatar inisial, nama/TBA, jabatan, badge status, tombol Download
- Search/filter client-side
- Responsive (mobile-friendly)
- Pola CSS dan JS konsisten dengan `mediasi-integration.html`
