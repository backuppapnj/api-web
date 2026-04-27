<?php

namespace App\Http\Controllers;

use App\Models\SurveyPekan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SurveyPekanController extends Controller
{
    private array $allowedFields = [
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'gambar_ikm',
        'link_ikm',
        'nilai_ikm',
        'gambar_ipkp',
        'link_ipkp',
        'nilai_ipkp',
        'gambar_ipak',
        'link_ipak',
        'nilai_ipak',
        'total_responden',
        'catatan',
    ];

    /**
     * Validasi field skor mingguan, dipakai di store & update.
     */
    private array $scoreValidation = [
        'nilai_ikm'        => 'nullable|numeric|min:0|max:100',
        'nilai_ipkp'       => 'nullable|numeric|min:0|max:100',
        'nilai_ipak'       => 'nullable|numeric|min:0|max:100',
        'total_responden'  => 'nullable|integer|min:0|max:100000',
        'catatan'          => 'nullable|string|max:5000',
    ];

    /**
     * Field upload file dan kolom URL tujuannya
     */
    private array $uploadMap = [
        'file_gambar_ikm'  => 'gambar_ikm',
        'file_gambar_ipkp' => 'gambar_ipkp',
        'file_gambar_ipak' => 'gambar_ipak',
    ];

    /**
     * Ambil semua data Pekan Survei (PUBLIC)
     */
    public function index(Request $request): JsonResponse
    {
        $query = SurveyPekan::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        $data = $query->orderBy('tanggal_mulai', 'desc')->get();

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

        $data = SurveyPekan::where('tahun', $tahun)
            ->orderBy('tanggal_mulai', 'desc')
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

        $item = SurveyPekan::find($id);
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
            'tahun'           => 'required|integer|min:2000|max:2100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'gambar_ikm'      => 'nullable|string|max:500',
            'link_ikm'        => 'nullable|string|max:500',
            'gambar_ipkp'     => 'nullable|string|max:500',
            'link_ipkp'       => 'nullable|string|max:500',
            'gambar_ipak'     => 'nullable|string|max:500',
            'link_ipak'       => 'nullable|string|max:500',
            'file_gambar_ikm'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_gambar_ipkp' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_gambar_ipak' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], $this->scoreValidation);
        $this->validate($request, $rules);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        // Auto-derive tahun dari tanggal_mulai jika tidak sesuai
        if (!empty($data['tanggal_mulai'])) {
            $derivedYear = (int) date('Y', strtotime($data['tanggal_mulai']));
            if ($derivedYear) $data['tahun'] = $derivedYear;
        }

        // Upload tiap gambar bila ada
        foreach ($this->uploadMap as $fileKey => $urlKey) {
            if ($request->hasFile($fileKey)) {
                $url = $this->uploadFile($request->file($fileKey), $request, 'survey/pekan');
                if ($url) $data[$urlKey] = $url;
            }
        }

        $item = SurveyPekan::create($data);

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

        $item = SurveyPekan::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $rules = array_merge([
            'tahun'           => 'sometimes|required|integer|min:2000|max:2100',
            'tanggal_mulai'   => 'sometimes|required|date',
            'tanggal_selesai' => 'sometimes|required|date|after_or_equal:tanggal_mulai',
            'gambar_ikm'      => 'nullable|string|max:500',
            'link_ikm'        => 'nullable|string|max:500',
            'gambar_ipkp'     => 'nullable|string|max:500',
            'link_ipkp'       => 'nullable|string|max:500',
            'gambar_ipak'     => 'nullable|string|max:500',
            'link_ipak'       => 'nullable|string|max:500',
            'file_gambar_ikm'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_gambar_ipkp' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_gambar_ipak' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], $this->scoreValidation);
        $this->validate($request, $rules);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        if (!empty($data['tanggal_mulai'])) {
            $derivedYear = (int) date('Y', strtotime($data['tanggal_mulai']));
            if ($derivedYear) $data['tahun'] = $derivedYear;
        }

        foreach ($this->uploadMap as $fileKey => $urlKey) {
            if ($request->hasFile($fileKey)) {
                $url = $this->uploadFile($request->file($fileKey), $request, 'survey/pekan');
                if ($url) $data[$urlKey] = $url;
            }
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

        $item = SurveyPekan::find($id);
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
