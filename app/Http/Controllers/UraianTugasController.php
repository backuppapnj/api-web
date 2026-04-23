<?php

namespace App\Http\Controllers;

use App\Models\UraianTugas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UraianTugasController extends Controller
{
    private array $allowedFields = [
        'nama',
        'jabatan',
        'kelompok_jabatan_id',
        'nip',
        'status_kepegawaian',
        'foto_url',
        'link_dokumen',
        'urutan',
    ];

    /**
     * Ambil semua data uraian tugas (PUBLIC)
     * Filter opsional: ?kelompok_id=, ?q=
     */
    public function index(Request $request): JsonResponse
    {
        $query = UraianTugas::with('kelompokJabatan');

        if ($request->has('kelompok_id') && $request->kelompok_id !== '') {
            $kelompokId = (int) $request->kelompok_id;
            if ($kelompokId > 0) {
                $query->where('kelompok_jabatan_id', $kelompokId);
            }
        }

        if ($request->has('q') && trim($request->q) !== '') {
            $search = trim(strip_tags($request->q));
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $query->orderBy('kelompok_jabatan_id', 'asc')
              ->orderBy('urutan', 'asc')
              ->orderBy('jabatan', 'asc');

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
            'total'   => $data->count(),
        ]);
    }

    /**
     * Ambil satu data uraian tugas (PUBLIC)
     */
    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = UraianTugas::with('kelompokJabatan')->find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    /**
     * Simpan data uraian tugas baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'jabatan'             => 'required|string|max:255',
            'kelompok_jabatan_id' => 'required|integer|exists:kelompok_jabatan,id',
            'nama'                => 'nullable|string|max:255',
            'nip'                 => 'nullable|string|max:30',
            'status_kepegawaian'  => 'nullable|in:PNS,PPNPN,CASN',
            'foto_url'            => 'nullable|url|max:500',
            'link_dokumen'        => 'nullable|url|max:500',
            'urutan'              => 'nullable|integer|min:0',
        ]);

        $data = $this->sanitizeInput(
            $request->only($this->allowedFields),
            ['foto_url', 'link_dokumen']
        );

        $item = UraianTugas::create($data);
        $item->load('kelompokJabatan');

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data'    => $item,
        ], 201);
    }

    /**
     * Perbarui data uraian tugas (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = UraianTugas::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $this->validate($request, [
            'jabatan'             => 'sometimes|required|string|max:255',
            'kelompok_jabatan_id' => 'sometimes|required|integer|exists:kelompok_jabatan,id',
            'nama'                => 'nullable|string|max:255',
            'nip'                 => 'nullable|string|max:30',
            'status_kepegawaian'  => 'nullable|in:PNS,PPNPN,CASN',
            'foto_url'            => 'nullable|url|max:500',
            'link_dokumen'        => 'nullable|url|max:500',
            'urutan'              => 'nullable|integer|min:0',
        ]);

        $data = $this->sanitizeInput(
            $request->only($this->allowedFields),
            ['foto_url', 'link_dokumen']
        );

        $item->fill($data);
        $item->save();
        $item->load('kelompokJabatan');

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data'    => $item,
        ]);
    }

    /**
     * Hapus data uraian tugas (PROTECTED)
     */
    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = UraianTugas::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
