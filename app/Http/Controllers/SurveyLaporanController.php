<?php

namespace App\Http\Controllers;

use App\Models\SurveyLaporan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SurveyLaporanController extends Controller
{
    /**
     * Kategori laporan survey yang valid
     */
    const KATEGORI = [
        'IKM',           // Survei Kepuasan Masyarakat
        'IPAK',          // Indeks Persepsi Anti Korupsi
        'TINDAK_LANJUT', // Tindak Lanjut Hasil Survei
    ];

    private array $allowedFields = [
        'kategori',
        'tahun',
        'periode',
        'urutan',
        'nilai_indeks',
        'kategori_mutu',
        'jumlah_responden',
        'unsur_terendah',
        'unsur_tertinggi',
        'kesimpulan',
        'rekomendasi',
        'gambar_url',
        'link_dokumen',
    ];

    /**
     * Validasi field tambahan yang dipakai di store & update.
     */
    private array $scoreValidation = [
        'nilai_indeks'     => 'nullable|numeric|min:0|max:100',
        'kategori_mutu'    => 'nullable|string|max:30',
        'jumlah_responden' => 'nullable|integer|min:0|max:100000',
        'unsur_terendah'   => 'nullable|string|max:255',
        'unsur_tertinggi'  => 'nullable|string|max:255',
        'kesimpulan'       => 'nullable|string|max:5000',
        'rekomendasi'      => 'nullable|string|max:5000',
    ];

    /**
     * Ambil semua data Survey Laporan (PUBLIC)
     */
    public function index(Request $request): JsonResponse
    {
        $query = SurveyLaporan::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        if ($request->has('kategori')) {
            $kategori = $request->kategori;
            if (in_array($kategori, self::KATEGORI)) {
                $query->where('kategori', $kategori);
            }
        }

        $data = $query->orderBy('tahun', 'desc')
            ->orderBy('kategori', 'asc')
            ->orderBy('urutan', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil data berdasarkan tahun (PUBLIC)
     */
    public function byYear(int $tahun): JsonResponse
    {
        if ($tahun < 2000 || $tahun > 2100) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun tidak valid'
            ], 400);
        }

        $data = SurveyLaporan::where('tahun', $tahun)
            ->orderBy('kategori', 'asc')
            ->orderBy('urutan', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil satu data
     */
    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = SurveyLaporan::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    /**
     * Simpan data baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $rules = array_merge([
            'kategori'     => 'required|string',
            'tahun'        => 'required|integer|min:2000|max:2100',
            'periode'      => 'required|string|max:100',
            'urutan'       => 'nullable|integer|min:1|max:99',
            'gambar_url'   => 'nullable|string|max:500',
            'link_dokumen' => 'nullable|string|max:500',
            'file_gambar'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ], $this->scoreValidation);
        $this->validate($request, $rules);

        if (!in_array($request->kategori, self::KATEGORI)) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid. Pilihan: ' . implode(', ', self::KATEGORI)
            ], 422);
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields));
        if (!isset($data['urutan']) || $data['urutan'] === null) {
            $data['urutan'] = 1;
        }

        // Upload gambar (opsional)
        if ($request->hasFile('file_gambar')) {
            $url = $this->uploadFile($request->file('file_gambar'), $request, 'survey/laporan');
            if ($url) $data['gambar_url'] = $url;
        }
        // Upload dokumen (opsional)
        if ($request->hasFile('file_dokumen')) {
            $url = $this->uploadFile($request->file('file_dokumen'), $request, 'survey/laporan');
            if ($url) $data['link_dokumen'] = $url;
        }

        $item = SurveyLaporan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $item
        ], 201);
    }

    /**
     * Perbarui data (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = SurveyLaporan::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $rules = array_merge([
            'kategori'     => 'sometimes|required|string',
            'tahun'        => 'sometimes|required|integer|min:2000|max:2100',
            'periode'      => 'sometimes|required|string|max:100',
            'urutan'       => 'nullable|integer|min:1|max:99',
            'gambar_url'   => 'nullable|string|max:500',
            'link_dokumen' => 'nullable|string|max:500',
            'file_gambar'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ], $this->scoreValidation);
        $this->validate($request, $rules);

        if ($request->has('kategori') && !in_array($request->kategori, self::KATEGORI)) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid. Pilihan: ' . implode(', ', self::KATEGORI)
            ], 422);
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        if ($request->hasFile('file_gambar')) {
            $url = $this->uploadFile($request->file('file_gambar'), $request, 'survey/laporan');
            if ($url) $data['gambar_url'] = $url;
        }
        if ($request->hasFile('file_dokumen')) {
            $url = $this->uploadFile($request->file('file_dokumen'), $request, 'survey/laporan');
            if ($url) $data['link_dokumen'] = $url;
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $item->fresh()
        ]);
    }

    /**
     * Hapus data (PROTECTED)
     */
    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = SurveyLaporan::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
