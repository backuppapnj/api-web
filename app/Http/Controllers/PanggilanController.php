<?php

namespace App\Http\Controllers;

use App\Models\Panggilan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PanggilanController extends Controller
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
        'panggilan_ikrar',
        'tanggal_sidang',
        'pip',
        'link_surat',
        'keterangan'
    ];

    /**
     * Ambil semua data panggilan (PUBLIC - Read Only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Panggilan::query();

        // SECURITY: Validasi dan sanitasi parameter tahun
        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun_perkara', $tahun);
            }
        }

        // SECURITY: Limit hasil untuk mencegah memory exhaustion
        $limit = min((int) $request->get('limit', 500), 1000);

        $data = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count()
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

        $data = Panggilan::where('tahun_perkara', $tahun)
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

        $panggilan = Panggilan::find($id);

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
            'panggilan_ikrar' => 'nullable|date',
            'tanggal_sidang' => 'nullable|date',
            'pip' => 'nullable|string|max:100',
            'link_surat' => 'nullable|url|max:500',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // SECURITY: Hanya ambil field yang diizinkan (prevent mass assignment)
        $data = $request->only($this->allowedFields);

        // SECURITY: Sanitasi input teks
        $data = $this->sanitizeInput($data);

        $panggilan = Panggilan::create($data);

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

        $panggilan = Panggilan::find($id);

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
            'panggilan_ikrar' => 'nullable|date',
            'tanggal_sidang' => 'nullable|date',
            'pip' => 'nullable|string|max:100',
            'link_surat' => 'nullable|url|max:500',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // SECURITY: Hanya ambil field yang diizinkan
        $data = $request->only($this->allowedFields);

        // SECURITY: Sanitasi input
        $data = $this->sanitizeInput($data);

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

        $panggilan = Panggilan::find($id);

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

    /**
     * SECURITY: Sanitasi input untuk mencegah XSS
     */
    private function sanitizeInput(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($value) && $key !== 'link_surat') {
                // Hapus tag HTML (kecuali untuk URL)
                $data[$key] = strip_tags($value);
                // Trim whitespace
                $data[$key] = trim($data[$key]);
            }
        }
        return $data;
    }
}
