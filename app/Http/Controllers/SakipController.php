<?php

namespace App\Http\Controllers;

use App\Models\Sakip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SakipController extends Controller
{
    /**
     * Jenis dokumen SAKIP yang valid
     */
    const JENIS_DOKUMEN = [
        'Indikator Kinerja Utama',
        'Rencana Strategis',
        'Program Kerja',
        'Rencana Kinerja Tahunan',
        'Perjanjian Kinerja',
        'Rencana Aksi',
        'Laporan Kinerja Instansi Pemerintah',
    ];

    private array $allowedFields = [
        'tahun',
        'jenis_dokumen',
        'uraian',
        'link_dokumen',
    ];

    /**
     * Ambil semua data SAKIP (PUBLIC - Read Only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Sakip::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        // Urutan berdasarkan daftar jenis dokumen tetap
        $placeholders = implode(',', array_fill(0, count(self::JENIS_DOKUMEN), '?'));
        $data = $query->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(jenis_dokumen, $placeholders)", self::JENIS_DOKUMEN)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil data berdasarkan tahun (PUBLIC - Read Only)
     */
    public function byYear(int $tahun): JsonResponse
    {
        if ($tahun < 2000 || $tahun > 2100) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun tidak valid'
            ], 400);
        }

        $placeholders = implode(',', array_fill(0, count(self::JENIS_DOKUMEN), '?'));
        $data = Sakip::where('tahun', $tahun)
            ->orderByRaw("FIELD(jenis_dokumen, $placeholders)", self::JENIS_DOKUMEN)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil satu data SAKIP
     */
    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = Sakip::find($id);
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
     * Simpan data SAKIP baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun'          => 'required|integer|min:2000|max:2100',
            'jenis_dokumen' => 'required|string',
            'uraian'         => 'nullable|string',
            'link_dokumen'  => 'nullable|string',
            'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ]);

        if (!in_array($request->jenis_dokumen, self::JENIS_DOKUMEN)) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis dokumen tidak valid. Pilihan: ' . implode(', ', self::JENIS_DOKUMEN)
            ], 422);
        }

        // Cek duplikat
        $exists = Sakip::where('tahun', $request->tahun)
            ->where('jenis_dokumen', $request->jenis_dokumen)
            ->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun dan jenis dokumen tersebut sudah ada',
            ], 422);
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'sakip');
            if ($link) $data['link_dokumen'] = $link;
        }

        $item = Sakip::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $item
        ], 201);
    }

    /**
     * Perbarui data SAKIP (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = Sakip::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'tahun'          => 'sometimes|required|integer|min:2000|max:2100',
            'jenis_dokumen' => 'sometimes|required|string',
            'uraian'         => 'nullable|string',
            'link_dokumen'  => 'nullable|string',
'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ]);

        if ($request->has('jenis_dokumen') && !in_array($request->jenis_dokumen, self::JENIS_DOKUMEN)) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis dokumen tidak valid. Pilihan: ' . implode(', ', self::JENIS_DOKUMEN)
            ], 422);
        }

        // Cek duplikat (kecuali record ini sendiri)
        if ($request->has('tahun') || $request->has('jenis_dokumen')) {
            $tahun = $request->tahun ?? $item->tahun;
            $jenis = $request->jenis_dokumen ?? $item->jenis_dokumen;
            $exists = Sakip::where('tahun', $tahun)
                ->where('jenis_dokumen', $jenis)
                ->where('id', '!=', $id)
                ->first();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data untuk tahun dan jenis dokumen tersebut sudah ada',
                ], 422);
            }
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'sakip');
            if ($link) $data['link_dokumen'] = $link;
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $item->fresh()
        ]);
    }

    /**
     * Hapus data SAKIP (PROTECTED)
     */
    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = Sakip::find($id);
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
