# Modul LRA (Laporan Realisasi Anggaran) Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Membuat modul LRA lengkap (backend + admin panel + halaman publik) yang menggantikan halaman statis LRA.html, dengan upload file ke Google Drive mengikuti pola modul Itsbat.

**Architecture:** Flat table `lra_reports` dengan CRUD controller, Google Drive upload untuk file PDF dan cover image, admin panel Next.js untuk manajemen data, dan halaman publik Joomla-integration untuk embed di website.

**Tech Stack:** Lumen 11 (PHP 8.1), Next.js 15 + React 19 + TypeScript, Google Drive API, jQuery + DataTables (halaman publik)

---

### Task 1: Migration — Buat tabel `lra_reports`

**Files:**
- Create: `api-web/database/migrations/2026_04_01_000002_create_lra_reports_table.php`

**Step 1: Buat file migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lra_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('jenis_dipa', 10);
            $table->integer('triwulan');
            $table->string('judul', 255);
            $table->string('file_url', 500);
            $table->string('cover_url', 500)->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'jenis_dipa', 'triwulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lra_reports');
    }
};
```

**Step 2: Jalankan migration**

Run: `php artisan migrate`
Expected: Tabel `lra_reports` berhasil dibuat.

**Step 3: Commit**

```bash
git add database/migrations/2026_04_01_000002_create_lra_reports_table.php
git commit -m "feat(lra): tambah migration tabel lra_reports"
```

---

### Task 2: Model — Buat model `LraReport`

**Files:**
- Create: `api-web/app/Models/LraReport.php`

**Step 1: Buat file model**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LraReport extends Model
{
    protected $table = 'lra_reports';

    protected $fillable = [
        'tahun',
        'jenis_dipa',
        'triwulan',
        'judul',
        'file_url',
        'cover_url',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'triwulan' => 'integer',
    ];
}
```

**Step 2: Commit**

```bash
git add app/Models/LraReport.php
git commit -m "feat(lra): tambah model LraReport"
```

---

### Task 3: Controller — Buat `LraReportController`

**Files:**
- Create: `api-web/app/Http/Controllers/LraReportController.php`
- Reference: `api-web/app/Http/Controllers/ItsbatNikahController.php` (pola upload Google Drive)

**Step 1: Buat file controller**

Controller harus mengikuti pola existing:
- Private `$allowedFields` array
- `$request->only($this->allowedFields)` bukan `$request->all()`
- Validasi via `$this->validate()`
- Validasi tahun: `integer|min:2000|max:2100`
- Validasi triwulan: `integer|min:1|max:4`
- Validasi jenis_dipa: `in:DIPA 01,DIPA 04`
- Upload file_upload → `file_url` via GoogleDriveService
- Upload cover_upload → `cover_url` via GoogleDriveService
- Fallback ke local storage `public/uploads/lra/`
- Format respons: `['success' => true, 'data' => ...]`
- Pesan error dalam Bahasa Indonesia
- Sanitasi string: `strip_tags()` + `trim()`

```php
<?php

namespace App\Http\Controllers;

use App\Models\LraReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LraReportController extends Controller
{
    private $allowedFields = [
        'tahun',
        'jenis_dipa',
        'triwulan',
        'judul',
        'file_url',
        'cover_url',
    ];

    public function index(Request $request)
    {
        $query = LraReport::query();

        if ($request->has('tahun')) {
            $tahun = (int) $request->input('tahun');
            if ($tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        if ($request->has('jenis_dipa')) {
            $query->where('jenis_dipa', $request->input('jenis_dipa'));
        }

        $query->orderBy('tahun', 'desc')
              ->orderBy('jenis_dipa', 'asc')
              ->orderBy('triwulan', 'asc');

        $perPage = min((int) $request->input('limit', 10), 100);
        $data = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ]);
    }

    public function show($id)
    {
        $data = LraReport::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data LRA tidak ditemukan'
            ], 404);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required|integer|min:2000|max:2100',
            'jenis_dipa' => 'required|in:DIPA 01,DIPA 04',
            'triwulan' => 'required|integer|min:1|max:4',
            'judul' => 'required|string|max:255',
            'file_upload' => 'required|file|mimes:pdf|max:10240',
            'cover_upload' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $dataInput = $request->only($this->allowedFields);

        // Sanitasi string
        foreach (['judul', 'jenis_dipa'] as $field) {
            if (isset($dataInput[$field])) {
                $dataInput[$field] = trim(strip_tags($dataInput[$field]));
            }
        }

        // Upload file PDF ke Google Drive
        if ($request->hasFile('file_upload')) {
            $dataInput['file_url'] = $this->uploadToGoogleDrive(
                $request->file('file_upload'),
                $request,
                'lra'
            );
        }

        // Upload cover image ke Google Drive
        if ($request->hasFile('cover_upload')) {
            $dataInput['cover_url'] = $this->uploadToGoogleDrive(
                $request->file('cover_upload'),
                $request,
                'lra/covers'
            );
        }

        $data = LraReport::create($dataInput);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data LRA berhasil ditambahkan'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = LraReport::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data LRA tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'tahun' => 'required|integer|min:2000|max:2100',
            'jenis_dipa' => 'required|in:DIPA 01,DIPA 04',
            'triwulan' => 'required|integer|min:1|max:4',
            'judul' => 'required|string|max:255',
            'file_upload' => 'nullable|file|mimes:pdf|max:10240',
            'cover_upload' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $dataInput = $request->only($this->allowedFields);

        // Sanitasi string
        foreach (['judul', 'jenis_dipa'] as $field) {
            if (isset($dataInput[$field])) {
                $dataInput[$field] = trim(strip_tags($dataInput[$field]));
            }
        }

        // Upload file PDF baru ke Google Drive (jika ada)
        if ($request->hasFile('file_upload')) {
            $dataInput['file_url'] = $this->uploadToGoogleDrive(
                $request->file('file_upload'),
                $request,
                'lra'
            );
        }

        // Upload cover image baru ke Google Drive (jika ada)
        if ($request->hasFile('cover_upload')) {
            $dataInput['cover_url'] = $this->uploadToGoogleDrive(
                $request->file('cover_upload'),
                $request,
                'lra/covers'
            );
        }

        $data->update($dataInput);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data LRA berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $data = LraReport::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data LRA tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data LRA berhasil dihapus'
        ]);
    }

    /**
     * Upload file ke Google Drive dengan fallback ke local storage.
     * Mengikuti pola ItsbatNikahController.
     */
    private function uploadToGoogleDrive($file, Request $request, string $localFolder): string
    {
        try {
            if (!class_exists('\App\Services\GoogleDriveService')) {
                throw new \Exception('Class GoogleDriveService not found');
            }

            $driveService = new \App\Services\GoogleDriveService();
            $link = $driveService->upload($file);

            Log::info('File LRA berhasil diupload ke Google Drive', [
                'original_name' => $file->getClientOriginalName(),
                'link' => $link
            ]);

            return $link;
        } catch (\Throwable $e) {
            Log::error('Google Drive gagal untuk LRA. Menggunakan penyimpanan lokal.', [
                'error' => $e->getMessage()
            ]);

            try {
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                $destinationPath = app()->basePath('public/uploads/' . $localFolder);

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);

                $baseUrl = $request->root();
                return $baseUrl . '/uploads/' . $localFolder . '/' . $filename;
            } catch (\Throwable $localEx) {
                throw new \Exception('Gagal upload file (Drive & Local): ' . $e->getMessage());
            }
        }
    }
}
```

**Step 2: Commit**

```bash
git add app/Http/Controllers/LraReportController.php
git commit -m "feat(lra): tambah LraReportController dengan CRUD dan upload Google Drive"
```

---

### Task 4: Routes — Tambah route LRA di `web.php`

**Files:**
- Modify: `api-web/routes/web.php`

**Step 1: Tambah route public (setelah baris Sisa Panjar)**

Di grup public `throttle:100,1`, tambahkan:

```php
    // LRA Routes
    $router->get('lra', 'LraReportController@index');
    $router->get('lra/{id:[0-9]+}', 'LraReportController@show');
```

**Step 2: Tambah route protected (setelah baris Sisa Panjar)**

Di grup protected `api.key` + `throttle:100,1`, tambahkan:

```php
    // LRA
    $router->post('lra', 'LraReportController@store');
    $router->put('lra/{id:[0-9]+}', 'LraReportController@update');
    $router->post('lra/{id:[0-9]+}', 'LraReportController@update');
    $router->delete('lra/{id:[0-9]+}', 'LraReportController@destroy');
```

**Step 3: Commit**

```bash
git add routes/web.php
git commit -m "feat(lra): tambah route API /api/lra (public + protected)"
```

---

### Task 5: Seeder — Migrasi data dari LRA.html

**Files:**
- Create: `api-web/database/seeders/LraReportSeeder.php`

**Step 1: Buat seeder dengan 14 entri dari LRA.html**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LraReport;

class LraReportSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // 2025 - DIPA 01
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 1, 'judul' => 'LRA Triwulan 1 DIPA 01 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1FkkI_zMHbCi5rngDwduX27dNGTk8dIzS/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 2, 'judul' => 'LRA Triwulan 2 DIPA 01 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1uEqnubSl8sXcfcN7eKSlfqtoO5OWy_a8/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 3, 'judul' => 'LRA Triwulan 3 DIPA 01 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1gnZe_J-raFpDMpgvWAZqulZUiddZArN-/view?usp=sharing', 'cover_url' => null],
            // 2025 - DIPA 04
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 1, 'judul' => 'LRA Triwulan 1 DIPA 04 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1AWGs9LtbJC6a6gXOvHMBpWuHadQqYSTf/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 2, 'judul' => 'LRA Triwulan 2 DIPA 04 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1jAL7DD85GxaplGyeGInbVC5PkRUBmr-C/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 3, 'judul' => 'LRA Triwulan 3 DIPA 04 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/16naY0gdPtkado5Y3r2cEZ-puBsVxwX8z/view?usp=sharing', 'cover_url' => null],
            // 2024 - DIPA 01
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 1, 'judul' => 'LRA Triwulan 1 DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/19vGd1E-XM2EEMETG1gdTy9LtrFO9hJBD/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 2, 'judul' => 'LRA Triwulan 2 DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1tbVCIGzY1BZ8J97Zdv51imw4T76q3eEF/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 3, 'judul' => 'LRA Triwulan 3 DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/17tAXMpGoTILVflWmzFRpuuybx_ld6uRm/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'triwulan' => 4, 'judul' => 'LRA Triwulan 4 DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1JxETbqUVeUB6315klzvLwCzZCt_WoQw5/view', 'cover_url' => null],
            // 2024 - DIPA 04
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 1, 'judul' => 'LRA Triwulan 1 DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1rS3n-nWdWnKEhX-tFvVGpfBUUqPfe4yN/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 2, 'judul' => 'LRA Triwulan 2 DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1AKhhzSENWL2wat0ROIX7JITpQ4yHCAeK/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 3, 'judul' => 'LRA Triwulan 3 DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1KwvJJ9TpWPbDT-zAqFCofrvTXDybeP-U/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'triwulan' => 4, 'judul' => 'LRA Triwulan 4 DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1s2swxIrbWYxKnwJn4exJtKgd3RjHjITt/view', 'cover_url' => null],
        ];

        foreach ($data as $item) {
            LraReport::updateOrCreate(
                ['tahun' => $item['tahun'], 'jenis_dipa' => $item['jenis_dipa'], 'triwulan' => $item['triwulan']],
                $item
            );
        }
    }
}
```

**Step 2: Jalankan seeder**

Run: `php artisan db:seed --class=Database\\Seeders\\LraReportSeeder`
Expected: 14 records berhasil diinsert.

**Step 3: Commit**

```bash
git add database/seeders/LraReportSeeder.php
git commit -m "feat(lra): tambah seeder dengan 14 data existing dari LRA.html"
```

---

### Task 6: Admin Panel — Interface & API functions di `api.ts`

**Files:**
- Modify: `admin-panel/lib/api.ts`

**Step 1: Tambah interface `LraReport` (setelah interface terakhir)**

```typescript
export interface LraReport {
  id?: number;
  tahun: number;
  jenis_dipa: string;
  triwulan: number;
  judul: string;
  file_url: string;
  cover_url?: string;
  created_at?: string;
  updated_at?: string;
}
```

**Step 2: Tambah fungsi API CRUD (di akhir file)**

```typescript
// ==========================================
// API LRA (Laporan Realisasi Anggaran)
// ==========================================

// GET - Ambil semua data LRA
export async function getAllLra(tahun?: number, page = 1): Promise<ApiResponse<LraReport[]>> {
  let url = `${API_URL}/lra?page=${page}`;
  if (tahun) {
    url += `&tahun=${tahun}`;
  }
  const response = await fetch(url, { cache: 'no-store' });
  return response.json();
}

// GET - Ambil satu data LRA
export async function getLra(id: number): Promise<LraReport | null> {
  const response = await fetch(`${API_URL}/lra/${id}`);
  const result: ApiResponse<LraReport> = await response.json();
  return result.data || null;
}

// POST - Tambah data LRA
export async function createLra(data: LraReport | FormData): Promise<ApiResponse<LraReport>> {
  const isFormData = data instanceof FormData;
  const response = await fetch(`${API_URL}/lra`, {
    method: 'POST',
    headers: getHeaders(isFormData),
    body: isFormData ? data : JSON.stringify(data),
  });
  return response.json();
}

// PUT - Update data LRA
export async function updateLra(id: number, data: LraReport | FormData): Promise<ApiResponse<LraReport>> {
  const isFormData = data instanceof FormData;
  const method = isFormData ? 'POST' : 'PUT';
  if (isFormData) {
    (data as FormData).append('_method', 'PUT');
  }
  const response = await fetch(`${API_URL}/lra/${id}`, {
    method: method,
    headers: getHeaders(isFormData),
    body: isFormData ? data : JSON.stringify(data),
  });
  return response.json();
}

// DELETE - Hapus data LRA
export async function deleteLra(id: number): Promise<ApiResponse<null>> {
  const response = await fetch(`${API_URL}/lra/${id}`, {
    method: 'DELETE',
    headers: getHeaders(),
  });
  return response.json();
}
```

**Step 3: Commit**

```bash
git add lib/api.ts
git commit -m "feat(lra): tambah interface LraReport dan fungsi API CRUD di api.ts"
```

---

### Task 7: Admin Panel — Halaman List `app/lra/page.tsx`

**Files:**
- Create: `admin-panel/app/lra/page.tsx`
- Reference: `admin-panel/app/itsbat/page.tsx` (pola yang sama)

**Step 1: Buat halaman list**

Ikuti pola `itsbat/page.tsx`:
- `'use client'` di baris pertama
- Import dari `@/lib/api`: `getAllLra`, `deleteLra`, `type LraReport`
- Filter tahun (Select dropdown)
- Tabel kolom: No, Tahun, Jenis DIPA, Triwulan, Judul, Cover (thumbnail), Aksi (Edit, Hapus)
- Pagination dengan `renderPaginationItems()`
- AlertDialog untuk konfirmasi hapus
- BlurFade animation
- Tombol "Tambah Data" warna emerald-600 (tema keuangan)

**Step 2: Commit**

```bash
git add app/lra/page.tsx
git commit -m "feat(lra): tambah halaman list admin panel app/lra/page.tsx"
```

---

### Task 8: Admin Panel — Halaman Tambah `app/lra/tambah/page.tsx`

**Files:**
- Create: `admin-panel/app/lra/tambah/page.tsx`
- Reference: `admin-panel/app/itsbat/tambah/page.tsx` (pola upload file)

**Step 1: Buat halaman tambah**

Ikuti pola `itsbat/tambah/page.tsx`:
- `'use client'` di baris pertama
- Form fields:
  - Tahun: Select dropdown (`getYearOptions()`)
  - Jenis DIPA: Select dropdown (`DIPA 01`, `DIPA 04`)
  - Triwulan: Select dropdown (1, 2, 3, 4)
  - Judul: Input text (required)
  - File Laporan: Input file (accept: `.pdf`, required)
  - Cover Image: Input file (accept: `.jpg,.jpeg,.png,.webp`, optional)
- FormData submission dengan `createLra()`
- Toast feedback sukses/gagal
- Redirect ke `/lra` setelah sukses
- Tombol Simpan warna green-600

**Step 2: Commit**

```bash
git add app/lra/tambah/page.tsx
git commit -m "feat(lra): tambah halaman form tambah app/lra/tambah/page.tsx"
```

---

### Task 9: Admin Panel — Halaman Edit `app/lra/[id]/edit/page.tsx`

**Files:**
- Create: `admin-panel/app/lra/[id]/edit/page.tsx`
- Reference: `admin-panel/app/itsbat/[id]/edit/page.tsx` (pola edit + upload)

**Step 1: Buat halaman edit**

Ikuti pola `itsbat/[id]/edit/page.tsx`:
- `'use client'` di baris pertama
- Load existing data via `getLra(id)` di useEffect
- Form sama dengan halaman tambah tapi pre-filled
- Tampilkan link file existing (jika ada) dengan ikon ExternalLink
- Tampilkan preview cover existing (jika ada) sebagai thumbnail
- Upload file/cover bersifat opsional (hanya replace jika ada file baru)
- FormData submission dengan `updateLra(id, data)`
- Toast feedback sukses/gagal

**Step 2: Commit**

```bash
git add app/lra/[id]/edit/page.tsx
git commit -m "feat(lra): tambah halaman form edit app/lra/[id]/edit/page.tsx"
```

---

### Task 10: Admin Panel — Tambah navigasi sidebar

**Files:**
- Modify: `admin-panel/components/app-sidebar.tsx`

**Step 1: Tambah menu LRA di sidebar**

Tambahkan setelah entri "Realisasi Anggaran":

```typescript
{
    label: 'LRA',
    icon: FileBarChart,  // atau BarChart3
    href: '/lra',
    color: 'text-cyan-500',
},
```

Import icon `FileBarChart` dari `lucide-react`.

**Step 2: Commit**

```bash
git add components/app-sidebar.tsx
git commit -m "feat(lra): tambah menu LRA di sidebar admin panel"
```

---

### Task 11: Halaman Publik — `joomla-integration-lra.html`

**Files:**
- Create: `api-web/docs/joomla-integration-lra.html`
- Reference: `api-web/docs/joomla-integration-anggaran.html` dan `api-web/docs/sisa-panjar.html`

**Step 1: Buat halaman publik**

Halaman ini akan di-embed di Joomla. Fitur:
- Fetch data dari API `/api/lra?tahun=YYYY&limit=100`
- Tab per tahun (tahun terbaru di depan)
- Sub-section per jenis DIPA (DIPA 01, DIPA 04)
- Grid card (4 kolom) per triwulan:
  - Cover image sebagai thumbnail (jika ada)
  - Placeholder card jika cover tidak ada (dengan teks judul)
  - Klik card → buka `file_url` di tab baru
- Filter tahun (select dropdown)
- Tema warna cyan/teal (konsisten dengan warna sidebar)
- jQuery 3.7.1 dari CDN
- Responsive design

**Step 2: Commit**

```bash
git add docs/joomla-integration-lra.html
git commit -m "feat(lra): tambah halaman publik joomla-integration-lra.html"
```

---

### Task 12: Verifikasi & Build

**Step 1: Verifikasi backend**

Run: `php artisan migrate` (di api-web/)
Run: `php -S localhost:8000 -t public` dan test endpoint:
- GET `/api/lra` → harus return 14 records
- GET `/api/lra?tahun=2025` → harus return 6 records

**Step 2: Verifikasi frontend**

Run: `npm run lint` (di admin-panel/)
Run: `npm run build` (di admin-panel/)
Expected: Tidak ada error TypeScript atau lint.

**Step 3: Final commit**

```bash
git add -A
git commit -m "feat(lra): modul LRA lengkap - backend, admin panel, halaman publik"
```
