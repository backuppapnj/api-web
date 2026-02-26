<?php

namespace App\Http\Controllers;

use App\Models\PanggilanEcourt;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PanggilanEcourtController extends Controller
{
    /**
     * SECURITY: Daftar kolom yang diizinkan untuk mass assignment
     */
    private array $allowedFields = [
        'tahun_perkara',
        'nomor_perkara',
        'nama_dipanggil',
        'alamat_asal',
        'panggilan_1',
        'panggilan_2',
        'panggilan_3',
        'panggilan_ikrar',
        'tanggal_sidang',
        'pip',
        'link_surat',
        'keterangan'
    ];

    /**
     * Ambil semua data panggilan ecourt (PUBLIC - Read Only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = PanggilanEcourt::query();

        // SECURITY: Validasi dan sanitasi parameter tahun
        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun_perkara', $tahun);
            }
        }

        // SECURITY: Limit hasil untuk mencegah memory exhaustion
        // Default 500 query, Max 2000 (Cukup untuk load data tahunan)
        $limit = min((int) $request->get('limit', 500), 2000);

        $data = $query->orderBy('created_at', 'desc')
            ->paginate($limit);

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ]);
    }

    /**
     * Ambil data berdasarkan tahun (PUBLIC - Read Only)
     */
    public function byYear(int $tahun): JsonResponse
    {
        // SECURITY: Validasi tahun
        if ($tahun < 2000 || $tahun > 2100) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun tidak valid'
            ], 400);
        }

        $data = PanggilanEcourt::where('tahun_perkara', $tahun)
            ->orderBy('created_at', 'desc')
            ->limit(500)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    /**
     * Ambil detail satu data (PUBLIC - Read Only)
     */
    public function show(int $id): JsonResponse
    {
        // SECURITY: Validasi ID positif
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $panggilan = PanggilanEcourt::find($id);

        if (!$panggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $panggilan
        ]);
    }

    /**
     * Simpan data baru (PROTECTED - Butuh API Key)
     */
    public function store(Request $request): JsonResponse
    {
        // SECURITY: Validasi ketat untuk semua input
        $this->validate($request, [
            'tahun_perkara' => 'required|integer|min:2000|max:2100',
            'nomor_perkara' => 'required|string|max:50|regex:/^[0-9\/\.a-zA-Z]+$/',
            'nama_dipanggil' => 'required|string|max:255',
            'alamat_asal' => 'nullable|string|max:1000',
            'panggilan_1' => 'nullable|date',
            'panggilan_2' => 'nullable|date',
            'panggilan_3' => 'nullable|date',
            'panggilan_ikrar' => 'nullable|date',
            'tanggal_sidang' => 'nullable|date',
            'pip' => 'nullable|string|max:100',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // SECURITY: Hanya ambil field yang diizinkan (prevent mass assignment)
        $data = $request->only($this->allowedFields);

        // SECURITY: Sanitasi input teks (skip strip_tags untuk link_surat dan nomor_perkara)
        $data = $this->sanitizeInput($data, ['link_surat', 'nomor_perkara']);

        // Handle File Upload
        if ($request->hasFile('file_upload')) {
            try {
                // Cek apakah class GoogleDriveService ada sebelum instansiasi
                if (!class_exists('\App\Services\GoogleDriveService')) {
                    throw new \Exception('Class GoogleDriveService not found');
                }

                $driveService = new \App\Services\GoogleDriveService();
                $link = $driveService->upload($request->file('file_upload'));
                $data['link_surat'] = $link;

                \Illuminate\Support\Facades\Log::info('File Panggilan Ecourt berhasil diupload ke Google Drive', [
                    'nomor_perkara' => $request->nomor_perkara,
                    'link' => $link
                ]);
            } catch (\Throwable $e) {
                // FALLBACK: Simpan ke Local Storage jika Google Drive gagal
                \Illuminate\Support\Facades\Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                    'nomor_perkara' => $request->nomor_perkara,
                    'error' => $e->getMessage()
                ]);

                try {
                    $file = $request->file('file_upload');
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                    $destinationPath = app()->basePath('public/uploads/panggilan_ecourt'); // Separate folder

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);

                    // Generate URL (sesuaikan dengan domain server)
                    // Menggunakan env('APP_URL') atau request()->root()
                    $baseUrl = $request->root();
                    $link = $baseUrl . '/uploads/panggilan_ecourt/' . $filename;

                    $data['link_surat'] = $link;

                    \Illuminate\Support\Facades\Log::info('File disimpan di lokal (Fallback)', ['link' => $link]);
                } catch (\Throwable $localEx) {
                    // Jika local storage juga gagal, baru return error
                    \Illuminate\Support\Facades\Log::error('Gagal simpan lokal', ['error' => $localEx->getMessage()]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal upload file (Drive & Local): ' . $e->getMessage()
                    ], 500);
                }
            }
        }

        $panggilan = PanggilanEcourt::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $panggilan
        ], 201);
    }

    /**
     * Update data (PROTECTED - Butuh API Key)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // SECURITY: Validasi ID
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $panggilan = PanggilanEcourt::find($id);

        if (!$panggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // SECURITY: Validasi input
        $this->validate($request, [
            'tahun_perkara' => 'sometimes|integer|min:2000|max:2100',
            'nomor_perkara' => 'sometimes|string|max:50|regex:/^[0-9\/\.a-zA-Z]+$/',
            'nama_dipanggil' => 'sometimes|string|max:255',
            'alamat_asal' => 'nullable|string|max:1000',
            'panggilan_1' => 'nullable|date',
            'panggilan_2' => 'nullable|date',
            'panggilan_3' => 'nullable|date',
            'panggilan_ikrar' => 'nullable|date',
            'tanggal_sidang' => 'nullable|date',
            'pip' => 'nullable|string|max:100',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // SECURITY: Hanya ambil field yang diizinkan
        $data = $request->only($this->allowedFields);

        // SECURITY: Sanitasi input (skip strip_tags untuk link_surat dan nomor_perkara)
        $data = $this->sanitizeInput($data, ['link_surat', 'nomor_perkara']);

        // Handle File Upload
        if ($request->hasFile('file_upload')) {
            try {
                if (!class_exists('\App\Services\GoogleDriveService')) {
                    throw new \Exception('Class GoogleDriveService not found');
                }

                $driveService = new \App\Services\GoogleDriveService();
                $link = $driveService->upload($request->file('file_upload'));
                $data['link_surat'] = $link;

                \Illuminate\Support\Facades\Log::info('File Update Panggilan Ecourt berhasil diupload ke Google Drive', [
                    'id' => $id,
                    'nomor_perkara' => $request->nomor_perkara ?? $panggilan->nomor_perkara,
                    'link' => $link
                ]);
            } catch (\Throwable $e) {
                // FALLBACK: Simpan ke Local Storage jika Google Drive gagal
                \Illuminate\Support\Facades\Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                    'nomor_perkara' => $request->nomor_perkara,
                    'error' => $e->getMessage()
                ]);

                try {
                    $file = $request->file('file_upload');
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                    $destinationPath = app()->basePath('public/uploads/panggilan_ecourt');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);

                    $baseUrl = $request->root();
                    $link = $baseUrl . '/uploads/panggilan_ecourt/' . $filename;

                    $data['link_surat'] = $link;

                    \Illuminate\Support\Facades\Log::info('File disimpan di lokal (Fallback)', ['link' => $link]);
                } catch (\Throwable $localEx) {
                    \Illuminate\Support\Facades\Log::error('Gagal simpan lokal', ['error' => $localEx->getMessage()]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal upload file (Drive & Local): ' . $e->getMessage()
                    ], 500);
                }
            }
        }

        $panggilan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $panggilan->fresh()
        ]);
    }

    /**
     * Hapus data (PROTECTED - Butuh API Key)
     */
    public function destroy(int $id): JsonResponse
    {
        // SECURITY: Validasi ID
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $panggilan = PanggilanEcourt::find($id);

        if (!$panggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $panggilan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

}
