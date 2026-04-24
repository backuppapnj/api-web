# Design: WYSIWYG Editor + Modal Uraian Tugas

## Overview
Menambahkan WYSIWYG editor (TipTap) untuk mengisi kolom `uraian_tugas` di admin panel, dan modal popup di integrasi Joomla untuk menampilkan isi uraian tugas saat card diklik.

## Backend
- **No changes required**. Model `UraianTugas` dan controller `UraianTugasController` sudah support field `uraian_tugas` (longtext, nullable).

## Admin Panel — TipTap WYSIWYG Editor
- **Library**: TipTap with `@tiptap/react`, `@tiptap/starter-kit`
- **Features**: Bold, Italic, Heading (H1/H2), Bullet List, Ordered List, Link
- **No image support** (text-only sesuai kebutuhan)
- **Files modified**:
  - `admin-panel/components/TiptapEditor.tsx` (new reusable component)
  - `admin-panel/app/uraian-tugas/tambah/page.tsx`
  - `admin-panel/app/uraian-tugas/[id]/edit/page.tsx`
- **Output**: HTML string disimpan ke field `uraian_tugas`

## Joomla Integration — Modal Uraian Tugas
- **File modified**: `api-web/docs/joomla-integration-uraian-tugas.html`
- Card dengan `uraian_tugas` menjadi clickable dengan indikator visual
- Saat diklik, modal overlay muncul menampilkan HTML content dari `uraian_tugas`
- Card tanpa `uraian_tugas` tetap tidak clickable
- **Bug fix**: `status_kepegawaian` (field lama) diganti ke `item.jenis_pegawai?.nama`
- **Compatibility**: CSS modal menggunakan vanilla CSS tanpa framework, kompatibel dengan Joomla 3

## Data Flow
```
[Admin Form] → TipTap HTML → API POST/PUT → DB (uraian_tugas longtext)
[Joomla Page] → API GET → Card clickable → Modal render HTML
```
